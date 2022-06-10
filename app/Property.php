<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App;


class Property extends Model
{
    protected $table = "properties";
    protected $fillable = ['property_key',
                           'property_type_id',
                           'user_id',
                           'bulding_type_id',
                           'land_area_type_id',
                           'latitude',
                           'longitude',
                           'address',
                           'region',
                           'postal_code',
                           'property_state',
                           'review',
                           'is_public_status',
                           'is_save',
                           'is_delete',
                           'email',
                           'is_address_precise',
                           'view',
                           'update_count',
                           'last_update',
                           'next_update',
                           'is_archive',
                           'is_bids',
                           'is_top',
                           'top_start',
                           'top_end',
                           'same_place_group',
                           'saved_at',
                           'archived_at',
                           'deleted_at'

                        ];


   public function   property_type(){
       return $this->belongsTo('App\PropertyType','property_type_id','id');
   }  
   public function   user(){
      return $this->belongsTo('App\User','user_id','id');
   }               
   public function   bulding_type(){
       return $this->belongsTo('App\BuldingType','bulding_type_id','id');
   }         
   public function   land_area_type(){
    return $this->belongsTo('App\LandAreaType','land_area_type_id','id');
   }     
   public function filters_values(){
       return $this->hasMany('App\FiltersValue','property_id','id');
   }
   public function filters_values_not_null(){
       return $this->hasMany('App\FiltersValue','property_id','id')->whereNotNull('value');
   }
   public function filters_values_speciale(){
       return $this->hasMany('App\FiltersValue','property_id','id')->whereHas('filter' , function ($query){
                  $query->whereIn('name',['new_building','area','number_of_floors_of_the_building','apartment_floor','number_of_rooms']);
               });
   }
   public function property_images(){
       return $this->hasMany('App\PropertyImage','property_id','id')->orderBy('index','asc'); 
   }
   public function property_images_paginat(){
    return $this->hasMany('App\PropertyImage','property_id','id')->orderBy('index','asc')->limit(1); 
   }

   public function property_deals(){
       return $this->hasMany('App\PropertyDeal','property_id','id'); 
   }
   public function deal_types(){
       return $this->belongsToMany('App\DealType','property_deals','property_id','deal_type_id');
   }
   public function translate_descriptions(){
      return $this->hasMany('App\TranslateDescription','property_id','id'); 
   }
   
   public function translate_property_address(){
      return $this->hasMany('App\TranslatePropertyAddress','property_id','id'); 
   }
   public function sel_translate_property_address(){
     $selLanguage =App::getLocale();
     return $this->hasMany('App\TranslatePropertyAddress','property_id','id')->whereHas('language', function($query) use ( $selLanguage ) {
        $query->where('code', $selLanguage);
    });; 
   }
   public function user_favorite_properties(){
    return $this->hasMany('App\UserFavoriteProperty','property_id','id');
   }
   public function notification_users_properties(){
    return $this->hasMany('App\NotificationUsersProperties','property_id','id');
   }
   public function suggests_price_property(){
     return $this->hasMany('App\SuggestsPriceProperty','property_id','id');
   }
   public function property_attach_phones(){
     return $this->hasMany('App\PropertyAttachPhone','property_id','id');
   }
   public function spams(){
     return $this->hasMany('App\Spam','property_id','id'); 
   }


}
