<?php
/**
 * @name C-Worklog工作记录
 * @author Jerry Cheung <master@xshgzs.com>
 * @since 2018-11-02
 * @version 2018-11-27
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Worklog extends CI_Controller {

	public $allMenu;
	public $sessPrefix;
	public $nowUserID;
	public $nowUserName;

	function __construct()
	{
		parent::__construct();

		$this->safe->checkPermission();
		$this->sessPrefix=$this->safe->getSessionPrefix();
		$roleID=$this->session->userdata($this->sessPrefix."roleID");
		$this->allMenu=$this->RBAC_model->getAllMenuByRole($roleID);

		$this->nowUserID=$this->session->userdata($this->sessPrefix.'userID');
		$this->nowUserName=$this->session->userdata($this->sessPrefix.'userName');
	}


	public function list($id=0)
	{
		if($id==0){
			$id=$this->nowUserID;
		}
		
		$query1=$this->db->get_where('archive',array('user_id'=>$id));
		$info=$query1->result_array();
		
		if(isset($info[0]['name'])){
			$name=$info[0]['name'];
		}else{
			header("location:".base_url("/"));
		}
		
		$query=$this->db->get_where('work_log',array('user_id'=>$id));
		$info=$query->result_array();

		$this->load->view('workLog/list',['list'=>$info,'name'=>$name]);
	}


	public function showDetail($id)
	{
		$query=$this->db->get_where('work_log',array('id'=>$id));
		$list=$query->result_array();

		// 判断是否存在此工作记录
		if(count($list)!=1){
			header("location:".base_url('/'));
		}else{
			$info=$list[0];

			if($info['photo_url']!=""){
				$photoUrl=json_decode($info['photo_url']);
				$info['photo_url']=$photoUrl;
			}

			// 加入工作人名称
			$userInfo=$this->db->get_where('archive',array('user_id'=>$list[0]['user_id']));
			$userInfo=$userInfo->result_array();
			
			if(count($userInfo)==1){
				$info['name']=$userInfo[0]['name'];
			}else{
				$info['name']='帐户已注销';
			}
		}

		$this->load->view('workLog/detail',['info'=>$info]);
	}


	public function chooseMember()
	{
		$this->load->view('workLog/chooseMember');
	}
	
	
	public function myAdd()
	{
		$this->ajax->makeAjaxToken();
		
		$query=$this->db->get_where('archive',array('user_id'=>$this->nowUserID));
		$info=$query->result_array();

		$this->load->view('workLog/add',['type'=>'my','myName'=>$info[0]['name'],'id'=>$this->nowUserID]);
	}


	public function memberAdd()
	{
		$this->ajax->makeAjaxToken();
		$this->load->view('workLog/add',['type'=>'member']);
	}
	
	
	public function toAdd()
	{
		$token=$this->input->post('token');
		$this->ajax->checkAjaxToken($token);
		
		$userId=$this->input->post('userId');
		$beginDate=$this->input->post('beginDate');
		$endDate=$this->input->post('endDate');
		$workHour=$this->input->post('workHour');
		$content=$this->input->post('content');
		$photoUrl=$this->input->post('photoUrl');
		
		$data=array(
			'user_id'=>$userId,
			'begin_time'=>$beginDate,
			'end_time'=>$endDate,
			'work_hour'=>$workHour,
			'content'=>$content,
			'photo_url'=>$photoUrl
		);
		$this->db->insert('work_log',$data);

		if($this->db->affected_rows()==1){
			$ret=$this->ajax->returnData("200","success");
			die($ret);
		}else{
			$ret=$this->ajax->returnData("0","addFailed");
			die($ret);
		}
	}
	
	
	public function edit($logId=0)
	{
		$this->ajax->makeAjaxToken();
		$query=$this->db->query("SELECT a.*,b.name AS real_name FROM work_log a,archive b WHERE a.id=? AND a.user_id=b.id",[$logId]);
		$list=$query->result_array();
		
		if(count($list)!=1){
			header("location:".base_url());
		}
		
		$list[0]['photo_url']=json_decode($list[0]['photo_url'],TRUE);
		$this->session->set_userdata($this->sessPrefix."workLog_editId",$logId);
		
		$this->load->view('workLog/edit',['info'=>$list[0]]);
	}


	public function toEdit()
	{
		$token=$this->input->post('token');
		$this->ajax->checkAjaxToken($token);
		
		$beginDate=$this->input->post('beginDate');
		$endDate=$this->input->post('endDate');
		$workHour=$this->input->post('workHour');
		$content=$this->input->post('content');
		$photoUrl=$this->input->post('photoUrl');
		
		$data=array(
			'begin_time'=>$beginDate,
			'end_time'=>$endDate,
			'work_hour'=>$workHour,
			'content'=>$content,
			'photo_url'=>$photoUrl
		);
		$this->db->where('id',$this->session->userdata($this->sessPrefix."workLog_editId"));
		$this->db->update('work_log',$data);

		if($this->db->affected_rows()==1){
			$this->session->unset_userdata($this->sessPrefix."workLog_editId");
			$ret=$this->ajax->returnData("200","success");
			die($ret);
		}else{
			$ret=$this->ajax->returnData("0","editFailed");
			die($ret);
		}
	}


	public function toUploadPhoto()
	{
		$num=(int)$this->input->post('uploadingNum');
		
		if($num<1 || $num>5) die($this->ajax->returnData(3,"numError"));

		if($_FILES['file']["error"]==0){
			if(($_FILES["file"]["type"]=="image/png"||$_FILES["file"]["type"]=="image/jpeg")&&$_FILES["file"]["size"]<10485760){
				$extend=pathinfo($_FILES['file']["name"]);
				$extend=$extend['extension'];
				$name=$this->nowUserID."-".date("YmdHi")."-".mt_rand(123,987).".".$extend;
				$tmp_name=$_FILES["file"]["tmp_name"];

				if(file_exists("resource/images/upload/worklog/".$name)){
					$ret=$this->ajax->returnData(1,"fileExists");
					die($ret);
				}else{
					move_uploaded_file($tmp_name,"resource/images/upload/worklog/".$name);
					$ret=$this->ajax->returnData(200,"success",['url'=>base_url("resource/images/upload/worklog/".$name)]);
					die($ret);
				}
			}else{
				$ret=$this->ajax->returnData(2,"invaildExtension");
				die($ret);
			}
		}else{
			$ret=$this->ajax->returnData($_FILES["file"]["error"],"unknownError");
			die($ret);
		}
	}
}
