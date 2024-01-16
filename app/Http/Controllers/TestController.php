<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use File;
use App\Property;
use App\User;
use Illuminate\Support\Facades\Http;
use App\PropertyImage;
// use App\Singleton\RestUrl;
use App\Http\Traits\GetIdTrait;
use App\CurrencyType;
use App\SaveUserFilter;
use Image;

use Laravel\Socialite\Facades\Socialite;




class TestController extends Controller
{
    use GetIdTrait;

    public function test(Request $request){
        
        $picture = $request->picture;
        $logo = $request->logo;

        $fileName_img ='picture'.Str::random(3).time().'.'.$picture->getClientOriginalExtension();
        while(file_exists(storage_path('app/public/test/'.$fileName_img))){
            $fileName_img = Str::random(3).time().'.'.$picture->getClientOriginalExtension();
        };

        $picture->storeAs('public/test',$fileName_img);

        $fileName_logo ='picture'.Str::random(3).time().'.'.$logo->getClientOriginalExtension();
        while(file_exists(storage_path('app/public/test/'.$fileName_logo))){
            $fileName_logo = 'logo'.Str::random(3).time().'.'.$logo->getClientOriginalExtension();
        };

        $logo->storeAs('public/test',$fileName_logo);

        // $image = Image::make(storage_path('app/public/test/'.$fileName_logo));

        // $image->resize(null, 300, function($constraint) {
        //     $constraint->aspectRatio();
        // });

        // unlink(storage_path('app/public/test/'.$fileName_logo));
        // $image->save(storage_path('app/public/test/'.$fileName_logo));


        $img = Image::make(storage_path('app/public/test/'.$fileName_img));
   
        /* insert watermark at bottom-right corner with 10px offset */
        $img->insert(storage_path('app/public/test/'.$fileName_logo), 'center');
       
        $new_image = 'new_'.$fileName_img;
        $img->save(storage_path('app/public/test/'.$new_image)); 
       
        return response()->json(["image" => url('storage/test/'.$new_image)]);

    }


    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function Callback(Request $request,$provider){

        // $user = Socialite::driver('facebook')->stateless()->user();;
        dd($request->code);
        // return redirect('/t2')->with('provider', $provider);;
    }


    public function image(Request $request){

        $validate = $request->validate([
            'img.*' => 'image'
        ]);

        if($request->img){
            $nkarner = [];
            foreach( $request->img as $img) {

                $picture = $img;

                $fileName_img = Str::random(10) . time() . '.' . $picture->getClientOriginalExtension();
                while (file_exists(storage_path('app/public/users/' . $fileName_img))) {
                    $fileName_img = Str::random(10) . time() . '.' . $picture->getClientOriginalExtension();
                };

                $picture->storeAs('public/users', $fileName_img);

                if (file_exists(storage_path('app/public/users/' . $fileName_img))) {
                    array_push($nkarner, url('storage/users/' . $fileName_img));
                }
            }
            return response()->json(['img' => $nkarner]);

        }

       
        return response()->json(['error' => 'not save']);


    }




    public function json(){
        $xml='<?xml version="1.0" encoding="utf-8"?>
        <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
          <soap:Body>
            <ExchangeRatesLatest xmlns="http://www.cba.am/" />
          </soap:Body>
        </soap:Envelope>';

        $response = Http::withHeaders([
            "Content-Type" => "text/xml;charset=utf-8",
            'SOAPAction'   => 'http://www.cba.am/ExchangeRatesLatest'
        ])->send("POST", "http://api.cba.am/exchangerates.asmx", [
            "body" =>  $xml
        ]);
        $response =$response->body();

        $response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $response);
        $xml = new \SimpleXMLElement($response);
        $body = $xml->xpath('//SBody');
        $rates = json_decode(json_encode((array)$xml), TRUE); 
        $rates = $rates['soapBody']['ExchangeRatesLatestResponse']['ExchangeRatesLatestResult']['Rates']['ExchangeRate'];

        $currencyTypes = CurrencyType::all();

        foreach($currencyTypes as $currencyType){
            $name = $currencyType->name;
            $rate = $this->findRate($rates,$name);
          
            if($rate){
              CurrencyType::where('name',$name)->update(['rate' =>  $rate]);
            } 

        }

        

       dd('finish');
       

    // $id = $this->getKeyId(User::Class,'full_name','Mihran Baldryan');

    // $user= User::where('full_name','Mihran Baldryan')->first();
        
    // dd($id);




       
        // $property= Property::leftJoin('filters_values','properties.id','=','filters_values.property_id')
        //            ->leftJoin('filters','filters.id','=','filters_values.filter_id')->where('filters_values.value',1000)->select('properties.*')->get()
        //            ->unique('id');

        $filters = ['test2'];

       

        $propertyClass = Property::Class;
        $first = true;

        foreach($filters as $filter){
            if($first){
                 $property=$propertyClass::whereHas('filters_values' , function ($query) use ($filter){
                     $query->leftJoin('filters', 'filters.id', '=', 'filters_values.filter_id');
             
                      $query->where(function ($query) use ($filter) {
                         $query->where('name',$filter);
                         $query->where('value',1000);
                     });
         
                 });
            } else {
                $property=$propertyClass->whereHas('filters_values' , function ($query) use ($filter){
                    $query->leftJoin('filters', 'filters.id', '=', 'filters_values.filter_id');
            
                     $query->where(function ($query) use ($filter) {
                        $query->where('name',$filter);
                        $query->where('value',1000);
                    });
        
                });

            }

            $propertyClass=$property;
            $first=false;

       }



        dd($property->get());

     }


     public function findRate($rates,$ISO){

        foreach($rates as $rate){
            if($rate['ISO']==$ISO){
                return  $rate['Rate'];
            };
        }

        return null;

     }





   


 
}
