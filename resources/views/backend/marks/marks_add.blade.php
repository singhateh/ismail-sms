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
					<h4 class="box-title">Student <strong>Marsk Entry</strong></h4>
					<h2 style="font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif; font-size:2em" class="pull-right" id="message"></h2>
				  </div>

				  <div class="box-body">
				
		<form method="post" action="{{ route('marks.entry.store') }}" autocomplete="off" id="SubmitForm">
			@csrf
			<div class="row">

<div class="col-md-2">
 	<div class="form-group">
		<h5>Year <span class="text-danger"> </span></h5>
	<div class="controls">
		<select name="year_id" id="year_id" required="" class="form-control">
				<option value="" selected="" disabled="">Select Year</option>
				 @foreach($years as $year)
	 			<option value="{{ $year->id }}">{{ $year->name }}</option>
			 	@endforeach 
		</select>
	</div>		 
	  </div>
	  
</div> <!-- End Col md 3 --> 

<div class="col-md-2">

 	<div class="form-group">
		<h5>Period <span class="text-danger"> </span></h5>
	<div class="controls">
		<select name="periode_id" id="periode_id" required="" class="form-control">
				<option value="" selected="" disabled="">Select Year</option>
				 @foreach($periodes as $periode)
	 			<option value="{{ $periode->id }}" >{{ $periode->name }}</option>
			 	@endforeach 
		</select>
	</div>		 
	  </div>
	  
</div> <!-- End Col md 3 --> 



 			
 		<div class="col-md-2">

 		 <div class="form-group">
		<h5>Class <span class="text-danger"> </span></h5>
		<div class="controls">
	 <select name="class_id" id="class_id"  required="" class="form-control">
			<option value="" selected="" disabled="">Select Class</option>
			 @foreach($classes as $class)
			<option value="{{ $class->id }}">{{ $class->name }}</option>
		 	@endforeach
			 
		</select>
	  </div>		 
	  </div>
	  
 			</div> <!-- End Col md 3 --> 


 		<div class="col-md-2">

 		 <div class="form-group">
		<h5>Subject <span class="text-danger"> </span></h5>
		<div class="controls">
	 <select name="assign_subject_id" id="assign_subject_id"  required="" class="form-control">
			<option  selected="" >Select Subject</option>
			  
			 
		</select>
	  </div>		 
	  </div>
	  
 			</div> <!-- End Col md 3 --> 

<div class="col-md-2">

 		 <div class="form-group">
		<h5>Exam Type <span class="text-danger"> </span></h5>
		<div class="controls">
 <select name="exam_type_id" disabled id="exam_type_id"  required="" class="form-control">
			<option value="" selected="" disabled="">Select Exam</option>
			 @foreach($exam_types as $exam)
			<option value="{{ $exam->id }}">{{ $exam->name }}</option>
		 	@endforeach
		</select>
	  </div>		 
	  </div>
	  
</div> <!-- End Col md 3 --> 

 			<div class="col-md-2" style="margin-top: 2%" >

  <a id="search" class="btn btn-primary" name="search"> Search</a>
	  
 			</div> <!-- End Col md 3 --> 		
			</div><!--  end row --> 


 <!--  ////////////////// Mark Entry table /////////////  -->


 <div class="row d-none" id="marks-entry">
 	<div class="col-md-12">
 		<table class="table table-bordered table-striped" style="width: 100%">
 			<thead>
 				<tr>
 					<th>ID No</th>
 					<th>Student Name </th>
 					<th style="text-align:center !important">DT</th>
 					<th style="text-align:center !important">TT</th>
 					<th style="text-align:center !important">EF</th>
 				 </tr> 				
 			</thead>
 			<tbody id="marks-entry-tr" class="">
 				
 			</tbody>
 			
 		</table>
 <input type="submit" class="btn btn-rounded btn-primary" value="Submit">
 <input type="hidden" data-url="{{ route('marks.entry.update') }}" id="UpdateUrl">

 	</div>
 	
 </div>
 

		</form> 

			       
			</div>
			<!-- /.col -->
		  </div>
		  <!-- /.row -->
		</section>
		<!-- /.content -->
	  
	  </div>
  </div>

<script type="text/javascript">

	$('#exam_type_id').on('change', function(){
		if ($(this).val() == 1) {
			$('.homework').attr('disabled', false);
			$('.final').attr('disabled', true);
			$('.test').attr('disabled', true);
		}else if($(this).val() == 2){
			$('.homework').attr('disabled', true);
			$('.final').attr('disabled', true);
			$('.test').attr('disabled', false);
		}else if($(this).val() == 3){
			$('.homework').attr('disabled', true);
			$('.test').attr('disabled', true);
			$('.final').attr('disabled', false);
		}else{
			// DISABLED ALL THE EDITABLE INPUTS 
					$('.homework').attr('disabled', true);
					$('.final').attr('disabled', true);
					$('.test').attr('disabled', true);
		}
	});


  $(document).on('click','#search',function(){

    var year_id = $('#year_id').val();
    var class_id = $('#class_id').val();
		var assign_subject_id = $('#assign_subject_id').val();
		var exam_type_id = $('#exam_type_id').val();
		var periode_id = $('#periode_id').val();
		var marks = $('#marks_id').val();
		var update_url = $('#UpdateUrl').data('url');
		// alert(update_url);
		// return false
		$.ajax({
			url: "{{ route('marks.get.marksvalidate')}}",
      type: "GET",
			data: {'year_id':year_id,'periode_id':periode_id,'class_id':class_id,'assign_subject_id':assign_subject_id},
      success: function (data) {
				console.log(data)
				var mark_year_id = data.year_id;
				var mark_class_id = data.class_id;
				var mark_assign_subject_id = data.assign_subject_id ;
				var mark_exam_type_id = data.exam_type_id ;
				var mark_period = data.periode_id ;

				if (mark_year_id == year_id) {
						UpgradeExistingExamMarks(year_id, periode_id, class_id, assign_subject_id, exam_type_id);
						$('#SubmitForm').attr('action', update_url);
						
				}else{
					AddNewExamMarks(year_id,class_id);
					
				}
				
				
				}

			});
  });

