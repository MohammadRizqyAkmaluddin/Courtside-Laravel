<?php

namespace App\Http\Controllers\Api\CSM;

use App\Http\Controllers\Controller;
use App\Models\Court;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CourtController extends Controller
{
    public function indexCourt()
    {
        $data = Court::with(['sportType', 'courtType', 'addition.additionalType.additional'])
            ->where('venue_id', Auth::id())
            ->get();
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function showCourt(Court $court)
    {
        $court->load([
            'ratings'
        ]);
        $court->loadAvg('ratings', 'rate');
        $court->ratings_avg_rate = round((float) $court->ratings_avg_rate, 2);

        return response()->json([
            'success' => true,
            'data' => $court
        ]);
    }

    public function addCourt(Request $request)
    {
        $request->validate([
            'sport_type_id' => 'required|integer',
            'court_type_id' => 'required|integer',
            'court_material_id' => 'required|integer',
            'name' => 'required|string',
            'session_duration' => 'required|integer',
            'price' => 'required|integer',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
        ]);

        $imageName = null;
        
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $imageName = Str::random(20) . '.' . $extension;
            $file->storeAs('public/court', $imageName);
        }
        $data = Court::create([
            'venue_id' => Auth::id(),
            'sport_type_id' => $request->sport_type_id,
            'court_type_id' => $request->court_type_id,
            'court_material_id' => $request->court_material_id,
            'name' => $request->name,
            'session_duration' => $request->session_duration,
            'price' => $request->price,
            'image' => $imageName
        ]);

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function modifyCourt(Request $request)
    {
        $request->validate([
            'sport_type_id' => 'required|integer',
            'court_type_id' => 'required|integer',
            'court_material_id' => 'required|integer',
            'name' => 'required|string',
            'session_duration' => 'required|string',
            'price' => 'required|integer',
            'image' => 'required|image|mimes:png,jpg,jpeg,webp|max:2048',
        ]);

        $file = $request->file('image');
        $extension = $file->getClientOriginalExtension();
        $imageName = Str::random(20) . '.' . $extension;
        $file->storeAs('public/court', $imageName);

        $data = Court::update([
            'venue_id' => Auth::id(),
            'sport_type_id' => $request->sport_type_id,
            'court_type_id' => $request->court_type_id,
            'court_material_id' => $request->court_material_id,
            'name' => $request->name,
            'session_duration' => $request->session_duration,
            'price' => $request->price,
            'image' => $imageName
        ]);

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function removeCourt(Request $request)
    {
        $data = Court::where('id', $request->court_id)->delete();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
