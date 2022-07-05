<?php

namespace App\GraphQL\Mutations;

use App\Config;

class AdminSetConfig
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
      $configs = $args['configs'];

      foreach ($configs as $config){
            Config::updateOrCreate(
                ['key' =>  $config['key']],
                ['value' => $config['value']]
            );
      }

      return [ 'status' => true ];
    }
}
