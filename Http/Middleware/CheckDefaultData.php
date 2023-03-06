<?php

namespace Modules\Product\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Product\Models\Product;

class CheckDefaultData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // check if there is at least one user in the database
        if (!User::count()) {
            // create a default user
            Product::createAndLoginDefaultUser();
        }

        // check if there is at least one product in the database
        if (!Product::count()) {
            // create a default product
            Product::createDefaultProduct();
        }
        return $next($request);
    }
}
