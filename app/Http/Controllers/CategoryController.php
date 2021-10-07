<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
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
        $categories = Category::all();
        return response()->json($categories);
    }

    public function create(Request $request)
    {
        $category = new Category();
        $category->category_name = $request->category_name;

        $result = $category->save();
        if($result)
        {
            return response()->json($category, 201);
        }
        return response()->json(array('error' => 'Category named '.$request->category_name.' already exists'), 404);
    }

    public function show($id)
    {
        $category = Category::find($id);
        $contact_list = DB::table('contacts')
                        ->join('category_contact_mapping','contacts.id','=','category_contact_mapping.contact_id')
                        ->where('category_contact_mapping.category_id', '=', $id)
                        ->get('contacts.*');
        if($category)
        {
            $category->contacts = $contact_list;
            return response()->json($category);
        }
        return response()->json(['error' => 'Category ID '.$id.' is not found in database)'], 404);
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        
        $changed = false;
        if($request->input('category_name'))
        {
            $category->category_name = $request->input('category_name');
            $changed = !$changed;
        }

        if($changed)
        {
            $category->save();
            return response()->json(['id' => $id]);
        }
        return response()->json(['error' => 'Category item is not modified'], 400);
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        if($category)
        {
            $category->delete();
            return response()->json(array('id' => $id));
        }
    }

    public function add_contact($category_id, $contact_id)
    {
        $result = DB::table('category_contact_mapping')->where([['category_id', '=', $category_id], ['contact_id', '=', $contact_id]])->exists();

        if(!$result)
        {
            DB::table('category_contact_mapping')->insert(['category_id' => $category_id, 'contact_id' => $contact_id]);
            return response()->json(['category_id' => $category_id, 'contact_id' => $contact_id]);
        }
        return response()->json(['error' => 'Already exists'], 400);
    }

    public function delete_contact($category_id, $contact_id)
    {
        $result = DB::table('category_contact_mapping')->where([['category_id', '=', $category_id], ['contact_id', '=', $contact_id]])->exists();

        if($result)
        {
            DB::table('category_contact_mapping')->where(['category_id' => $category_id, 'contact_id' => $contact_id])->delete();
            return response()->json(['category_id' => $category_id, 'contact_id' => $contact_id]);
        }
        return response()->json(['error' => 'Mapping not found'], 400);
    }
}