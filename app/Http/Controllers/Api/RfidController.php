<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absen;

class RfidController extends Controller
{
    public function receiveRfid(Request $request)
    {
        Absen::create($request->all());
    }
}
