<?php 
/**
 * @name V-发布新通知
 * @author Jerry Cheung <master@xshgzs.com>
 * @since 2018-03-29
 * @version 2018-11-24
 */
?>

<!DOCTYPE html>
<html>

<head>
	<?php $this->load->view('include/header'); ?>
	<title>发布新通知 / <?=$this->Setting_model->get('systemName'); ?></title>
</head>

<body>
<div id="wrapper">

<?php $this->load->view('include/navbar'); ?>

<div id="page-wrapper">
<!-- Page Main Content -->

<!-- Page Name-->
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">发布新通知</h1>
	</div>
</div>
<!-- ./Page Name-->

<div class="panel panel-default">
	<div class="panel-heading">发布新通知</div>
	<div class="panel-body">
		<div class="form-group">
			<label for="title">通知标题</label>
			<input class="form-control" id="title">
			<p class="help-block">请输入<font color="green">1</font>-<font color="green">50</font>字的通知标题</p>
		</div>
		<br>
		<div class="form-group">
			<label for="title">通知接收人</label>
			<input class="form-control" id="receiverName" onclick="$('#selectUserModal').modal('show');" readonly>
			<input type="hidden" id="receiverIds">
			<p class="help-block">可选，如不选则代表所有人可看</p>
		</div>
		<br>
		<div class="form-group">
			<label for="content">通知内容</label>
			<div id="wangEditor_div"></div>
		</div>
		<button class="btn btn-success btn-block" onclick='publish()'>确 认 发 布 &gt;</button>
	</div>
</div>

<?php $this->load->view('include/footer'); ?>

<!-- ./Page Main Content -->
</div>
<!-- ./Page -->
</div>

<script>
var setting = {
	data: {
		simpleData: {
			enable: true
		}
	},
	check: {
		enable: true
	},
	view: {
		showIcon: showIconForTree
	}
};

$(document).ready(function(){
	$.fn.zTree.init($("#treeDemo"), setting,getUserList());
});


function showIconForTree(treeId,treeNode){
	return treeNode.level!=0;
}

function getCheckedNodes(){
	ids="";j=0;
	zTree=$.fn.zTree.getZTreeObj("treeDemo");
	nodes=zTree.getCheckedNodes();

	for(i=0;i<nodes.length;i++){
		id=nodes[i].id;
		id=id.toString();
		
		if(id.substr(0,2)!="D_"){
			ids+=id+",";
			j++;
		}
	}
	
	ids=ids.substr(0,ids.length-1);
	console.log(ids);
	$("#receiverIds").val(ids);
	$("#receiverName").val("已选择"+j+"人");
	$("#selectUserModal").modal("hide");
}

var E = window.wangEditor;
var editor = new E('#wangEditor_div');
editor.create();
$("#title").focus();

$(function(){
	$('#tipsModal').on('hidden.bs.modal',function (){
		$("#wangEditor_div").removeAttr("style");
	});
});

function publish(){
	lockScreen();
	title=$("#title").val();
	receiverIds=$("#receiverIds").val();
	content=editor.txt.html();
	$("#wangEditor_div").attr("style","display:none;");
	
	if(title==""){
		unlockScreen();
		$("#tips").html("请输入通知标题！");
		$("#tipsModal").modal('show');
		return false;
	}
	if(content==""){
		unlockScreen();
		$("#tips").html("请输入通知内容！");
		$("#tipsModal").modal('show');
		return false;
	}
	if(title.length<1 || title.length>50){
		unlockScreen();
		$("#tips").html("请输入 1-50字 的通知标题！");
		$("#tipsModal").modal('show');
		return false;
	}
	if(receiverIds==""){
		receiverIds=",";
	}

	$.ajax({
		url:"<?=base_url('admin/notice/toPublish'); ?>",
		type:"post",
		data:{<?=$this->ajax->showAjaxToken(); ?>,"title":title,"content":content,"receiverIds":receiverIds},
		dataType:'json',
		error:function(e){
			console.log(JSON.stringify(e));
			unlockScreen();
			$("#tips").html("服务器错误！<hr>请联系技术支持并提交以下错误码：<br><font color='blue'>"+e.status+"</font>");
			$("#tipsModal").modal('show');
			return false;
		},
		success:function(ret){
			unlockScreen();
			
			if(ret.code=="200"){
				alert("发布成功！");
				history.go(-1);
				return true;
			}else if(ret.message=="publishFailed"){
				$("#tips").html("发布失败！！！");
				$("#tipsModal").modal('show');
				return false;
			}else if(ret.code=="403"){
				$("#tips").html("Token无效！<hr>Tips:请勿在提交前打开另一页面哦~");
				$("#tipsModal").modal('show');
				return false;
			}else{
				$("#tips").html("系统错误！<hr>请联系技术支持并提交以下错误码：<br><font color='blue'>"+ret.code+"</font>");
				$("#tipsModal").modal('show');
				return false;
			}
		}
	});
}


function getUserList(){
	var rtn=[];
	lockScreen();

	$.ajax({
		url:"<?=base_url('api/getDepartmentByZtree3');?>",
		async:false,
		dataType:'json',
		error:function(e){
			console.log(JSON.stringify(e));
			unlockScreen();
			$("#tips").html("服务器错误！<hr>请联系技术支持并提交以下错误码：<br><font color='blue'>"+e.status+"</font>");
			$("#tipsModal").modal('show');
			return false;
		},
		success:function(ret){
			unlockScreen();
			
			if(ret.code=="200"){
				rtn=ret.data;
			}else if(ret.code=="403"){
				$("#tips").html("Token无效！<hr>Tips:请勿在提交前打开另一页面哦~");
				$("#tipsModal").modal('show');
				return false;
			}else{
				$("#tips").html("系统错误！<hr>请联系技术支持并提交以下错误码：<br><font color='blue'>"+ret.code+"</font>");
				$("#tipsModal").modal('show');
				return false;
			}
		}
	});
	return JSON.parse(rtn);
}
</script>

<?php $this->load->view('include/tipsModal'); ?>

<div class="modal fade" id="selectUserModal" style="z-index:99999;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
        <h3 class="modal-title" id="ModalTitle">用户选择（带★为部门）</h3>
      </div>
      <div class="modal-body">
        <div class="zTreeDemoBackground left">
        <ul id="treeDemo" class="ztree"></ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick='getCheckedNodes();'>确认 &gt;</button>
      </div>
    </div>
  </div>
</div>

</body>
</html>
