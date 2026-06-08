<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Booking;
use App\Models\BookingSession;
use App\Models\BookingHold;
use App\Models\BookingHoldHeader;
use App\Models\BookingHoldAdditional;
use App\Models\BookingAdditional;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Midtrans\Snap;
use Illuminate\Support\Str;

use function Symfony\Component\Clock\now;

class BookingHoldController extends Controller
{
    public function storeAuth(Request $request)
    {
        $request->validate([
            'venue_id' => 'required|exists:venues,id',
            'court_id' => 'required|exists:courts,id',
            'date' => 'required|date',
            'sessions' => 'required|array|min:1',
            'sessions.*.start' => 'required',
            'sessions.*.end' => 'required',
            'sessions.*.price' => 'required|integer',
            'additions' => 'nullable|array',
            'additions.*.id' => 'required|exists:additionals,id'
        ]);

        $userId = Auth::id();

        $checkExisting = BookingHoldHeader::where('user_id', $userId)->first();

        if ($checkExisting) {
            $checkExisting->delete();
        }

        $bookingHoldHeader = BookingHoldHeader::create([
            'venue_id'     => $request->venue_id,
            'court_id'     => $request->court_id,
            'user_id'      => $userId,
            'booking_type' => 'Self-booking',
            'booking_date' => $request->date
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

    public function storeGuest(Request $request)
    {
        $request->validate([
            'venue_id' => 'required|exists:venues,id',
            'court_id' => 'required|exists:courts,id',
            'date' => 'required|date',
            'sessions' => 'required|array|min:1',
            'sessions.*.start' => 'required',
            'sessions.*.end' => 'required',
            'sessions.*.price' => 'required|integer',
            'guest_contact' => 'required|string',
            'additions' => 'nullable|array',
            'additions.*.id' => 'required|exists:additionals,id'
        ]);

        $checkExisting = BookingHoldHeader::where('guest_contact', $request->guest_contact)->first();

        if ($checkExisting) {
            $checkExisting->delete();
        }

        $expiresAt = Carbon::now()->addMinutes(10);

        $bookingHoldHeader = BookingHoldHeader::create([
            'venue_id' => $request->venue_id,
            'court_id' => $request->court_id,
            'guest_contact' => $request->guest_contact,
            'guest_name' => $request->guest_name,
            'booking_type' => 'Self-booking',
            'booking_date'  => $request->date,
            'expires_at' => $expiresAt
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
            'expires_at' => $expiresAt,
            'booking_hold_header_id' => $bookingHoldHeader->id,
            'sessions' => $holds,
            'additional' => $additionRows
        ]);
    }

    public function show($id)
    {
        $header = BookingHoldHeader::with([
            'venue:id,name',
            'venue.firstImage',
            'court:id,name,image',
            'court.addition.additionalType',
            'additional',
            'additional.additional.additionalType',
            'hold:id,booking_hold_header_id,start_time,end_time,price'
        ])
            ->findOrFail($id);

        $header->session_price = $header->hold->sum('price');
        $header->subtotal = ($header->hold->sum('price') + $header->additional->sum('price'));
        $header->admin_fee = 4000;
        $header->tax = $header->subtotal * 0.02;
        $header->total_price = ($header->subtotal + $header->admin_fee + $header->tax);

        return response()->json([
            'success' => true,
            'data' => $header,
        ]);
    }

    public function cancel(Request $request)
    {
        $request->validate([
            'booking_hold_header_id' => 'required|integer',
        ]);

        $header = BookingHoldHeader::with('hold')
            ->find($request->booking_hold_header_id);

        if (!$header) {
            return response()->json([
                'success' => false,
                'message' => 'Booking hold header not found'
            ], 404);
        }

        $header->delete();

        return response()->json([
            'success' => true
        ]);
    }

    public function active(Request $request)
    {
        $user = Auth::user();

        $hold = BookingHold::with('header')
            ->where('user_id', $user->id)
            ->whereHas('header', function ($q) {
                $q->where('status', 'hold'); // atau unpaid
            })
            ->latest()
            ->first();

        return response()->json([
            'has_active' => (bool) $hold,
            'hold' => $hold,
        ]);
    }

    public function replace(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required|integer',
        ]);

        DB::transaction(function () use ($request) {
            // hapus booking lama
            BookingHold::where('user_id', Auth::id())->delete();
            BookingHoldHeader::where('user_id', Auth::id())
                ->where('status', 'hold')
                ->delete();

            // buat booking baru
            $header = BookingHoldHeader::create([
                'user_id' => Auth::id(),
                'status' => 'hold',
            ]);

            BookingHold::create([
                'booking_hold_header_id' => $header->id,
                'user_id' => Auth::id(),
                'schedule_id' => $request->schedule_id,
            ]);
        });

        return response()->json([
            'success' => true,
        ]);
    }

    public function check()
    {
        $user = Auth::check();

        if ($user) {
            $checkExisting = BookingHoldHeader::where('user_id', Auth::id())->first();
        }

        if ($checkExisting) {
            return response()->json([
                'success' => true,
                'data'   => $checkExisting
            ]);
        } else {
            return response()->json([
                'success' => false,
                'data' => $checkExisting
            ]);
        }
    }

    public function createPayment($id)
    {
        try {

            $header = BookingHoldHeader::with(['hold', 'additional'])->findOrFail($id);

            $orderId = 'ORDER-' . time() . '-' . $header->id;

            $sessionTotal = $header->hold->sum('price');
            $additionalTotal = $header->additional->sum('price');

            $subtotal = $sessionTotal + $additionalTotal;
            $admin_fee = 4000;
            $tax = $subtotal * 0.02;
            $total_price = ($subtotal + $admin_fee + $tax);

            if ($total_price <= 0) {
                throw new \Exception('Total price is 0');
            }

            $params = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => $total_price,
                ],
            ];

            $snapToken = \Midtrans\Snap::getSnapToken($params);

            $header->update([
                'midtrans_order_id' => $orderId,
                'snap_token' => $snapToken,
                'payment_status' => 'pending',
                'expires_at' => Carbon::now()->addMinutes(15),
            ]);

            return response()->json([
                'snap_token' => $snapToken
            ]);
        } catch (\Exception $e) {
            \Log::error($e);
            dd($e->getMessage(), $e->getLine());
        }
    }


    private function generateCode()
    {
        do {
            $code = strtoupper(Str::random(6));
        } while (Booking::where('code', $code)->exists());

        return $code;
    }

    private function markAsPaid($orderId)
    {
        DB::transaction(function () use ($orderId) {

            $header = BookingHoldHeader::with('hold', 'additional')
                ->where('midtrans_order_id', $orderId)
                ->first();

            if (!$header) return;

            $sessionTotal = $header->hold->sum('price');
            $additionalTotal = $header->additional->sum('price');

            $subtotal = $sessionTotal + $additionalTotal;
            $admin_fee = 4000;
            $tax = $subtotal * 0.02;
            $total_price = ($subtotal + $admin_fee + $tax);

            $admin_fee = 4000;
            $tax = $subtotal * 0.02;
            $total_price = ($subtotal + $admin_fee + $tax);

            $booking = Booking::create([
                'user_id' => $header->user_id,
                'guest_contact' => $header->guest_contact,
                'guest_name' => $header->guest_name,
                'venue_id' => $header->venue_id,
                'court_id' => $header->court_id,
                'booking_date' => $header->booking_date,
                'price' => $subtotal,
                'admin_fee'  => $admin_fee,
                'tax'        => $tax,
                'total_price' => $total_price,
                'midtrans_order_id' => $header->midtrans_order_id,
                'payment_status' => 'Paid',
                'status' => 'Confirmed',
                'code' => $this->generateCode()
            ]);

            foreach ($header->hold as $hold) {
                BookingSession::create([
                    'booking_id' => $booking->id,
                    'start_time' => $hold->start_time,
                    'end_time'   => $hold->end_time,
                    'price'      => $hold->price,
                ]);
            }

            if ($header->additional) {
                foreach ($header->additional as $add) {
                    BookingAdditional::create([
                        'booking_id'    => $booking->id,
                        'additional_id' => $add->id,
                        'price'         => $add->price,
                    ]);
                }
            }

            $header->additional()->delete();
            $header->hold()->delete();
            $header->delete();
        });
    }

    private function markAsFailed($orderId)
    {
        $header = BookingHoldHeader::where('midtrans_order_id', $orderId)->first();

        if (!$header) return;

        $header->hold()->delete();
        $header->delete();
    }

    public function handle(Request $request)
    {
        $orderId = $request->order_id;
        $status = $request->transaction_status;
        $fraud = $request->fraud_status;

        $signatureKey = hash(
            'sha512',
            $request->order_id .
                $request->status_code .
                $request->gross_amount .
                config('midtrans.server_key')
        );

        if ($signatureKey !== $request->signature_key) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        if ($status == 'capture') {
            if ($fraud == 'accept') {
                $this->markAsPaid($orderId);
            }
        } elseif ($status == 'settlement') {
            $this->markAsPaid($orderId);
        } elseif ($status == 'expire' || $status == 'cancel') {
            $this->markAsFailed($orderId);
        }

        return response()->json(['message' => 'ok']);
    }
}
