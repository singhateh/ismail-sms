<?php

namespace App\Http\Controllers\Backend\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentPeriode; 

class StudentPeriodeController extends Controller
{
    public function ViewPeriode(){
    	$data['allData'] = StudentPeriode::all();
    	return view('backend.setup.periode.view_periode',$data);

    }

     public function StudentPeriodeAdd(){
    	return view('backend.setup.periode.add_periode');
    }

	public function StudentPeriodeStore(Request $request){

	    	$validatedData = $request->validate([
	    		'name' => 'required|unique:student_periodes,name',
	    		
	    	]);

	    	$data = new StudentPeriode();
	    	$data->name = $request->name;
	    	$data->save();

	    	$notification = array(
	    		'message' => 'Student Period Inserted Successfully',
	    		'alert-type' => 'success'
	    	);

	    	return redirect()->route('student.periode.view')->with($notification);

	    }


	 public function StudentPeriodeEdit($id){
	    	$editData = StudentPeriode::find($id);
	    	return view('backend.setup.periode.edit_periode',compact('editData'));

	    }


	public function StudentPeriodeUpdate(Request $request,$id){

		$data = StudentPeriode::find($id);
     
     	$validatedData = $request->validate([
    		'name' => 'required|unique:student_periodes,name,'.$data->id
    		
    	]);

    	
    	$data->name = $request->name;
    	$data->save();

    	$notification = array(
    		'message' => 'Student Periode Updated Successfully',
    		'alert-type' => 'success'
    	);

    	return redirect()->route('student.periode.view')->with($notification);
    }



	 public function StudentPeriodeDelete($id){
	    	$user = StudentPeriode::find($id);
	    	$user->delete();

	    	$notification = array(
	    		'message' => 'Student Period Deleted Successfully',
	    		'alert-type' => 'info'
	    	);

	    	return redirect()->route('student.periode.view')->with($notification);

	    }


}
