<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Attendance Monitoring System</title> 

        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css')}}">
    <script src="{{ asset('js/jQuery-v3.3.1.js')}}"></script>
    <script src="{{ asset('js/sweetalert2.min.js') }}"></script>

        <link rel="stylesheet" type="text/css" href="{{asset('css/sweetalert2.min.css')}}">

        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 60px;
            }

            .links  {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                /*text-transform: uppercase;*/
                margin-bottom: 10px
            }
            #setup{
                font-size: 13px
            }
            .m-b-md {
                margin-bottom: 10px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">

            <div class="content">
                <div class="title m-b-md">
                    Welcome!    
                </div>
                <div class="links">
                    Setup System Database to use this application.
                </div>
                <div>
                    <button id='setup'class="btn btn-primary">Setup Now</button>
                    
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function(){
                alert("Welcome");
                $("#setup").on('click',function(){

                Swal.fire({
                  title: 'Setup your Database',
                  showCancelButton: true,
                  showLoaderOnConfirm: true,
                  preConfirm: () => {
                    return fetch("{{ route('setup')}}")
                      .then(response => {
                        if (!response.ok) {
                          throw new Error(response.statusText)
                        }
                        return response;
                      })
                      .catch(error => {
                        Swal.showValidationMessage(
                          `Request failed: ${error}`
                        )
                      })
                  },
                  allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                  if (result.value) {
                    Swal.fire({
                        type:'success',
                      title: 'Done Setting Up your Database',
                      showConfirmButton: true,
                      preConfirm: () => {
                         window.location.reload();
                      },
                    })

                  }
                })

                });

                function downloadData(){
                     if($.ajax({
                        url:"{{ route('setup')}}",
                        method: "get",
                        success:function(data){
                             return data;                 

                        }
                    })){
                        return true;
                     }
                     else{
                        return false;
                     }
                }

                


            });
        </script>
    </body>
</html>

 

 