<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Favorite;
use Illuminate\Support\Facades\DB;

class FavoriteController extends Controller
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

    public function index()
    {
        $favorite = DB::table('favorite')->join('contacts', 'contacts.id', '=', 'favorite.contact_id')->get('contacts.*');
        return response()->json($favorite);
    }

    public function add_contact($contact_id)
    {
        $contact_result = DB::table('contacts')->where('id', '=', $contact_id)->exists();
        if(!$contact_result)
        {
            return response()->json(['error' => 'Contact not found'], 400);
        }
        $result = DB::table('favorite')->where('contact_id', '=', $contact_id)->exists();

        if(!$result)
        {
            DB::table('favorite')->insert(['contact_id' => $contact_id]);
            return response()->json(['contact_id' => $contact_id]);
        }
        return response()->json(['error' => 'Already exists'], 400);
    }

    public function delete_contact($contact_id)
    {
        $result = DB::table('favorite')->where('contact_id', '=', $contact_id)->exists();

        if($result)
        {
            DB::table('favorite')->where('contact_id', '=', $contact_id)->delete();
            return response()->json(['contact_id' => $contact_id]);
        }
        return response()->json(['error' => 'Mapping not found'], 400);
    }
}