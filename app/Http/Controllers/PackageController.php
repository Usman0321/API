<?php

namespace App\Http\Controllers;

use App\Models\package;
use Illuminate\Http\Request;
use Validator;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $records = package::with('hotel')->get();
        if(!$records){
            return response(['Message' => "Package Not Found"]);
        }
        return response(['Records' => $records]);
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

        $validatedData = Validator::make($request->all() , [
            'package_name' => 'required|string',
            'package_type' => 'required|string',
            'price' => 'required|integer',
            'duration' => 'required|string',
            'description' => 'required|string',
            'hotel_details' => 'required|integer',
            'laugage_capacity' => 'required|string',
            'group_size' => 'required|integer',
            'departure_date' => 'required',
            'return_date' => 'required',
            'contact_information' => 'required|string',
        ]);

        if($validatedData->fails()){
            return response($validatedData->errors() , 400);
        }


        // Check if package is already Exist
        // $room = package::where('package_name' , $request->room_number)->first();
        // if($room){
        //     return response(['Message' => 'This Room number is already taken'] , 403);
        // }

        // Insert Room Package into database
        $room = package::create([
            'package_name' => $request->package_name,
            'package_type' => $request->package_type,
            'price' => $request->price,
            'duration' => $request->duration,
            'description' => $request->description,
            'hotel_details' => $request->hotel_details,
            'laugage_capacity' => $request->laugage_capacity,
            'group_size' => $request->group_size,
            'departure_date' => $request->departure_date,
            'return_date' => $request->return_date,
            'contact_information' => $request->contact_information,
        ]);


        return response(['Message' => "Package Added Successfully"] , 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $record = package::with('hotel')->where('id' , $id)->first();
        if(!$record){
            return response(['Error' => "Package Not Found"] );
        }
        return $record;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(package $package)
    {
        $record = package::with('hotel')->where('id' , $package->id)->first();
        if(!$record){
            return response(['Error' => "Package Not Found"] );
        }
        return $record;

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, package $package)
    {
        $validatedData = Validator::make($request->all() , [
            'package_name' => 'required|string',
            'package_type' => 'required|string',
            'price' => 'required|integer',
            'duration' => 'required|string',
            'description' => 'required|string',
            'hotel_details' => 'required|integer',
            'laugage_capacity' => 'required|string',
            'group_size' => 'required|integer',
            'departure_date' => 'required',
            'return_date' => 'required',
            'contact_information' => 'required|string',
        ]);

        if($validatedData->fails()){
            return response($validatedData->errors() , 400);
        }

        // Update Package Record
            $package->package_name  =  $request->package_name;
            $package->package_type  =  $request->package_type;
            $package->price  =  $request->price;
            $package->duration  =  $request->duration;
            $package->description  =  $request->description;
            $package->hotel_details  =  $request->hotel_details;
            $package->laugage_capacity  =  $request->laugage_capacity;
            $package->group_size  =  $request->group_size;
            $package->departure_date  =  $request->departure_date;
            $package->return_date  =  $request->return_date;
            $package->contact_information  =  $request->contact_information;
            $package->save();

        return response(['Message' => "Package Added Successfully"] , 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(package $package)
    {
        $record = package::where('id' , $package->id)->first();
        if(!$record){
            return response(['Error' => "Package Not Found"] );
        }
        $record->delete();
        return response(['Message' => "Package Deleted"] );

    }
}
