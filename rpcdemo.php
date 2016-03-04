<?php
/**
* rpc
*/
class rpcdemo extends PT_Controller
{
	public function server(){
		$this->load->library("xmlrpc");
		$this->load->library("xmlrpcs");
		$config["function"]["test"] = array("function"=>"rpcdemo.test");
		$config['object'] = $this;
		$this->xmlrpcs->initialize($config);
		$url = "http://i.ptbus.com/rpcdemo/server";
		$this->xmlrpcs->serve();
	}
	public function test($request){
		$parameters = $request->output_parameters();
        $response = array(
            array(
                'you_said'  => $parameters[0],
                'i_respond' => 'Not bad at all.'
            ),
            'struct'
        );
        return $this->xmlrpc->send_response($response);
	}
}