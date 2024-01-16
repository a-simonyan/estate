<?php

namespace App\GraphQL\Queries;

use App\Config;

class GetMediaLinks
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $facebook_link = Config::where('key','facebook_link')->first();
        $instagram_link = Config::where('key','instagram_link')->first();
        $youtube_link = Config::where('key','youtube_link')->first();

        return [
            'facebook_link' => $facebook_link ? $facebook_link->value : null,
            'instagram_link' => $instagram_link ? $instagram_link->value : null,
            'youtube_link' => $youtube_link ? $youtube_link->value : null

        ];
    }
}
