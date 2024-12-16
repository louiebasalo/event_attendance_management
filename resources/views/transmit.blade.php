
<style type="text/css">
	#p{
		color:red
	}
	#d{
		color:yellowgreen;
	}
	.flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
                position: relative;
                height: 100vh;

            }
</style>
@extends('layouts.app')

@section('content')

<div class="card-body flex-center"style="margin-top: -80px;">
	<div class="content">
		<div class="m-b-md" style="font-size: 40px">
			{{ $data['event']->title}} Records
		</div>
		<div id="select"tyle="width: 300px;float: right;">
			<button class="btn btn-primary" id="btn">Transmit now </button>	
			<a class="btn btn-secondary" href="{{route('home')}}">Back</a>
			<p id="p"></p>	
			<p id="d"></p>			
		</div>
	</div> 
	
</div>


@endsection

@section('script')
<script type="text/javascript">
	$(document).ready(function(){
		load();
		var num;
		var tosend = [];

		function load(){
			$.ajax({
				url: "{{ route('getAll')}}",
				method: "get",
				// dataType: "json",
				success:function(data){
					console.log(data);
					// alert('success');
					tosend = JSON.parse(data);
					// num = tosend.records.length;
					// $("#obj").text(num);
					console.log(tosend);
				}
			});

		}//end sa load na function



		$('#btn').click(function(){
			var id = "{{$data['event']->id}}";
			$.ajax({
				url: "{{ route('transmitna')}}",
				method: "get",
				data:{tosend:id},
				// dataType: "json",
				success:function(response){
					console.log("the event ID is:"+id);
					var msg = [];
					msg = JSON.parse(response);
					if(msg.error != null){
						$("#p").html(msg.error);
						Swal.fire({
					    position: 'center',
					    type: 'error',
					    title: ''+msg.error,
					    text: ''+msg.errmsg,
					    showConfirmButton: false,
					    timer: 6000,
					   	backdrop: `   
					    rgba(0,0,123,(0.4)`
					});
					}else{
						$("#d").text(msg.msg2);
						Swal.fire({
					    position: 'center',
					    type: 'success',
					    title: ''+msg.msg,
					    showConfirmButton: false,
					    timer: 1500,
					   	backdrop: `   
					    rgba(0,0,123,(0.4)`
					});
					}
					

				}
			});
		});
	});
</script>
@endsection