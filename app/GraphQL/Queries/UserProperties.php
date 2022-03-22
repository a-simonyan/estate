<?php

namespace App\GraphQL\Queries;
use App\Property;
use Auth;
use App\Http\Traits\GetIdTrait;
use App\Http\Traits\ChangeCurrencyTrait;
use App\CurrencyType;
use App\PropertyType;
use App\DealType;
use App\Http\Services\PropertyService;


class UserProperties
{
    use GetIdTrait, ChangeCurrencyTrait;
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        $user_auth   = Auth::user();
        $user_id     = $user_auth->id;
        $total = null;
        $lastPage = null;
       
        $is_public_status = !empty($args['is_public_status'])? $args['is_public_status']:['published'];
        $first = !empty($args['first']) ? $args['first'] : 10;
        $page  = !empty($args['page']) ? $args['page'] : 1;

        $field = 'id';
        // ASC or DESC
        $order = 'DESC';

        if(!empty($args['orderBy'])){
            $field = $args['orderBy']['field'];
            $order = $args['orderBy']['order'];
        };

        $propertyClass = Property::where('user_id',$user_id)
                                 ->where('is_delete', false)
                                 ->where('is_archive', false)
                                 ->where('is_save', false);

         /*search by property type*/
         if(!empty($args['property_type'])){
            $typeArr=[];
            foreach($args['property_type'] as $property_type){
               $property_type_id = $this->getKeyId(PropertyType::Class,'name',$property_type);
               array_push($typeArr,$property_type_id);
            }
           
            $propertyClass = $propertyClass->whereIn('property_type_id',$typeArr);
          }

          $propertyClass = $propertyClass->whereIn('is_public_status', $is_public_status);
            
          /*order by price  ASC and DESC*/
          if(!empty($args['price_order'])){

            $properties = $propertyClass->get();


            $currency_type_id = CurrencyType::where('is_current',true)->first()->id;
            $propertie_plus = [];
            $propertie_minus = [];
            $price_order=$args['price_order'];



            $deal_type_id=$this->getKeyId(DealType::Class,'name','sale');
            foreach($properties as $propertie){
                foreach($propertie->property_deals as $property_deal){
                    if($property_deal->deal_type_id==$deal_type_id){
                        $propertie->price_order = $this->changeCurrency($property_deal->price,$property_deal->currency_type_id,$currency_type_id);
                        break;
                    }
                }
                if(empty($propertie->price_order) && !empty($propertie->property_deals[0])){
                    $property_deal = $propertie->property_deals[0];
                    $propertie->price_order = -$this->changeCurrency($property_deal->price,$property_deal->currency_type_id,$currency_type_id);

                    $propertie_minus[]=$propertie;

                } else {
                    $propertie_plus[]=$propertie;
                }

            }


            $propertie_plus  = collect($propertie_plus);
            $propertie_minus = collect($propertie_minus);

            if( $price_order == 'DESC') {
                $propertie_plus  = $propertie_plus->sortByDesc('price_order');
                $propertie_minus = $propertie_minus->sortBy('price_order'); 
                $properties = $propertie_plus->merge($propertie_minus);
            } else {
               $propertie_plus  = $propertie_plus->sortBy('price_order');
               $propertie_minus = $propertie_minus->sortByDesc('price_order'); 
               $properties = $propertie_plus->merge($propertie_minus);
            }
            $properties = PropertyService::paginate($properties, $first, $page);
            $total = $properties->total();
            $lastPage = $properties->lastPage();

            return ['properties' => $properties, 'total' => $total, 'lastPage' => $lastPage];
        
           } else {


            $properties = $propertyClass->orderBy($field, $order)
                                        ->paginate($first,['*'],'page', $page);
            $total = $properties->total();
            $lastPage = $properties->lastPage();                            

           }

        return ['properties' => $properties, 'total' => $total, 'lastPage' => $lastPage];
    }
}
