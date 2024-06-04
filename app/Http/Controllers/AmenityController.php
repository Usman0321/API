<?php

namespace App\Http\Controllers;

use App\Models\amenity;
use Illuminate\Http\Request;
use Validator;

class AmenityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $amenities = amenity::get();
        return $amenities;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validate = Validator::make($request->all() , [
            'icon' => 'required|file',
            'name' => 'required|string'
        ]);
        if($validate->fails()){
            return response($validate->errors());
        }


        // Verify if already have this type of Amenity
        $varification = amenity::where('name' , $request->name)->first();
        if($varification){
            return response('This Amenity is Already Existed');
        }

        // Insert Amenity into Table
        $file = $request->file('icon')->store('Amenity-Icons');
        amenity::create([
            'icon' => $file ,
            'name' => $request->name ,
        ]);


        return response(["Message" => 'Amenity Added Successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(amenity $amenity = null)
    {
        $record = amenity::find($amenity) ;
        return $record;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(amenity $amenity)
    {
        return $amenity;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, amenity $amenity)
    {
        // Apply Validation
            $validation = Validator::make($request->all() , [
                'icon' => 'required|file',
                'name' => 'required|string'
            ]);
            if($validation->fails()){
                return response(['Message' => $validation->errors()]);
            }
            

            // Update Room Information
            $file = $request->file('icon')->store('Amenity-Icons');

            $amenity->icon = $file;
            $amenity->name = $request->name;
            $amenity->save();
        return ['Amenity' => $amenity ,  'Message' => 'Updated Successfully'];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(amenity $amenity)
    {
        $amenity->delete();
        return response(['Message' => 'Amenity Deleted']);
    }
}
