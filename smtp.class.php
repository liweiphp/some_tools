<?php
/**
* stmp send email
*/
class smtp_email
{
	private $host;
	private $port = 25;
	private $user;
	private $password;
	private $debug = false;
	private $socket;
	private $mail_format;
	public function __construct($host,$port,$user,$password,$format = 1,$debug = 0){
		$this->host = $host;
		$this->port = $port;
		$this->user = base64_encode($user);
		$this->password = base64_encode($password);
		$this->mail_format = $format;
		$this->debug = $debug;
		$this->socket = fsockopen($this->host,$this->port,$erron,$errstr,10);
		if(!$this->socket){
			exit("erron:{$erron},error:{$errstr}\n");
		}
		$response = fgets($this->socket);
		if(strstr($response,"220")===FALSE){
			exit("server error:$response\n");
		}
	}
	private function show_debug($message){
		if($this->debug){
			echo "<p>debug:$message</p>";
		}
	}
	private function do_command($cmd,$return_code){
		fwrite($this->socket, $cmd);
		echo $cmd;
		echo "<br/>";
		$response = fgets($this->socket);
		if(strstr($response,"$return_code")===false){
			$this->show_debug($response);
			return false;
		}
		return true;
	}
	private function is_email($email){
		return filter_var($email,FILTER_SANITIZE_EMAIL);
	}
	public function send_email($from,$to,$subject,$body){
		if(!$this->is_email($from)||!$this->is_email($to)){
			$this->show_debug("please vaild email");
			return false;
		}
		if(empty($subject)||empty($body)){
			$this->show_debug("please enter subject/content");
			return false;
		}
		$detail = "From:".$from."\r\n";
		$detail .= "To:".$to."\r\n";
		$detail .= "Subject:".$subject."\r\n";
		if($this->mail_format == 1){
			$detail .= "Content-Type: text/html;\r\n";

		}else{
			$detail .= "Content-Type: text/plain;\r\n";
		}
		$detail .= "charset: gb2312;\r\n\r\n";
		$detail .= $body;
		$this->do_command("HELO ".$this->host."\r\n",250);
		$this->do_command("AUTH LOGIN\r\n",334);
		$this->do_command($this->user."\r\n",334);
		$this->do_command($this->password."\r\n",235);
		$this->do_command("MAIL FROM: <".$from.">\r\n",250);
		$this->do_command("RCPT TO: <".$to.">\r\n",250);
		$this->do_command("DATA\r\n",354);
		$this->do_command($detail."\r\n.\r\n",250);
		$this->do_command("QUIT\r\n",221);
		return true;
	}




}