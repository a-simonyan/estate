<?php

namespace App\GraphQL\Mutations;

use App\Support;

class AdminUpdateSupport
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $support = Support::find($args['id']);

        if(!empty($args['is_support_status'])){
            $support->update(['is_support_status' => $args['is_support_status']]);
        }

        return ['status' => true];
    }
}
