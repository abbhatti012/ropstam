<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Exception;
use Illuminate\Http\Request;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = Car::orderBy('id','desc')->with('category')->get();
            return response()->json(['status' => 200, 'data' => $data]);
        } catch (\Throwable $th) {
            return response()->json(['status' => 500, 'data' => 'Server Error']);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'color' => 'required',
            'make' => 'required',
            'model' => 'required',
            'registration_number' => 'required',
        ]);
        try {
            $car = new Car;
            $car->name = $request->name;
            $car->cat_id = $request->category;
            $car->color = $request->color;
            $car->model = $request->model;
            $car->make = $request->make;
            $car->registration_number = $request->registration_number;
            if($car->save()){
                return response()->json(['status' => 200, 'message' => 'Car Inserted Sucessfully!', 'data' => $car]);
            } else {
                return response()->json(['status' => 201, 'message' => 'Unknown error occured!']);
            }
        } catch (Exception $e) {
            return response()->json(['status' => 500, 'message' => 'Server Error']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $data = Car::find($id);
            return response()->json(['status' => 200, 'data' => $data]);
        } catch (\Throwable $th) {
            return response()->json(['status' => 500, 'data' => 'Server Error']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function edit(Car $car)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'color' => 'required',
            'make' => 'required',
            'model' => 'required',
            'registration_number' => 'required',
        ]);
        try {
            $car = Car::find($id);
            $car->name = $request->name;
            $car->cat_id = $request->category;
            $car->color = $request->color;
            $car->model = $request->model;
            $car->make = $request->make;
            $car->registration_number = $request->registration_number;
            if($car->save()){
                return response()->json(['status' => 200, 'message' => 'Car Updated Sucessfully!']);
            } else {
                return response()->json(['status' => 201, 'message' => 'Unknown error occured!']);
            }
        } catch (Exception $e) {
            return response()->json(['status' => 500, 'message' => 'Server Error']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Car::where('id',$id)->delete();
            return response()->json(['status' => 200, 'message' => 'Car Deleted Sucessfully!']);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, 'message' => 'Server Error!']);
        }
    }
}
