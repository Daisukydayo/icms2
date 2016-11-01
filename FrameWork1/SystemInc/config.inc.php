<?php

/**
 * 系统名称
 */
$incSystemName = 'iCMS';

/**
 * 系统数据库配置
 */
$incDatabaseInfo = array();
$incDatabaseInfo[] = 'host';
$incDatabaseInfo[] = 3306;
$incDatabaseInfo[] = 'dbname';
$incDatabaseInfo[] = 'username';
$incDatabaseInfo[] = 'pass';
$incDatabaseInfo[] = '0'; //debug
$incDatabaseInfo = implode('|',$incDatabaseInfo);

/**
 * 系统语言
 */
$incLanguage = "language/zh";

/**
 * 系统域名
 */
$incDomain = array();
$incDomain['webapp'] = 'http://localhost';
$incDomain['manage'] = 'http://localhost';

/**
 * 是否开启管理日志
 */
$incOpenManageUserLog = true;

/**
 * 安全ip设置
 */
$incSecurityIP = array('130.1.0','20.20.20','40.40.40','130.0.152','113.240.237','222.240.248.34');  //'222.240.183.54','222.240.128.2', --wanbao？
$incSecurityIP = implode('|',$incSecurityIP);

$incMemcachedServers = array(
    array('130.1.0.168',11211)
);
?>
