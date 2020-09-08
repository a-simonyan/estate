<?php

namespace App\GraphQL\Mutations;
use App\Property;
use App\PropertyImage;
use Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Nuwave\Lighthouse\Exceptions\DefinitionException;


class DeleteProperty
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $user_auth = Auth::user();
        $property_id = $args['id'];
        $property = Property::find($property_id);

        if($user_auth->is_admin||$user_auth->id == $property->user_id){
        
            foreach($property->property_images as $img){
             if($img->name&&file_exists(storage_path('app/public/property/'.$img->name))){
                 unlink(storage_path('app/public/property/'.$img->name));
               }
            }

            $delete_property = $property->delete();

        } else {
            return new DefinitionException("not have  permission");
        }
    }
}
