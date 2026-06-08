<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\CommunityMember;
use App\Models\BookingHoldHeader;
use App\Models\Booking;
use Carbon\Carbon;

class ActivityController extends Controller
{
    public function myActiveHolds()
    {
        $header = BookingHoldHeader::with([
            'venue',
            'court',
            'hold',
            'additional',

        ])
            ->where('user_id', Auth::id())
            ->orderBy('id')
            ->first();

        $header->subtotal = $header->hold->sum('price');
        $header->admin_fee = 4000;
        $header->tax = $header->subtotal * 0.02;
        $header->total_price = ($header->subtotal + $header->admin_fee + $header->tax);

        return response()->json($header);
    }

    public function getActiveBookings()
    {
        $now = Carbon::now();

        $bookings = Booking::with([
            'venue:id,name',
            'venue.firstImage',
            'court:id,name,image',
            'additional:id,booking_id,price,additional_id',
            'additional.additional.additionalType',
            'sessions' => function ($query) {
                $query->orderBy('start_time');
            }
        ])
            ->whereHas('sessions', function ($query) use ($now) {
                $query->whereRaw("CONCAT(booking_date, ' ', end_time) > ?", [$now]);
            })
            ->where('user_id', Auth::id())
            ->get();

        $bookings = $bookings->map(function ($booking) use ($now) {

            $bookingDate = Carbon::parse($booking->booking_date)->startOfDay();
            $today = $now->copy()->startOfDay();

            if ($bookingDate->equalTo($today)) {
                $booking->day_status = 'Today';
            } elseif ($bookingDate->equalTo($today->copy()->addDay())) {
                $booking->day_status = 'Tomorrow';
            } elseif ($bookingDate->greaterThan($today)) {
                $days = $today->diffInDays($bookingDate);
                $booking->day_status = "Starts in {$days} days";
            } else {
                $booking->day_status = 'Past';
            }

            $booking->sessions = $booking->sessions->map(function ($session) use ($now, $booking) {

                $endDateTime = Carbon::parse($booking->booking_date . ' ' . $session->end_time);

                $session->status = $endDateTime->gt($now);

                return $session;
            });

            $booking->active_sessions = $booking->sessions
                ->where('status', true)
                ->count();

            return $booking;
        });

        return response()->json([
            'success' => true,
            'data' => $bookings
        ]);
    }

    public function history()
    {
        $history =  Booking::with([
            'sessions:id,booking_id,start_time,end_time',
            'venue:id,name',
            'venue.firstImage',
            'court:id,name,image',
            'rating:id,booking_id,rate,review,updated_at',
            'additional:id,booking_id,price,additional_id',
            'additional.additional.additionalType',
        ])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'DESC')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $history
        ]);
    }

    public function myMembership()
    {
        $member = CommunityMember::with('community')
            ->where('user_id', Auth::user()->id)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $member
        ]);
    }

    public function leaveCommunity($communityId)
    {

        CommunityMember::where('user_id', Auth::id())
            ->where('community_id', $communityId)
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Member data removed'
        ]);
    }
}
