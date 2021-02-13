@extends('admin.admin_master')
@section('admin')


 <div class="content-wrapper">
	  <div class="container-full">
		<!-- Content Header (Page header) -->
	

<section class="content">

		 <!-- Basic Forms -->
		  <div class="box">
			<div class="box-header with-border">
			  <h4 class="box-title">Edit Exam Type</h4>
			  
			</div>
			<!-- /.box-header -->
			<div class="box-body">
			  <div class="row">
				<div class="col">

	 <form method="post" action="{{ route('update.exam.type', $editData->id) }}" autocomplete="off">
	 	@csrf
		{{-- @method('put') --}}
		<div class="col-12">	
			<div class="row">
		<div class="form-group col-md-5">
		<h5>Exam Type Name <span class="text-danger">*</span></h5>
		<div class="controls">
	 <input type="text" name="name" id="name" value="{{ $editData->name }}" class="form-control" > 
	 <span class="text-danger name"></span>
	 @error('name')
	 <span class="text-danger name">{{ $message }}</span>
	 @enderror
	  </div>
		 
	</div>
	<div class="form-group col-md-3">
		<h5>Exam Code<span class="text-danger">*</span></h5>
		<div class="controls">
	 <input type="text" name="code" value="{{ $editData->code }}" class="form-control" id="code" > 
	 <span class="text-danger code"></span>
	 @error('code')
	 <span class="text-danger code">{{ $message }}</span>
	 @enderror
	  </div>
		 
	</div>
	<div class="form-group col-md-3">
		<h5>Percentage<span class="text-danger">*</span> <i class="fa fa-info-circle pull-right" style="cursor: pointer" data-toggle="tooltip" data-placement="left" title="This percentage will converted to decimal"></i></h5>
		<div class="controls">
	 <input type="hidden" name="percentage_value" id="percentage_value">
	 <input type="text" name="percentage" value="{{ $editData->percent }}" class="form-control"
	 data-type="decimal"  id="percentage" placeholder="">
	 <span class="text-danger percentage"></span>
	 @error('percentage')
	 <span class="text-danger percentage">{{ $message }}</span>
	 @enderror
	  </div>
		 
	</div>
		{{-- <div class="form-group col-md-1"> --}}
	 <span class="symbol">%</span>
	{{-- </div> --}}
 
	<div class="text-xs-right col-md-6">
	 <input type="submit" id="FormExam" class="btn btn-rounded btn-info mb-5" value="Submit">
						</div>
					</form>

				</div>
				<!-- /.col -->
			  </div>
			  <!-- /.row -->
			</div>
			<!-- /.box-body -->
		  </div>
		  <!-- /.box -->

		</section>
	  </div>
  </div>

<style>
	.symbol {
  /* border: 1px inset #ccc; */
	margin-top: 2.5em !important;
	padding-right: 2em !important;
}
.symbol input {
  /* border: none; */
  padding:0px;
  outline: none;
}
</style>



@endsection

@section('scripts')
<script>
$('#name').focus();

	$('#FormExam').on('click', function(){
		var  name =	$('#name').val();
		var  code =	$('#code').val();
		var  percentage =	$('#percentage').val();

		if (name == '') {
				$('.name').text('name field is required!');
				$('#name').focus();
				return false
		}else if(code == ''){
			$('.code').text('code field is required!');
			$('#code').focus();
				return false
		}
		else if(percentage == ''){
			$('.percentage').text('percentage field is required!');
			$('#percentage').focus();
				return false
		}
			
	});

	$('#name').on('keyup', function(){
		var name = $(this).val();
		if (name != '') {
			$('.name').text('');
		}
	})

		$('#code').on('keyup', function(){
		var code = $(this).val();
		if (code != '') {
			$('.code').text('');
		}
	})

		$('#percentage').on('keyup', function(e){

			if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
				$('.percentage').text('only numbers are required!');
				$('#percentage').val('')
				return false;
			}
		var percentage = $(this).val();
		if (percentage != '') {
			$('.percentage').text('');
		}

		 var value = parseFloat($(this).val()) / 100;

     $('#percentage_value').val( value.toFixed(1));

		 if (percentage.length > 3) {
			 	$('.percentage').text(' only 3 charcters are required!');
				 $('#percentage').val('')
				 return false
		 }
	
	})
</script>
@endsection