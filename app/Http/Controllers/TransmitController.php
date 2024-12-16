<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use SoapClient;
use App\event;
use DB;

class TransmitController extends Controller
{
    public function __construct(){
		$params = array('location' => 'http://localhost/soapServer/server.php',
						'uri' => 'urn://localhost/soapServer/server.php',
						'trace' => 1); 

		$this->instance = new SoapClient(NULL, $params);
	}

	


	function transmit($records)
	{
		return $this->instance->__soapCall('storeAttendance',array($records));
	}

	public function totransmit(Request $request)
	{ 
		$records = $this->getall($request->get('tosend'));
		$all = array('records' => $records);
		$msg = array();
		try{
			$servermsg = $this->transmit($all);
			$a = event::find($request->get('tosend'));
			$a->submitted = 1;
			$a->save();
			if(isset($servermsg['error']))
			{
				$msg['error'] = "Records allready exists in the Cloud database.";
				$msg['errmsg'] = "";
			}else{
				$msg['msg'] = "Records Tranmitted.";
			}
			echo json_encode($msg);
		}catch(Exception $e){
			$msg['error'] = "<p style ='color:red; font-weight: bolder '> Error 500:</p><br>";
			$msg['errmsg'] = "".$e->getMessage();
			$msg['eerr'] ="Failed to transmit records";
			echo json_encode($msg);
		}
		
	}

	
	 public function getall($id)
	{
		$data = DB::table('attendances')->where('events_id','=',$id)->get();
		$all = array();
		foreach ($data as $key => $value) {
			$in = strtotime($value->login);
			$out = strtotime($value->logout);
			$item = array(
				'id' => $value->id, 
				'event' => $value->events_id,
				'login' => $value->login,
				'logout' => date('H:i:s',$out),
				'created_at' => $value->created_at,
				'updated_at' => $value->updated_at,
			);
			array_push($all, $item);
		}
		return $all;
	}

}
 