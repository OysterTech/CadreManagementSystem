<?php
/**
* @name C-显示
* @author Jerry Cheung <master@xshgzs.com>
* @since 2018-02-06
* @version 2018-11-28
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class Show extends CI_Controller {

	public $allMenu; 
	public $sessPrefix;
	public $nowUserID;
	public $nowUserName;

	function __construct()
	{
		parent::__construct();
		
		$this->sessPrefix=$this->safe->getSessionPrefix();
		$this->allMenu=$this->RBAC_model->getAllMenuByRole($roleID);
		
		$this->nowUserName=$this->session->userdata($this->sessPrefix.'userName');
	}


	public function blank()
	{
		$this->load->view('show/blank');
	}


	public function login()
	{
		$this->load->view('show/login');
	}
	

	public function jumpOut($url){
		$url=urldecode($url);
		$this->load->view('show/jumpOut',['url'=>$url]);
	}
}
