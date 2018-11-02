<?php
/**
 * @name C-Profile个人资料
 * @author Jerry Cheung <master@xshgzs.com>
 * @since 2018-10-25
 * @version 2018-11-02
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

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


	public function myCard()
	{
		$this->ajax->makeAjaxToken();

		$query=$this->db->get_where('profile',array('user_id'=>$this->nowUserID));
		$info=$query->result_array();

		$this->load->view('profile/my',['info'=>$info[0]]);
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
		$description=$this->input->post('description');
		$photoUrl=$this->input->post('photoUrl');
		
		$data=array(
			'name'=>$name,
			'sex'=>$sex,
			'id_card'=>$idCard,
			'enroll_year'=>$enrollYear,
			'class_num'=>$classNum,
			'phone'=>$phone,
			'description'=>$description,
			'photo_url'=>$photoUrl
		);
		$this->db->where('user_id',$this->nowUserID);
		$this->db->update('profile',$data);

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

					if(file_exists("resource/images/upload/profile/".$name)){
						$ret=$this->ajax->returnData(1,"fileExists");
						die($ret);
					}else{
						move_uploaded_file($tmp_name,"resource/images/upload/profile/".$name);
						$ret=$this->ajax->returnData(200,"success",['url'=>base_url("resource/images/upload/profile/".$name)]);
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
		$this->load->view('profile/myMember');
	}
}
