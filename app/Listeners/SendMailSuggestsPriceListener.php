<?php

namespace App\Listeners;

use App\Events\SendMailSuggestsPrice;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\SuggestsPriceProperty;
use Mail;
use App\Mail\SuggestsPriceMail;
use App\Property;

class SendMailSuggestsPriceListener 
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
     * @param  SendMailSuggestsPrice  $event
     * @return void
     */
    public function handle(SendMailSuggestsPrice $event)
    {
        $suggestsPriceProperty = $event->suggestsPriceProperty;

        if($suggestsPriceProperty->property->email){
            $details=[
                'user_name'            => $suggestsPriceProperty->user->full_name,
                'user_email'           => $suggestsPriceProperty->user->email,
                'property_address'     => $suggestsPriceProperty->property->address,
                'price'                => $suggestsPriceProperty->price,
                'currency_type_symbol' => $suggestsPriceProperty->currency_type->symbol,
                'end_time'             => $suggestsPriceProperty->end_time
            ];
    
            Mail::to( $suggestsPriceProperty->property->email)->send(new SuggestsPriceMail($details));
        }
    }
}
