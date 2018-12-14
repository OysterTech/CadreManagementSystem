<?php
/**
 * @name C-基本
 * @author Jerry Cheung <master@xshgzs.com>
 * @since 2018-02-07
 * @version 2018-11-29
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	public $allMenu;
	public $sessPrefix;
	public $nowUserID;
	public $nowUserName;

	function __construct()
	{
		parent::__construct();
		
		$this->sessPrefix=$this->safe->getSessionPrefix();
		$roleID=$this->session->userdata($this->sessPrefix.'roleID');
		$this->allMenu=$this->RBAC_model->getAllMenuByRole($roleID);

		$this->nowUserID=$this->session->userdata($this->sessPrefix.'userID');
		$this->nowUserName=$this->session->userdata($this->sessPrefix.'userName');
	}


	public function index()
	{
		if($this->nowUserID==NULL || $this->nowUserID<1){
			header('location:'.base_url('user/logout'));
		}
		
		// 判断是否已建立档案
		$archiveQuery=$this->db->get_where("archive",["user_id"=>$this->nowUserID]);
		$archiveInfo=$archiveQuery->result_array();
		if(!isset($archiveInfo[0])){
			$userInfo=$this->User_model->getUserInfoByUserName($this->nowUserName);
			$this->session->set_userdata($this->sessPrefix."reg_phone",$userInfo['phone']);
			$this->session->set_userdata($this->sessPrefix."reg_realName",$userInfo['nick_name']);
			$this->session->set_userdata($this->sessPrefix."reg_userId",$this->nowUserID);

			header("location:".base_url('archive/reg'));
		}
		
		$latestNotice=$this->Notice_model->get(0,'index');
		
		$this->load->view('index',['allNotice'=>$latestNotice]);
	}
}
