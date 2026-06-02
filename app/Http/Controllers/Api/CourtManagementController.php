<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CourtManagementController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            ''
        ]);
    }
}
