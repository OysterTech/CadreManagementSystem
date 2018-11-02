<?php 
/**
 * @name V-工作记录详情
 * @author Jerry Cheung <master@xshgzs.com>
 * @since 2018-11-02
 * @version 2018-11-02
 */ 
?>

<!DOCTYPE html>
<html>

<head>
	<?php $this->load->view('include/header'); ?>
	<title>工作记录详情 / <?php echo $this->Setting_model->get('systemName'); ?></title>
</head>

<body>
<div id="wrapper">

<?php $this->load->view('include/navbar'); ?>

<!-- Page Content -->
<div id="page-wrapper">

<!-- Page Name-->
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">工作记录详情</h1>
	</div>
</div>
<!-- ./Page Name-->

<div style="text-align: center;">
	<div class="alert alert-success">
		为防止用户的手机流量损耗过多<br>欲查看工作图片请手动点开，谢谢！
	</div>
</div>

<div class="form-group">
	<label>工作人</label>
	<input class="form-control" value="<?=$info['name'];?>" disabled>
</div>

<div class="form-group">
	<label for="content" id="descTips">工作内容介绍</label>
	<textarea class="form-control" rows="8" readonly><?=$info['content'];?></textarea>
</div>

<label>工作照片(点击按钮查看)</label><br>
<?php foreach($info['photo_url'] as $key=>$photoUrl){ ?>
	<button class="btn btn-success" onclick='showPhoto("<?=$key+1;?>","<?=$photoUrl;?>");'><?=$key+1;?> <i class="fa fa-eye"></i></button>
<?php } ?>

<?php $this->load->view('include/footer'); ?>

<!-- ./Page Main Content -->
</div>
<!-- ./Page -->
</div>

<script>
function showPhoto(num,url){
	$("#photoTitle").html("工作照片（第"+num+"张）")
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
