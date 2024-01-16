<?php

namespace App\GraphQL\Queries;

use App\Translation;

class GetPrivacyPolicy
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $translation = Translation::where('name','privacy_policy');
        if(!empty($args['language'])){
            $selLanguage = $args['language'];
            $translation->whereHas('language', function($query) use ( $selLanguage ) {
                $query->where('code', $selLanguage);
            }); 
        }

        $translation = $translation->get();

        return $translation;
       
    }
}
