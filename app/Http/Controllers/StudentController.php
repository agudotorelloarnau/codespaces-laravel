<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    public function index(){
        $students = Student::all();
        return response()->json(['students' => $students], 200);
    }

    public function estudiante2($id){
        $student2 = Student::find($id);
        return response()->json(['student' => $student2], 200);
    }
}
