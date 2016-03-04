<?php
/**
* rpc
*/
class rpcdemo extends CI_Controller
{
	public function server(){
		$this->load->library("xmlrpc");
		$this->load->library("xmlrpcs");
		$config["functions"]["hello"] = array("function"=>"rpcdemo.test");
		//$config['object'] = $this;
		$this->xmlrpcs->initialize($config);
		$this->xmlrpcs->serve();
	}
	public function test($request){
		$parameters = $request->output_parameters();
        $response = array(
            array(
                'you_said'  => $parameters[0]
                ,'i_respond' => 'Not bad at all.'
                ,'just'=>$parameters[1]
            ),
            'struct'
        );
        return $this->xmlrpc->send_response($response);
	}
}