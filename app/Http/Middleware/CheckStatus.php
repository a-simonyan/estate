<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Nuwave\Lighthouse\Exceptions\DefinitionException;

class CheckStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if (!($user->is_delete) && !($user->is_block)) {
            return $next($request);
        }

        return new DefinitionException("account not active");
    }
}
