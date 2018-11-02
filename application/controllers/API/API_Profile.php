<?php
/**
* @name A-Profile-资料API
* @author Jerry Cheung <master@xshgzs.com>
* @since 2018-10-28
* @version 2018-10-28
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class API_Profile extends CI_Controller {

	public $sessPrefix;
	public $nowUserID;
	
	function __construct()
	{
		parent::__construct();

		$this->sessPrefix=$this->safe->getSessionPrefix();
		$this->nowUserID=$this->session->userdata($this->sessPrefix.'userID');
	}


	public function getProfile(){
		$token=$this->input->post('token');
		$this->ajax->checkAjaxToken($token);
		
		$id=$this->input->post('id');
		$query=$this->db->get_where('profile',array('id'=>$id));
		$list=$query->result_array();
		
		if(count($list)==1){
			$ret=$this->ajax->returnData("200","success",['data'=>$list[0]]);
			die($ret);
		}else{
			$ret=$this->ajax->returnData("0","noProfile");
			die($ret);
		}
	}
}
