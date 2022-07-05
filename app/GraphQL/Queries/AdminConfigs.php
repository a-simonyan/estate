<?php

namespace App\GraphQL\Queries;

use App\Config;

class AdminConfigs
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $configsClass = Config::orderBy('created_at','DESC');
        $total = null;
        $lastPage = null;

        /*add paginate*/
        if(!empty($args['paginate'])){
            $first = !empty($args['paginate']['first']) ? $args['paginate']['first'] : 10;
            $page  = !empty($args['paginate']['page']) ? $args['paginate']['page'] : 1;
            $configs = $configsClass->paginate($first,['*'],'page', $page);

            $total = $configs->total();
            $lastPage = $configs->lastPage();

            return  ['configs' => $configs, 'total' => $total, 'lastPage' => $lastPage];
        }

        $configs = $configsClass->get();

        return ['configs' => $configs, 'total' => $total, 'lastPage' => $lastPage];
    }
}
