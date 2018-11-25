<?php
/**
* @name A-Department-部门API
* @author Jerry Cheung <master@xshgzs.com>
* @since 2018-10-28
* @version 2018-11-24
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
			// 首次显示顶级菜单(我所在的部门)
			$query1=$this->db->get_where('archive',array('user_id'=>$this->nowUserID));
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
		$query3=$this->db->get_where('archive',array('dep_id'=>$pId));
		$list3=$query3->result_array();
		foreach($list3 as $info3){
			$ret[$i]['id']=$info3['user_id'];
			$ret[$i]['name']=$info3['name'];
			$i++;
		}

		die(json_encode($ret));
	}


	public function getDepartmentByZtree2(){
		if(array_key_exists('id',$_REQUEST)){
			$pId=$_REQUEST['id'];
		}else{
			$pId=1;
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

		die(json_encode($ret));
	}
	
	
	public function getDepartmentByZtree3(){
		$ret=[];$i=0;

		$userQuery=$this->db->get_where('archive',array('user_id'=>$this->nowUserID));
		$userList=$userQuery->result_array();
		$myDepId=$userList[0]['dep_id'];

		$depQuery=$this->db->get('department');
		$depList=$depQuery->result_array();
		$depListObject=json_decode(json_encode($depList));
		$tree=$this->getAllChild([$myDepId],$depListObject);

		$ids=$tree[0];
		$pIds=$tree[1];
		
		// 循环部门信息
		foreach($ids as $key=>$id){
			$pId=$pIds[$key];
			
			// 查询此部门信息
			$depInfoQuery=$this->db->get_where('department',['id'=>$id]);
			$depInfoList=$depInfoQuery->result_array();
			
			$ret[$i]['id']="D_".$id;
			$ret[$i]['pId']="D_".$pId;
			$ret[$i]['name']="★ ".$depInfoList[0]['name'];
			$ret[$i]['isParent']=true;
			
			// 如果是我的部门，展开
			if($id==$myDepId){
				$ret[$i]['open']=true;
			}
			
			$i++;
			
			// 搜索此部门的人员
			$depUserQuery=$this->db->get_where('archive',array('dep_id'=>$id));
			$depUserList=$depUserQuery->result_array();
			foreach($depUserList as $depUserinfo){
				$ret[$i]['id']=$depUserinfo['id'];
				$ret[$i]['pId']="D_".$id;
				$ret[$i]['name']=$depUserinfo['name'];
				$i++;
			}
		}

		die($this->ajax->returnData("200","success",json_encode($ret)));
	}


	function getAllChild($pid,&$collects){
		$map=[];$data=$pid;$data2=[];
		
		foreach($collects as $collect){
			$map[]=$collect->pid.'_'.$collect->id;
		}

		foreach($map as $mix_str){
			$mix=explode('_',$mix_str);

			if(in_array($mix[0],$data)){
				$data[]=$mix[1];
				$data2[]=$mix[0];
			}
		}
		
		array_unshift($data2,0);
		return [$data,$data2];
	}
}