</script>


<!--   // for get Student Subject  -->

<script type="text/javascript">
  $(function(){
    $(document).on('change','#class_id',function(){
      var class_id = $('#class_id').val();
      $.ajax({
        url:"{{ route('marks.getsubject') }}",
        type:"GET",
        data:{class_id:class_id},
        success:function(data){
          var html = '<option value="">Select Subject</option>';
          $.each( data, function(key, v) {
            html += '<option value="'+v.id+'">'+v.school_subject.name+'</option>';
          });
          $('#assign_subject_id').html(html);
        }
      });
    });
  });

// Add New Exam Marks
  function AddNewExamMarks(year_id = '', class_id = '') {
     $.ajax({
			url: "{{ route('student.marks.getstudents')}}",
      type: "GET",
      data: {'year_id':year_id,'class_id':class_id},
      success: function (data) {
				console.log(data)
				if (data == '') {
					$('#message').text('No data found');
					return false
					}
					$('#exam_type_id').attr('disabled', false);
				  $('#marks-entry').removeClass('d-none');
        var html = '';
        $.each( data, function(key, v){
					
          html +=
          '<tr>'+
          '<td>'+v.student.id_no+'<input type="hidden" name="student_id[]" value="'+v.student_id+'"> <input type="hidden" name="id_no[]" value="'+v.student.id_no+'"> </td>'+
          '<td>'+v.student.name+'</td>'+
          '<td><input type="text" disabled id="homework" value="0" class="form-control form-control-sm homework" name="homework[]" ></td>'+
          '<td><input type="text" disabled id="test" value="0" readonly class="form-control form-control-sm test" name="test[]" ></td>'+
          '<td><input type="text" disabled id="f_exam" value="0" readonly class="form-control form-control-sm final" name="f_exam[]" ></td>'+
          '</tr>';
        });
        html = $('#marks-entry-tr').html(html);
		$('#message').text('Please Select exam type to start entering marks');
      	
				}
    });
  };

// Upgrade Existing Exam Marks
	function UpgradeExistingExamMarks(year_id = '', periode_id = '' ,class_id = '', assign_subject_id = '' , exam_type_id = '' ) {

		 $.ajax({
      url: "{{ route('marks.get.marks')}}",
      type: "GET",
      data: {'year_id':year_id,'periode_id':periode_id,'class_id':class_id,'assign_subject_id':assign_subject_id,'exam_type_id':exam_type_id},
      success: function (data) {
				console.log(data)
					if (data == '') {
					$('#message').text('No data found');
					return false
					}
					$('#exam_type_id').attr('disabled', false);
				 $('#marks-entry').removeClass('d-none');
        var html = '';
        $.each( data, function(key, v){
				
          html +=
          '<tr>'+
          '<td>'+v.student.id_no+'<input type="hidden" name="student_id[]" value="'+v.student_id+'"> <input type="hidden" name="id_no[]" value="'+v.student.id_no+'">'+ 
					'</td> <input type="hidden" id="dt" value="'+v.dt+'"  class="form-control form-control-sm" name="dt[]" ><input type="hidden" id="tt" value="'+v.tt+'"  class="form-control form-control-sm" name="tt[]" > <input type="hidden" id="ef" value="'+v.ef+'"  class="form-control form-control-sm" name="ef[]" > <input type="hidden" id="ef" value="'+v.dt+'"  class="form-control form-control-sm" name="dt_l" ><input type="hidden" id="ef" value="'+v.tt+'"  class="form-control form-control-sm" name="tt_l" ><input type="hidden" id="ef" value="'+v.ef+'"  class="form-control form-control-sm" name="ef_l" >'+
          '<td>'+v.student.name+'</td>'+
          '<td><input type="text" disabled id="homework" value="'+v.dt_marks+'" class="form-control form-control-sm homework" name="homework[]" ></td>'+
          '<td><input type="text" disabled id="test" value="'+v.tt_marks+'"  class="form-control form-control-sm test" name="test[]" ></td>'+
          '<td><input type="text" disabled id="f_exam" value="'+v.ef_marks+'"  class="form-control form-control-sm final" name="f_exam[]" ></td>'+
          '</tr>';
        });
        html = $('#marks-entry-tr').html(html);
					$('#message').text('Please Select exam type to start entering marks');
				}
    });
  };

</script>



@endsection
