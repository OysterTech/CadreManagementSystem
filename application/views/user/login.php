<?php 
/**
 * @name V-登录
 * @author Jerry Cheung <master@xshgzs.com>
 * @since 2018-02-20
 * @version 2018-11-24
 */
?>

<!DOCTYPE html>
<html>

<head>
	<?php $this->load->view('include/header'); ?>
	<title>登录 / <?=$this->Setting_model->get('systemName'); ?></title>
	<style>
	body{
		padding-top: 40px;
	}
	</style>
</head>

<body>
<div class="container">
	<div class="col-md-6 col-md-offset-3">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">欢迎登录<?=$this->Setting_model->get('systemName'); ?></h3>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label for="userName">用户名</label>
					<input class="form-control" placeholder="用户名 / UserName" id="userName" onkeyup='if(event.keyCode==13)$("#pwd").focus();'>
				</div>
				<br>
				<div class="form-group">
					<label for="pwd">密码</label> <a href="<?=base_url('user/forgetPwd'); ?>" target="_blank">（忘记密码 Forget Password）</a>
					<input class="form-control" placeholder="密码 / Password" id="pwd" type="password" onkeyup='if(event.keyCode==13)toLogin();'>
				</div>
				<div class="checkbox">
					<label for="Remember">
						<input type="checkbox" id="Remember">记住用户名
					</label>
				</div>
				<center>
					<button class="btn btn-success" style="width:98%" onclick='toLogin();'>登录 / Login &gt;</button>
				</center>
			</div>
		</div>
	</div>
</div>

<?php $this->load->view('include/footer'); ?>

<script>
var isAjaxing=0;

// 监听模态框关闭事件
$(function (){
	$('#tipsModal').on('hidden.bs.modal',function(){
		isAjaxing=0;
	});
});


window.onload=function(){  
	/********** ▼ 记住密码 ▼ **********/
	Remember=getCookie("<?=$this->sessPrefix;?>RmUN");
	
	if(Remember!=null){
		$("#userName").val(Remember);
		$("#pwd").focus();
		$("#Remember").attr("checked",true);
	}else{
		$("#userName").focus();
	}
	/********** ▲ 记住密码 ▲ **********/
}


function toLogin(){
	
	// 防止多次提交
	if(isAjaxing==1){
		return false;
	}

	isAjaxing=1;
	lockScreen();
	$("#userName").attr("disabled",true);
	$("#pwd").attr("disabled",true);
	userName=$("#userName").val();
	pwd=$("#pwd").val();

	/********** ▼ 记住密码 ▼ **********/
	Remember=$("input[type='checkbox']").is(':checked');
	if(Remember==true){
		setCookie("<?=$this->sessPrefix;?>RmUN",userName);
	}else{
		delCookie("<?=$this->sessPrefix;?>RmUN");
	}
	/********** ▲ 记住密码 ▲ **********/

	if(userName==""){
		showTipsModal("请输入用户名！");
		unlockScreen();
		$("#userName").removeAttr("disabled");
		$("#pwd").removeAttr("disabled");
		return false;
	}
	if(userName.length<4){
		showTipsModal("用户名长度有误！");
		unlockScreen();
		$("#userName").removeAttr("disabled");
		$("#pwd").removeAttr("disabled");
		return false;
	}
	if(pwd==""){
		showTipsModal("请输入密码！");
		unlockScreen();
		$("#userName").removeAttr("disabled");
		$("#pwd").removeAttr("disabled");
		return false;
	}
	if(pwd.length<6){
		showTipsModal("密码长度有误！");
		unlockScreen();
		$("#userName").removeAttr("disabled");
		$("#pwd").removeAttr("disabled");
		return false;  
	}

	$.ajax({
		url:"<?=base_url('user/toLogin');?>",
		type:"post",
		data:{<?=$this->ajax->showAjaxToken();?>,"userName":userName,"pwd":pwd},
		dataType:"json",
		error:function(e){
			console.log(e);
			unlockScreen();
			$("#userName").removeAttr("disabled");
			$("#pwd").removeAttr("disabled");
			$("#delModal").modal('hide');
			showTipsModal("服务器错误！<hr>请联系技术支持并提交以下错误码：<br><font color='blue'>"+e.status+"</font>");
			return false;
		},
		success:function(ret){
			unlockScreen();
			$("#userName").removeAttr("disabled");
			$("#pwd").removeAttr("disabled");

			if(ret.code==200){
				window.location.href="<?=base_url('/');?>"
			}else if(ret.message=="userForbidden"){
				showTipsModal("当前用户被禁用！<br>请联系管理员！");
				return false;
			}else if(ret.message=="invaildPwd"){
				showTipsModal("用户名或密码错误！");
				return false;
			}else if(ret.message=="userForbidden"){
				showTipsModal("用户被禁用！<br>请联系管理员！");
				return false;
			}else if(ret.message=="userNotActive"){
				showTipsModal("用户暂未激活！<br>请尽快进行激活！");
				return false;
			}else if(ret.message=="noRoleInfo"){
				showTipsModal("获取角色信息失败！请联系管理员！");
				return false;
			}else if(ret.code=="403"){
				showTipsModal("Token无效！<hr>Tips:请勿在提交前打开另一页面哦~");
				return false;
			}else{
				console.log(ret);
				showTipsModal("系统错误！<hr>请联系技术支持并提交以下错误码：<br><font color='blue'>"+ret.code+"</font>");
				return false;
			}
		}  
	});
}
</script>

<div class="modal fade" id="tipsModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
        <h3 class="modal-title" id="ModalTitle">温馨提示</h3>
      </div>
      <div class="modal-body">
        <form method="post">
          <font color="red" style="font-weight:bolder;font-size:24px;text-align:center;">
            <p id="tips"></p>
          </font>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" onclick='isAjaxing=0;$("#tipsModal").modal("hide");'>返回 &gt;</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

</body>
</html>
