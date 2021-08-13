<?php


namespace App\Helpers;
use Illuminate\Support\Facades\Request;
use App\Models\LogSystem as LogSystemModel;

class LogSystem
{


    public static function addLog($description,$error,$data = NULL)
    {
		$user_agent = Request::header('User-Agent');

		$plataform = self::plataform($user_agent);
		$agent = self::agent($user_agent);

		if($data == NULL){
			$user_id = auth()->user()->id;
			$user_email = auth()->user()->email == null ? '' : auth()->user()->email;
		}else{
			$user_id = $data->id;
			$user_email = $data->email;
		}
    	$log = [];
    	$log['description'] = $description;
    	$log['ip'] = Request::ip();
    	$log['agent'] = $plataform.'-'.$agent;
    	$log['user_id'] = $user_id;
    	$log['user_email'] = $user_email;
    	$log['error'] = $error;
    	LogSystemModel::create($log);
	}
	

	public static function plataform($user_agent)
	{
		$platform = 'Desconocido';
	
		//First get the platform?
		if (preg_match('/linux/i', $user_agent)) {
			$platform = 'Linux';
		}
		elseif (preg_match('/macintosh|mac os x/i', $user_agent)) {
			$platform = 'Mac';
		}
		elseif (preg_match('/windows|win32/i', $user_agent)) {
			$platform = 'Windows';
		}
	
		return $platform;
	}

	public static function agent($user_agent)
	{
		$bname = 'Desconocido';

		// Next get the name of the useragent yes seperately and for good reason

		if(preg_match('/MSIE/i',$user_agent) && !preg_match('/Opera/i',$user_agent))
		{
			$bname = 'Internet Explorer';
		}
		elseif(preg_match('/Firefox/i',$user_agent))
		{
			$bname = 'Mozilla Firefox';
		}
		elseif(preg_match('/Chrome/i',$user_agent))
		{
			$bname = 'Google Chrome';
		}
		elseif(preg_match('/Safari/i',$user_agent))
		{
			$bname = 'Apple Safari';
		}
		elseif(preg_match('/Opera/i',$user_agent))
		{
			$bname = 'Opera';
		}
		elseif(preg_match('/Netscape/i',$user_agent))
		{
			$bname = 'Netscape';
		}

		return $bname;
	}


}