<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SportType;
use App\Models\City;
use App\Models\CourtMaterial;
use App\Models\CourtType;
use Illuminate\Http\Request;

class LookupController extends Controller
{
    public function sportType()
    {
        return response()->json(
            SportType::all()
        );
    }

    public function city()
    {
        return response()->json(
            City::all()
        );
    }

    public function courtType()
    {
        return response()->json(
            CourtType::all()
        );
    }

    public function courtMaterial()
    {
        return response()->json(
            CourtMaterial::all()
        );
    }
}
