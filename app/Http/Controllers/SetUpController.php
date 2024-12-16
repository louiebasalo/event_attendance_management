<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\course;
use App\event;
use App\major;
use App\student;
use App\User;
use SoapClient;
class SetUpController extends Controller
{
    
	public function __construct(){
		$params = array('location' => 'http://localhost/soapServer/getData.php',
						'uri' => 'urn://localhost/soapServer/getData.php',
						'trace' => 1); 

		$this->instance = new SoapClient(NULL, $params);
	}

	public function downloaRecords()
	{
		$arrayName = array('myname' => 'louie', );
		return $this->instance->__soapCall('get_all_database_records',array($arrayName));
	}

	public function setUp()
	{
		$arr = $this->insertInto_Events = $this->downloaRecords();
		$this->insertInto_Events($arr['events']);
		$this->insertInto_Courses($arr['courses']);
		$this->insertInto_Majors($arr['majors']);
		$this->insertInto_Students($arr['students']);
		$this->insertInto_Users($arr['users']);
	}

	public function insertInto_Events($array)
	{
		foreach ($array as $key => $value) {
			event::create([
				'id'=> $value[0]['id'],
				'title' => $value[0]['title'],
				'date' => $value[0]['date'],
				'venue' => $value[0]['venue'],
				'logintime' => $value[0]['logintime'],
				'logouttime' => $value[0]['logouttime'],
				'loginfines' => $value[0]['loginfines'],
				'logoutfines' => $value[0]['logoutfines'],
			]);
		}
	}

	public function insertInto_Courses($array)
	{
		foreach ($array as $key => $value) {
			course::create([
				'id'=> $value[0]['id'],
				'course_description' => $value[0]['course_description'],
			]);
		}
	}

	public function insertInto_Majors($array)
	{
		foreach ($array as $key => $value) {
			major::create([
				'id'=> $value[0]['id'],
				'major' => $value[0]['major'],
			]);
		}
	}

	public function insertInto_Students($array)
	{
		foreach ($array as $key => $value) {
			student::create([
				'id'=> $value[0]['id'],
				'student_id' => $value[0]['student_id'],
				'name' => $value[0]['name'],
				'level' => $value[0]['level'],
				'courses_id' => $value[0]['course_id'],
				'majors_id' => $value[0]['major_id'],
			]);
		}
	}

	public function insertInto_Users($array)
	{
		foreach ($array as $key => $value) {
			user::create([
				'student_id'=> $value[0]['Students_id'],
				'username' => $value[0]['username'],
				'password' => $value[0]['password'],
				'email' => $value[0]['email'],
				'contact_number' => $value[0]['contact_number'],
			]);
		}
	}

}
