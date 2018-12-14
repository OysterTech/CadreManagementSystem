<?php 
/**
 * @name V-用户注册-初次填档案
 * @author Jerry Cheung <master@xshgzs.com>
 * @since 2018-11-05
 * @version 2018-11-28
 */
?>

<!DOCTYPE html>
<html>

<head>
	<?php $this->load->view('include/header'); ?>
	<title>初次填写档案 / <?=$this->Setting_model->get('systemName'); ?></title>
	<style>
	body{padding-top:20px;}
	</style>
</head>

<body>
<div class="container">
	<div class="col-md-6 col-md-offset-3">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">初次填写个人档案</h3>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label for="name">真实姓名</label>
					<input class="form-control" id="name" value="<?=$name;?>" disabled>
				</div>
				<div class="form-group">
					<label for="phone">手机号</label>
					<input class="form-control" id="phone" value="<?=$phone;?>" disabled>
				</div>

				<hr>
				
				<div class="form-group">
					<label for="idCard">身份证号</label>
					<input class="form-control" id="idCard" onkeyup='if(event.keyCode==13 || this.value.length==18){checkIdCard(this.value);$("#grade").focus();}'>
				</div>
				<div class="form-group">
					<label>性别</label>
					<select class="form-control" id="sex" disabled>
						<option selected disabled>::: 请选择性别 :::</option>
						<option value="男">男性 ♂</option>
						<option value="女">女性 ♀</option>						
					</select>
					<p class="help-block">系统将会在您输入身份证号后，自动为您选择性别</p>
				</div>
				<br>
				<div class="form-group">
					<label for="grade">当前年级</label>
					<select class="form-control" id="grade" onchange='$("#classNum").focus();'>
						<option selected disabled>::: 请选择年级 :::</option>
						<option value="1">1. 高一</option>
						<option value="2">2. 高二</option>
						<option value="3">3. 高三</option>
					</select>
					<p class="help-block">请选择<b>目前所在</b>的年级</p>
				</div>
				<div class="form-group">
					<label for="classNum">班别</label>
					<select class="form-control" id="classNum" onchange='$("#description").focus();'>
						<option selected disabled>::: 请选择班别 :::</option>
						<?php for($i=1;$i<=12;$i++){ ?>
						<option value="<?=$i;?>"><?=$i;?> 班</option>
						<?php } ?>
					</select>
				</div>
				<br>
				<div class="form-group">
					<label for="description" id="descTips">个人简介</label>
					<textarea class="form-control" id="description" rows="5" oninput='$("#descTips").html("个人简介(剩余可输入字数:<font color=red>"+(200-this.value.length)+"</font>)");'></textarea>
					<p class="help-block" style="font-weight:bold;color:red;">选填，限200字以内</p>
				</div>
				<br>
				<div class="form-group">
					<label for="name">所在部门(点击灰色框进行选择)</label>
					<input class="form-control" id="depName" onclick='$("#chooseDepModal").modal("show");' readonly>
					<input type="hidden" id="depId">
				</div>
				<div class="form-group">
					<label for="jobName">职务</label>
					<input class="form-control" id="jobName">
					<p class="help-block">如：部员、部长、常委</p>
				</div>
				
				<hr>
				
				<div style="text-align: center;">
					<div class="alert alert-info">
						个人照片请登录后再上传，谢谢！
					</div>
				</div>
				<div style="text-align: center;">
					<div class="alert alert-warning">
						若信息填错可在登录后再次修改！
					</div>
				</div>
				
				<hr>

				<button class="btn btn-lg btn-success btn-block" onclick='reg();'>确 认 提 交 &gt;</button>
			</div>
		</div>
	</div>
</div>

<?php $this->load->view('/include/footer'); ?>

<script src="<?=base_url('resource/js/idCard.js');?>"></script>
<script>
function checkIdCard(num){
	if(!checkValidIDCard(num)){
		unlockScreen();
		showTipsModal("请注意：身份证号校验不通过！<br>请重新输入！");
		$("#idCard").focus();
		return false;
	}else{
		sexNum=num.substr(16,1);
		
		if(sexNum%2==1) $("#sex").val("男");
		else if(sexNum%2==0) $("#sex").val("女");
	}
}

