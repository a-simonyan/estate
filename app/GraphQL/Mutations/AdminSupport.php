<?php

namespace App\GraphQL\Mutations;

use App\Support;

class AdminSupport
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $support = Support::find($args['id']);

        $details = [
            'title' => $args['title'],
            'body'  =>  $args['body']
        ];
       
        \Mail::to($support->email)->send(new \App\Mail\SupportMail($details));
        if(empty($args['is_support_status'])){
          $support->update(['is_support_status' => 'done']);
        } else {
          $support->update(['is_support_status' => $args['is_support_status']]);  
        }

        return ['status' => true];
    }
}
