<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMatrix
{
    private array $map = [
        "reader" => ["GET"],
        "author" => ["GET","POST"],
        "admin"  => ["GET","POST","PUT","PATCH","DELETE"],
    ];

    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        if (!$user) return response()->json(["message"=>"Unauthenticated."], 401);

        $role = $user->getRoleNames()->first() ?? "";
        $allowed = $this->map[$role] ?? [];
        if (!in_array($request->getMethod(), $allowed, true)) {
            return response()->json(["message"=>"Forbidden for role: $role"], 403);
        }
        return $next($request);
    }
}
