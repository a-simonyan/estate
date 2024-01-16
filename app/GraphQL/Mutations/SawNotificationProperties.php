<?php

namespace App\GraphQL\Mutations;
use App\NotificationUsersProperties;
use Auth;

class SawNotificationProperties
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $user_auth_id = Auth::user()->id;
        foreach($args['notificationProperties_ids'] as $notificationProperties_id){
            $notificationUsersPropertie =  NotificationUsersProperties::find($notificationProperties_id);
            if($notificationUsersPropertie->user_id == $user_auth_id){
                $notificationUsersPropertie->delete();
            }
        }


        return true;

    }
}
