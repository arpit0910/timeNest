<?php
$exceptions = [
    'LeaveRequestNotFoundException' => [
        'code' => 404,
        'error_code' => 'LEAVE_REQUEST_NOT_FOUND',
        'message' => 'Leave request not found.'
    ],
    'InsufficientLeaveBalanceException' => [
        'code' => 422,
        'error_code' => 'INSUFFICIENT_LEAVE_BALANCE',
        'message' => 'Insufficient leave balance for this request.'
    ],
    'LeaveOverlapException' => [
        'code' => 422,
        'error_code' => 'LEAVE_OVERLAP',
        'message' => 'You already have a leave request for one or more of the selected dates.'
    ],
    'LeaveAdvanceNoticeException' => [
        'code' => 422,
        'error_code' => 'LEAVE_ADVANCE_NOTICE_REQUIRED',
        'message' => ''
    ],
    'LeaveDocumentRequiredException' => [
        'code' => 422,
        'error_code' => 'LEAVE_DOCUMENT_REQUIRED',
        'message' => 'A supporting document is required for this leave request.'
    ],
    'LeaveRequestAlreadyProcessedException' => [
        'code' => 422,
        'error_code' => 'LEAVE_REQUEST_ALREADY_PROCESSED',
        'message' => 'This leave request has already been processed.'
    ],
    'LeaveCancellationNotAllowedException' => [
        'code' => 422,
        'error_code' => 'LEAVE_CANCELLATION_NOT_ALLOWED',
        'message' => ''
    ],
    'UnauthorizedLeaveActionException' => [
        'code' => 403,
        'error_code' => 'UNAUTHORIZED_LEAVE_ACTION',
        'message' => 'You are not authorized to perform this action on this leave request.'
    ],
    'LeaveTypeNotActiveException' => [
        'code' => 422,
        'error_code' => 'LEAVE_TYPE_NOT_ACTIVE',
        'message' => 'This leave type is not currently available.'
    ],
];

@mkdir(__DIR__ . '/app/Exceptions/Leave', 0777, true);

foreach ($exceptions as $name => $data) {
    $messageAssignment = $data['message'] ? "\$this->message = '{$data['message']}';" : '';
    $constructorParam = $data['message'] ? "string \$message = '{$data['message']}'" : "string \$message";
    
    $content = <<<PHP
<?php

declare(strict_types=1);

namespace App\Exceptions\Leave;

use RuntimeException;
use Illuminate\Http\JsonResponse;

class $name extends RuntimeException
{
    public function __construct($constructorParam)
    {
        parent::__construct(\$message);
    }

    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => \$this->getMessage(),
            'error_code' => '{$data['error_code']}',
        ], {$data['code']});
    }
}
PHP;
    file_put_contents(__DIR__ . '/app/Exceptions/Leave/' . $name . '.php', $content);
}
echo "Exceptions created successfully.\n";
