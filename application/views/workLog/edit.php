<?php 
/**
 * @name V-编辑工作记录
 * @author Jerry Cheung <master@xshgzs.com>
 * @since 2018-11-24
 * @version 2018-11-25
 */ 
?>

<!DOCTYPE html>
<html>

<head>
	<?php $this->load->view('include/header'); ?>
	<title>编辑工作记录 / <?=$this->Setting_model->get('systemName');?></title>

	<link rel="stylesheet" type="text/css" href="<?=base_url('resource/css/jquery-ui.css');?>">
	<style type="text/css">
		td,select{font-size:12px;}
		.demo{width:500px;margin:20px auto;}
		.demo h4{height:32px;line-height:32px;font-size:14px;}
		.demo h4 span{font-weight:500;font-size:12px;}
		.ui-timepicker-div dl dt {height: 25px;margin-bottom: -25px;}
		.ui-timepicker-div dl dd {margin: 0 10px 10px 65px;}
		.ui_tpicker_hour_label,.ui_tpicker_minute_label,.ui_tpicker_time_label{padding-left:20px;font-size:12px;}
	</style>

	<script>
		jQuery.browser={};(function(){jQuery.browser.msie=false; jQuery.browser.version=0;if(navigator.userAgent.match(/MSIE ([0-9]+)./)){ jQuery.browser.msie=true;jQuery.browser.version=RegExp.$1;}})();
	</script>

	<script src="<?=base_url('resource/js/jquery-ui.js');?>"></script>
	<script src="<?=base_url('resource/js/jquery-ui-slide.min.js');?>"></script>
	<script src="<?=base_url('resource/js/jquery-ui-timepicker-addon.js');?>"></script>
</head>

<body>
<div id="wrapper">

<?php $this->load->view('include/navbar'); ?>

<!-- Page Content -->
<div id="page-wrapper">

<!-- Page Name-->
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">编辑工作记录</h1>
	</div>
</div>
<!-- ./Page Name-->

<div class="panel panel-default">
	<div class="panel-body">
		<div class="form-group">
			<label>工作人</label>
			<input class="form-control" id="person" value="<?=$info['real_name'];?>" disabled>
		</div>

		<div class="form-group">
			<div class="col-xs-12">
				<label>开始工作时间</label>
			</div>
			<div class="col-xs-6">
				<input id="beginDate" class="form-control" onchange="getWorkHour();" value="<?=substr($info['begin_time'],0,10);?>" readonly>
			</div>
			<div class="col-xs-6">
				<select id="beginHour" class="form-control" onchange="getWorkHour();">
					<option selected disabled>::: 请选择小时 :::</option>
					<?php for($i=1;$i<=24;$i++){ ?>
					<option value="<?php if($i<10) echo 0;?><?=$i;?>:00"><?php if($i<10) echo 0;?><?=$i;?>:00</option>
					<?php } ?>
				</select>
			</div>
			<br><br><br>
		</div>

		<div class="form-group">
			<div class="col-xs-12">
				<label>结束工作时间</label>
			</div>
			<div class="col-xs-6">
				<input id="endDate" class="form-control" onchange="getWorkHour();" value="<?=substr($info['end_time'],0,10);?>" readonly>
			</div>
			<div class="col-xs-6">
				<select id="endHour" class="form-control" onchange="getWorkHour();">
					<option selected disabled>::: 请选择小时 :::</option>
					<?php for($i=1;$i<=24;$i++){ ?>
					<option value="<?php if($i<10) echo 0;?><?=$i;?>:00"><?php if($i<10) echo 0;?><?=$i;?>:00</option>
					<?php } ?>
				</select>
			</div>
			<br><br><br>
		</div>

		<div class="form-group">
			<label>工作时长(单位:小时)</label>
			<input class="form-control" id="workHour" value="<?=$info['work_hour'];?>" disabled>
		</div>
		
		<hr>

		<div class="form-group">
			<label for="content" id="descTips">工作内容介绍</label>
			<textarea class="form-control" id="content" rows="8" oninput='$("#descTips").html("工作内容介绍(剩余可输入字数:<font color=red>"+(400-this.value.length)+"</font>)");'><?=$info['content'];?></textarea>
			<p class="help-block" style="color:red;font-weight:bold;font-size:16px;">必填，字数限制：10~400</p>
		</div>

		<br>

		<form method="post" enctype="multipart/form-data">
		<label>工作照片</label>
		
		<?php
		$totalPhoto=count($info['photo_url']);
		for($j=1;$j<=5;$j++){
		?>
		<div class="input-group">
			<span class="input-group-addon"><?=$j;?></span>
			<input type="file" class="form-control" id="myfile_<?=$j;?>" <?php if($j<=$totalPhoto){echo "disabled";} ?>>
			<span class="input-group-btn">
				<?php if($j<=$totalPhoto){ ?>
				<button id="uploadBtn_<?=$j;?>" type="button" class="btn btn-success" onclick='showPhoto("<?=$j;?>");'>
					<i class="fa fa-eye"></i>
				</button>
				<?php }else{ ?>
				<button id="uploadBtn_<?=$j;?>" type="button" class="btn btn-info" onclick='uploadPhoto("<?=$j;?>");'>
					<i class="fa fa-upload"></i>
				</button>
				<?php } ?>
			</span>
			<input type="hidden" id="photoUrl_<?=$j;?>" value="<?php if($j<=$totalPhoto){echo $info['photo_url'][$j-1];}?>">
		</div>
		<?php } ?>
		
		<p class="help-block" style="color:red;font-weight:bold;font-size:16px;">
			选填，最多可上传5张<br>
			请先点击右侧上传，再确认新增
		</p>
		<input type="hidden" id="uploadingNum" name="uploadingNum" value="<?=$totalPhoto;?>">
		</form>

		<hr>

		<button class="btn btn-success btn-block" onclick='toEdit()'>确 认 编 辑 &gt;</button>
	</div>
