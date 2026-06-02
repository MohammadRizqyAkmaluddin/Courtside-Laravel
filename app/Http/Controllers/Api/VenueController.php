<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VenueController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 12);

        $query = Venue::with([
            'city:id,city,province',
            'images:id,venue_id,image',
            'court' => function ($q) {
                $q->select(
                    'id',
                    'venue_id',
                    'sport_type_id',
                    'name',
                    'price',
                    'image'
                )
                ->with([
                    'sportType:id,type'

                ]);
            }
        ])
        ->withCount('court')
        ->withMin('court', 'price')
        ->withAvg('ratings as avg_rating', 'rate')
        ->withCount('ratings as total_reviews');

        if ($request->filled('search')) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }

        if ($request->filled('city_id')) {
            $query->where('city_id', $request->city_id);
        }

        if ($request->filled('sport_type_id')) {
            $query->whereHas('court', function ($q) use ($request) {
                $q->where('sport_type_id', $request->sport_type_id);
            });
        }

        $venues = $query->paginate($perPage);

        $venues->getCollection()->transform(function ($venue) {
            $venue->avg_rating = $venue->avg_rating
                ? number_format((float) $venue->avg_rating, 1)
                : 0;

            return $venue;
        });

        return response()->json($venues);
    }

    public function show(Venue $venue)
    {
        $venue->load([
            'facility:id,venue_id,facility_type_id',
            'city:id,city,province',
            'images:id,venue_id,image',
            'court.sportType:id,type',
            'booking' => function ($q) {
                $q->select('id', 'venue_id', 'court_id', 'user_id', 'price')
                  ->whereHas('rating')
                  ->with([
                    'user:id,name,profile_image',
                    'rating:id,booking_id,rate,review,updated_at',
                    'court:id,name'
                  ]);
            }
        ]);

        $venue->loadAvg('ratings as avg_rating', 'rate');
        $venue->avg_rating = number_format((float) $venue->avg_rating, 1);
        $venue->loadCount('ratings as total_reviews');

        $venue->avg_rating = $venue->avg_rating ?? 0;

        return response()->json([
            'success' => true,
            'data'   => $venue
        ]);
    }

    public function me(Request $request)
    {
        return response()->json([
            'data' => $request->user('venue')
        ]);
    }


}

