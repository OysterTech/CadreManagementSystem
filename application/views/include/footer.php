<hr>

<center>
	<p style="font-weight:bold;font-size:18px;line-height:26px;">
		&copy; <a href="https://www.xshgzs.com?from=ycCdms" target="_blank">生蚝科技</a>(高二8 张镜濠) 提供技术支持<br>
		All Rights Reserved.<br>
	
		<a style="color:#64DD17" onclick='$("#adminWxModal").modal("show");'><i class="fa fa-weixin fa-lg" aria-hidden="true"></i></a>
		<a style="color:#FF7043" onclick='launchQQ()'><i class="fa fa-qq fa-lg" aria-hidden="true"></i></a>
		<a style="color:#29B6F6" href="mailto:master@xshgzs.com"><i class="fa fa-envelope fa-lg" aria-hidden="true"></i></a>
		<a style="color:#AB47BC" href="https://github.com/OysterTech" target="_blank"><i class="fa fa-github fa-lg" aria-hidden="true"></i></a>
		<a href="http://www.miitbeian.gov.cn/" target="_blank" style="color:black;">粤ICP备18045107号-2</a><br>
	</p>
</center>

<p style="line-height:6px;">&nbsp;</p>

<script>
function launchQQ(){		
	if(/Android|webOS|iPhone|iPod|BlackBerry/i.test(navigator.userAgent)){
		window.location.href="mqqwpa://im/chat?chat_type=wpa&uin=571339406";
	}else{
		window.open("http://wpa.qq.com/msgrd?v=3&uin=571339406");
	}
}
</script>

<!-- JS -->
<script src="https://cdn.bootcss.com/jquery/3.1.0/jquery.min.js"></script>
<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdn.bootcss.com/metisMenu/1.1.3/metisMenu.min.js"></script>
<script src="https://cdn.bootcss.com/raphael/2.2.7/raphael.min.js"></script>
<script src="https://cdn.bootcss.com/morris.js/0.5.0/morris.min.js"></script>
<script src="https://cdn.bootcss.com/startbootstrap-sb-admin-2/3.3.7+1/js/sb-admin-2.min.js"></script>
<script src="https://cdn.bootcss.com/datatables/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.bootcss.com/datatables/1.10.16/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.bootcss.com/zTree.v3/3.5.28/js/jquery.ztree.core.min.js"></script>
<script src="https://cdn.bootcss.com/zTree.v3/3.5.28/js/jquery.ztree.excheck.min.js"></script>
<script src="https://cdn.bootcss.com/zTree.v3/3.5.28/js/jquery.ztree.exedit.min.js"></script>
<script src="https://cdn.bootcss.com/wangEditor/10.0.13/wangEditor.min.js"></script>
<script src="<?=base_url('resource/js/dataTables.responsive.js'); ?>"></script>
<script src="<?=base_url('resource/js/utils.js'); ?>"></script>
<!-- ./JS -->

<!-- 百度统计 -->
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "https://hm.baidu.com/hm.js?51648db7eb596a2b38fee2b8dfe1b2c2";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>
<!-- ./百度统计 -->

<div class="modal fade" id="adminWxModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
				<h3 class="modal-title">微信联系技术支持</h3>
			</div>
			<div class="modal-body">
				<img src="<?=base_url('resource/images/wxCode.png');?>" style="width:100%;">
				<font color="blue" style="font-weight:bold;font-size:22px;text-align:left;">
					扫码添加技术支持个人微信，或搜索微信号“zjhit0409”<br>
					★ 添加时，请备注：<font color="green">YC+登录用户名</font>。
				</font>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">关闭 &gt;</button>
			</div>
		</div>
	</div>
</div>
