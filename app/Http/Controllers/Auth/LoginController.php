<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function redirectTo()
    {
        $user = Auth::user();
        
        // Pastikan method hasRole tersedia
        if (method_exists($user, 'hasRole')) {
            if ($user->hasRole('admin')) {
                return route('admin.dashboard');
            }
        }
        
        return route('dashboard');
    }
}