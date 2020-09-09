<?php

namespace App\Singleton;

class RestUrl{

     public $password_reset_url="";

     public function setPasswordResetUrl($password_reset_url){
         $this->password_reset_url=$password_reset_url;
     }
    
}