<?php

namespace App\GraphQL\Directives;

use Illuminate\Validation\Rule;
use Nuwave\Lighthouse\Schema\Directives\ValidationDirective;
use Illuminate\Support\Facades\Http;

class RegisterInputValidationDirective extends ValidationDirective  
{
    
    public function rules(): array
    {
        

        return [
            'full_name'    => ['required', 'string'], 
            'picture'      => ['string','nullable'],
            'picture_type' => ['string','in:jpeg,jpg,png','nullable'],
            'email'        => ['required', 'email', 'unique:users'],
            'user_type_id' => ['required','numeric'],
            'password'     => ['required', 'min:8'],
            'password_confirmation' => ['required','same:password'],
            'recaptcha'    =>  [ function ($attribute, $value, $fail) {
                                           if($this->args['system_type']=='web'){     
                                             $recapcha_secret = Config('googlerecapcha.recapcha_secret_'.$this->args['system_type']);  
                                             if($recapcha_secret){
                                                 $response = Http::asForm()->post(
                                                    'https://www.google.com/recaptcha/api/siteverify',
                                                        [
                                                            'secret'   =>  $recapcha_secret,
                                                            'response' =>  $value
                                                         ]
                                                );
                                                $body = json_decode((string)$response->getBody());
                                                 if($body&&$body->success){
                                                     return true;
                                                 }
                                            }
                                            $fail(__('messages.recaptcha_error'));
                
                                            } else {
                                                return true;
                                            }

                                             }, 'nullable'
            ]
        ];
    }


     public function messages(): array
    {   
        
        return [
            'password_confirmation.same' =>  __('messages.same_password_validation'),
        ];
    }
    
}
