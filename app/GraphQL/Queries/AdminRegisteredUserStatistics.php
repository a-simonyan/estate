<?php

namespace App\GraphQL\Queries;

use Carbon\Carbon;
use  App\User;

class AdminRegisteredUserStatistics
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $start = !empty($args['start']) ? $args['start'] : Carbon::now()->format('Y-m-d');
        $end = !empty($args['end']) ? $args['end'] : Carbon::now()->format('Y-m-d') ;
        $total = null;
        $lastPage = null;
        $first = !empty($args['paginate']['first']) ? $args['paginate']['first'] : 10;
        $page  = !empty($args['paginate']['page']) ? $args['paginate']['page'] : 1;

        $users= User::whereDate('created_at', '>=', $start)
                    ->whereDate('created_at', '<=', $end)
                    ->orderBy('created_at', 'DESC')
                    ->paginate($first,['*'],'page', $page);
        $total = $users->total();
        $lastPage = $users->lastPage();

        return  ['users' => $users, 'total' => $total, 'lastPage' => $lastPage];
    }
}
