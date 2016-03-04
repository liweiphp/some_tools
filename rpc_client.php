<?php
/**
* 
*/
class rpc_client extends PT_Controller
{
	public function index(){
		$server_url = "http://i.ptbus.com/rpcdemo/server";
        $this->load->library('xmlrpc');
        $this->xmlrpc->debug = TRUE;
        $this->xmlrpc->server($server_url, 80);
        $this->xmlrpc->method('test');
        $request = array('How is it going?');
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