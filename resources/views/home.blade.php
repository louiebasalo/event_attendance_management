@extends('layouts.app')
<style type="text/css">
  div{
   color:rgba(0,0,0,.7);
  }
</style>
@section('content')
<!-- <div > -->
<?php
  try{
    if(isset($_SESSION['event'])){
      session_unset();
      // echo "Sesstion unset";
    }else{
      // echo "walay session";
    }
  }catch(Exception $e){

  }
?>
  
    <div class="container" style="width: 100%;margin: auto;margin-top: 30px;margin-bottom: 30px">
        
        <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="">

                <div class="card-body" >
                   <div class="col-md-7 " style="float: left" >
                      <div class="" style="font-size:30px;margin-bottom: 10px; ">
                          Events
                      </div>
                      <div id="events">
                          
                      </div>
                      
                   </div>

                   <div class="col-md-4 card" style="height:auto;max-height: 700px; float:right">
                       <div class="" style="font-size: 20px;margin-bottom: 10px; margin-top:10px;">
                          Attendance
                      </div>
                      <div id="transmit">
                        
                      </div>
                     <!--  <div class="card" style="margin-bottom: 30px">
                          <div class="card-body">
                            
                          </div>
                      </div> -->
                   </div>
                </div>
            </div>
        </div>
    </div>

    </div>
    <!-- Footer -->
      <div class="card-body" style="position: relative;bottom: 0px;width: 100%">
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
<!-- </div> -->
@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function(){

        view_sheet();

        $.ajax({
            url:"{{ route('homehome') }}",
            method: "get",
        }).done(function(data){
           console.log(data);

           var result = $.parseJSON(data);
           var string = "";
           console.log(result);
           $.each(result, function(key, value){
            string +="<div class='card' disabled style='margin-bottom: 10px;box-shadow:#c2c2c2 1px 2px 3px'>";
            string +="<div class='card-body'>";
            string +="<h5>"+value['title']+"</h5>";
            string +="<form action='{{route('collect')}}' method='get'>";
            string +="<input type='text' name='id' value='"+value['id']+"' hidden > ";
            string +="<p> Date: "+value['date']+"";
            // string +="<br>"+value['description']+"</p>";
            string +="<div class='btn-group' style='float:right;'>";
            // string +="<button class='btn btn-info' style='font-size:13px'>View</button>";
            if(value['done'] == 1)
            {
              
            }else{
            string +="<button type='success'class=' btn btn-primary' style='font-size:13px'>Collect Attendance</button>";
            }
            
            string +="</div></form></div>";

            string +="</div>";

           })
           $("#events").html(string);
        });

      function view_sheet()
      {
        $.ajax({
          url:"{{ route('sheet') }}",
          method: "get",

        }).done(function (data){
          var string = "";
          var events = $.parseJSON(data);
          $.each(events,function(key,value){
              string +=" <div class='card' style='margin-bottom: 10px'>"
              string +=" <div class='card-body'>";
              string +=" <span style='font-size:14px;font-weight:620;'>"+value['title']+"</span>";
              var dd = value['date'];
              var date = "{{ strtotime("+dd+")}}";
              string += "<p style='font-size: 12px'>"+value['date']+"</p>";
              string += "<span style='font-size:12px;'>"+value['submitted']+"</span>";
             
                string += ""
              

// string += "<a class='btn btn-primary'style='float:right;font-size:12px'href=''>Submit</a>";
            
              string +=" </div></div>";
          })
          $("#transmit").html(string);
        });
      }
        
    });
</script>

@endsection
<!-- 


<div class="container">
    
</div> -->