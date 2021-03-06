<?php 
/**
 * @name V-档案-我的部员
 * @author Jerry Cheung <master@xshgzs.com>
 * @since 2018-10-25
 * @version 2018-11-19
 */ 
?>

<!DOCTYPE html>
<html>

<head>
	<?php $this->load->view('include/header'); ?>
	<title>我的部员档案 / <?php echo $this->Setting_model->get('systemName'); ?></title>
	<style>
	ul.ztree{
		margin-top: 10px;
		border: 1px solid #617775;
		background: #f0f6e4;
		width:100%;
		height:360px;
		overflow-y:scroll;
		overflow-x:auto;
	}
	</style>
</head>

<body>
<div id="wrapper">

<?php $this->load->view('include/navbar'); ?>

<!-- Page Content -->
<div id="page-wrapper">

<!-- Page Name-->
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">我的部员档案</h1>
	</div>
</div>
<!-- ./Page Name-->

<div class="zTreeDemoBackground left">
	<ul id="treeDemo" class="ztree"></ul>
</div>

<?php $this->load->view('include/footer'); ?>

<!-- ./Page Main Content -->
</div>
<!-- ./Page -->
</div>

<script src="<?=base_url('resource/js/idCard.js');?>"></script>
<SCRIPT type="text/javascript">
var setting = {
	async: {
		enable: true,
		url:"<?=base_url('api/getDepartmentByZtree');?>",
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

function showArchive(id){
	lockScreen();
	$.ajax({
		url:"<?=base_url('api/getArchive');?>",
		type:"post",
		data:{<?php echo $this->ajax->showAjaxToken(); ?>,'id':id},
		dataType:"json",
		error:function(e){
			console.log(JSON.stringify(e));
			unlockScreen();
			showTipsModal("服务器错误！<hr>请联系技术支持并提交以下错误码：<br><font color='blue'>"+e.status+"</font>");
			return false;
		},
		success:function(ret){
			unlockScreen();
			
			if(ret.code=="200"){
				var info=ret.data['data'];
				
				$("#archiveModalTitle").html(info['name']+"的资料卡");
				$("#name").html(info['name']);
				$("#sex").html(info['sex']);
				gradeName=getGradeByEnrollYear(info['enroll_year']);
				$("#className").html(gradeName+"("+info['class_num']+")班");
				$("#jobName").html(info['job_name']);
				$("#phone").html(info['phone']);
				$("#description").html(info['description']);
				$("#photo").attr("src",info['photo_url']);
				$("#archiveModal").modal("show");
			}
		}
	});
}


// Ztree关键函数
function filter(treeId,parentNode,childNodes) {
	if(!childNodes) return null;
	for(var i=0,l=childNodes.length;i<l;i++){
		childNodes[i].name=childNodes[i].name.replace(/\.n/g, '.');
	}
	return childNodes;
}
function addHoverDom(treeId, treeNode) {
	var aObj=$("#"+treeNode.tId+"_a");
	var editStr="<button id='show_1_"+treeNode.id+"' onclick='showArchive("+'"'+treeNode.id+'"'+");'>显示资料卡</button> <button id='show_2_"+treeNode.id+"' onclick="+'"'+"window.location.href='<?=base_url('archive/memberCard/');?>"+treeNode.id+"';"+'"'+"'>编辑档案</button>";
	
	if($("#show_1_"+treeNode.id).length>0) return;
	if($("#show_2_"+treeNode.id).length>0) return;
	if(treeNode.isParent==true) return;
	aObj.append(editStr);
};
function removeHoverDom(treeId, treeNode) {
	$("#show_1_"+treeNode.id).unbind().remove();
	$("#show_2_"+treeNode.id).unbind().remove();
};
</SCRIPT>

<?php $this->load->view('include/tipsModal'); ?>

<div class="modal fade" id="archiveModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
				<h3 class="modal-title" id="archiveModalTitle"></h3>
			</div>
			<div class="modal-body">
				<table class="table table-hover table-striped table-bordered">
					<tr>
						<th>姓名</th>
						<td id="name"></td>
					</tr>
					<tr>
						<th>性别</th>
						<td id="sex"></td>
					</tr>
					<tr>
						<th>班别</th>
						<td id="className"></td>
					</tr>
					<tr>
						<th>手机号</th>
						<td id="phone"></td>
					</tr>
					<tr>
						<th>职务</th>
						<td id="jobName"></td>
					</tr>
					<tr>
						<th>个人简介</th>
						<td id="description"></td>
					</tr>
					<tr>
						<th>照片</th>
						<td><img id="photo" style="width:100%;"></td>
					</tr>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">确认 &gt;</button>
			</div>
		</div>
	</div>
</div>

</body>
</html>
