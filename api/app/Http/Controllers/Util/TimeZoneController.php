<?php

namespace App\Http\Controllers\Util;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TimeZoneController extends Controller
{
    /**
     * Returns a listing of all timezones from PHP.
     * 
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(allTimeZones());
    }
}
