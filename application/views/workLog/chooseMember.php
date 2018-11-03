<?php 
/**
 * @name V-查看部员工作记录-选择部员
 * @author Jerry Cheung <master@xshgzs.com>
 * @since 2018-11-03
 * @version 2018-11-03
 */ 
?>

<!DOCTYPE html>
<html>

<head>
	<?php $this->load->view('include/header'); ?>
	<title>选择部员 / <?php echo $this->Setting_model->get('systemName'); ?></title>
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
		<h1 class="page-header">我的部员列表</h1>
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

function seeWorkLog(id){
	url="<?=base_url('workLog/member/list/');?>";
	url+=id;
	window.location.href=url;
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
	var editStr="<button id='show_"+treeNode.id+"' onclick='seeWorkLog("+'"'+treeNode.id+'"'+");'>查看此人工作记录</button>";
	if($("#show_"+treeNode.id).length>0) return;
	if(treeNode.isParent==true) return;
	aObj.append(editStr);
};
function removeHoverDom(treeId, treeNode) {
	$("#show_"+treeNode.id).unbind().remove();
};
</SCRIPT>

<?php $this->load->view('include/tipsModal'); ?>

</body>
</html>
