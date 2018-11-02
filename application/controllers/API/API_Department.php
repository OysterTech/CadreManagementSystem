<?php
/**
* @name A-Department-部门API
* @author Jerry Cheung <master@xshgzs.com>
* @since 2018-10-28
* @version 2018-10-28
*/

defined('BASEPATH') OR exit('No direct script access allowed');

class API_Department extends CI_Controller {

	public $sessPrefix;
	public $nowUserID;
	
	function __construct()
	{
		parent::__construct();

		$this->sessPrefix=$this->safe->getSessionPrefix();
		$this->nowUserID=$this->session->userdata($this->sessPrefix.'userID');
	}


	public function getDepartmentByZtree(){
		if(array_key_exists('id',$_REQUEST)){
			$pId=$_REQUEST['id'];
		}else{
			// 首次显示顶级菜单
			$query1=$this->db->get_where('profile',array('user_id'=>$this->nowUserID));
			$list1=$query1->result_array();
			$pId=$list1[0]['dep_id'];
		}
		
		$ret=[];$i=0;

		// 搜索所有子部门
		$query2=$this->db->get_where('department',array('pid'=>$pId));
		$list2=$query2->result_array();
		foreach($list2 as $info2){
			$ret[$i]['id']=$info2['id'];
			$ret[$i]['name']=$info2['name'];
			$ret[$i]['isParent']=true;
			$i++;
		}

		// 搜索当前部门的成员
		$query3=$this->db->get_where('profile',array('dep_id'=>$pId));
		$list3=$query3->result_array();
		foreach($list3 as $info3){
			$ret[$i]['id']=$info3['id'];
			$ret[$i]['name']=$info3['name'];
			$i++;
		}

		die(json_encode($ret));
	}
}
