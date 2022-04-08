<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function fetch(){
        $students = Student::all();
        return response()->json([
            'students'=>$students,
        ]);
    }

    public function index(){
        return view('student.index');
    }

    public function store(Request $request){

        $student = new Student;
        $student->name = $request->input('name');
        $student->email = $request->input('email');
        $student->phoneNumber = $request->input('phoneNumber');
        $student->birthday = $request->input('birthday');
        $student->address = $request->input('address');
        $student->save();
    }
}
