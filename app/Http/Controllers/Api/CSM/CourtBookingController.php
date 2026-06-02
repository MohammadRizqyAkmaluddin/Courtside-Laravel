<?php

namespace App\Http\Controllers\Api\CSM;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingHold;
use App\Models\BookingHoldHeader;
use App\Models\CancelRequest;
use App\Models\Court;
use App\Models\ManualBooking;
use App\Models\ManualBookingAdditional;
use App\Models\ManualBookingSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;


class CourtBookingController extends Controller
{
    public function index(Request $request)
    {
        $perpage = $request->get('per_page', 3);
        $query = Booking::where('venue_id', Auth::id())
            ->with(['sessions', 'additional.additional.additionalType', 'court'])
            ->orderBy('created_at', 'DESC');

        if ($request->filled('status')) {
            if ($request->status == 'confirmed') {
                $query->where('status', 'Confirmed');
            } elseif ($request->status == 'canceled') {
                $query->where('status', 'Canceled');
            } elseif ($request->status == 'active') {
                $query->where(function ($q) {
                    $q->where('booking_date', '>', now()->toDateString())
                    ->orWhere(function ($q2) {
                        $q2->where('booking_date', now()->toDateString())
                            ->whereRaw("
                                CONCAT(booking_date, ' ', (
                                    SELECT MAX(end_time)
                                    FROM booking_sessions
                                    WHERE booking_sessions.booking_id = bookings.id
                                )) >= ?
                            ", [now()]);
                    });
                });
            }
        }
        if ($request->filled('user_type')) {
            if ($request->user_type == 'guest') {
                $query->where('guest_contact', '!=', NULL);
            } elseif ($request->user_type == 'registered') {
                $query->where('user_id', '!=', NULL);
            }
        }
        if ($request->filled('order_by')) {
            if ($request->date == 'oldest') {
                $query->orderBy('created_at', 'ASC');
            } elseif ($request->date == 'newest') {
                $query->orderBy('created_at', 'DESC');
            }
        }
        if ($request->filled('court')) {
            $query->where('court_id', $request->court);
        }
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $start = Carbon::parse($request->start_date)->startOfDay();
            $end = Carbon::parse($request->end_date)->endOfDay();

            $query->whereBetween('created_at', [$start, $end]);
        }

        $data = $query->paginate($perpage);

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function todayBooking(Request $request)
    {
        $query = Booking::where('venue_id', Auth::id())
            ->with(['sessions', 'additional.additional.additionalType', 'court', 'user'])
            ->where('booking_date', '>=', now()->toDateString())
            ->where('status', '>=', 'Confirmed')
            ->orderBy('booking_date', 'ASC')
            ->orderByRaw("
                (
                    SELECT MIN(start_time)
                    FROM booking_sessions
                    WHERE booking_sessions.booking_id = bookings.id
                ) ASC
            ");

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('court', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%");
                });
            });
        }

        if ($request->filled('filter')) {
            $now = now();
            if ($request->filter == 'ongoing') {
                $query->whereRaw("
                    CONCAT(booking_date, ' ', (
                        SELECT MIN(start_time)
                        FROM booking_sessions
                        WHERE booking_sessions.booking_id = bookings.id
                    )) <= ?
                ", [$now])
                ->whereRaw("
                    CONCAT(booking_date, ' ', (
                        SELECT MAX(end_time)
                        FROM booking_sessions
                        WHERE booking_sessions.booking_id = bookings.id
                    )) >= ?
                ", [$now]);
            }

            if ($request->filter == 'passed') {
                $query->whereRaw("
                    CONCAT(booking_date, ' ', (
                        SELECT MAX(end_time)
                        FROM booking_sessions
                        WHERE booking_sessions.booking_id = bookings.id
                    )) < ?
                ", [$now]);
            }

            if ($request->filter == 'upcoming') {
                $query->whereRaw("
                    CONCAT(booking_date, ' ', (
                        SELECT MIN(start_time)
                        FROM booking_sessions
                        WHERE booking_sessions.booking_id = bookings.id
                    )) > ?
                ", [$now]);
            }
        }

        if ($request->filled('court')) {
            $query->where('court_id', $request->court);
        }

        $data = $query->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function upcomingBooking()
    {
        $data = Booking::where('venue_id', Auth::id())
            ->with(['sessions', 'additional.additional.additionalType', 'court'])
            ->where(function ($q) {
                $q->where('booking_date', '>', now()->toDateString())
                ->orWhere(function ($q2) {
                    $q2->where('booking_date', '>', now()->toDateString())
                        ->whereRaw("
                            CONCAT(booking_date, ' ', (
                                SELECT MAX(end_time)
                                FROM booking_sessions
                                WHERE booking_sessions.booking_id = bookings.id
                            )) >= ?
                        ", [now()]);
                });
            })
            ->orderBy('booking_date', 'asc')
            ->orderByRaw("
                (
                    SELECT MIN(start_time)
                    FROM booking_sessions
                    WHERE booking_sessions.booking_id = bookings.id
                ) ASC
            ")
            ->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function cancelRequest(Request $request)
    {
        $perpage = $request->get('per_page', 1);
        $query = CancelRequest::with(['booking.user', 'booking.court', 'booking.sessions'])
                ->where('status', 'Requested')
                ->whereHas('booking', function ($q) {
                    $q->where('venue_id', Auth::id());
                })
                ->orderBy('created_at', 'ASC');

        $data = $query->paginate($perpage);
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function cancelRequestMobile(Request $request)
    {
        $data = CancelRequest::with(['booking.user', 'booking.court', 'booking.sessions'])
                ->where('status', 'Requested')
                ->whereHas('booking', function ($q) {
                    $q->where('venue_id', Auth::id());
                })
                ->orderBy('created_at', 'ASC')
                ->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function cancelDetail(Request $request)
    {
        $data = CancelRequest::where('id', $request->id)->first();
        
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function rejectCancel(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:cancel_requests,id'
        ]);

        CancelRequest::where('id', $request->id)
            ->update([
                'status' => 'Rejected'
            ]);

        $data = CancelRequest::with(['booking'])
                ->where('id', $request->id)
                ->first();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function cancelBooking(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:cancel_requests,id'
        ]);

        $cancel = CancelRequest::where('id', $request->id)->first();

        CancelRequest::where('id', $request->id)
            ->update([
                'status' => 'Accepted'
            ]);

        Booking::where('id', $cancel->booking_id)
            ->update([
                'payment_status' => 'Refund',
                'status' => 'Canceled'
            ]);

        $data = CancelRequest::with(['booking'])
                ->where('id', $request->id)
                ->first();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

     public function indexCourt()
    {
        $data = Court::where('courts.venue_id', Auth::id())
            ->leftJoin('bookings', function ($join) {
                $join->on('courts.id', '=', 'bookings.court_id')
                    ->where('bookings.status', '!=', 'Canceled');
            })
            ->leftJoin('booking_sessions', 'bookings.id', '=', 'booking_sessions.booking_id')
            ->select(
                'courts.*',
                DB::raw('COUNT(booking_sessions.id) as total_sessions_used')
            )
            ->groupBy('courts.id')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function bookingHold(Request $request)
    {
        $request->validate([
            'court_id'      => 'required|exists:courts,id',
            'guest_name'    => 'required|string',
            'guest_contact' => 'required|string',
            'date'          => 'required|date',
            'sessions'      => 'required|array|min:1',
            'sessions.*.start' => 'required',
            'sessions.*.end' => 'required',
            'sessions.*.price' => 'required|integer',
            'additions'     => 'nullable|array',
            'additions.*.id' => 'required|exists:additionals,id'
        ]);

        $checkExisting = BookingHoldHeader::where('venue_id', Auth::id())
                        ->where('booking_type', 'Manual-booking')
                        ->first();

        if ($checkExisting) {
            $checkExisting->delete();
        }

        $bookingHoldHeader = BookingHoldHeader::create([
            'venue_id'     => Auth::id(),
            'court_id'     => $request->court_id,
            'booking_type' => 'Manual-Booking',
            'booking_date' => $request->date,
            'guest_name'   => $request->guest_name,
            'guest_contact'=> $request->guest_contact
        ]);

        $holds = [];
        foreach ($request->sessions as $session) {
            $holds[] =  BookingHold::create([
                'booking_hold_header_id' => $bookingHoldHeader->id,
                'start_time' => $session['start'],
                'end_time' => $session['end'],
                'price' => $session['price'],
            ]);
        }

        $additionRows = [];

        if ($request->has('additions')) {
            foreach ($request->additions as $addition) {

                $data = DB::table('additionals')
                    ->where('id', $addition['id'])
                    ->first();

                if (!$data) continue;

                $additionRows[] = [
                    'booking_hold_header_id' => $bookingHoldHeader->id,
                    'additional_id' => $data->id,
                    'price' => $data->price,
                ];
            }
        }

        if (!empty($additionRows)) {
            DB::table('booking_hold_additions')->insert($additionRows);
        }

        return response()->json([
            'success' => true,
            'booking_hold_header_id' => $bookingHoldHeader->id,
            'sessions' => $holds,
            'additional' => $additionRows
        ]);
    }

    public function paymentSummary()
    {
        $data = BookingHoldHeader::with([
                'hold',
                'additional.additional.additionalType',
                'court'
            ])
            ->where('booking_type', 'Manual-booking')
            ->where('venue_id', Auth::id())
            ->first();

        if ($data) {
            if ($data->additional != null) {
                $data->additional_price = $data->additional->sum('price');
            }
            $data->court_price = $data->hold->sum('price');
            $data->subtotal = $data->court_price + $data->additional_price;
            $data->tax = $data->subtotal * 0.01;
            $data->total_price = $data->subtotal + $data->tax;
        }

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function cancelPayment()
    {
        BookingHoldHeader::where('booking_type', 'Manual-booking')
            ->where('venue_id', Auth::id())
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Booking summary removed'
        ]);
    }

    public function pay(Request $request)
    {
        $hold = BookingHoldHeader::with([
                'hold',
                'additional.additional.additionalType',
                'court'
                ])
                ->where('booking_type', 'Manual-booking')
                ->where('venue_id', Auth::id())
                ->first();

        if ($hold->additional != null) {
            $additional_price = $hold->additional->sum('price');
        }
        $court_price = $hold->hold->sum('price');
        $subtotal = $court_price + $additional_price;
        $tax = $subtotal * 0.01;
        $total_price = $subtotal + $tax;


        $booking = ManualBooking::create([
            'venue_id' => Auth::id(),
            'court_id' => $hold->court_id,
            'customer_name' => $hold->guest_name,
            'customer_contact' => $hold->guest_contact,
            'booking_date' => $hold->booking_date,
            'subtotal' => $subtotal,
            'tax'      => $tax,
            'total_price' => $total_price,
            'payment_type' => $request->payment_type,
            'payment_status' => 'Paid',
            'status' => 'Confirmed',
            'code'   => $this->generateCode(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        foreach ($hold->hold as $session) {
            ManualBookingSession::create([
                'manual_booking_id' => $booking->id,
                'start_time' => $session->start_time,
                'end_time'   => $session->end_time,
                'price'      => $session->price,
            ]);
        }

        if ($hold->additional) {
            foreach ($hold->additional as $add) {
                ManualBookingAdditional::create([
                    'manual_booking_id' => $booking->id,
                    'additional_id' => $add->id,
                    'price'         => $add->price,
                ]);
            }
        }

        $hold->delete();
    }

    private function generateCode()
    {
        do {
            $code = strtoupper(Str::random(6));
        } while (ManualBooking::where('code', $code)->exists());

        return $code;
    }

}
