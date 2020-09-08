<?php

namespace App\GraphQL\Mutations;
use Auth;
use App\Property;
use App\PropertyImage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Nuwave\Lighthouse\Exceptions\DefinitionException;

class UpdateProperty
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $user_auth   = Auth::user();
        $property_id = $args['id'];
        $property    = Property::find($property_id);

        if($user_auth->is_admin||$user_auth->id == $property->user_id){
        
        //  $property->update(['property_type_id' => $args['property_type_id'],
        //                     'user_id'          => $user_auth->id,  
        //                     'deal_type_id'     => $args['deal_type_id'],
        //                     'property_number'  => $args['property_number'],
        //                     'bulding_type_id'  => $args['bulding_type_id'],
        //                     'latitude'         => $args['latitude'],
        //                     'longitude'        => $args['longitude'],
        //                     'country_id'       => $args['country_id'],
        //                     'city_id'          => $args['city_id'],
        //                     'address'          => $args['address'],
        //                     'postal_code'      => $args['postal_code'],
        //                    ]); 

        $property->update($args);             


        if($args['property_images']){
           
            $property_images=json_decode( $args['property_images']);
            $image_types = ["jpeg","jpg","png"];

            foreach($property_images as $property_image){
                $picture_type=$property_image->type;
                
                if (in_array($picture_type, $image_types)){
                    $image = $property_image->image;
                     
                    $imageName = Str::random(10).time().'.'.$picture_type;
                    while(file_exists(storage_path('app/public/property/'.$imageName))){
                        $imageName = Str::random(10).time().$picture_type;
                    };
                    Storage::put('public/property/'.$imageName, base64_decode($image));
                    if(file_exists(storage_path('app/public/property/'.$imageName))){
                        PropertyImage::create([
                            'property_id' => $property_id,
                            'name'        => $imageName
                        ]);
                    }

                } 

            }
        }                             



        $property    = Property::find($property_id);

        return  $property;

      } else {
          
        return new DefinitionException("not have  permission");
      }
    }
}
