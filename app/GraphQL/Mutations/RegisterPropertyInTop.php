<?php

namespace App\GraphQL\Mutations;

use Illuminate\Support\Facades\Http;
use App\Property;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App;

class RegisterPropertyInTop
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $property = Property::find($args['id']);
        $user_auth = Auth::user();

        if($user_auth->id==$property->user_id) {

            $url = env('IPAY_API');
            $username = env('IPAY_USERNAME');
            $password = env('IPAY_PASSWORD');
            $selLanguage =App::getLocale();

            $amount = 500;
            /*
             *AMD 051
             *USD 840
             *EUR 978
             *RUB 643
             * */
            $currency = '051';

            $orderNumber = random_int(1000, 9999).'-'.time();

            $jsonParams = json_encode(['property_id' => $property->id, 'order_type'=>'in_top' ]);

            $response = Http::asForm()->post($url . '/register.do', [
                'userName' => $username,
                'password' => $password,
                'amount'   => $amount,
                'currency' =>  $currency,
                'language' => $selLanguage,
                'orderNumber' =>  $orderNumber,
                'returnUrl'   => $args['return_url'],
                'jsonParams'  =>  $jsonParams,
                'pageView'    => $args['page_view']

            ]);

            $data = json_decode($response->body(), true);


            if ($data && !empty($data['orderId']) && !$data['error']) {
                return ['error'=>false, 'errorMessage' => null, 'orderId' => $data['orderId'], 'formUrl'=> $data['formUrl']];
            } elseif($data) {
                return ['error'=>true, 'errorMessage' => $data['errorMessage'], 'orderId' => null, 'formUrl'=> null];
            } else {
                return ['error'=>true, 'errorMessage' => $response->body(), 'orderId' => null, 'formUrl'=> null];
            }

        }

        return ['error'=>true, 'errorMessage' => 'not have prmission', 'orderId' => null, 'formUrl'=> null];
    }
}
