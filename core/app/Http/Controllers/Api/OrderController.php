<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function update(Request $request){
        $request->validate([
           'body' => 'string|required'
        ]);

        $booking = Booking::query()->whereStatus($request->body)->first();

        if(!$booking)
            return response()->json([
                'status' => 404,
                'data' => 'Book not found!'
            ]);

        $booking->status = 1;
        $booking->save();

        return response()->json([
           'status' => 200,
           'data' => 'Update success!'
        ]);
    }
}
