<?php
/**
 * @name C-Log日志
 * @author Jerry Cheung <master@xshgzs.com>
 * @since 2018-02-26
 * @version 2018-11-28
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Log extends CI_Controller {

	public $allMenu;
	public $sessPrefix;
	public $nowUserID;
	public $nowUserName;

	function __construct()
	{
		parent::__construct();
		
		$this->sessPrefix=$this->safe->getSessionPrefix();
		$roleID=$this->session->userdata($this->sessPrefix."roleID");
		$this->allMenu=$this->RBAC_model->getAllMenuByRole($roleID);

		$this->nowUserID=$this->session->userdata($this->sessPrefix.'userID');
		$this->nowUserName=$this->session->userdata($this->sessPrefix.'userName');
	}


	public function toList()
	{
		$this->ajax->makeAjaxToken();
		
		$query=$this->db->get("log");
		$list=$query->result_array();
		
		$this->load->view('admin/sys/log/list',['list'=>$list]);
	}
	
	
	public function toTruncate()
	{
		$token=$this->input->post('token');
		$this->ajax->checkAjaxToken($token);
		
		$pwd=$this->input->post('pwd');
		$userStatus=$this->User_model->validateUser($this->nowUserID,"",$pwd);
		
		if($userStatus!="200"){
			$ret=$this->ajax->returnData("1","invaildPwd");
			die($ret);
		}
		
		$sql1="DELETE FROM log";
		$query1=$this->db->query($sql1,[]);
		
		$logInsert=$this->Log_model->create("日志","清空日志");
		
		if($logInsert==TRUE){
			$ret=$this->ajax->returnData("200","success");
			die($ret);
		}else{
			$ret=$this->ajax->returnData("0","truncateFailed");
			die($ret);
		}
	}
}
