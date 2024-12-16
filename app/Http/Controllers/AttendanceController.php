<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\attendance;
use App\student;
use App\evnets;
use Carbon;
	session_start();

class AttendanceController extends Controller
{
	
    
	public function insertAttendance(Request $request)
	{
		if($request->ajax())
		{
			$idNumber = $request->get('id');
			$event = $_SESSION['event'];
			$lilo = $_SESSION['lilo'];

			$data['students'] = DB::table('students')->where('student_id','=',$idNumber)->first();

			if($data['students'] != null)
			{
				$student_id = $data['students']->id;
				$data['sheet'] = attendance::all()->where('id','=',$student_id)->where('events_id','=',$event)->first();
				if($data['sheet'] != null)
				{
					$haslogin = $data['sheet']->login;
					$haslogout = $data['sheet']->logout;
						
					if($lilo == "login" && $haslogin != null){
						//session login, and if naka login na sha
						$msg['msg'] = "You have already loged in";
						echo json_encode($msg );
					}elseif ($lilo == "logout" && $haslogout != null) {
						// session is logout, nya naka logout na sha
						$msg['msg'] = "You have already loged out";
						echo json_encode($msg);
					}elseif ($lilo == "login" && $haslogout != null) {
						// session is login, pero naa na shay logout
						$msg['msg'] = "You can not login anymore since you are done logging out";
						echo json_encode($msg);
					}elseif ($lilo == "logout" && $haslogin != null) {
						$this->updateLogout($student_id, $event, $lilo);
						$this->selectStudent($student_id);
					}
				}
				else
				{
					//insert student to attendance
					if($lilo == "login"){
						$this->insertLogin($student_id, $event, $lilo);
						$this->selectStudent($student_id);
					}elseif ($lilo == "logout") {
						$this->insertLogout($student_id, $event, $lilo);
						$this->selectStudent($student_id);
					}
				}
			}
			else
			{
				//unregisterd id
				$msg['notfound'] = "ID Number does not exist in the record";
				echo json_encode($msg);
			}
			
		}

		// echo json_encode($data, JSON_PRETTY_PRINT);
	}

	public function insertLogin($idNumber, $event, $lilo)
	{
		$thisDate = Carbon\Carbon::now();
		$tda = strtotime($thisDate);
		$myTime =date('H:i:s',$tda);

		attendance::create([
			'id' => $idNumber,
			'events_id' => $event,
			'login' =>$myTime,
		]);
	}

	public function insertLogout($idNumber, $event, $lilo)
	{
		$thisDate = Carbon\Carbon::now();
		$tda = strtotime($thisDate);
		$myTime =date('H:i:s',$tda);

		attendance::create([
			'id' => $idNumber,
			'events_id' => $event,
			'logout' => $myTime,
		]);
	}
	
	public function updateLogout($idNumber, $event, $lilo)
	{
		$thisDate = Carbon\Carbon::now();
		$tda = strtotime($thisDate);
		$myTime =date('H:i:s',$tda);

		attendance::where('id','=',$idNumber)->where('events_id','=',$event)->first()->update(['logout'=> $myTime]);
	}



	public function selectStudent($idNumber)
	{
		$data['student'] = attendance::all()->where('id','=',$idNumber)->first();

		echo json_encode($data);
	}


	public function getall()
	{
		$data['attendances'] = DB::table('attendances')
							->orderBy('updated_at','asc')->get();
		echo json_encode($data, JSON_PRETTY_PRINT);
	}



}
