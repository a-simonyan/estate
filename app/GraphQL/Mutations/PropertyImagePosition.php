<?php

namespace App\GraphQL\Mutations;
use App\Property;
use App\PropertyImage;
use Auth;

class PropertyImagePosition
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $user_auth = Auth::user();
        $images_ids = $args['images_ids'];

        $index=1;

        foreach( $images_ids as $images_id){
            $propertyImage=PropertyImage::find($images_id);
            if($user_auth->is_admin||$user_auth->id == $propertyImage->property->user_id){
                $propertyImage->update([
                    'index' => $index++
                ]);
            }

        }

        return true;

    }
}
