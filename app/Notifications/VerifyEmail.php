<?php

namespace App\Notifications;

use Illuminate\Support\Carbon;

class VerifyEmail extends \Illuminate\Auth\Notifications\VerifyEmail
{
    public $url="";
    /**
     * Get the verification URL for the given notifiable.
     *
     * @param mixed $notifiable
     *
     * @return string
     */

    public function __construct($url)
    {
        $this->url = $url;
    }


    protected function verificationUrl($notifiable)
    {
        $payload = base64_encode(json_encode([
            'id'         => $notifiable->getKey(),
            'hash'       => encrypt($notifiable->getEmailForVerification()),
            'expiration' => encrypt(Carbon::now()->addMinutes(10)->toIso8601String()),
        ]));

        return $this->url.'?token='.$payload;
    }
}