</div>

<?php $this->load->view('include/footer'); ?>

<!-- ./Page Main Content -->
</div>
<!-- ./Page -->
</div>

<script>
$("#beginHour").val("<?=substr($info['begin_time'],11,5);?>");
$("#endHour").val("<?=substr($info['end_time'],11,5);?>");

$(function(){
	$('#beginDate').datepicker();
	$('#endDate').datepicker();
});


function getWorkHour(){
	beginDate=$("#beginDate").val();
	beginHour=$("#beginHour").val();
	endDate=$("#endDate").val();
	endHour=$("#endHour").val();
	
	if(beginDate=="" || beginHour==null || endDate=="" || endHour==null){
		return;
	}
	
	begin=Date.parse(beginDate+" "+beginHour);
	end=Date.parse(endDate+" "+endHour);
	leave=end-begin;
	
	if(leave<=0){
		showTipsModal("请正确选择日期！");
		$("#workHour").val("0");
	}else{
		workHour=leave/(3600*1000);
		$("#workHour").val(workHour);
	}
	
	return;
}


function toEdit(){
	lockScreen();
	beginDate=$("#beginDate").val();
	beginHour=$("#beginHour").val();
	endDate=$("#endDate").val();
	endHour=$("#endHour").val();
	workHour=$("#workHour").val();
	content=$("#content").val();
	num=parseInt($("#uploadingNum").val());
	photoUrl=new Array();
	
	beginDate=beginDate+" "+beginHour+":00";
	endDate=endDate+" "+endHour+":00";

	if(beginDate=="" || beginHour==null || endDate=="" || endHour==null){
		unlockScreen();
		showTipsModal("请正确选择工作时间！");
		return false;
	}

	if(content.length>400 || content.length<10){
		unlockScreen();
		showTipsModal("请输入10~400字的工作内容介绍！");
		return false;
	}
	if(beginDate.length!=19 || endDate.length!=19 || workHour=="" || workHour<=0){
		unlockScreen();
		showTipsModal("请正确选择工作日期！");
		return false;
	}

	for(i=1;i<=num;i++){
		photoUrl.push($("#photoUrl_"+i).val());
	}

	photoUrl=JSON.stringify(photoUrl);

	$.ajax({
		url:"<?=base_url('workLog/toEdit');?>",
		type:"post",
		data:{<?php echo $this->ajax->showAjaxToken(); ?>,"beginDate":beginDate,"endDate":endDate,"workHour":workHour,"content":content,'photoUrl':photoUrl},
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
				alert("编辑成功！");
				history.go(-1);
				return true;
			}else if(ret.message=="editFailed"){
				showTipsModal("编辑失败！<br>数据未被保存！！！");
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

</body>
</html>
