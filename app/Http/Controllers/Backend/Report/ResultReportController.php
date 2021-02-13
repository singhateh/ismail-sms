<?php

namespace App\Http\Controllers\Backend\Report;

use App\Models\User;
use App\Models\ExamType;

use App\Models\StudentYear;
use App\Models\StudentClass;
use App\Models\StudentMarks;
use Illuminate\Http\Request;
use App\Models\AssignStudent;

// use PDF;
use App\Models\StudentPeriode;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\AssignSubject;
use App\Models\MarksGrade;

class ResultReportController extends Controller
{
    public function ResultView(){
    	$data['years'] = StudentYear::all();
			$data['periodes'] = StudentPeriode::all();
    	$data['classes'] = StudentClass::all();
    	$data['exam_type'] = ExamType::all();
    	return view('backend.report.student_result.student_result_view',$data);

    }


    public function ResultGet(Request $request){

    	$year_id = $request->year_id;
    	$class_id = $request->class_id;
    	$exam_type_id = $request->exam_type_id;
    	$periode_id = $request->periode_id;
			$student_id = $request->student_id;

			if ($student_id) {

					$rollStudent = User::find($student_id);

					// if ($rollStudent == true) {

						$student = $this->Student_academics_details($rollStudent->id)->first();
						// dd($singleResult->toArray());

					//  Splite the student name to get firstname and lastname from the array
						$name = $student->student_name;

						$alagie = explode(" ", $name);
						if(count($alagie) > 1) {
								$lastname = array_pop($alagie);
								$firstname = implode(" ", $alagie);
						}
						else
						{
								$firstname = $name;
								$lastname = " ";
						}

						// Avarage students in class
						$avg_student = AssignStudent::where('class_id', $class_id)
							->where('year_id', $year_id)->count();

						// Subject Assign for the students
						$subjects = $this->School_subjects_details( $student_id, $year_id, $periode_id)->get();
							// echo "<pre>";print_r($subjects->toArray() );exit;
						
							$subcollection = array();

									foreach ($subjects as $subject) {
									$submarks = StudentMarks::select('total')
									->where('student_id', '=', $student->student_id)
									->where('assign_subject_id', '=', $subject->assign_subject_id)
									// ->where('exam_type_id', '=', $exam_type_id)
									// ->where('class_id', '=', $class_id)
									->first();

										$sumofMarks = StudentMarks::where('class_id', '=', $class_id)
									->where('periode_id', '=', $periode_id)->get();

									// Selecting Highest Mark from student Marks table
									$maxMarks = StudentMarks::select(DB::raw('max(total) as highest'))
									// ->where('class_id', '=', $class_id)
									->where('assign_subject_id', '=', $subject->assign_subject_id)
									->where('exam_type_id', '=', $exam_type_id)->first();

									$submarks["highest"] = $maxMarks->highest;
									$submarks["sub_name"] = $subject->subject_name;
									// $submarks["full_mark"] = $subject->full_mark;
									// $submarks["pass_mark"] = $subject->pass_mark;
									$submarks["homework_total"] = $subject->dt_marks;
									$submarks["test_total"] = $subject->tt_marks;
									$submarks["final_exam"] = $subject->ef_marks;
									$submarks["mark_grade"] = $subject->grade;
									$submarks["outof"] = $subject->total;
									$submarks["all_total"] = $subject->total;
														
									array_push($subcollection, $submarks);
													
								}

								return view('backend.report.student_result.student_result_pdf', 
								['subcollection' => $subcollection, 'student'=> $student, 'sumofMarks' => $sumofMarks,
								'firstname' => $firstname, 'lastname' => $lastname, 'avg_student' => $avg_student
								]);

								// Multiple Students Report Card By Calss
							}else if($class_id){

							$student_class = $this->Student_class_details($class_id)
								->get();

						// Avarage students in class
						$avg_student = AssignStudent::where('class_id', $class_id)
							->where('year_id', $year_id)->count();

						// Subject Assign for the students
						$subjects = $this->School_class_subjects_details( $class_id, $year_id, $periode_id)->get();
							// echo "<pre>";print_r($subjects->toArray() );exit;
						
									$subcollection = array();
									$studentcollection = [];
									foreach (User::where('usertype', 'student')->get() as $key => $student) {
												$studentcollection = $student->student_id;
									}

									// echo "<pre>f";print_r($studentcollection); die;

									foreach ($subjects as $subject) {
										
									$submarks = StudentMarks::select('total')
									// ->where('student_id', '=', $student->student_id)
									->where('assign_subject_id', '=', $subject->assign_subject_id)
									->where('periode_id', '=', $periode_id)
									->where('class_id', '=', $class_id)
									->first();

									foreach ($submarks as $key => $marks) {
										# code...
									}
									// Selecting Highest Mark from student Marks table
									$maxMarks = StudentMarks::select(DB::raw('max(total) as highest'))
									->where('class_id', '=', $class_id)
									->where('assign_subject_id', '=', $subject->assign_subject_id)
									->where('periode_id', '=', $periode_id)->first();

									$sumofMarks = StudentMarks::where('class_id', '=', $class_id)
									// ->where('assign_subject_id', '=', $subject->assign_subject_id)
									->where('periode_id', '=', $periode_id)->get();

									$submarks["highest"] = $maxMarks->highest;
									$submarks["sub_name"] = $subject->subject_name;
									// $submarks["full_mark"] = $subject->full_mark;
									// $submarks["pass_mark"] = $subject->pass_mark;
									$submarks["homework_total"] = $subject->dt_marks;
									$submarks["test_total"] = $subject->tt_marks;
									$submarks["final_exam"] = $subject->ef_marks;
									$submarks["mark_grade"] = $subject->exam_grade;
									$submarks["outof"] = $subject->total;
									$submarks["student_id"] = $subject->student_id;
									$submarks["all_total"] = $subject->total;
											
									// dd($submarks);
														
									array_push($subcollection, $submarks);
													
								}

								// echo "<pre>f";print_r($subcollection); die;
				
								return view('backend.report.student_result.student_class_result_pdf', 
								['subcollection' => $subcollection, 'student_class'=> $student_class,
								'avg_student' => $avg_student, 'sumofMarks' => $sumofMarks, 'subjects' => $subjects,
								]);

				}else{
					$notification = array(
						'message' => 'Sorry These Criteria Does not match',
						'alert-type' => 'error'
					);

					return redirect()->back()->with($notification);
					}
				} // end Method 

