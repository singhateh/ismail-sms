@extends('admin.admin_master')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

 <div class="content-wrapper">
	  <div class="container-full">
		<!-- Content Header (Page header) -->
		 

		<!-- Main content -->
		<section class="content">
		  <div class="row">

		
<div class="col-12">
<div class="box bb-3 border-warning">
				  <div class="box-header">
	 <h4 class="box-title">Manage <strong>Student Result Report</strong></h4>
				  </div>

				  <div class="box-body">
				
 <form method="GET" action="{{ route('report.student.result.get') }}" target="_blank" autocomplete="off">
			@csrf
			<div class="row">

<div class="col-md-3">

 		 <div class="form-group">
		<h5>Periode<span class="text-danger"> </span></h5>
		<div class="controls">
 <select name="periode_id" id="periode_id"  required="" class="form-control">
			<option value="" >Select Periode</option>
			 @foreach($periodes as $period)
			<option value="{{ $period->id }}">{{ $period->name }}</option>
		 	@endforeach
			 
		</select>
	  </div>		 
	  </div>
	  
</div> <!-- End Col md 3 --> 


<div class="col-md-3">

 		 <div class="form-group">
		<h5>Year <span class="text-danger"> </span></h5>
		<div class="controls">
	 <select name="year_id" id="year_id" required="" class="form-control">
			<option value="" >Select Year</option>
			 @foreach($years as $year)
 <option value="{{ $year->id }}" >{{ $year->name }}</option>
		 	@endforeach
			 
		</select>
	  </div>		 
	  </div>
	  
</div> <!-- End Col md 3 --> 

 			
 		<div class="col-md-3" id="hide_class">
 		 <div class="form-group">
		<h5>Class <span class="text-danger"> </span></h5>
		<div class="controls">
	 <select name="class_id" id="class_id"   class="form-control">
			<option value="" >Select Class</option>
			 @foreach($classes as $class)
			<option value="{{ $class->id }}">{{ $class->name }}</option>
		 	@endforeach
			 
		</select>
	  </div>		 
	  </div>
	  
	</div> <!-- End Col md 3 --> 

	
<div class="col-md-3" id="hide_student">
 		 <div class="form-group">
		<h5>Student No <span class="text-danger"> </span></h5>
		<div class="controls">
			<input type="text" name="student_id" id="student_id" class="form-control">
	  </div>		 
	  </div>
</div> <!-- End Col md 3 --> 





{{-- <div class="col-md-3">

 		 <div class="form-group">
		<h5>Exam Type <span class="text-danger"> </span></h5>
		<div class="controls">
 <select name="exam_type_id" id="exam_type_id"  required="" class="form-control">
			<option value="" >Select Class</option>
			 @foreach($exam_type as $exam)
			<option value="{{ $exam->id }}">{{ $exam->name }}</option>
		 	@endforeach
			 
		</select>
	  </div>		 
	  </div>
	  
</div> <!-- End Col md 3 -->  --}}

 


 			<div class="col-md-3" style="padding-top: 25px;"  >

  <input type="submit" class="btn btn-rounded btn-primary" value="Search">

	  
 			</div> <!-- End Col md 3 --> 		
			</div><!--  end row --> 

 

		</form> 

			       
			</div>
			<!-- /.col -->
		  </div>
		  <!-- /.row -->
		</section>
		<!-- /.content -->
	  
	  </div>
  </div>

@endsection

@section('scripts')
<script>
	$(document).ready(function(){
		// alert(1)
	})
	$('#student_id').on('keyup', function(){

		if ($(this).val() != '') {
				$('#hide_class').hide();
		}else{
			$('#hide_class').show();
		}
	});

		$('#class_id').on('change', function(){

		if ($(this).val() != '') {
				$('#hide_student').hide();
		}else{
			$('#hide_student').show();
		}
	});
</script>
@endsection