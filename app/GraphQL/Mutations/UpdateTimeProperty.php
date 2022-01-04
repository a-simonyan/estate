<?php

namespace App\GraphQL\Mutations;

use Auth;
use App\Property;
use Carbon\Carbon;
use DB;

class UpdateTimeProperty
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $user_auth   = Auth::user();
        $user_id     = $user_auth->id;
        $property_id = $args['id'];

        $property = Property::Find($property_id);                            

        if($property&&$property->user->id == $user_id){
            $date = Carbon::now();
            $nextUpdateDaysCount = env('Next_UPDATE_DAYS_COUNT',1);
            $query = Property::where('id',$property_id);

            if($property->next_update){
                $query =  $query->whereDate('next_update', '<=', $date);
            }
            $count = $query->update([
                'update_count' => DB::raw('update_count+1'),
                'last_update'  => Carbon::now(),
                'next_update'  => Carbon::now()->addDays($nextUpdateDaysCount),
            ]);

            if($count){
               return [ 'status' => true ];
            }
        }

        return [ 'status' => false ];
    }
}
