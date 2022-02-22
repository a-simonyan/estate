<?php

namespace App\GraphQL\Directives;

use Illuminate\Validation\Rule;
use Nuwave\Lighthouse\Schema\Directives\ValidationDirective;
use App\Http\Traits\ConfigTrait;


class SetCurrencyDirective extends ValidationDirective 
{
    use ConfigTrait;
    
    public function rules(): array
    {
        $this->setCurrency($this->args);
        return [];
    }
    
}
