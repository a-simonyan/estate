<?php

namespace App\GraphQL\Mutations;
use App\Property;
use App\PropertyImage;
use Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Exceptions\SendException;
use App\NotificationUsersProperties;




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

        if($user_auth->id == $property->user_id){
        
            $property->update(['is_delete'=>true]);
            NotificationUsersProperties::where('property_id',$property_id)->delete();

            return $property;

        } else {
             throw new SendException(
                'error',
                __('messages.not_have_permission')
              );
        }
    }
}
