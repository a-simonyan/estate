<?php

namespace App\GraphQL\Queries;

use App\Spam;

class AdminSpams
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $spamClass = Spam::orderBy('created_at','DESC');
        $total = null;
        $lastPage = null;

        /*add paginate*/
        if(!empty($args['paginate'])){
            $first = !empty($args['paginate']['first']) ? $args['paginate']['first'] : 10;
            $page  = !empty($args['paginate']['page']) ? $args['paginate']['page'] : 1;
            $spams = $spamClass->paginate($first,['*'],'page', $page);

            $total = $spams->total();
            $lastPage = $spams->lastPage();

            return  ['spams' => $spams, 'total' => $total, 'lastPage' => $lastPage];
        }

        $spams = $spamClass->get();

        return ['spams' => $spams, 'total' => $total, 'lastPage' => $lastPage];

    }
}
