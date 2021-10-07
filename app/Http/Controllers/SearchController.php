<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function search(Request $request)
    {
        $query = DB::table('contacts');
        // Builder time!
        if($request->name)
        {
            $query->where('name', 'ilike', '%'.$request->name.'%');
        }
        if($request->phone_number)
        {
            $query->where('phone_number', 'ilike', '%'.$request->phone_number.'%');
        }

        $result = $query->get();
        return response()->json($result);
    }
}