function reg(){
	lockScreen();
	name=$("#name").val();
	sex=$("#sex").val();
	idCard=$("#idCard").val();
	grade=$("#grade").val();
	classNum=$("#classNum").val();
	phone=$("#phone").val();
	depId=$("#depId").val();
	jobName=$("#jobName").val();
	description=$("#description").val();
	enrollYear=0;

	if(sex!="男" && sex!="女"){
		unlockScreen();
		showTipsModal("请选择性别！");
		return false;
	}
	if(!checkValidIDCard(idCard)){
		unlockScreen();
		showTipsModal("身份证号校验不通过！<br>请重新输入！");
		return false;
	}

	if(grade=="" || grade==null){
		unlockScreen();
		showTipsModal("请选择当前年级！");
		return false;
	}else{
		enrollYear=getEnrollYearByGrade(grade);
	}

	if(classNum=="" || classNum==null){
		unlockScreen();
		showTipsModal("请选择所在班级！");
		return false;
	}
	if(depId=="" || depId==0){
		unlockScreen();
		showTipsModal("请选择所在部门！");
		return false;	
	}
	if(jobName=="" || jobName.length<=1){
		unlockScreen();
		showTipsModal("请正确输入职务名称！");
		return false;	
	}
	if(description.length>200){
		unlockScreen();
		showTipsModal("请输入200字以内的个人简介！");
		return false;
	}

	$.ajax({
		url:"<?=base_url('archive/toReg');?>",
		type:"post",
		data:{<?=$this->ajax->showAjaxToken();?>,'name':name,"sex":sex,"idCard":idCard,"phone":phone,"enrollYear":enrollYear,"classNum":classNum,"description":description,'depId':depId,'jobName':jobName},
		dataType:'json',
		error:function(e){
			console.log(JSON.stringify(e));
			unlockScreen();
			showTipsModal("服务器错误！<hr>请联系技术支持并提交以下错误码：<br><font color='blue'>"+e.status+"</font>");
			return false;
		},
		success:function(ret){
			unlockScreen();
			
			if(ret.code=="200"){
				alert("档案保存成功！请重新登录系统！");
				window.location.href="<?=base_url();?>";
				return true;
			}else if(ret.message=="regFailed"){
				showTipsModal("保存失败！！！");
				return false;
			}else if(ret.code=="403"){
				showTipsModal("Token无效！<hr>Tips:请勿在提交前打开另一页面哦~");
				return false;
			}else{
				showTipsModal("系统错误！<hr>请联系技术支持并提交以下错误码：<br><font color='blue'>"+ret.code+"</font>");
				return false;
			}
		}
	});
}


// 选择所在部门
var setting = {
	async: {
		enable: true,
		url:"<?=base_url('api/getDepartmentByZtree2');?>",
		autoParam:["id"],
		dataFilter: filter
	},
	view: {
		addHoverDom: addHoverDom,
		removeHoverDom: removeHoverDom,
	}
};

$(document).ready(function(){
	$.fn.zTree.init($("#treeDemo"), setting);
});


function sureChoose(depId,name){
	$("#depId").val(depId);
	$("#depName").val(name);
	$("#chooseDepModal").modal('hide');
}


// Ztree关键函数
function filter(treeId,parentNode,childNodes) {
	if(!childNodes) return null;
	for(var i=0,l=childNodes.length;i<l;i++){
		childNodes[i].name=childNodes[i].name.replace(/\.n/g, '.');
	}
	return childNodes;
}
function addHoverDom(treeId, treeNode){
	var aObj=$("#"+treeNode.tId+"_a");
	var editStr="<button id='show_"+treeNode.id+"' onclick='sureChoose("+'"'+treeNode.id+'","'+treeNode.name+'"'+");'>我在此部门</button>";
	if($("#show_"+treeNode.id).length>0) return;
	if(treeNode.level==0) return;
	aObj.append(editStr);
}
function removeHoverDom(treeId, treeNode) {
	$("#show_"+treeNode.id).unbind().remove();
}
</script>

<?php $this->load->view('include/tipsModal'); ?>

<div class="modal fade" id="chooseDepModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
				<h3 class="modal-title" id="photoTitle">选择您所在的部门</h3>
			</div>
			<div class="modal-body">
				<div style="text-align: center;">
					<div class="alert alert-success">
						点击所在部门名称后，再点击右侧的“在此部门”即可！
					</div>
				</div>
				<ul id="treeDemo" class="ztree"></ul>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">关闭 &gt;</button>
			</div>
		</div>
	</div>
</div>

</body>
</html>
