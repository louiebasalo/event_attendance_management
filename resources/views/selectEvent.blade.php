<style type="text/css">
	#btngo
	{
		float: right;
		margin-top: 5px
	}
</style>
@extends('layouts.app')

@section('content')

<div class="card-body"style="
	width: 550px;
	height: 350px;
	margin:auto;
	margin-top: 180px;
	
">
	
	<h3>Select Event</h3>
	<div id="select"tyle="width: 300px;float: right;">
								
	</div>

	<?php

	if(isset($_POST['eventName'])){
		session_unset();
		$_SESSION['event'] = $_POST['eventName'];
		echo $_SESSION['event'];
		if($_SESSION['event'] == null){
			echo "<span class='danger'>Must select event</span>";
		}else{
			

		}
	}else{
	session_unset();
	}

?>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$.ajax({
			url: "{{ route('getevents.action')}}",
			method: "GET",
			}).done(function(data){
				console.log(data);
				var result = $.parseJSON(data);
				var string = "";
				string += "<select id='event' name='eventName'class='form-control'>";
				string += "<option>     </option>";
				$.each(result, function(key, value){
					string += "<option value='"+value['Event_ID']+"'>"+value['Event_Name']+"</option>";
									
				});
				string +="</select>";
				string +="<span class='danger' style='color: red' id='must'></span>";
				string +="<button id='btngo'type='submit' class='btn btn-primary'>Next</button>";
				string +=""
				$("#select").html(string);
			});

		$(document).on('click','#btngo',function(){
			var evt = $("#event").val();
			if(evt == "")
			{
				$("#must").text("Must select event to proceed.");
			}else{
				$("#must").text("");
				$.ajax({
					url: "{{route('attendance')}}",
					method: "GET",
					data: {event:evt},
					success:function(data){
						window.location.href = "http://localhost:8000/attendance";
					}
				});
			}
		});

		$(document).on('change','#event',function(){
			$("#must").text("");
		});

	});
	</script>


	

@endsection

@section('script')
	
@endsection

@section('content2')


@endsection