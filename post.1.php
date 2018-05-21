<?php
ini_set('date.timezone','Asia/Shanghai');
include "Db.php";
include "common.php";
$db=new Db();
if (@$_POST["type"]=='name'){
  $name=htmlspecialchars($_POST["id"]);
  $res=$db->getRow("select FLD_LOGINID from TBL_ACCOUNT where FLD_LOGINID='{$name}'");
  if (!$res){json(["code"=>0,"msg"=>"账号不存在"]);}
  json(["code"=>1,"msg"=>"通过"]);
}
$id=htmlspecialchars(@$_POST["id"]);
$money=(float) @$_POST["money"];
if ($id && $money){
  $res=$db->getRow("select FLD_LOGINID from TBL_ACCOUNT where FLD_LOGINID='{$name}'");
  if (!$res){json(["code"=>0,"msg"=>"账号不存在"]);}
  die;
}else{
  json(["code"=>0,"msg"=>"各参数不能为空！"]);
}
$data=[
    "FLD_ORDER"=>time(),
    "FLD_USERID"=>"test",
    "FLD_MONEY"=>1,
    "FLD_MAKETIME"=>time(),
    "FLD_STATUS"=>0
];
$order=time();
$time=date("Y-m-d H:i:s");
//更新数据
$sql="UPDATE TBL_ORDER  SET FLD_STATUS = ?,FLD_PAYTIME=? WHERE FLD_ORDER = ?";
var_dump($db->execute($sql,["1",$time,"1526811980"]));die;
$sql="insert into TBL_ORDER (FLD_ORDER,FLD_USERID,FLD_MONEY,FLD_MAKETIME,FLD_STATUS)values(?,?,?,?,?)";
var_dump($db->execute($sql,[$order,"test","0.01",$time,"0"]));die;
var_dump($db->getRow("select * from TBL_ACCOUNT"));
die;
//header("Content-type: text/html; charset=utf-8");
//本地测试的服务名 
$serverName="61.153.61.242";
//使用sql server身份验证，参数使用数组的形式，一次是用户名，密码，数据库名
//如果你使用的是windows身份验证，那么可以去掉用户名和密码
$connectionInfo = array( "UID"=>"sa","PWD"=>"850813Ccy","Database"=>"ACCOUNT");
$conn = sqlsrv_connect( $serverName, $connectionInfo);
if(!$conn)
{
 $error=sqlsrv_errors();
 //die("无法链接数据库".@$error[0]["message"]);
 die( print_r( sqlsrv_errors(), true));
}
/*查询 */
$val=sqlsrv_query($conn,"select * from TBL_ACCOUNT");
while($row=sqlsrv_fetch_array($val)){
  echo $row[1]."<br />";
}
/**插入 */

//sqlsrv_close($conn); 