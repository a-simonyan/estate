<?php

namespace App\GraphQL\Queries;

use App\PropertyClientIp;
use Illuminate\Support\Facades\DB;

class PropertyStatistics
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {

       $data = PropertyClientIp::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as views'))
            ->where('created_at', '>', now()->subDays(30)->endOfDay())
            ->groupBy('date')
            ->get();

        return json_encode($data);
    }
}
