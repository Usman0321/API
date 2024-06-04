<?php

namespace App\Http\Controllers;

use App\Models\car;
use App\Models\carImage;
use Illuminate\Http\Request;
use Validator;
use Storage;
class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $records = car::with('subImages')->get();
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
            'name' => 'required|string',
            'type' => 'required|string',
            'license_plate' => 'required|string',
            'capacity' => 'required|integer',
            'price_per_day' => 'required|integer',
            // 'description' => 'required',
            'main_image' => 'required|file',
            // 'sub_images' => 'required|array|file',
        ]);

        if($validateData->fails()){
            return response(['errors' => $validateData->errors()] , 404);
        }

        // Check if this Vehical is already Exsist
        $ExistRecord = car::where('license_plate' , $request->license_plate)->first();
        if($ExistRecord){
            return response(['Message' => "This Car is already Exsist"]);
        }



        // Insert Car info into table
        $main_image = $request->file('main_image')->store("cars/" . $request->license_plate);
        $record = car::create([
            'name' => $request->name,
            'type' => $request->type,
            'license_plate' => $request->license_plate,
            'capacity' => $request->capacity,
            'price_per_day' => $request->price_per_day,
            'description' => $request->description,
            'main_image' => $main_image,
        ]);

        // Insert Sub Images in car_images table
        foreach ($request->file('sub_images') as $image) {
            $singleImage = $image->store("cars/{$request->license_plate}");
            carImage::create([
                'car_id' => $record->id,
                'image' => $singleImage,
            ]);
        }


        if($record){
            return response(['Message' => "Car Added" , 'Record' => $record] , 200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // return $car;
        $record = car::with(['subImages' => function($query) {
            $query->select('image', 'car_id');
        }])->where('id' , $id)->first();
        return $record;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(car $car)
    {
        $record = car::with(['subImages' => function ($query) {
            $query->select('id' , 'image' , 'car_id');
        }])->where('id' , $car->id)->first();

        return $record;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, car $car)
    {
        $validateData = Validator::make($request->all() , [
            'name' => 'required|string',
            'type' => 'required|string',
            'license_plate' => 'required|string',
            'capacity' => 'required|integer',
            'price_per_day' => 'required|integer',
            // 'main_image' => 'required|file',
            // 'sub_images' => 'required|array|file',
        ]);

        if($validateData->fails()){
            return response(['errors' => $validateData->errors()] , 404);
        }


        // First Delete Old main and sub Images than Add New Ones
        // $carRecord = car::with('subImages')->where('id' , $car->id)->first();
        // $mainImageExist = car::with('subImages')->where('main_image' , $carRecord->main_image)->exists();
        // if($mainImageExist){
        //     Storage::delete($carRecord->main_image);
        //     $mainImage = $validateData->file('main_image')->store('cars/'."$request->license_plate");
        // }
        // if ($request->hasFile('sub_images')) {
        //     foreach ($request->file('sub_images') as $image) {
        //         // Optionally, you can add logic here to check if a sub image should be replaced
        //         $subImagePath = $image->store("cars/{$car->license_plate}/sub_images");
        //         $car->subImages()->create(['image' => $subImagePath]);
        //     }
        // }



        // Insert Sub Images in car_images table
        // foreach ($request->file('sub_images') as $image) {
        //     $singleImage = $image->store("cars/{$request->license_plate}");
        //     carImage::create([
        //         'car_id' => $record->id,
        //         'image' => $singleImage,
        //     ]);
        // }


        //Update all the main And Sub images's record with there updated path.
            $oldLicensePlate = $car->license_plate;
            $newLicensePlate = $request->license_plate;

            if ($oldLicensePlate != $newLicensePlate) {
                $oldFolder = "cars/{$oldLicensePlate}";
                $newFolder = "cars/{$newLicensePlate}";

                if (Storage::exists($oldFolder)) {
                    Storage::move($oldFolder, $newFolder);
                }
                if ($car->main_image) {
                    $car->main_image = str_replace($oldLicensePlate, $newLicensePlate, $car->main_image);
                }
                foreach ($car->subImages as $subImage) {
                    $subImage->image = str_replace($oldLicensePlate, $newLicensePlate, $subImage->image);
                    $subImage->save();
                }
            }

        $car->name = $request->name ;
        $car->type = $request->type ;
        $car->license_plate = $request->license_plate ;
        $car->capacity = $request->capacity ;
        $car->price_per_day = $request->price_per_day ;
        $car->save();


        if($car){
            return response(['Message' => "Car Added" , 'Record' => $car] , 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(car $car)
    {
        $record = car::with('subImages')->where('id' , $car->id)->first();
        storage::delete($record->subImages());
        $record->delete();
        return response(['Message' => 'Record Deleted Successfully']);
    }

    public function showSubImages($carId){
        $records = carImage::where('car_id' , $carId)->get();
        return $records;
    }
    public function addSubImages(Request $request,$id){

        $img_address = carImage::where('car_id' , $id)->first()->image;
        $addressExploded = explode('/' , $img_address);
        $oldCarAddress = $addressExploded[0] . '/' . $addressExploded[1];
        foreach ($request->images as $image) {
            $file = $image->store($oldCarAddress);
            carImage::create([
                'car_id' => $id,
                'image' => $file,
            ]);
        }
        return response(['Message' => "Images Added successfully"]);
    }

    public function deleteSubImages(Request $request,$id){
        $allImagesRecords = carImage::where('car_id' , $id)->pluck('id');
        $imagesToDelete = [];
        foreach ($allImagesRecords as $oldImage) {
            if(!in_array($oldImage , $request->images)){
                $imagesToDelete[] = $oldImage  ;
            }
        }
        CarImage::whereIn('id', $imagesToDelete)->delete();
        return response(['Message' => "Images Deleted successfully"]);

    }
}
