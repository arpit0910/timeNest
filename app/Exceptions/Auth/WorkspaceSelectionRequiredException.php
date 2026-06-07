<?php
declare(strict_types=1);

namespace App\Exceptions\Auth;

use App\Exceptions\BaseApiException;

class WorkspaceSelectionRequiredException extends BaseApiException
{
    public function __construct(string $message = "Please select a organization to continue", ?array $metadata = null)
    {
        parent::__construct($message, 403, "WORKSPACE_SELECTION_REQUIRED", $metadata);
        $this->setShouldLog(false);
    }
}
