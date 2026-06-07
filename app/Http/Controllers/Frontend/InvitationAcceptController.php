<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Enums\InvitationStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use App\Models\Invitation\Invitation;
use App\Services\Invitation\InvitationAcceptanceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class InvitationAcceptController extends Controller
{
    public function __construct(
        private readonly InvitationAcceptanceService $acceptanceService,
    ) {}

    /**
     * GET /invitations/accept?token=...
     *
     * Handles the browser click from the invitation email.
     * Validates the token and shows the acceptance page.
     */
    public function show(Request $request): View
    {
        $rawToken = $request->query('token');

        if (! $rawToken || ! is_string($rawToken)) {
            return $this->errorView(
                'Invalid Invitation Link',
                'The invitation link is malformed or incomplete. Please contact the person who invited you.',
            );
        }

        $result = $this->resolveInvitation($rawToken);

        if (isset($result['error'])) {
            return $this->errorView($result['heading'], $result['message']);
        }

        $invitation = $result['invitation'];
        $userExists = User::where('email', $invitation->email)->exists();

        return view('frontend.pages.invitation-accept', [
            'invitation' => $invitation,
            'userExists' => $userExists,
            'rawToken' => $rawToken,
            'success' => null,
        ]);
    }

    /**
     * POST /invitations/accept
     *
     * Processes the invitation acceptance form submission.
     */
    public function accept(Request $request): View
    {
        $rawToken = $request->input('token');

        if (! $rawToken || ! is_string($rawToken)) {
            return $this->errorView('Invalid Request', 'Missing invitation token.');
        }

        $result = $this->resolveInvitation($rawToken);

        if (isset($result['error'])) {
            return $this->errorView($result['heading'], $result['message']);
        }

        $invitation = $result['invitation'];
        $userExists = User::where('email', $invitation->email)->exists();

        try {
            if ($userExists) {
                // Existing user: authenticate them first, then accept
                $user = User::where('email', $invitation->email)->first();

                $password = $request->input('password');

                if (! $password || ! Hash::check($password, $user->password)) {
                    return view('frontend.pages.invitation-accept', [
                        'invitation' => $invitation,
                        'userExists' => true,
                        'rawToken' => $rawToken,
                        'success' => null,
                        'loginError' => 'Invalid password. Please try again.',
                    ]);
                }

                // Set the user in memory so the service can use auth()->user()
                // Using setUser() instead of login() to avoid session/remember_token dependency
                auth()->setUser($user);

                $this->acceptanceService->acceptInvitation($rawToken);

                auth()->forgetUser();

                return view('frontend.pages.invitation-accept', [
                    'success' => true,
                    'heading' => 'Invitation Accepted!',
                    'message' => "You've joined {$invitation->organization->legal_name}. Log in to your timeNest account to access your new workspace.",
                ]);
            } else {
                // New user: needs name + password
                $request->validate([
                    'name' => 'required|string|min:2|max:100',
                    'password' => 'required|string|min:8|confirmed',
                ]);

                $this->acceptanceService->acceptInvitation($rawToken, [
                    'name' => $request->input('name'),
                    'password' => $request->input('password'),
                ]);

                return view('frontend.pages.invitation-accept', [
                    'success' => true,
                    'heading' => 'Welcome to TimeNest!',
                    'message' => "Your account has been created and you've joined {$invitation->organization->legal_name}. You can now log in.",
                ]);
            }
        } catch (\Exception $e) {
            return view('frontend.pages.invitation-accept', [
                'invitation' => $invitation,
                'userExists' => $userExists,
                'rawToken' => $rawToken,
                'success' => null,
                'loginError' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Validate the raw token and return the invitation or error info.
     */
    private function resolveInvitation(string $rawToken): array
    {
        $hashedToken = hash('sha256', $rawToken);

        $invitation = Invitation::where('token', $hashedToken)
            ->with(['organization', 'role'])
            ->first();

        if (! $invitation) {
            return ['error' => true, 'heading' => 'Invalid Invitation', 'message' => 'This invitation link is invalid. Please contact the person who invited you for a new link.'];
        }

        if ($invitation->isExpired()) {
            if ($invitation->status === InvitationStatusEnum::Pending) {
                $invitation->update(['status' => InvitationStatusEnum::Expired]);
            }
            return ['error' => true, 'heading' => 'Invitation Expired', 'message' => 'This invitation has expired. Please ask the person who invited you to send a new invitation.'];
        }

        if ($invitation->status === InvitationStatusEnum::Revoked) {
            return ['error' => true, 'heading' => 'Invitation Revoked', 'message' => 'This invitation has been revoked by the organization administrator.'];
        }

        if ($invitation->status === InvitationStatusEnum::Accepted) {
            return ['error' => true, 'heading' => 'Already Accepted', 'message' => 'This invitation has already been accepted. You can log in to access the workspace.'];
        }

        return ['invitation' => $invitation];
    }

    private function errorView(string $heading, string $message): View
    {
        return view('frontend.pages.invitation-accept', [
            'error' => true,
            'heading' => $heading,
            'message' => $message,
        ]);
    }
}
