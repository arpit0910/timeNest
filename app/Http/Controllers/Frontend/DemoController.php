<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

use App\Models\DemoBooking;
use Illuminate\Http\Request;

class DemoController extends Controller
{
    public function index() { return view('frontend.pages.book-demo'); }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'company_size' => 'required|string|max:50',
            'booking_date' => 'required|date_format:Y-m-d',
            'booking_time' => 'required|string|max:50',
        ]);

        $bookingDate = new \DateTime($validated['booking_date']);
        $today = new \DateTime('today');
        
        if ($bookingDate <= $today) {
            return response()->json([
                'success' => false,
                'message' => 'Please select a future date.'
            ], 422);
        }

        $dayOfWeek = (int)$bookingDate->format('w'); // 0 (Sun) to 6 (Sat)
        // 3 = Wednesday, 5 = Friday, 6 = Saturday
        if ($dayOfWeek !== 3 && $dayOfWeek !== 5 && $dayOfWeek !== 6) {
            return response()->json([
                'success' => false,
                'message' => 'Demos can only be scheduled on Wednesdays, Fridays, or Saturdays.'
            ], 422);
        }

        // Indian public holidays (fixed dates)
        $monthDay = $bookingDate->format('m-d');
        $holidays = [
            '01-26' => 'Republic Day',
            '08-15' => 'Independence Day',
            '10-02' => 'Gandhi Jayanti',
            '12-25' => 'Christmas Day',
        ];

        if (array_key_exists($monthDay, $holidays)) {
            return response()->json([
                'success' => false,
                'message' => "Selected date is a public holiday in India ({$holidays[$monthDay]})."
            ], 422);
        }

        $booking = DemoBooking::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'company_size' => $validated['company_size'],
            'booking_date' => $validated['booking_date'],
            'booking_time' => $validated['booking_time'],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Demo booking saved successfully.',
            'booking' => $booking
        ]);
    }
}
