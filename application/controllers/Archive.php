<?php
/**
 * @name C-Archive个人档案
 * @author Jerry Cheung <master@xshgzs.com>
 * @since 2018-10-25
 * @version 2018-11-29
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Archive extends CI_Controller {

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
	
	
	public function reg()
	{
		$this->ajax->makeAjaxToken();
		
		if($this->session->userdata($this->sessPrefix."reg_userId")<1){
			header("Location:".base_url('user/logout'));
		}

		$name=$this->session->userdata($this->sessPrefix."reg_realName");
		$phone=$this->session->userdata($this->sessPrefix."reg_phone");

		$this->load->view('archive/reg',['name'=>$name,'phone'=>$phone]);
	}
	
	
	public function toReg()
	{
		$token=$this->input->post('token');
		$this->ajax->checkAjaxToken($token);
		
		$name=$this->input->post('name');
		$sex=$this->input->post('sex');
		$idCard=$this->input->post('idCard');
		$enrollYear=$this->input->post('enrollYear');
		$classNum=$this->input->post('classNum');
		$phone=$this->input->post('phone');
		$depId=$this->input->post('depId');
		$jobName=$this->input->post('jobName');
		$description=$this->input->post('description');
		
		$data=array(
			'user_id'=>$this->session->userdata($this->sessPrefix."reg_userId"),
			'name'=>$name,
			'sex'=>$sex,
			'id_card'=>$idCard,
			'enroll_year'=>$enrollYear,
			'class_num'=>$classNum,
			'phone'=>$phone,
			'dep_id'=>$depId,
			'job_name'=>$jobName,
			'description'=>$description
		);
		$this->db->insert('archive',$data);

		if($this->db->affected_rows()==1){
			$ret=$this->ajax->returnData("200","success");
			die($ret);
		}else{
			$ret=$this->ajax->returnData("0","regFailed");
			die($ret);
		}
	}


	public function myCard()
	{
		$this->ajax->makeAjaxToken();

		$query=$this->db->get_where('archive',array('user_id'=>$this->nowUserID));
		$info=$query->result_array();
		
		$depId=$info[0]['dep_id'];
		$query2=$this->db->get_where('department',array('id'=>$depId));
		$info2=$query2->result_array();
		$depName=$info2[0]['name'];
		
		$info[0]['dep_name']=$depName;

		$this->load->view('archive/my',['info'=>$info[0]]);
	}
	
	
	public function toEditMy()
	{
		$token=$this->input->post('token');
		$this->ajax->checkAjaxToken($token);
		
		$name=$this->input->post('name');
		$sex=$this->input->post('sex');
		$idCard=$this->input->post('idCard');
		$enrollYear=$this->input->post('enrollYear');
		$classNum=$this->input->post('classNum');
		$phone=$this->input->post('phone');
		$depId=$this->input->post('depId');
		$jobName=$this->input->post('jobName');
		$description=$this->input->post('description');
		$photoUrl=$this->input->post('photoUrl');
		
		$data=array(
			'name'=>$name,
			'sex'=>$sex,
			'id_card'=>$idCard,
			'enroll_year'=>$enrollYear,
			'class_num'=>$classNum,
			'phone'=>$phone,
			'dep_id'=>$depId,
			'job_name'=>$jobName,
			'description'=>$description,
			'photo_url'=>$photoUrl
		);
		$this->db->where('user_id',$this->nowUserID);
		$this->db->update('archive',$data);

		if($this->db->affected_rows()==1){
			$ret=$this->ajax->returnData("200","success");
			die($ret);
		}else{
			$ret=$this->ajax->returnData("0","updateFailed");
			die($ret);
		}
	}


	public function toUploadPhoto()
	{
		foreach($_FILES['myfile']["error"] as $key => $error){
			if($error == UPLOAD_ERR_OK){
				if(($_FILES["myfile"]["type"][0]=="image/png"||$_FILES["myfile"]["type"][0]=="image/jpeg")&&$_FILES["myfile"]["size"][0]<10485760){
					$extend=pathinfo($_FILES["file"]["name"]);
					$extend=$extend['extension'];
					$name=$this->nowUserID."-".date("YmdHi")."-".mt_rand(123,987).".".$extend;
					$tmp_name=$_FILES["myfile"]["tmp_name"][$key];

					if(file_exists("resource/images/upload/archive/".$name)){
						$ret=$this->ajax->returnData(1,"fileExists");
						die($ret);
					}else{
						move_uploaded_file($tmp_name,"resource/images/upload/archive/".$name);
						$ret=$this->ajax->returnData(200,"success",['url'=>base_url("resource/images/upload/archive/".$name)]);
						die($ret);
					}
				}else{
					$ret=$this->ajax->returnData(2,"invaildExtension");
					die($ret);
				}
			}elseif($_FILES["myfile"]["error"][$key]!="4"){
				$ret=$this->ajax->returnData($_FILES["file"]["error"][$key],"unknownError");
				die($ret);
			}else{
				$ret=$this->ajax->returnData(var_dump($_FILES["file"]["error"]),"unknownError");
				die($ret);
			}
		}
	}
	
	
	public function myMember()
	{
		$this->ajax->makeAjaxToken();
		$this->load->view('archive/myMember');
	}
	
	
	public function memberCard($id=0)
	{
		if($id<1){
			header("Location:".base_url());
		}
		
		$this->ajax->makeAjaxToken();

		$query=$this->db->get_where('archive',array('user_id'=>$id));
		$info=$query->result_array();
		
		$depId=$info[0]['dep_id'];
		$query2=$this->db->get_where('department',array('id'=>$depId));
		$info2=$query2->result_array();
		$depName=$info2[0]['name'];
		
		$info[0]['dep_name']=$depName;

		$this->load->view('archive/memberCard',['info'=>$info[0]]);
	}
}
