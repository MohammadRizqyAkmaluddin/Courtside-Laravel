<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\BookingHold;
use App\Models\BookingSession;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

use function Symfony\Component\Clock\now;

class BookingController extends Controller
{
    public function checkout(Request $request)
    {
        return DB::transaction(function () {
            $hold = BookingHold::where('user_id', Auth::id())
                ->where('expires_at', '>', now())
                ->lockForUpdate()
                ->firstOrFail();

            $booking = Booking::create([
                'user_id' => Auth::id(),
                'status'  => 'pending'
            ]);

            BookingSession::create([
                'booking_id'    => $booking->id,
                'court_id'      => $hold->court_id,
                'booking_date'  => $hold->booking_date,
                'start_time'    => $hold->start_time,
                'end_time'      => $hold->end_time
            ]);

            $params = array(
                'transaction_details' => array(
                    'order_id' => rand(),
                    'gross_amount' => 10000,
                )
            );

            $snapToken = \Midtrans\Snap::getSnapToken($params);

            $hold->delete();

            // Set your Merchant Server Key
            \Midtrans\Config::$serverKey = config('midtrans.serverKey');
            // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
            \Midtrans\Config::$isProduction = false;
            // Set sanitization on (default)
            \Midtrans\Config::$isSanitized = true;
            // Set 3DS transaction for credit card to true
            \Midtrans\Config::$is3ds = true;

            return response()->json([
                'success' => true,
                'data' => $booking
            ]);
        });
    }

    public function callback(Request $request)
    {
        $booking = Booking::where('payment_ref', $request->order_id)->first();

        if (!$booking || $booking->status === 'Paid') {
            return response()->json(['ok' => true]);
        }
        if ($request->transaction_status === 'settlement') {
            $booking->update(['status' => 'paid']);
        }

        return response()->json(['ok' => true]);
    }
}
