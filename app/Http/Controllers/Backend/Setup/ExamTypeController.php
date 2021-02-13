<?php

namespace App\Http\Controllers\Backend\Setup;

use App\Models\ExamType; 
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExamTypeController extends Controller
{
    public function ViewExamType(){
    	$data['allData'] = ExamType::all();
    	return view('backend.setup.exam_type.view_exam_type',$data);
 
    }

    public function ExamTypeAdd(){
    	return view('backend.setup.exam_type.add_exam_type');
    }

     public function ExamTypeStore(Request $request){

			// return $request->all();
	    	 $request->validate([
	    		'name' => 'required|unique:exam_types,name',
	    		'code' => 'required|unique:exam_types,code',
	    		'percentage_value' => 'required',
	    		
	    	]);

	    	$data = new ExamType();
	    	$data->name = $request->name;
	    	$data->code = Str::lower($request->code);
	    	$data->percentage = $request->percentage_value;
				$data->percent = $request->percentage;
	    	$data->save();

	    	$notification = array(
	    		'message' => 'Exam Type Inserted Successfully',
	    		'alert-type' => 'success'
	    	);

	    return redirect()->route('exam.type.view')->with($notification);

	    }

		public function ExamTypeEdit($id){
	    	$editData = ExamType::find($id);
	    	return view('backend.setup.exam_type.edit_exam_type',compact('editData'));

	    }

	 public function ExamTypeUpdate(Request $request,$id){

		// return $request->all();

	 $data = ExamType::find($id);
     
     $request->validate([
    		'name' => 'required|unique:exam_types,name,'.$data->id,
				// 'code' => 'required|unique:exam_types,code',
				'percentage_value' => 'required',
    	]);
    	
				$data->name = $request->name;
	    	$data->code = Str::lower($request->code);
	    	$data->percentage = $request->percentage_value;
	    	$data->percent = $request->percentage;
				$data->save();

    	$notification = array(
    		'message' => 'Exam Type Updated Successfully',
    		'alert-type' => 'success'
    	);

    	return redirect()->route('exam.type.view')->with($notification);
    }


 public function ExamTypeDelete($id){
	    	$user = ExamType::find($id);
	    	$user->delete();

	    	$notification = array(
	    		'message' => 'Exam Type Deleted Successfully',
	    		'alert-type' => 'info'
	    	);

	    	return redirect()->route('exam.type.view')->with($notification);

	    }



}
