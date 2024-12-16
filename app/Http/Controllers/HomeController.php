<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\event;
use App\attendance;

    session_start();


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = DB::table('events')->get();
         // if($data->count() > 0)
         // {
         return view('home');
         // }else{
         //    return view('first');
         // }
    }

    public function home()
    {  
        return view('home');
    }

    public function homehome()
    {
        $data = DB::table('events')->orderBy('date','asc')->get();

        echo json_encode($data,JSON_PRETTY_PRINT);
    }

    public function attendance(Request $request)
    {
        if($request->ajax())
        {
            $_SESSION['event'] = $request->get('event');
        }
        return view('attendance');
    }

    public function select_event(){
        return view('selectEvent');
    }

    public function getEvents(Request $request){
        if($request->ajax())
        {
            $data['events'] = DB::table('events')->get();
            echo json_encode($data['events']);
        }
    }

    public function setSession(Request $request){
        if($request->ajax()){
            $_SESSION['lilo'] = $_GET['lilo'];

            echo $_SESSION['lilo'];
        }
        
    }

    public function endSession(Request $request)
    {
     // if( event::where('id','=',$request->get('id'))->first()->update(['done' => 1]))
     // {
     //    echo json_encode($request->get('id'));
     // }
        $e = event::find($request->get('id'));
        $e->done = 1;
        $e->save();
        

    }

    public function allAttendance(){
        $result['attendance'] = DB::table('attendances')->where('events_id','=',$_SESSION['event'])->orderBy('updated_at','asc')->get();
        $result['students'] = DB::table('students')->get();
        $output = "";

        $students = array();
        foreach ($result['students'] as $value) {
            $m = DB::table('majors')->where('id','=',$value->majors_id)->first();
            $item = array(
                'id' => $value->id,
                'ID_number' => $value->student_id,
                'Name' => $value->name,
                'Major' => $m->major,
                'Level' => $value->level
            );
            array_push($students, $item);
        }

        if($result['attendance'] != null)
        {
            foreach ($result['attendance'] as $value) {
                foreach ($students as  $value2) {
                    if($value->id == $value2['id'])
                    {
                        $output .= '
                            <tr>
                                <td>'.$value2['ID_number'].'</td>
                                <td>'.$value2['Name'].'</td>
                                <td>'.$value2['Level'].'</td>
                                <td>'.$value2['Major'].'</td>
                                <td>'.$value->login.'</td>
                                <td>'.$value->logout.'</td>
                            </tr>
                            ';
                    }
                }
            }

        $data = array(
            'records' => $output
        );

        echo json_encode($data);

        }

    }


    public function transmit($id)
    {
        $data['records'] = DB::table('attendances')->get();
        $data['event'] = DB::table('events')->where('id','=',$id)->first();
        return view('transmit')->with('data',$data);
    }


    public function collect(Request $request)
    {
         $_SESSION['event'] = $request->get('id');
         $data = event::select('title','id')->where('id','=',$request->get('id'))->first();
        return view('attendance')->with('data',$data);
    }

    public function getSheet()
    {
        $data['attendances'] = DB::table('attendances')->get();
        if($data['attendances']->count() > 0)
        {
            $events = DB::table('events')->orderBy('submitted','asc')->get();
            $res = array();
            $sub = "";
            foreach ($events as $key => $value) {
                $sub = "";
                if($value->done == 1)
                {
                    if($value->submitted == 1)
                    {
                        $sub .= "<span style='font-size: 12px;'>Submitted</span>";
                    }else{
                        $sub .= "<span style='fint-size:12px;font-weight:800;'>Waiting to be submitted</span><a class=''style='float:right;font-size:13px;font-weight:800'href='".route('transmit',$value->id)."'>Submit</a>";
                    }
                    $item = array(
                        'title' => $value->title,
                        'date' => $value->date,
                        'submitted' => $sub,
                    );
                    array_push($res, $item);
                }
              
            }// end of foreach
            echo json_encode($res,JSON_PRETTY_PRINT);

        }
    }


}//end class
 

