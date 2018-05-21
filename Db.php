<?php
//mssqls数据库连接
//作者:明天见 微信wapele
class Db{
    private $conn=null;
    private $config=[
        "host"=>"61.153.61.242",
        "info"=>["UID"=>"sa","PWD"=>"850813Ccy","Database"=>"ACCOUNT"]
        
    ];
    function __construct($config=[]) {
        if ($this->config){
            $this->config=array_merge($this->config,$config);
        }
        $this->conn = sqlsrv_connect($this->config["host"],$this->config["info"]);
        if (!$this->conn){$this->error();}
    }
    function execute($sql="",$pre=[]){
        $sql= sqlsrv_prepare($this->conn, $sql, $pre);
        if (!$sql){$this->error();}
        if (sqlsrv_execute($sql)){return 1;}
        else{ $this->error(); }

        
    }
    
    function query($sql){
        $result = sqlsrv_query($this->conn, $sql);
    }
    function getRow($sql){
        $result = sqlsrv_query($this->conn, $sql);
        return sqlsrv_fetch_array($result);
        $arr = array();
        while($row = sqlsrv_fetch_array($result))
        {
            $arr[] = $row;
        }
        return $arr[0];
    }
    function getAll($sql){
        $result = sqlsrv_query($this->conn, $sql);
        $arr = array();
        while($row = sqlsrv_fetch_array($result))
        {
            $arr[] = $row;
        }
        return $arr;
    }
    function error(){
        $error=sqlsrv_errors();
        if ($error){
            $msg=iconv("gbk", "utf-8//ignore", @$error[0]["message"]);
            die($msg);
        }
    }
    function close(){
        sqlsrv_close($this->conn); 
    }
    function __destruct() {
        unset($this->conn);
    }
}