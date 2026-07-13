<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class DemoBooking extends Model
{
    use HasUuid;

    protected $table = 'demo_bookings';

    protected $fillable = [
        'name',
        'email',
        'company_size',
        'booking_date',
        'booking_time',
        'ip_address',
        'user_agent',
    ];

    protected function casts(): array
    {
        return [
            'booking_date' => 'date:Y-m-d',
        ];
    }
}
