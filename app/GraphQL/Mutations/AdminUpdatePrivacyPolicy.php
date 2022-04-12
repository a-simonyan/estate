<?php

namespace App\GraphQL\Mutations;

use App\Language;
use App\Translation;

class AdminUpdatePrivacyPolicy
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        if(!empty($args['privacy_policy'])){
          foreach($args['privacy_policy'] as $translate_description){
            $language_code = $translate_description['language'];
            $language = Language::where('code',$language_code)->first();
            if($language){
                $language_id = $language->id;

                $user = Translation::updateOrCreate(
                    ['name' =>  'privacy_policy', 'language_id' =>  $language_id],
                    ['translated_name' => $translate_description['description']]
                );

            }
        }

        return [ 'status' => true ];
       }

       return [ 'status' => false ];
    }
}
