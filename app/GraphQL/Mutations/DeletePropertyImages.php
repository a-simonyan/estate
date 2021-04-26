<?php

namespace App\GraphQL\Mutations;
use App\Property;
use App\PropertyImage;
use Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Nuwave\Lighthouse\Exceptions\DefinitionException;

class DeletePropertyImages
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $user_auth = Auth::user();
        $images_ids = $args['images_ids'];
      
        foreach( $images_ids as $images_id){
            $propertyImage=PropertyImage::find($images_id);
            if($user_auth->id == $propertyImage->property->user_id){
                $propertyImage_name = $propertyImage->getOriginal('name');
                if($propertyImage_name&&file_exists(storage_path('app/public/property/'.$propertyImage_name))){
                    unlink(storage_path('app/public/property/'.$propertyImage_name));
                  }
                  $propertyImage->delete();
            }

        }

        

      return true;
        
         
    }
}
