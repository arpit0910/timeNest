<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Traits\ApiResponse;
use Illuminate\Routing\Controller;

/**
 * Base API controller providing standardized JSON response methods.
 *
 * All API controllers extend this. Never return raw models from controllers —
 * always use API Resources via the ApiResponse trait methods.
 */
abstract class BaseApiController extends Controller
{
    use ApiResponse;
}
