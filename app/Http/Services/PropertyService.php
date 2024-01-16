<?php

namespace App\Http\Services;

use App\Language;
use App\TranslatePropertyAddress;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class PropertyService {

    

    public static function  getAndSaveTranslatePropertyAddress($property_id,$longLat){
      
        $langs = [ ['en_RU', 'en'],['ru-RU','ru'],['hy-AM','hy']];
        $api_key = env('YANDEX_KEY','5ba341c6-2228-439d-b08c-4bcd1403d6c1');

        TranslatePropertyAddress::where('property_id', $property_id)->delete();

        foreach($langs as $lang ){
           
            $language = Language::where('code', $lang[1])->first();
            $data =  Http::get('https://geocode-maps.yandex.ru/1.x/?apikey='.$api_key.'&format=json&geocode='.$longLat.'&lang='.$lang[0].'&results=1');
            $decodeData = json_decode($data->body(), true);

            $transelateData = ['property_id' => $property_id, 'language_id' => $language->id ];

            if(!empty($decodeData['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['metaDataProperty']['GeocoderMetaData']['Address'])){
             
                $addresse = $decodeData['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['metaDataProperty']['GeocoderMetaData']['Address'];
               
                $transelateData['addresse'] = $addresse['formatted'];

                foreach($addresse['Components'] as $component){
                    switch ($component['kind']) {
                        case "country":
                            $transelateData['country']=$component['name'];
                          break;
                        case "province":
                            $transelateData['province']=$component['name'];
                          break;
                        case "locality":
                            $transelateData['locality']=$component['name'];
                          break;
                        case "street":
                            $transelateData['street']=$component['name'];
                          break;
                        case "house":
                            $transelateData['house']=$component['name'];
                          break;  
                        
                      }
                }

                $reverseAddress = '';
                if(!empty($transelateData['province'])&&!empty($transelateData['locality'])&&($transelateData['province']==$transelateData['locality'])){
                  $reverseAddressArr = explode(", ",$transelateData['addresse'], 3);
                
                  //mine address
                  if(!empty($reverseAddressArr[2])){
                    $reverseAddress .= $reverseAddressArr[2].", ";
                  }
                  //province
                  if(!empty($reverseAddressArr[1])){
                    $reverseAddress .= $reverseAddressArr[1].", ";
                  }
                  //country
                  if(!empty($reverseAddressArr[0])){
                    $reverseAddress .= $reverseAddressArr[0];
                  }
                } else {
                  $reverseAddressArr = explode(", ",$transelateData['addresse'], 4);
                  //mine address
                  if(!empty($reverseAddressArr[3])){
                    $reverseAddress .= $reverseAddressArr[3].", ";
                  }
                  //province
                  if(!empty($reverseAddressArr[2])){
                    $reverseAddress .= $reverseAddressArr[2].", ";
                  }
                  //locality
                  if(!empty($reverseAddressArr[1])){
                    $reverseAddress .= $reverseAddressArr[1].", ";
                  }
                  //country
                  if(!empty($reverseAddressArr[0])){
                    $reverseAddress .= $reverseAddressArr[0];
                  }

                }

                $transelateData['reverse_address'] =  $reverseAddress;

                TranslatePropertyAddress::create($transelateData);

            }
        }

      
       return true;
    }

    public static function paginate($items, $perPage = 10, $page = null, $options = [])
    {
       $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
       $items = $items instanceof Collection ? $items : Collection::make($items);
       return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

}   
