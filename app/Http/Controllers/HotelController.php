<?php

namespace App\Http\Controllers;

use App\Models\hotel;
use Illuminate\Http\Request;
use Validator;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

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
        // Validation
        $validate = Validator::make($request->all() , [
            'hotel' => 'required|string',
            'location' => 'required',
            'description' => 'required',
            'city' => 'required|integer|exists:cities,id'
        ]);
        if($validate->fails()){
            return response($validate->errors());
        }

        // Check If Hotel is already Exist
        $hotel = hotel::where('hotel_name' ,  $request->hotel)->first();
        if($hotel){
            return response(['message' => 'This Hotel Is Already Exist']);
        }

        // Add hotel to database
        $newHotel = hotel::create([
            'hotel_name' => $request->hotel,
            'location' => $request->location,
            'description' => $request->description,
            'city_id' => $request->city,
        ]);
        return response([ 'Record' => $newHotel , 'message' => 'Hotel Added Successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(hotel $hotel = null)
    {
        // return $hotel;
        $record = $hotel ? hotel::with('city')->where('id' , $hotel->id)->first() : hotel::with('city')->get();
        return response($record);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(hotel $hotel)
    {
        $record = hotel::with('city')->where('id' , $hotel->id)->first() ;
        return  response($record);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, hotel $hotel)
    {
        // Verify that user send a valid Id of Hotel
        $record = hotel::where('id' , $hotel->id)->first() ;
        if(!$record){
            return 'Hotel Not found';
        }

        // Validation on updated Data
        $validate = Validator::make($request->all() , [
            'hotel' => 'required|string',
            'location' => 'required',
            'description' => 'required',
            'city' => 'required|integer|exists:cities,id'
        ]);
        if($validate->fails()){
            return response($validate->errors());
        }

        // Update Hotel Record
        $record->hotel_name = $request->hotel;
        $record->city_id = $request->city;
        $record->location = $request->location;
        $record->description = $request->description;
        $record->save();
        return response(['Message' => "Record Is updated successfully"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(hotel $hotel)
    {
        $record =  hotel::with('city')->where('id' , $hotel->id)->first() ;
        $record->delete();
        return response('Record Deleted Successfully');
    }



}
