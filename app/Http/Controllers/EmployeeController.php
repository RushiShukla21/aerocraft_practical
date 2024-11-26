<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::all();
        return view('employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('employees.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = array(
            'first_name' => 'required|string|max:25',
            'last_name' => 'required|string|max:25',
            'email' => 'required|email|unique:employees,email',
            'country_code' => 'required',
            'mobile_number' => 'required|numeric',
            'address' => 'required',
            'gender' => 'required',
            'hobby' => 'required',
        );

        $validator = Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return redirect()->route('employees.add')->withErrors($validator);
        } else {
            $storagename = "";
            if ($request->hasFile('photo')) {
                $rulesfile = array(
                    'photo' => 'required|mimes:jpg,png,jpeg',
                );

                $validatorfile = Validator::make($request->file(), $rulesfile);
                if ($validatorfile->fails()) {
                    return redirect()->route('employees.add')->withErrors($validatorfile);
                } else {
                    $photo = $request->file('photo');
                    $photoname = $photo->getClientOriginalName();
                    if ($photoname != "") {
                        $path = Storage::putFile('public/employee', $request->file('photo'), $request->hasFile($photoname));
                        $storagename = basename($path);
                    }
                }
            }

            $newemp = new Employee;
            $newemp->first_name = $request->input('first_name');
            $newemp->last_name = $request->input('last_name');
            $newemp->email = $request->input('email');
            $newemp->gender = $request->input('gender');
            $newemp->hobby = json_encode($request->input('hobby'));
            $newemp->address = $request->input('address');
            $newemp->country_code = $request->input('country_code');
            $newemp->mobile_number = $request->input('mobile_number');
            $newemp->photo = $storagename;
            $newemp->save();

            return redirect()->route('employees.index')->with('success', 'New employee added successfully.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        return view('employees.view');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        
        return view('employees.edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Employee $employee, Request $request)
    {
        $rules = array(
            'id' => 'required',
            'first_name' => 'required|string|max:25',
            'last_name' => 'required|string|max:25',
            'email' => 'required|email|unique:employees,email,' . $employee->id,
            'country_code' => 'required',
            'mobile_number' => 'required|numeric',
            'address' => 'required',
            'gender' => 'required',
            'hobby' => 'required',
        );

        $validator = Validator::make($request->input(), $rules);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        } else {


            $fetch = Employee::where('id', $request->input('id'))->get()->toArray();
            if (empty($fetch)) {
                return Redirect::back()->with('error', 'Employee not found');
            }

            $storagename = basename($fetch[0]['photo']);
            if ($request->hasFile('photo')) {
                $rulesfile = array(
                    'photo' => 'mimes:jpg,png,jpeg',
                );

                $validatorfile = Validator::make($request->file(), $rulesfile);
                if ($validatorfile->fails()) {
                    return Redirect::back()->withErrors($validatorfile);
                } else {

                    if ($storagename != "") {
                        $photopath = public_path('storage/employee' . $storagename);
                        if (file_exists($photopath)) {
                            unlink($photopath);
                        }
                    }

                    $photo = $request->file('photo');
                    $photoname = $photo->getClientOriginalName();
                    if ($photoname != "") {
                        $path = Storage::putFile('public/employee', $request->file('photo'), $request->hasFile($photoname));
                        $storagename = basename($path);
                    }
                }
            }

            Employee::where('id', $request->input('id'))->update([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
                'gender' => $request->input('gender'),
                'hobby' => json_encode($request->input('hobby')),
                'address' => $request->input('address'),
                'country_code' => $request->input('country_code'),
                'mobile_number' => $request->input('mobile_number'),
                'photo' => $storagename,
            ]);


            return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $fetch = Employee::where('id', $employee->id)->get()->toArray();
        if (empty($fetch)) {
            return Redirect::back()->with('error', 'Employee not found');
        }

        $storagename = $fetch[0]['photo'];
        $employee->delete();
        if ($storagename != "") {
            $photopath = public_path('storage/employee' . $storagename);
            if (file_exists($photopath)) {
                unlink($photopath);
            }
        }

        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }
}