    public function IdcardView(){
    	$data['years'] = StudentYear::all();
    	$data['classes'] = StudentClass::all();
    	return view('backend.report.idcard.idcard_view',$data);
    }

  public function IdcardGet(Request $request){
    	$year_id = $request->year_id;
    	$class_id = $request->class_id;

    	$check_data = AssignStudent::where('year_id',$year_id)->where('class_id',$class_id)->first();

    if ($check_data == true) {
    	$data['allData'] = AssignStudent::where('year_id',$year_id)->where('class_id',$class_id)->get();
    	// dd($data['allData']->toArray());

				$pdf = PDF::loadview('backend.report.idcard.idcard_pdf', $data);
				$pdf->SetProtection(['copy', 'print'], '', 'pass');
				return $pdf->stream('document.pdf');

    }else{

    	$notification = array(
    		'message' => 'Sorry These Criteria Does not match',
    		'alert-type' => 'error'
    	);

    	return redirect()->back()->with($notification);

    }


  }// end method 


		static  function Student_academics_details($student_id)
		{
			return	DB::table('assign_students')
				->join('users', 'users.id', 'assign_students.student_id')
				->join('student_years', 'student_years.id', 'assign_students.year_id')
				->join('student_classes', 'student_classes.id', 'assign_students.class_id')
				->join('student_groups', 'student_groups.id', 'assign_students.group_id')
				->join('student_marks', 'student_marks.student_id', 'student_marks.student_id')
				->join('student_periodes', 'student_periodes.id', 'student_marks.periode_id')
				->join('student_shifts', 'student_shifts.id', 'assign_students.shift_id')
				->select('student_marks.year_id','student_marks.class_id',
				'student_marks.student_id as student_id',
				'users.name as student_name', 'profile_photo_path', 
				'student_years.name as year_name', 
				'student_classes.name as class_name', 
				'student_periodes.name as periode_name')
				        ->where('users.id','=',$student_id);
		}

			static function School_subjects_details($student_id , $year_id, $periode_id)
		{
			return  AssignSubject::join('student_classes', 'student_classes.id', 'assign_subjects.class_id')
				->join('school_subjects', 'school_subjects.id', 'assign_subjects.subject_id')
				->join('student_marks', 'student_marks.assign_subject_id', 'assign_subjects.id')
				->select('school_subjects.id as subject_id','school_subjects.name as subject_name',
				 'full_mark', 'pass_mark', 'total', 'dt_marks', 'tt_marks', 'ef_marks', 'grade', 'assign_subjects.id as assign_subject_id')
				->where('student_marks.student_id', '=', $student_id)
				->where('student_marks.year_id', '=', $year_id)
				->where('student_marks.periode_id', '=', $periode_id);
				
		}


				static  function Student_class_details($class_id)
		{
			return User::join('assign_students', 'assign_students.student_id', 'users.id')
				->join('student_years', 'student_years.id', 'assign_students.year_id')
				->join('student_classes', 'student_classes.id', 'assign_students.class_id')
				->join('student_groups', 'student_groups.id', 'assign_students.group_id')
				->join('student_marks', 'student_marks.student_id', 'student_marks.student_id')
				->join('student_periodes', 'student_periodes.id', 'student_marks.periode_id')
				// ->join('student_shifts', 'student_shifts.id', 'assign_students.shift_id')
				->select('student_marks.year_id','student_marks.class_id',
				'student_marks.student_id as student_id',
				'users.name as student_name', 'profile_photo_path', 
				'student_years.name as year_name', 'users.gender',
				'student_classes.name as class_name', 
				'student_periodes.name as periode_name')
					->where('student_classes.id','=',$class_id)
					->groupBy('users.id');
		}
	
		static function School_class_subjects_details($class_id , $year_id, $periode_id)
		{
			return  AssignSubject::join('student_classes', 'student_classes.id', 'assign_subjects.class_id')
				->join('school_subjects', 'school_subjects.id', 'assign_subjects.subject_id')
				->join('student_marks', 'student_marks.assign_subject_id', 'assign_subjects.id')
				->join('exam_types', 'exam_types.id', 'student_marks.exam_type_id')
				->select('school_subjects.id as subject_id','school_subjects.name as subject_name',
				 'full_mark', 'pass_mark', 'dt_marks', 'tt_marks', 'ef_marks', 'student_marks.grade as exam_grade', 'total', 'exam_types.name as exam_name', 'assign_subjects.id as assign_subject_id',
				 'student_marks.student_id as student_id')
				->where('student_marks.class_id', '=', $class_id)
				->where('student_marks.year_id', '=', $year_id)
				->where('student_marks.periode_id', '=', $periode_id);
				
		}
	

}
 