<?php
function getGreeting(){
	$nowHour=date("H");
	if($nowHour>=0 && $nowHour<6) $ret="凌晨好！";
	elseif($nowHour>=6 && $nowHour<10) $ret="早安！";
	elseif($nowHour>=10 && $nowHour<12) $ret="上午好！";
	elseif($nowHour>=12 && $nowHour<15) $ret="中午好！";
	elseif($nowHour>=15 && $nowHour<17) $ret="下午好！";
	elseif($nowHour>=17 && $nowHour<20) $ret="傍晚好！";
	elseif($nowHour>=20 && $nowHour<24) $ret="晚上好！";

	return $ret;
}

$navData=$this->allMenu;
$allNotice=$this->Notice_model->get(0,"nav");
?>

<!-- Navigation -->
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="<?php echo base_url(); ?>"><?php echo $this->Setting_model->get('systemName'); ?></a>
	</div>
	<!-- dropdown-head-right -->
	<ul class="nav navbar-top-links navbar-right">
		<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="fa fa-envelope fa-fw"></i> <i class="fa fa-caret-down"></i>
			</a>
			<ul class="dropdown-menu dropdown-messages">
				<?php if(count($allNotice)!=0){ ?>
				<?php foreach($allNotice as $info){ ?>
				<li>
					<a href="<?php echo base_url('notice/detail/').$info['id']; ?>" target="_blank">
						<div>
							<b><font color="#FF9800"><?php echo $info['create_user']; ?></font></b>
							<span class="pull-right text-muted">
								<em><?php echo $info['create_time']; ?></em>
							</span>
						</div>
						<div><?php echo $info['title']; ?></div>
					</a>
				</li>
				<li class="divider"></li>
				<?php } ?>
				<?php }else{ ?>
				<li>
					<p class="text-center" style="color:red;font-weight:bold;">7天内暂无新公告</p>
				</li>
				<li class="divider"></li>
				<?php } ?>
				<li>
					<a class="text-center" href="<?php echo base_url('notice/list'); ?>">
						<b>阅 读 所 有 公 告</b>
						<i class="fa fa-angle-right"></i>
					</a>
				</li>
			</ul>
		</li>
		<!-- /.dropdown-messages -->
		
		<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="fa fa-user fa-lg"></i>
				<i class="fa fa-caret-down"></i>
			</a>
			<ul class="dropdown-menu">
				<li>
					<a href="javascript:void(0)"><b><font color="green"><?php echo $this->session->userdata($this->sessPrefix.'nickName'); ?></font></b>，<?php echo getGreeting(); ?></a>
				</li>
				<li>
					<a href="javascript:void(0)">角色：<b><font color="#F57C00"><?php echo $this->session->userdata($this->sessPrefix.'roleName'); ?></font></b></a>
				</li>
				<li class="divider"></li>
				<li>
					<a href="<?php echo base_url('user/updateProfile'); ?>">
						<i class="fa fa-user fa-fw"></i>修改个人资料</a>
				</li>
				<li>
					<a href="<?php echo base_url('user/logout'); ?>">
						<i class="fa fa-sign-out fa-fw"></i>登出系统</a>
				</li>
			</ul>
		</li>
		<!-- /.dropdown-user -->
	</ul>
	<!-- /.dropdown-head-right -->

	<!-- navbar-main -->
	<div class="navbar-default sidebar" role="navigation">
		<div class="sidebar-nav navbar-collapse">
			<ul class="nav" id="side-menu">
				<li>
					<a href="<?php echo base_url(); ?>">
						<i class="fa fa-home"></i> 主页面</a>
				</li>
				
				<?php
				// 显示父菜单
				foreach($navData as $info){
					if($info['hasChild']!="1"){
					// 没有二级菜单
				?>
					<li>
						<a href="<?php echo base_url($info['uri']); ?>">
							<i class="fa fa-<?php echo $info['icon']; ?>" aria-hidden="true"></i>
							<?php echo $info['name']; ?>
						</a>
					</li>
					<!-- ./父菜单 -->
				<?php
					}else{
					// 有二级菜单
				?>
					<li>
						<a href="#">
							<i class="fa fa-<?php echo $info['icon']; ?>" aria-hidden="true"></i>
							<?php echo $info['name']; ?>
							<span class="fa arrow"></span>
						</a>
						<ul class="nav nav-second-level">
						<?php 
						// 显示二级菜单
						foreach($info['child'] as $child_info){
							if($child_info['hasChild']!="1"){
							// 没有三级菜单
						?>
							<li>
								<a href="<?php echo base_url($child_info['uri']); ?>">
									<i class="fa fa-<?php echo $child_info['icon']; ?>" aria-hidden="true"></i>
									<?php echo $child_info['name']; ?>
								</a>
							</li>
							<!-- ./二级菜单 -->
						<?php
							}else{
							// 有三级菜单
						?>
							<li>
								<a href="#">
									<i class="fa fa-<?php echo $child_info['icon']; ?>" aria-hidden="true"></i>
									<?php echo $child_info['name']; ?>
									<span class="fa arrow"></span>
								</a>
								<ul class="nav nav-third-level">
									<?php
									// 显示三级菜单
									foreach($child_info['child'] as $child2_info){
									?>
									<li>
										<a href="<?php echo base_url($child2_info['uri']); ?>">
											<i class="fa fa-<?php echo $child2_info['icon']; ?>" aria-hidden="true"></i>
											<?php echo $child2_info[ 'name']; ?>
										</a>
									</li>
									<!-- ./三级菜单 -->
									<?php } ?>
								</ul>
							</li>
							<!-- ./二级菜单 -->
						<?php } } ?>
					</ul>
				</li>
				<!-- ./父菜单 -->
				<?php } } ?>
			</ul>
		</div>
	</div>
	<!-- /.navbar-main -->
</nav>