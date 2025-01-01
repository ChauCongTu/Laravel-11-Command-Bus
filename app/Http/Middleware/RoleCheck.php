<?php

namespace App\Http\Middleware;

use App\Constants\ResponseMessage;
use App\Exceptions\AuthException;
use App\Exceptions\ForbiddenException;
use App\Models\UserRole;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = auth()->user();
        if (!$user) {
            throw new AuthException(ResponseMessage::UNAUTHORIZED);
        }

        $allowRoleId = UserRole::where('role_level', '>=', $roles)->get()->pluck('id')->toArray();
        if (!in_array($user->role_id, $allowRoleId)) {
            throw new ForbiddenException(ResponseMessage::FORBIDDEN);
        }

        return $next($request);
    }
}
