<?php

namespace App\Http\Controllers;

use App\Models\User;
use Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function login(Request $request){
        $validation =  Validator::make($request->all() , [
            'email' => 'required || email',
            'password' => 'required '
        ]);
        if($validation->fails()){
            return response(['Message' => $validation->error()]);
        }

        // Varify User
        $user = User::where('email' , $request->email)->first();
        if(!$user || Hash::check($user->passwod , $request->password)){
            return response(['Message' => 'Invalid Crendtials']);
        }

        // If Valid Credentials than send a token
        $token = $user->createToken('token')->plainTextToken;
        return response(['User' =>  $user , 'token' => $token] );
    }
     public function index(){
        $record = User::get();
        if(!$record){
            return response(['Message' => "Users Not Found"]);
        }
        return response(['Records' => $record]);
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
    public function store(Request $request)
    {
        // Check Validation
        $validate = Validator::make($request->all() , [
            'name' => 'required || string',
            'email' => 'required || email',
            'image' => 'required || file',
            'password' => 'required',
        ]);
        if($validate->fails()){
            return response([$validate->errors()]);
        }

        // Check If Email Already Exist
        $check_email = User::where('email' , $request->email)->first();
        if($check_email){
            return response(['Message' => "This Email is Already Exist Please Choose Another Email "]);
        }

        // Add User
        $file = $request->file('image')->store('API-User-Images');
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'image' => $file,
            'password' => Hash::make($request->password),
        ]);

        //Response
        return response(['user' => $user , "message" => "Account Created"]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $record = User::find($id);
        if(!$record){
            return response(['Message' => "Users Not Found"]);
        }
        return response(['Records' => $record]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $record = User::where('id' , $id)->first();
        if(!$record){
            return response(['Message' => "Record Not Found"]);
        }
        return $record;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $record = User::where('id' , $id)->first();
        if(!$record){
            return response(['Message' => "Record Not Found"]);
        }

        $Validate = Validator::make($request->all() , [
            'name' => 'required|string',
            'email' => 'required|email',
            'image' => 'required|file|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if($Validate->fails()){
            return response(['Errors' => $Validate->errors()] , 404);
        }

        if ($record->image) {
            $existingImagePath = 'API-User-Images/' . basename($record->image);
            if (Storage::exists($existingImagePath)) {
                Storage::delete($existingImagePath); // Delete the existing image
            }
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image')->store('API-User-Images');
            $record->image = $file;
        }
        $record->name = $request->name;
        $record->email = $request->email;

        return response([ 'record' => $record , 'Message' => "record Updated"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $record = User::find($id);
        if(!$record){
            return response(['Message' => "Record Not Found"] , 404);
        }
        if($record->image){
            $path = "API-User-Images/" . basename($record->image);
            Storage::delete($path);
        }
        $record->delete();
        return response(['Message' => "Record Deleted Successfully"] , 200);
    }


}
