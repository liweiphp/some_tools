<?php
/**
*	@author L
*	@date 2014-6-10
*	@desc get client ip
*
*/

function get_ip(){
	if(getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"),"unknown")){
		$ip = getenv("REMOTE_ADDR");
	}else if(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")){
		$ip = $_SERVER['REMOTE_ADDR'];
	}else if(getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"),"unknown")){
		$ip = getenv();
	}else if(getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"),"unknown" )){
		$ip = getenv("HTTP_X_FORWARDED_FOR");
	}else{
		$ip = 'unknown';
	}
	return $ip;
}