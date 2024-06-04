<?php

namespace App\Http\Controllers;

use App\Models\amenity;
use App\Models\room;
use App\Models\room_amenity;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Validator;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $records = room::with('amenities')->get();
        if(!$records){
            return response(['Message' => "Users Not Found"]);
        }
        return response(['Records' => $records]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     */

    public function logout(){
        return 'DEleted';
    }
    public function store(Request $request){
        $validatedData = Validator::make($request->all() , [
            'room_number' => 'required',
            'hotel_id' => 'required|integer',
            'room_capacity' => 'required | integer',
            'price_per_night' => 'required| numeric',
            'amenities' => 'required|array|exists:amenities,id',
            // 'room_images' => 'required || file',
        ]);

        if($validatedData->fails()){
            return response($validatedData->errors() , 400);
        }


        // Check if room is already Exist
        $room = room::where('room_number' , $request->room_number)->first();
        if($room){
            return response(['Message' => 'This Room number is already taken'] , 403);
        }

        // Insert Room data into database
        $room = room::create([
            'room_number' => $request->room_number,
            'hotel_id' => $request->hotel_id,
            'room_capacity' => $request->room_capacity,
            'price_per_night' => $request->price_per_night,
            'availability' => "Available"
        ]);


        // convert an stringed ["1,3,5"] array of amenities into ORG [1,3,5] array
        $stringValue = $request->amenities[0];
        $stringArray = explode(',', $stringValue);
        $amenities_arr = array_map('intval', $stringArray);
        foreach ($amenities_arr as $amenityId) {
            room_amenity::create([
                'amenity_id' => $amenityId,
                'room_id' => $room->id
            ]);
        }

        // $images = $request->file('images');
        // foreach ($images as $image) {
        //     $result .= $value.getClientO;
        // }


        return response(['Message' => "Room Added Successfully"] , 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(room $room )
    {
        $record = room::where('id' , $room->id)->with('amenities')->first();
        return response($record);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($room)
    {
        $record = room::with('amenities')->find( $room);
        if(!$record){
            return response(['Message' => "Record Not Found"]);
        }
        return response(['Records' => $record]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, room $room)
    {

        $validatedData = Validator::make($request->all() , [
            'room_number' => 'required',
            'hotel_id' => 'required|integer',
            'room_capacity' => 'required | integer',
            'price_per_night' => 'required| numeric',
            'amenities' => 'required|array|exists:amenities,id',
        ]);

        if($validatedData->fails()){
            return response($validatedData->errors() , 400);
        }


        // Update Room Information
        $room->room_number = $request->room_number;
        $room->hotel_id = $request->hotel_id;
        $room->room_capacity = $request->room_capacity;
        $room->price_per_night = $request->price_per_night;

        // First Delete Old Amenities than Add New Ones
        $amenitiesExist = room_amenity::where('room_id', $room->id)->exists();
            if($amenitiesExist){
                room_amenity::where('room_id' , $room->id)->delete();
            }

        // Converting an stringed ["1,3,5"] array of amenities into ORG [1,3,5] array
        $stringValue = $request->amenities[0];
        $stringArray = explode(',', $stringValue);
        $amenities_arr = array_map('intval', $stringArray);
        foreach ($amenities_arr as $amenityId) {
            room_amenity::create([
                'amenity_id' => $amenityId ,
                'room_id'=> $room->id
            ]);
        }

        $room->save();
        return ['record' =>$room , 'Message' => 'Updated Successfully'];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(room $room)
    {
        $room->delete();
        return response(["Message" => "Record Deleted"]);
    }
}
