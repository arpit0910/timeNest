<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PasswordResetWebController extends Controller
{
    /**
     * GET /reset-password
     *
     * Displays the password reset form.
     */
    public function show(Request $request): View
    {
        return view('frontend.pages.reset-password', [
            'email' => $request->query('email', ''),
            'token' => $request->query('token', ''),
        ]);
    }
}
