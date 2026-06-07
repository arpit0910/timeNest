<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Frontend Application URL
    |--------------------------------------------------------------------------
    |
    | The base URL of the frontend SPA. Used to generate links in emails
    | (e.g., email verification, password reset, invitation acceptance).
    | Must NOT have a trailing slash.
    |
    */

    'frontend_url' => env('FRONTEND_URL', 'http://localhost:3000'),

    /*
    |--------------------------------------------------------------------------
    | Email Verification
    |--------------------------------------------------------------------------
    |
    | Controls email verification token behaviour.
    |
    | expire: Number of minutes before a verification token expires.
    |
    */

    'verification' => [
        'expire' => (int) env('VERIFICATION_TOKEN_EXPIRE_MINUTES', 60),
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Reset
    |--------------------------------------------------------------------------
    |
    | Controls password reset token behaviour.
    |
    | expire: Number of minutes before a password reset token expires.
    |
    */

    'password_reset' => [
        'expire' => (int) env('PASSWORD_RESET_EXPIRE_MINUTES', 60),
    ],

];
