<?php
//作者:明天见 微信wapele
error_reporting(0); 
ini_set('date.timezone','Asia/Shanghai');
include "common.php";
include "config.php";
include "Db.php";
$time=date("Y-m-d H:i:s");
$db=new Db();
if ($_SERVER['REQUEST_METHOD']!="POST" && !$_POST){exit("错误请求");}
//if ($_POST["sign"]!=signMd5($_POST,KEY,1)){die("签名不正确");}
$res=$db->getRow("select FLD_MONEY from TBL_ORDER where FLD_ORDER='{$_POST["trade_sn"]}'");
if (!$res){exit("订单不存在");}
if ($res["FLD_MONEY"]!=$_POST["totalmoney"]){die("订单金额不正确");}
$sql="UPDATE TBL_ORDER  SET FLD_STATUS = ?,FLD_PAYTIME=? WHERE FLD_ORDER = ?";
$res=$db->execute($sql,["1",$time,$_POST["trade_sn"]]);
if ($res){die("success");}
echo "error";