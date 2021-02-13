<?php

namespace App\Http\Controllers\Backend\Marks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AssignStudent;
use App\Models\User;
use App\Models\DiscountStudent;
use App\Models\ExamMarks;
use App\Models\StudentYear;
use App\Models\StudentPeriode;
use App\Models\StudentClass;
use App\Models\StudentGroup;
use App\Models\StudentShift;
use Illuminate\Support\Facades\DB;
use PDF;

use App\Models\StudentMarks;
use App\Models\ExamType;

class MarksController extends Controller
{

    public function MarksAdd(){
        $data['years'] = StudentYear::all();
        $data['periodes'] = StudentPeriode::all();
        $data['classes'] = StudentClass::all();
        $data['exam_types'] = ExamType::all();
        $data['student_marks'] = StudentMarks::all();

        return view('backend.marks.marks_add',$data);

    }


    public function MarksStore(Request $request){

        DB::transaction(function () use($request) {
        // dd($request->all());
        $student_id = $request->student_id;
        $year_id = $request->year_id;
        $periode_id = $request->periode_id;
        $class_id = $request->class_id;
        $assign_subject_id = $request->assign_subject_id;
        $exam_type_id = $request->exam_type_id;

         $percentage = ExamType::where('id', $exam_type_id)->first();
         $marks = StudentMarks::where('periode_id', $request->periode_id)->first();

         if ($marks) {

             if ($marks->year_id == $year_id 
                && $marks->exam_type_id == $exam_type_id 
                && $marks->periode_id == $periode_id
                && $marks->class_id  == $class_id
                && $marks->assign_subject_id == $assign_subject_id
                ) 
                {
                    $notification = array(
                    'message' => 'Mark already taken for this subject',
                    'alert-type' => 'error'
                );

                return redirect()->back()->with($notification);
            }
         }
        
        $studentcount = $student_id;
        if ($studentcount) {
            for ($i=0; $i <count($student_id) ; $i++) { 
            $data = New StudentMarks();
            $data->year_id = $year_id;
            $data->periode_id = $periode_id;
            $data->class_id = $class_id;
            $data->assign_subject_id = $assign_subject_id;
            $data->exam_type_id = $exam_type_id;
            $data->student_id = $student_id[$i];
            $data->id_no = $request->id_no[$i];

            // Marks 
            $data->dt_marks = $request->homework[$i];
            $data->tt_marks = $request->test[$i];
            $data->ef_marks = $request->f_exam[$i];

            // Pecentage Points
            $data->dt = $request->homework[$i] * $percentage->percentage;
            $data->tt = $request->test[$i] * $percentage->percentage;
            $data->ef = $request->f_exam[$i] * $percentage->percentage;
            $data->total = $data->ef + $data->tt + $data->dt;

            // Grade point Section 
            if ($data->total>= 90) {
                $data->grade = 'A';
            }elseif ($data->total >= 80) {
                   $data->grade = 'B';
            }
            elseif ($data->total >= 70) {
                $data->grade = 'C';
            }elseif ($data->total >= 65) {
                $data->grade = 'D';
            }
            elseif ($data->total >= 50) {
                  $data->grade = 'E';

            }elseif ($data->total <= 49) {
                $data->grade = 'F';
            }
            $data->save();

            } // end for loop
        }// end if conditon
           
    });

     $notification = array(
            'message' => 'Student Marks Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
}// end method



    public function MarksEdit(){
        $data['years'] = StudentYear::all();
        $data['periodes'] = StudentPeriode::all();
        $data['classes'] = StudentClass::all();
        $data['exam_types'] = ExamType::all();

        return view('backend.marks.marks_edit',$data);
    }


    public function MarksEditGetStudents(Request $request){
        $year_id            = $request->year_id;
        $periode_id         = $request->periode_id;
        $class_id           = $request->class_id;
        $assign_subject_id  = $request->assign_subject_id;
        // $exam_type_id       = $request->exam_type_id;

        $getStudent = StudentMarks::with(['student'])->where('year_id',$year_id)->where('periode_id',$request->periode_id)->where('class_id',$class_id)->where('assign_subject_id',$assign_subject_id)->get();

        return response()->json($getStudent);

    }


    public function MarksUpdate(Request $request){

        // dd($request->all());

        DB::transaction(function () use($request) {
            
        $student_id = $request->student_id;
        $id_no = $request->id_no;
        $homework = $request->homework;
        $test = $request->test;
        $f_exam = $request->f_exam;
        $year_id = $request->year_id;
        $periode_id = $request->periode_id;
        $class_id = $request->class_id;
        $assign_subject_id = $request->assign_subject_id;
        $exam_type_id = $request->exam_type_id;

         $percentage = ExamType::where('id', $exam_type_id)->first();
        StudentMarks::where('year_id',$year_id)->where('periode_id',$periode_id)->where('class_id',$class_id)->where('assign_subject_id',$assign_subject_id)->delete();

        $studentcount = $student_id;
        if ($studentcount) {
            for ($i=0; $i <count($student_id) ; $i++) { 

            $data = New StudentMarks();
            $data->year_id = $year_id;
            $data->periode_id = $periode_id;
            $data->class_id = $class_id;
            $data->assign_subject_id = $assign_subject_id;
            $data->exam_type_id = $exam_type_id;
            $data->student_id = $student_id[$i];
            $data->id_no = $id_no[$i];

            // Marks 
            $data->dt_marks = $request->homework[$i];
            $data->tt_marks = $request->test[$i];
            $data->ef_marks = $request->f_exam[$i];
            
            if ($request->dt_l != 0) {
                $data->dt = $request->dt[$i];
            }else {
                $data->tt = $homework[$i] * $percentage->percentage;
            }
            
            if ($request->tt_l != 0) {
               $data->tt = $request->tt[$i];
            }else {
               $data->tt = $test[$i] * $percentage->percentage;
            }

            if ($request->ef_l != 0) {
                $data->ef = $$request->ef[$i];
            }else {
               $data->ef = $f_exam[$i] * $percentage->percentage;
            }
            
            $data->total = $data->ef + $data->tt + $data->dt;

            // Grade point Section 
            if ($data->total>= 90) {
                $data->grade = 'A';
            }elseif ($data->total >= 80) {
                   $data->grade = 'B';
            }
            elseif ($data->total >= 70) {
                $data->grade = 'C';
            }elseif ($data->total >= 65) {
                $data->grade = 'D';
            }
            elseif ($data->total >= 50) {
                  $data->grade = 'E';

            }elseif ($data->total <= 49) {
                $data->grade = 'F';
            }
            $data->save();
            
            } // end for loop
        }// end if conditon

         });

        $notification = array(
            'message' => 'Student Marks Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    } // end marks


    public function GetMarksValues(Request $request)
    {
        $year_id            = $request->year_id;
        $periode_id         = $request->periode_id;
        $class_id           = $request->class_id;
        $assign_subject_id  = $request->assign_subject_id;
        $exam_type_id       = $request->exam_type_id;

        $getMarks = StudentMarks::with(['student'])->where('year_id',$year_id)->where('periode_id',$periode_id)->where('class_id',$class_id)->where('assign_subject_id',$assign_subject_id)->get();

        return response()->json($getMarks);
    }

    public function GetMarksValidate(Request $request)
    {
        $year_id            = $request->year_id;
        $periode_id         = $request->periode_id;
        $class_id           = $request->class_id;
        $assign_subject_id  = $request->assign_subject_id;
        $exam_type_id       = $request->exam_type_id;

        $getMarks = StudentMarks::with(['student'])->where('year_id',$year_id)->where('periode_id',$periode_id)->where('class_id',$class_id)->where('assign_subject_id',$assign_subject_id)->first();

        return response()->json($getMarks);
    }






}
 