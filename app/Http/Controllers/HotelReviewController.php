<?php

namespace App\Http\Controllers;

use App\Models\hotelReview;
use Illuminate\Http\Request;
use Validator;

class HotelReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $records = hotelReview::with('hotel:id,hotel_name','user:id,name,email')->get();
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
        $validateData = Validator::make($request->all() , [
            'rating' => 'required|numeric',
            'review_description' => 'string',
        ]);
        if($validateData->fails()){
            return response(['Error' => $validateData->errors()] , 404);
        }

        $record = hotelReview::create([
            'user_id' => $request->user_id,
            'hotel_id' => $request->hotel_id,
            'rating' => $request->rating,
            'review_description' => $request->review_description,
        ]);

        if($record){
            return response(['Message' => "Hotel Review Added" , 'Record' => $record] , 200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $record = hotelReview::with('hotel','user')->where('id' , $id)->first();
        return $record;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $record = hotelReview::with('hotel','user')->where('id' , $id)->first();
        if(!$record){
            return response(['Message' => "Record Not Found"]);
        }
        return response(['Records' => $record]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {

        $record = hotelReview::with('hotel','user')->where('id' , $id)->first();
        if(!$record){
            return response(['Message' => "Record Not Found"]);
        }

        $validateData = Validator::make($request->all() , [
            'rating' => 'required|numeric',
            'review_description' => 'string',
        ]);
        if($validateData->fails()){
            return response(['Error' => $validateData->errors()] , 404);
        }

        $record->rating = $request->rating ;
        $record->review_description = $request->review_description ;
        $record->save();
        if($record){
            return response(['Message' => "Hotel Review Updated     " , 'Record' => $record] , 200);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(hotelReview $hotelReview)
    {
        //
    }
}
