<?php

namespace App\GraphQL\Queries;

use App\PropertyClientIp;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Carbon\CarbonPeriod;


class PropertyViewsStatistics
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
       $start = !empty($args['start']) ? $args['start'] : Carbon::now()->subDays(30)->format('Y-m-d');
       $end = !empty($args['end']) ? $args['end'] : Carbon::now()->format('Y-m-d') ;
       $period = CarbonPeriod::create($start, $end);
       $data = [];

       foreach($period as $date){
           array_push($data, [ 'date' => $date->format("Y-m-d"), 'views' => 0]);
       }

        $dbData = PropertyClientIp::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as views'))
                               ->where('property_id', $args['id'])
                               ->whereDate('created_at', '>=', $start)
                               ->whereDate('created_at', '<=', $end)
                               ->groupBy('date')
                               ->orderBy('date')
                               ->get();

       foreach ($dbData as $dbItem){
           foreach ($data as  $key=>$item){
               if($item['date']==$dbItem['date']){
                   $data[$key]['views'] = $dbItem['views'];
               }
           }
       }

        return ['start' => $start, 'end' => $end, 'views' => $data];
    }
}
