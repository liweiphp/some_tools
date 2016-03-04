<?php
/**
* 
*/
class rpc_client extends CI_Controller
{
	public function index(){
		$server_url = "http://localhost/ci/rpcdemo/server";
        $this->load->library('xmlrpc');
        //$this->xmlrpc->debug = TRUE;
        $this->xmlrpc->server($server_url, 80);
        $this->xmlrpc->method('hello');
        $request = array('How is it going?',"wocao");
        $this->xmlrpc->request($request);
        if ( ! $this->xmlrpc->send_request())
        {
            echo $this->xmlrpc->display_error();
        }
        else
        {
            echo '<pre>';
            print_r($this->xmlrpc->display_response());
            echo '</pre>';
        }
	}
}