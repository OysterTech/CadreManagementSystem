<?php 
/**
 * @name V-我的工作记录列表
 * @author Jerry Cheung <master@xshgzs.com>
 * @since 2018-11-02
 * @version 2018-11-02
 */ 
?>

<!DOCTYPE html>
<html>

<head>
  <?php $this->load->view('include/header'); ?>
  <title>我的工作记录 / <?php echo $this->Setting_model->get('systemName'); ?></title>
</head>

<body>
<div id="wrapper">

<?php $this->load->view('include/navbar'); ?>

<!-- Page Content -->
<div id="page-wrapper">

<!-- Page Name-->
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">我的工作列表</h1>
	</div>
</div>
<!-- ./Page Name-->

<table id="table" class="table table-striped table-bordered table-hover" style="border-radius: 5px; border-collapse: separate;">
	<thead>
		<tr>
			<th>工作内容</th>
			<th>工作时间</th>
			<th>操作</th>
		</tr>
	</thead>
	
	<tbody>
	<?php foreach($list as $info){ ?>
		<tr>
			<td><?php if(strlen($info['content'])>30){echo substr($info['content'],0,30)."...";}else{echo $info['content'];} ?></td>
			<td><?=$info['create_time'];?></td>
			<td><a href="<?=base_url('workLog/detail/').$info['id'];?>" class="btn btn-info">详细</a></td>
		</tr>
	<?php } ?>
</tbody>
</table>

<?php $this->load->view('include/footer'); ?>

<!-- ./Page Main Content -->
</div>
<!-- ./Page -->
</div>

<script>
window.onload=function(){
	$('#table').DataTable({
		responsive: true,
		"order":[[1,'desc']],
		"columnDefs":[{
			"targets":[2],
			"orderable": false
		}]
	});
};
</script>

</body>
</html>
