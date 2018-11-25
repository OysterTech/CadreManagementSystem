<?php 
/**
 * @name V-主页
 * @author Jerry Cheung <master@xshgzs.com>
 * @since 2018-02-06
 * @version 2018-11-18
 */ 
?>
<!DOCTYPE html>
<html>

<head>
  <?php $this->load->view('include/header'); ?>
  <title><?=$this->Setting_model->get('systemName'); ?></title>
</head>

<body>
<div id="wrapper">

<?php $this->load->view('include/navbar'); ?>

<!-- Page Main Content -->
<div id="page-wrapper">
<div class="row">
  <div class="col-lg-12">
    <h1 class="page-header">系统首页</h1>
  </div>
  <!-- /.col-lg-12 -->
</div>
<!-- /.row -->

<div style="font-size:18px;">
	欢迎登录<?=$this->Setting_model->get('systemName'); ?>！<br><br>
	如有任何疑问，可<b>点击页面底部的图标</b>联系管理员！<!--(微信请加<b>个人号zjhit0409，备注“YC+系统用户名”</b>)-->
</div>

<hr>

<!--div class="row">
  <div class="col-lg-3 col-md-6">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <div class="row">
          <div class="col-xs-3">
            <i class="fa fa-comments fa-5x"></i>
          </div>
          <div class="col-xs-9 text-right">
            <div class="huge">26</div>
            <div>New Comments!</div>
          </div>
        </div>
      </div>
      <a href="#">
        <div class="panel-footer">
          <span class="pull-left">View Details</span>
          <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
          <div class="clearfix"></div>
        </div>
      </a>
    </div>
  </div>
</div-->

<!-- ▼ 通知栏 ▼ -->
<ul class="list-group">
	<?php if($allNotice!=[]){ ?>
	<?php foreach($allNotice as $info){ ?>
	<li class="list-group-item">
		<div class="row">
			<div class="col-xs-8">
				<a href="<?php echo base_url('notice/detail/').$info['id']; ?>" target="_blank">
					<i class="fa fa-bullhorn"></i> <?=$info['title'];?>
				</a>
			</div>
		
			<div class="col-xs-4" style="text-align:right;">
				<?=substr($info['create_time'],0,10);?>
		</div>		
		</div>
	</li>
	<?php } ?>
	<?php }else{ ?>
	<li class="list-group-item">
		<i class="fa fa-envelope-open"></i>	暂无最新公告！
	</li>
	<?php } ?>
</ul>
<!-- ▲ 通知栏 ▲ -->

<?php $this->load->view('include/footer'); ?>

<!-- ./Page Main Content -->
</div>
<!-- ./Page -->
</div>
</body>
</html>
