<?php
namespace App\Http\Middleware;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class AdminAcess
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $userId = Auth::user()->id;
            $user = User::find($userId);
           
            if ($user->isAdmin()) {
                return $next($request);
            }
        }

        return redirect('/')->with('error', 'Acesso negado.');
    }
}
