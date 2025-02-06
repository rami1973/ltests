<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sms;
use Illuminate\Http\Request;

class SmsController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'sender' => 'required|string',
            'message' => 'required|string',
            'device_id' => 'required|string',
            'sim_slot' => 'required|integer|min:1'
        ]);

        $sms = Sms::create($validated);

        return response()->json($sms, 201);
    }

    public function index()
    {
        $messages = Sms::orderBy('created_at', 'desc')->paginate(10);
        return response()->json($messages);
    }
}