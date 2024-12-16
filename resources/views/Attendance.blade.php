@extends('layouts.app')
<style type="text/css">
	@media screen and (max-width: 100px){
		.rights{
			width: 100%;
			height:100%;
		}
		.lefts{
			width: 250px;
			height: 100%;
		}
	}
</style>
@section('content')

<?php
	if(isset($_SESSION['event']))
	{
		redirect(route('select_event'));
	}
?>

<div class="container" style="margin-top: 20px">
	<div class=" ">
		<div class="">
            <div class="paper" style="border-radius: 10px">
                <div class="paper-header" style="font-size:20px">{{ $data->title}}</div>
                <div class="row card-body" style=" size:auto;height:auto">

                   <div class="col-md-4" style="width:250px; height:auto;">
                   	<!-- <div class="idpic"></div> -->
	                   	<div class="card-body"style="padding-top:50px;width: 100%; height: 400px;border: 1px solid rgba(0,0,0,.100);margin-top: 50px;">
	                   		<label>ID number</label>
	                   		<input id="idnumber" class="form-control"type="text" name="id" style="float: left;" autofocus="">
	                   	</div>
                   </div>

                   <div class="col-md-8" style="height: 450px;float: right;">
                   		<div style="width: 100%; height:auto;margin-top: 50px ">
                   			<div style="width: 100px; float: right">
								<select id="li_lo" class="form-control" name="li_lo">
									<option value="login">Login</option>
									<option value="logout">Logout</option>
								</select>						
							</div>
								<button id="endsession"class="btn btn-primary">End Session</button>


                   			<div class="paper-header">Attendance
                   				
                   			</div>
                   			<div class="table-responsive" style="height: 300px;">
                   				<table class="table table-default">
								<thead>
									<tr>
										<td>ID Number</td>
										<td>Name</td>
										<td>Level</td>
										<td>Major</td>
										<td>Login</td>
										<td>Logout</td>
									</tr>
								</thead>
								<tr>
									<td>ID Number</td>
									<td>Name</td>
									<td>Year</td>
									<td>Course</td>
									<td>Login</td>
									<td>Logout</td>
									
								</tr>
								</thead>
								<tbody id="tbody">
								</tbody>
								</table>
                   			</div>
                   			

                   		</div>
                   </div>

                </div>
            </div>
        </div>
	</div>
</div>
 <!-- Footer -->
    <div class="card-body" style="position: relative;bottom: 0px;width: 100%;margin-top: 60px">
      <footer class="footer">
        <div class="row align-items-center justify-content-xl-between">
          <div class="col-xl-6">
            <div class="copyright text-center text-xl-left text-muted">
              &copy; 2018 <a href="https://www.creative-tim.com" class="font-weight-bold ml-1" target="_blank">Chicken Strip</a>
            </div>
          </div> 
        
        </div>
      </footer>
    </div>
<!-- end div -->

@endsection

@section('script')

<script type="text/javascript">
	$(document).ready(function(){
		
		lilo();
		fetchAttendance();
		$("#endsession").click(function(){
			Swal.fire({
	            type:'info',
	            title: 'Stop Collecting Attendance now?',
	            showConfirmButton: true,
	            preConfirm: () => {
	               	$.ajax({
	               		url: "{{ route('endsession') }}",
	              		method: "get",
	              		data:{id:"{{$data->id}}"},
	                	success:function(data){
	                    	Swal.fire({
				                type:'success',
				                title: 'Session Ended',
				                showConfirmButton: true,
				                preConfirm: () => {
				                window.location.href = "{{ route('home') }}";
				                },
				                })
	                      	}
	                   	})
	                },
	            })
		});
		$("#idnumber").change(function(){
			var id = $("#idnumber").val();
			var event = $("#eventName").val();
			var lilo = $("#li_lo").val();

			$.ajax({
				url: "{{ route('insertAttendance.action') }}",
				method: "get",
				data:{id:id, lilo:lilo},
				dataType:"json",
				success:function(data){
				
					if(data.notfound != null){
						Swal.fire({
							  type: 'error',
							  title: 'Unregistered!',
							  text: ''+data.notfound,
							  showConfirmButton: false,
					    	  timer: 3000,
					    	  backdrop: `
							    rgba(255,0,0,0.5)`
							});
					fetchAttendance();
					$("#idnumber").val("");

					}else if(data.msg != null){
						console.log("data");
						Swal.fire({
							  type: 'error',
							  title: 'Opps!',
							  text: ''+data.msg,
							  showConfirmButton: false,
					    	  timer: 2500,
					    	  backdrop: `
							    rgba(200,100,0,0.5)`
							});
					fetchAttendance();
					$("#idnumber").val("");
					}else{

					// $("#hID").text(data.ID_Number);
					// $("#hName").text(data.Name);
					// $("#hCourse").text(data.Course + " ("+data.Major+")");
					
					Swal.fire({
					    position: 'center',
					    // imageUrl: 'https://unsplash.it/400/200',
						imageWidth: 400,
						imageHeight: 200,
					    type: 'success',
					    title: 'Done',
					    showConfirmButton: false,
					    timer: 1500,
					   	backdrop: `
					    rgba(0,200,10,0.4)`
					});
					$("#idnumber").val("");
					fetchAttendance();


				}

			}			
		});
		
	});


	$("#li_lo").change(function(){
		lilo();
	});


	function lilo(){
		var lilo = $("#li_lo").val();
		$.ajax({
			url:"{{route('setSession.action')}}",
			method:'get',
			data:{lilo:lilo},
			success:function(data){
				Swal.fire({
				  position: 'top-end',
				  type: 'info',
				  // title: 'Session',
				  title:''+data+' session begin',
				  showConfirmButton: false,
				  timer: 1500,
				  backdrop: `
					    rgba(0,0,100,0.4)`
				});
			}
		})
	}

	function fetchAttendance(){
		$.ajax({
			url:"{{ route('allAttendance')}}",
			method: "get",
			dataType: "JSON",
			success:function(data){
				console.log(data.records);
				$("#tbody").html(data.records);
			}
		})
	}

	});
</script>
@endsection