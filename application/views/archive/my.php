<?php 
/**
 * @name V-我的档案
 * @author Jerry Cheung <master@xshgzs.com>
 * @since 2018-10-25
 * @version 2018-11-18
 */ 
?>

<!DOCTYPE html>
<html>

<head>
  <?php $this->load->view('include/header'); ?>
  <title>我的档案 / <?php echo $this->Setting_model->get('systemName'); ?></title>
</head>

<body>
<div id="wrapper">

<?php $this->load->view('include/navbar'); ?>

<!-- Page Content -->
<div id="page-wrapper">

<!-- Page Name-->
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">我的档案</h1>
	</div>
</div>
<!-- ./Page Name-->

<div class="panel panel-default">
	<div class="panel-body">
		<div class="form-group">
			<label for="name">真实姓名</label>
			<input class="form-control" id="name" onkeyup='if(event.keyCode==13)$("#sex").focus();' value="<?=$info['name'];?>">
		</div>
		<br>
		<div class="form-group">
			<label for="idCard">身份证号</label>
			<input class="form-control" id="idCard" onkeyup='if(event.keyCode==13 || this.value.length==18){checkIdCard(this.value);$("#grade").focus();}' value="<?=$info['id_card'];?>">
		</div>
		<br>
		<div class="form-group">
			<label>性别</label>
			<select class="form-control" id="sex" disabled>
				<option selected disabled>::: 请选择性别 :::</option>
				<option value="男">男性 ♂</option>
				<option value="女">女性 ♀</option>						
			</select>
			<p class="help-block">系统将会在您输入身份证号后，自动为您选择性别</p>
		</div>

		<hr>

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
		<br>
		<div class="form-group">
			<label for="classNum">班别</label>
			<select class="form-control" id="classNum" onchange='$("#phone").focus();'>
				<option selected disabled>::: 请选择班别 :::</option>
				<?php for($i=1;$i<=12;$i++){ ?>
				<option value="<?=$i;?>"><?=$i;?> 班</option>
				<?php } ?>
			</select>
		</div>

		<hr>

		<div class="form-group">
			<label for="phone">手机号</label>
			<input type="number" class="form-control" id="phone" onkeyup='if(event.keyCode==13)$("depName").focus();' value="<?=$info['phone'];?>">
		</div>
		<br>
		<div class="form-group">
			<label for="depName">所在部门</label>
			<input class="form-control" id="depName" onclick='$("#chooseDepModal").modal("show");' value="<?=$info['dep_name'];?>" readonly>
			<input type="hidden" id="depId" value="<?=$info['dep_id'];?>">
		</div>
		<br>
		<div class="form-group">
			<label for="jobName">职务</label>
			<input class="form-control" id="jobName" value="<?=$info['job_name'];?>">
		</div>
		<br>
		<div class="form-group">
			<label for="description" id="descTips">个人简介</label>
			<textarea class="form-control" id="description" rows="4" oninput='$("#descTips").html("个人简介(剩余可输入字数:<font color=red>"+(200-this.value.length)+"</font>)");'><?=$info['description'];?></textarea>
			<p class="help-block">选填，限200字以内</p>
		</div>

		<br>

		<form method="post" enctype="multipart/form-data">
		<label for="photo">个人照片</label>
		<div class="input-group">
			<input type="file" class="form-control" name="myfile[]" id="myfile">
			<span class="input-group-btn">
				<button class="btn btn-info" type="button" onclick="uploadPhoto();"><i class="fa fa-upload"></i></button>
			</span>
		</div>
		<p class="help-block" style="color:red;font-weight:bold;font-size:16px;">请先点击右侧上传，再确认修改资料！<button type="button" id="showOriginalPhoto_btn" class="btn btn-primary" onclick='$("#photoModal").modal("show");'>查看原照片</button></p>
		</form>

		<input type="hidden" id="photoUrl">
		<input type="hidden" id="originalPhotoUrl" value="<?=$info['photo_url'];?>">

		<hr>

		<button class="btn btn-success btn-block" onclick='updateArchive()'>确 认 修 改 资 料 &gt;</button>
	</div>
</div>

<?php $this->load->view('include/footer'); ?>

<!-- ./Page Main Content -->
</div>
<!-- ./Page -->
</div>

<script src="<?=base_url('resource/js/idCard.js');?>"></script>
<script>
window.onload=function(){
	$("#sex").val("<?=$info['sex'];?>");
	$("#grade").val("<?=date("Y")-$info['enroll_year']+1;?>");
	$("#classNum").val("<?=$info['class_num'];?>");
	
	// 若原来没有图片，隐藏查看原图按钮
	if($("#originalPhotoUrl").val()==""){
		$("#showOriginalPhoto_btn").attr("style","display:none;");
	}
}


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


function updateArchive(){
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
	originalPhotoUrl=$("#originalPhotoUrl").val();
	photoUrl=$("#photoUrl").val();
	enrollYear=0;

	if(name.length<2 || name.length>5){
		unlockScreen();
		showTipsModal("请正确输入真实姓名！");
		return false;
	}
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
	if(phone.length!=11){
		unlockScreen();
		showTipsModal("请正确输入手机号！");
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
	
	if(photoUrl=="" && originalPhotoUrl!=""){
		photoUrl=originalPhotoUrl;
	}

	$.ajax({
		url:"<?=base_url('archive/toEditMy');?>",
		type:"post",
		data:{<?=$this->ajax->showAjaxToken();?>,'name':name,"sex":sex,"idCard":idCard,"phone":phone,"enrollYear":enrollYear,"classNum":classNum,"description":description,"photoUrl":photoUrl,'depId':depId,'jobName':jobName},
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
				alert("修改成功！");
				location.reload();
				return true;
			}else if(ret.message=="updateFailed"){
				showTipsModal("修改失败！！！");
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


function uploadPhoto(){
	lockScreen();
	
	if($("#photoUrl").val()!=""){
		unlockScreen();
		showTipsModal("您已上传照片，请勿重复上传！<br>请及时点击确认修改即可！");
		return false;
	}

	if($("#myfile").val().length>0){
		var formData = new FormData($('form')[0]);
		formData.append('file',$('#myfile')[0].files[0]);

		$.ajax({
			url:'<?=base_url('archive/toUploadPhoto');?>',
			type: "post",
			data: formData,
			dataType:"json",
			cache: false,
			contentType: false,
			processData: false,
			error:function(e){
				unlockScreen();
				console.log(JSON.stringify(e));
				showTipsModal("服务器错误！请联系管理员！");
				return false;
			},
			success:function(ret){
				if(ret.code==200){
					unlockScreen();
					alert("上传成功！请及时点击“确认修改”！");
					$("#photoUrl").val(ret.data['url']);
					return true;
				}else if(ret.code==2){
					unlockScreen();
					showTipsModal("图片格式无效！");
					return false;
				}else{
					unlockScreen();
					console.log(ret);
					showTipsModal("未知系统错误！<br>请提交错误码["+ret.code+ret.message+"]给管理员");
					return false;
				}
			}
		});
	}else{
		unlockScreen();
		showTipsModal("请选择需要上传的照片！");
		return false;
	}
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

<div class="modal fade" id="photoModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
        <h3 class="modal-title">原照片</h3>
      </div>
      <div class="modal-body">
      	<img src="<?=$info['photo_url'];?>" style="width:100%;">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">关闭 &gt;</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="chooseDepModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
				<h3 class="modal-title" id="photoTitle">选择您所在的部门</h3>
			</div>
			<div class="modal-body">
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
