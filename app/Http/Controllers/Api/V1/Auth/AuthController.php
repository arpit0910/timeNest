<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\BaseApiController;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RefreshTokenRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ResendVerificationRequest;
use App\Http\Requests\Auth\SelectOrganizationRequest;
use App\Http\Resources\Auth\AuthTokenResource;
use App\Http\Resources\Auth\UserResource;
use App\Services\Auth\AuthService;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * AuthController — handles all authentication endpoints.
 *
 * Controllers only: validate → authorize → call Service → return Resource.
 * No business logic here.
 */
class AuthController extends BaseApiController
{
    public function __construct(
        private readonly AuthService $authService,
    ) {}

    /**
     * POST /api/v1/auth/login
     *
     * Authenticate with email + password.
     * Returns JWT tokens or intermediate state (2FA, workspace selection).
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $result = $this->authService->login(
            email: $request->validated('email'),
            password: $request->validated('password'),
            ip: $request->ip(),
            userAgent: $request->userAgent(),
        );

        if (isset($result['status']) && $result['status'] === '2fa_required') {
            return response()->json([
                'status' => '2fa_required',
                'message' => $result['message'],
                'token' => $result['temp_token'],
            ]);
        }

        return $this->success(
            data: new AuthTokenResource($result),
            message: $result['message'] ?? 'Login successful',
            status: 200,
        );
    }

    /**
     * POST /api/v1/auth/register
     *
     * Create a new user account.
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $result = $this->authService->register($request->validated());

        return $this->created(
            data: new AuthTokenResource($result),
            message: $result['message'],
        );
    }

    /**
     * POST /api/v1/auth/logout
     *
     * Invalidate current JWT and optionally revoke refresh token.
     */
    public function logout(Request $request): JsonResponse
    {
        $this->authService->logout(
            user: $request->user(),
            refreshToken: $request->input('refresh_token'),
        );

        return $this->success(message: 'Logged out successfully');
    }

    /**
     * POST /api/v1/auth/logout-all
     *
     * Logout from all devices by incrementing token_version and revoking all refresh tokens.
     */
    public function logoutAll(Request $request): JsonResponse
    {
        $this->authService->logoutAllDevices($request->user());

        return $this->success(message: 'Logged out from all devices');
    }

    /**
     * POST /api/v1/auth/refresh
     *
     * Refresh access token using a valid refresh token.
     * Implements token rotation: old refresh token is revoked, new pair is issued.
     */
    public function refresh(RefreshTokenRequest $request): JsonResponse
    {
        $tokens = $this->authService->refreshAccessToken(
            rawRefreshToken: $request->validated('refresh_token'),
        );

        return $this->success(data: $tokens, message: 'Token refreshed');
    }

    /**
     * GET /api/v1/auth/user/profile
     *
     * Get the authenticated user's profile.
     */
    public function profile(Request $request): JsonResponse
    {
        return $this->success(
            data: new UserResource($request->user()),
            message: 'User profile retrieved',
        );
    }

    /**
     * POST /api/v1/auth/select-organization
     *
     * Select a organization workspace and receive organization-guard JWT.
     */
    public function selectOrganization(SelectOrganizationRequest $request): JsonResponse
    {
        $result = $this->authService->selectOrganization(
            user: $request->user(),
            organizationUuid: $request->validated('organization_uuid'),
            switchMode: false,
            rawTempToken: $request->bearerToken(),
        );

        return $this->success(
            data: new AuthTokenResource($result),
            message: 'Organization selected',
        );
    }

    /**
     * POST /api/v1/auth/switch-organization
     *
     * Switch to a different organization. Invalidates current JWT first.
     */
    public function switchOrganization(SelectOrganizationRequest $request): JsonResponse
    {
        $result = $this->authService->selectOrganization(
            user: $request->user(),
            organizationUuid: $request->validated('organization_uuid'),
            switchMode: true,
        );

        return $this->success(
            data: new AuthTokenResource($result),
            message: 'Organization switched',
        );
    }

    /**
     * GET /api/v1/auth/workspaces
     *
     * Get all available workspaces (organizations) for the authenticated user.
     */
    public function workspaces(Request $request): JsonResponse
    {
        $workspaces = $this->authService->getWorkspaces($request->user());

        return $this->success(data: $workspaces, message: 'Workspaces retrieved');
    }

    /**
     * POST /api/v1/auth/verify-email
     *
     * Verify email address using the token sent via email.
     */
    public function verifyEmail(Request $request): JsonResponse
    {
        $request->validate(['token' => ['required', 'string', 'size:64']]);

        $user = $this->authService->verifyEmail($request->input('token'));

        return $this->success(
            data: new UserResource($user),
            message: 'Email verified successfully',
        );
    }

    /**
     * POST /api/v1/auth/change-password
     *
     * Change password. Invalidates all existing tokens.
     */
    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        $this->authService->changePassword(
            user: $request->user(),
            currentPassword: $request->validated('current_password'),
            newPassword: $request->validated('password'),
        );

        return $this->success(message: 'Password changed. All active sessions have been invalidated. Please log in again.');
    }

    /**
     * POST /api/v1/auth/resend-verification-email
     *
     * Resend the email verification link.
     * Always returns a constant message to prevent user enumeration.
     */
    public function resendVerificationEmail(ResendVerificationRequest $request): JsonResponse
    {
        $this->authService->resendVerificationEmail(
            email: $request->validated('email'),
        );

        return $this->success(
            message: 'If your account exists, a verification email has been sent.',
        );
    }
}
