<?php

namespace App\GraphQL\Mutations;
use App\PropertyClientIp;
use App\Property;
use Illuminate\Support\Facades\DB;

class AddViewCount
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {  
        $id = $args['id'];
        $ip = $this->getClientIp();

        if($ip){
          $propertyClientIp = PropertyClientIp::where('property_id',$id)
                                              ->where('client_ip', $ip)
                                              ->get();

          if(!$propertyClientIp->count()){
              
                Property::where('id', $id)->update([
                    'view'=> DB::raw('view+1')
                ]);
                PropertyClientIp::create([
                    'property_id' => $id,
                    'client_ip'   => $ip
                ]);
   
                return ['status' => true ];
            } 
        }

        return ['status' => false ];
    }

    public function getClientIp(){
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
            if (array_key_exists($key, $_SERVER) === true){
                foreach (explode(',', $_SERVER[$key]) as $ip){
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                        return $ip;
                    }
                }
            }
        }
        return request()->ip();
    }
}
