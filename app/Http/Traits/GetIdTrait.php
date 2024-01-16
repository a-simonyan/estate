<?php

namespace  App\Http\Traits;

trait GetIdTrait {
    
    public function getKeyId($model, $field, $key){
      $item=$model::where($field,$key)->first();
      if($item){
          return $item->id;
      }

      return null;
    }


}