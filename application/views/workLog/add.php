<?php 
/**
 * @name V-新增工作记录
 * @author Jerry Cheung <master@xshgzs.com>
 * @since 2018-11-02
 * @version 2018-11-02
 */ 
?>

<!DOCTYPE html>
<html>

<head>
  <?php $this->load->view('include/header'); ?>
  <title>新增工作记录 / <?php echo $this->Setting_model->get('systemName'); ?></title>
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
		<h1 class="page-header">新增工作记录</h1>
	</div>
</div>
<!-- ./Page Name-->

<div class="panel panel-default">
	<div class="panel-body">
		<div class="form-group">
			<label>工作人</label>
			<input class="form-control" id="person" <?php if($type=="member"){ ?>onclick='$("#choosePersonModal").modal("show");' readonly<?php }else{echo 'value="'.$myName.'" disabled';} ?>>
			<input type="hidden" id="userId" <?php if($type=="my"){echo 'value="'.$id.'"';} ?>>
		</div>
		
		<br>
		
		<div class="form-group">
			<label for="content" id="descTips">工作内容介绍</label>
			<textarea class="form-control" id="content" rows="8" oninput='$("#descTips").html("工作内容介绍(剩余可输入字数:<font color=red>"+(400-this.value.length)+"</font>)");'></textarea>
			<p class="help-block" style="color:red;font-weight:bold;font-size:16px;">必填，字数限制：10~400</p>
		</div>

		<br>

		<form method="post" enctype="multipart/form-data">
		<label>工作照片</label>
		<?php for($i=1;$i<=5;$i++){ ?>
		<div class="input-group">
			<span class="input-group-addon"><?=$i;?></span>
			<input type="file" class="form-control" id="myfile_<?=$i;?>">
			<span class="input-group-btn">
				<button id="uploadBtn_<?=$i;?>" class="btn btn-info" type="button" onclick='uploadPhoto("<?=$i;?>");'><i class="fa fa-upload"></i></button>
			</span>
			<input type="hidden" id="photoUrl_<?=$i;?>" value="">
		</div>
		<?php } ?>
		<p class="help-block" style="color:red;font-weight:bold;font-size:16px;">
			选填，最多可上传5张<br>
			请先点击右侧上传，再确认新增
		</p>
		<input type="hidden" id="uploadingNum" name="uploadingNum" value="0">
		</form>

		<hr>

		<button class="btn btn-success btn-block" onclick='toAdd()'>确 认 新 增 &gt;</button>
	</div>
</div>

<?php $this->load->view('include/footer'); ?>

<!-- ./Page Main Content -->
</div>
<!-- ./Page -->
</div>

<script>
function toAdd(){
	lockScreen();
	userId=$("#userId").val();
	content=$("#content").val();
	num=parseInt($("#uploadingNum").val());
	photoUrl=new Array();

	if(content.length>400 || content.length<10){
		unlockScreen();
		showTipsModal("请输入10~400字的工作内容介绍！");
		return false;
	}

	for(i=1;i<=num;i++){
		photoUrl.push($("#photoUrl_"+i).val());
	}

	photoUrl=JSON.stringify(photoUrl);

	$.ajax({
		url:"<?=base_url('workLog/toAdd');?>",
		type:"post",
		data:{<?php echo $this->ajax->showAjaxToken(); ?>,'userId':userId,"content":content,'photoUrl':photoUrl},
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
				alert("新增成功！\n感谢您为学校献出一份力！");
				location.reload();
				return true;
			}else if(ret.message=="addFailed"){
				showTipsModal("新增失败！！！");
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


function uploadPhoto(i){
	lockScreen();
	num=parseInt($("#uploadingNum").val());

	if((num+1)!=i){
		unlockScreen();
		showTipsModal("请按顺序上传！");
		return false;
	}

	if($("#myfile_"+i).val().length>0){
		$("#uploadingNum").val(i);
		var formData = new FormData($('form')[0]);
		formData.append('file',$('#myfile_'+i)[0].files[0]);

		$.ajax({
			url:'<?=base_url('workLog/toUploadPhoto');?>',
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
					alert("第 "+i+" 张上传成功！");
					$("#photoUrl_"+i).val(ret.data['url']);
					$("#uploadBtn_"+i).attr("class","btn btn-success");
					$("#uploadBtn_"+i).attr("onclick",'showPhoto("'+i+'")');
					$("#uploadBtn_"+i).html('<i class="fa fa-eye"></i>');
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


function showPhoto(i){
	url=$("#photoUrl_"+i).val();
	$("#photoTitle").html("工作照片（第"+i+"张）")
	$("#showPhotoUrl").attr("src",url);
	$("#photoModal").modal("show");
}


<?php if($type=="member"){ ?>
// 选择工作人
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


function sureChoose(userId,name){
	$("#userId").val(userId);
	$("#person").val(name);
	$("#choosePersonModal").modal('hide');
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
	var editStr="<button id='show_"+treeNode.id+"' onclick='sureChoose("+'"'+treeNode.id+'","'+treeNode.name+'"'+");'>选中此人</button>";
	if($("#show_"+treeNode.id).length>0) return;
	if(treeNode.isParent==true) return;
	aObj.append(editStr);
}
function removeHoverDom(treeId, treeNode) {
	$("#show_"+treeNode.id).unbind().remove();
}
<?php } ?>
</script>

<?php $this->load->view('include/tipsModal'); ?>

<div class="modal fade" id="photoModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
				<h3 class="modal-title" id="photoTitle"></h3>
			</div>
			<div class="modal-body">
				<img id="showPhotoUrl" style="width:100%;">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">关闭 &gt;</button>
			</div>
		</div>
	</div>
</div>

<?php if($type=="member"){ ?>
<div class="modal fade" id="choosePersonModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
				<h3 class="modal-title" id="photoTitle">选择工作人</h3>
			</div>
			<div class="modal-body">
				<div style="text-align: center;">
					<div class="alert alert-info">
						点击工作人的姓名后，再点击右侧的选中按钮即可。
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
<?php } ?>

</body>
</html>
