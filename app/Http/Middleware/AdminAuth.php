<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if session has admin_auth flag
        if (session()->has('admin_auth') && session('admin_auth') === true) {
            // Log successful admin access
            Log::info('Admin access granted', [
                'username' => session('admin_username'),
                'path' => $request->path()
            ]);
            
            return $next($request);
        }
        
        // Log failed admin access attempt
        Log::warning('Unauthorized admin access attempt', [
            'path' => $request->path(),
            'ip' => $request->ip(),
            'has_session' => $request->hasSession(),
            'session_status' => session()->isStarted() ? 'started' : 'not_started'
        ]);
        
        // Redirect to login with message
        return redirect()->route('admin.login')
            ->with('error', 'Your session has expired or you are not authorized. Please login again.');
    }
} 