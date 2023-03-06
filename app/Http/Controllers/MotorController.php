<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Motor;
use App\Models\Customer;
use Redirect;
use Auth;
use App\DataTables\MotorDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Facades\DataTables;

class MotorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $motors = Motor::all();
        return view('motor.index', compact('motors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('motor.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
          $motors = new Motor();

        $customer =  Customer::where('user_id', Auth::id())->first();

        $motors->customer_id = $customer->id;
        $motors->brand = $request->brand;
        $motors->model = $request->model;

        if($file = $request->hasFile('motor_img')) {
        $file = $request->file('motor_img') ;
        $fileName = $file->getClientOriginalName();
        $destinationPath = public_path().'/img_path' ;
        $input['motor_img'] = 'img_path/'.$fileName;
        $file->move($destinationPath,$fileName);
    
        $motors->motor_img = $fileName;

        }

        $motors->save();

        return redirect()->route('user.profile')->with("Your Motors is Successfully Recorded!");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
           $motors = Motor::findOrFail($id);
        return view('motor.edit', compact('motors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Motor $motors, $id)
    {
         $motors = Motor::find($id);

        $input = $request->all();

         $request->validate([

            'brand' => 'required|max:255',
            'model' => 'required|min:2',
            'motor_img' => 'mimes:png,jpg,gif,svg',
            
        ]);

        if($file = $request->hasFile('motor_img')) {
            $file = $request->file('motor_img');
            $fileName = $file->getClientOriginalName();
            $destinationPath = public_path().'/img_path' ;
            $input['motor_img'] = 'img_path/'.$fileName;
            $file->move($destinationPath, $fileName);
        }

            $motors->brand = $request->brand;
            $motors->model = $request->model;
            $motors->motor_img = $request->$fileName;

            $motors->update($input);
            return redirect()->route('getMotor')->with('Success', 'Product Record Updated Successfully!!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
          Motor::find($id)->delete();

        return redirect()->route('motors.index')->with('Product Successfully Removed');
    }

    
     public function getMotor(MotorDataTable $dataTable){


        $motors = Motor::with(['customer'])->get();
        return $dataTable->render('motor.motors');   }
}
