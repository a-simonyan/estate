<?php

namespace App\GraphQL\Mutations;

use App\SpamPoint;
use App\TranslateSpamPoint;
use App\Language;

class AdminCreateSpamPoint
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $spamPoint = SpamPoint::create([ 'name'=> $args['name'] ]);
        $this->saveTranslate($spamPoint->id, $args['translate_point']);

        return $spamPoint;
    }

    public function saveTranslate($spam_point_id,$translates){

        if($translates){

           foreach($translates as $translate){
               $language_code = $translate['language'];
               $language = Language::where('code',$language_code)->first();
               if($language){
                   $language_id = $language->id;
                   TranslateSpamPoint::create([
                     'spam_point_id' => $spam_point_id,
                     'language_id'   => $language_id,
                     'description'   => $translate['description']
                   ]);

               }

           }


        }

        return true;

   }
}
