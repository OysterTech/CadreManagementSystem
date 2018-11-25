<?php
/**
* @name 邮件配置
* @author Jerry Cheung <master@xshgzs.com>
* @since 2018-03-04
* @version 2018-11-25
*/

defined('BASEPATH') OR exit('No direct script access allowed');

//$config['smtp_host'] = 'ssl://smtp.qq.com';// QQ个人邮箱
$config['smtp_host'] = 'ssl://smtp.qiye.aliyun.com';// 阿里企业邮箱
$config['smtp_user'] = '';
$config['smtp_pass'] = '';// QQ邮箱请输入授权码

/* !!!!!!!!!! 下方配置无需修改 !!!!!!!!!! */
$config['protocol'] = 'smtp';
$config['charset'] = 'utf-8';
$config['wordwrap'] = TRUE;
$config['smtp_port'] = 465;
$config['smtp_timeout'] = '5';
$config['mailtype'] = 'html';
$config['crlf']="\r\n";
$config['newline']="\r\n";
/* !!!!!!!!!! 上方配置无需修改 !!!!!!!!!!! */
