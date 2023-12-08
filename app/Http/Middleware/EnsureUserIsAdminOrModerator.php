<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserIsAdminOrModerator
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
        if (auth()->check() && (auth()->user()->role == 'admin' || auth()->user()->role == 'moderator')) {
            return $next($request);
        }

        return redirect('/'); // Redirect to the homepage if the user is not an admin or a moderator
    }
}
