<?php

namespace App\GraphQL\Mutations;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App;


class CheckAndSetPropertyInTop
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
        $nextUpdateDaysCount = 7;

        $orderId =$args['order_id'];

        $url = env('IPAY_API');
        $username = env('IPAY_USERNAME');
        $password = env('IPAY_PASSWORD');

        $response = Http::asForm()->post($url.'/getOrderStatus.do',  [
            'userName' => $username,
            'password' => $password,
            'orderId'  => $orderId,
            'language' => 'ru'
        ]);

        $data = json_decode($response->body(),true);

        if($data['errorCode']=='0'&&$data['orderStatus']==2){

            $property->is_top = true;
            $property->top_start =  Carbon::now();
            $property->top_start =  Carbon::now()->addDays($nextUpdateDaysCount);
            $property->save();

            return ['status'=>true];
        }

        return ['status'=>true];

    }
}
