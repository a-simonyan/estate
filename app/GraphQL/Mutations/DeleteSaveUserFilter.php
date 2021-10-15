<?php

namespace App\GraphQL\Mutations;

use App\SaveUserFilter;
use Auth;

class DeleteSaveUserFilter
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $saveUserFilter_id = $args['id'];
        $user_id = Auth::user()->id;

        $saveUserFilter_user_id = SaveUserFilter::find($saveUserFilter_id)->user->id;

        if($saveUserFilter_user_id ==  $user_id ){
            SaveUserFilter::where('id', $saveUserFilter_id)->delete();

            return ['status' => true ];
        }

        return ['status' => false ];

    }
}
