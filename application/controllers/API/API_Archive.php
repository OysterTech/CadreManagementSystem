<?php
/**
* @name A-Archive-档案API
* @author Jerry Cheung <master@xshgzs.com>
* @since 2018-10-28
* @version 2018-11-04
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class API_Archive extends CI_Controller {

	public $sessPrefix;
	public $nowUserID;
	
	function __construct()
	{
		parent::__construct();

		$this->sessPrefix=$this->safe->getSessionPrefix();
		$this->nowUserID=$this->session->userdata($this->sessPrefix.'userID');
	}


	public function getArchive(){
		$token=$this->input->post('token');
		$this->ajax->checkAjaxToken($token);
		
		$id=$this->input->post('id');
		$query=$this->db->get_where('archive',array('id'=>$id));
		$list=$query->result_array();
		
		if(count($list)==1){
			$ret=$this->ajax->returnData("200","success",['data'=>$list[0]]);
			die($ret);
		}else{
			$ret=$this->ajax->returnData("0","noArchive");
			die($ret);
		}
	}
}
