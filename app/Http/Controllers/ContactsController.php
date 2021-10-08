<?php

namespace App\Http\Controllers;

use App\Models\Contacts;
use Illuminate\Http\Request;

class ContactsController extends Controller
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

    // Return all contacts in the database
    public function index()
    {
        $contacts = Contacts::all();
        foreach ($contacts as $contact) {
            $contact->last_viewed = date('c');
            $contact->save();
        }
        return response()->json($contacts);
    }

    public function create(Request $request)
    {
        $contact = new Contacts();
        $contact->name = $request->name;
        $contact->phone_number = $request->phone_number;
        $contact->address = $request->address;

        $result = $contact->save();
        if($result)
        {
            return response()->json($contact, 201);
        }
        return response()->json(array('error' => 'Contact named '.$request->name.' already exists'), 404);
    }

    public function show($id)
    {
        $contact = Contacts::find($id);
        $contact->last_viewed = date('c');
        $contact->save();
        if($contact)
        {
            return response()->json($contact);
        }
        return response()->json(array('error' => 'Contact ID '.$id.' is not found in database'), 404);
    }

    public function update(Request $request, $id)
    {
        $contact = Contacts::find($id);
        
        $changed = false;
        if($request->input('name'))
        {
            $contact->name = $request->input('name');
            $changed = !$changed;
        }
        if($request->input('phone_number'))
        {
            $contact->phone_number = $request->input('phone_number');
            $changed = !$changed;
        }
        if($request->input('address'))
        {
            $contact->address = $request->input('address');
            $changed = !$changed;
        }

        if($changed)
        {
            $contact->save();
            return response()->json(array('id' => $id));
        }
        return response()->json(array('error' => 'No items modified'), 400);
    }

    public function destroy($id)
    {
        $contact = Contacts::find($id);
        if($contact)
        {
            $contact->delete();
            return response()->json(array('id' => $id));
        }
    }
}
