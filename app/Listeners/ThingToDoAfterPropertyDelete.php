<?php

namespace App\Listeners;

use App\Events\PropertyDelete;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Property;
use App\NotificationUsersProperties;
use App\UserFavoriteProperty;

class ThingToDoAfterPropertyDelete
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PropertyDelete  $event
     * @return void
     */
    public function handle(PropertyDelete $event)
    {
        $property_id = $event->property_id;
        $property = Property::find($property_id);

        $this->deletePropertyAllConnection($property_id);
        $this->checkSamePlace($property);
    }

    public function deletePropertyAllConnection($property_id){
        NotificationUsersProperties::where('property_id',$property_id)->delete();
        UserFavoriteProperty::where('property_id',$property_id)->delete();
    }

    public function checkSamePlace(Property $property){
        $properties = Property::where('is_public_status','published')
                              ->whereNull('deleted_at')
                              ->whereNull('archived_at')
                              ->whereNull('saved_at')
                              ->where('latitude', $property->latitude)
                              ->where('longitude', $property->longitude);
         
        if($properties->count()===1){
            $properties->update(['same_place_group' => null]);
        }
        
        $property->update(['same_place_group' => null]);

        return true;
    }
    
}
