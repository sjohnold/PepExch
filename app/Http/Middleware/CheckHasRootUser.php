<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Spatie\Permission\Exceptions\RoleDoesNotExist;
use Symfony\Component\HttpFoundation\Response;

class CheckHasRootUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $hasRootUser = User::role('Admin')->exists();
        } catch (RoleDoesNotExist) {
            $hasRootUser = false;
        } catch (QueryException) {
            return $next($request);
        }

        if(!request()->routeIs(['create.root', 'create.superadmin']) && !$hasRootUser) {
            return redirect()->route('create.root');
        }
        if($hasRootUser && request()->routeIs(['create.root', 'create.superadmin'])) {
            return redirect()->route('admin.dashboard')->with('error', 'Super Admin already exists. You cannot create another one.');
        }

        return $next($request);
    }
}
