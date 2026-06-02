<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\Venue;
use Illuminate\Http\Request;

class VenueAuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name'          => 'required|string|max:100',
            'city_id'       => 'required|exists:regions,id',
            'email'         => 'required|email|unique:values,email',
            'password'      => 'required|min:8',
            'phone'         => 'required|max:15',
            'address'       => 'required|string',
        ]);

        $data['password'] = Hash::make($data['password']);
        $venue = Venue::create($data);

        return response()->json([
            'message'   => 'Venue registered succesfully',
            'venue'     => $venue
        ], 201);
    }

    public function login(Request $request)
    {
        $venue = Venue::where('email', $request->email)->first();

        if(!$venue || !Hash::check($request->password, $venue->password)) {
            return response()->json(['message' => 'Invalid Credentials'], 401);
        }

        $token = $venue->createToken('venue-token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'venue' => $venue
        ]);
    }

    public function profile(Request $request)
    {
        return response()->json($request->user());
    }
}
