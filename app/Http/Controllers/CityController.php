<?php

namespace App\Http\Controllers;

use App\Models\city;
use Illuminate\Http\Request;
use Validator;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $records = city::get();
        return $records;
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
            'city' => 'required|string'
        ]);
        if($validate->fails()){
            return response($validate->errors());
        }

        // Add city To Database
        city::create([
            'city_name' => $request->city,
        ]);

        return response(['Message' => "City Inserted Succesfully"]);
    }

    /**
     * Display the specified resource.
     */
    public function show($city)
    {
        $record = city::find($city);
        if(!$record){
            return response(['message' => 'City Not Found']);
        }
        return response(['records' => $record]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $city = city::find($id);
        if(!$city){
            return response(['Message' => "City Not Found"] , 404);
        }
        return $city;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, city $city)
    {
        //  Validation
        $validate = Validator::make($request->all() , [
            'city' => 'required|string'
        ]);
        if($validate->fails()){
            return response($validate->errors());
        }

        // Update City Record
        $city->city_name = $request->city;
        $city->save();
        return response(['Message' => "Record Updated Successfully"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(city $city=null)
    {
        $city =  city::find($city->id) ;
        if(!$city){
            return response(['Message' => "City Not Found"] , 404);
        }
        $city->delete();
        return response(['Message' => "Record Deleted Successfully"]);
    }
}
