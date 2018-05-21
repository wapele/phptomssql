<?php
//作者:明天见 微信wapele
error_reporting(0); 
ini_set('date.timezone','Asia/Shanghai');
include "common.php";
include "config.php";
include "Db.php";
$time=date("Y-m-d H:i:s");
$db=new Db();
if (@$_POST["type"]=='name'){
  $id=htmlspecialchars($_POST["id"]);
  $res=$db->getRow("select FLD_LOGINID from TBL_ACCOUNT where FLD_LOGINID='{$id}'");
  if (!$res){json(["code"=>0,"msg"=>"账号不存在"]);}
  json(["code"=>1,"msg"=>"通过"]);
}
$id=htmlspecialchars(@$_POST["id"]);
$money=(float) @$_POST["money"];
if ($id && $money){
  $res=$db->getRow("select FLD_LOGINID from TBL_ACCOUNT where FLD_LOGINID='{$id}'");
  if (!$res){json(["code"=>0,"msg"=>"账号不存在"]);}
  $sql="insert into TBL_ORDER (FLD_ORDER,FLD_USERID,FLD_MONEY,FLD_MAKETIME,FLD_STATUS)values(?,?,?,?,?)";
  $order=create_sn();
  $result=$db->execute($sql,[$order,$id,$money,$time,"0"]);
  if (!$result){json(["code"=>0,"msg"=>"无法写入数据库！"]);}
  $data=[
      "mchid"=>MCHID,
      "trade_sn"=>$order,
      "money"=>$money,
      "payChannel"=>is_weixin() ? "WEIXIN":"ALIPAY",
      "redirect"=>1,
      "notifyurl"=>NOTIFYURL,
      "returnurl"=>"http://www.baidu.com",
      
  ];
  $data["sign"]=signMd5($data,KEY,1);
  echo get_code($data,PAYURL);
  die;
}else{
  json(["code"=>0,"msg"=>"各参数不能为空！"]);
}
