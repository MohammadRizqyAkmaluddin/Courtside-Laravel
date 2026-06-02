<?php

namespace App\Http\Controllers\Api\CSM;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Facility;
use App\Models\OperationHour;
use App\Models\Venue;
use App\Models\VenueImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class VenueManagementController extends Controller
{
    public function bookingIndex()
    {
        $data = Booking::where('venue_id', Auth::id())->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function me(Request $request)
    {
        $venue = $request->user()->load('firstImage');

        return response()->json([
            'venue' => $venue
        ]);
    }

    public function meDetail(Request $request)
    {
        $venue = Venue::where('id', Auth::id())
        ->with('primaryImage')
        ->first();

        return response()->json([
            'data' => $venue
        ]);
    }

    public function venueImages()
    {
        $images = VenueImage::where('venue_id', Auth::id())->get();
        return response()->json([
            'data' => $images
        ]);
    }

    public function operationHours()
    {
        $hour = OperationHour::where('venue_id', Auth::id())->get();
        return response()->json([
            'data' => $hour
        ]);
    }

    public function facility()
    {
        $facility = Facility::where('venue_id', Auth::id())
            ->with('facilityType')
            ->get();
        return response()->json([
            'data' => $facility
        ]);
    }

    public function auth()
    {
        $venue = Venue::with([
            'firstImage',
            'court',
            'court.sportType:id,type',
            'qris',
            'bank' => function ($query) {
                $query->where('status', 'Main')
                ->first();
            }])
            ->where('id', Auth::id())
            ->first();

        return response()->json([
            'success' => true,
            'data' => $venue
        ]);
    }
}
