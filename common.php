<?php
function get_code($data, $gateway_url) {
    $str = '<form name="myform" action="' . $gateway_url . '" method="POST">';
    $prepare_data = $data;
    foreach ($prepare_data as $key => $value) $str .= '<input type="hidden" name="' . $key . '" value="' . $value . '" />';
    $str .= '</form>';
    $str .= '<script language="javascript">document.myform.submit();</script>';
    return $str;
}
function is_weixin() { 
    if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) { 
        return true; 
    } return false; 
}
function json($data=[]){
    header('Content-type:text/json');
    die(json_encode($data,JSON_UNESCAPED_UNICODE));
}
/*  $data 数据
        $key 密匙
        $lower 小写 1  0大写
        return md5
*/
function signMd5($data,$key,$lower=0){
    if (!is_array($data)){return false;}
    if (isset($data["sign"])){
        unset($data["sign"]);//剥离签名
    }
    if (isset($data["key"])){
        unset($data["key"]);//剥离密匙
    }
    ksort($data);
    //trace('[ ORDER ] ' . '通知签名' .var_export($data,true), 'error');
    //trace('[ ORDER ] ' . '密匙' .$key, 'error'); 
    $data["key"]=$key;
    $sign=http_build_query($data);
    $sign=urldecode($sign);//不被编码
      $sign=htmlspecialchars_decode($sign, ENT_NOQUOTES); // 把url $amp; 转换回来
    $sign=$lower ? md5($sign):strtoupper(md5($sign));
    return $sign;
    
}
/**
 * 生成流水号
 */
function create_sn(){
	mt_srand((double)microtime() * 1000000);
	return date('YmdHis').str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT).mt_rand(1, 99999);
}
   /**
     * Curl::getdata()
     * 
     * @param mixed $url
     * @param string $data
     * @param string $type
     * @param integer $second
     * @return
     */
function getdata($url,$data=[],$second = 60){
        $ch = curl_init();
		//设置超时
		curl_setopt($ch, CURLOPT_TIMEOUT, $second);
        curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);//严格校验
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0); //强制协议为1.0
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("'Expect: '")); //头部要送出'Expect: '
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 ); //强制使用IPV4协议解析域名
        //设置header
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //要求结果为字符串且输出到屏幕上
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        if ($data){
            //post提交方式
    		curl_setopt($ch, CURLOPT_POST, TRUE);
    		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        //运行curl
		$result = curl_exec($ch);
		//返回结果
		$responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		if($responseCode == 200){
			curl_close($ch);
            //trace("[ api ] " . "返回结果：".var_export($result,true), 'pay');
			return $result;
		} else { 
			$error = curl_errno($ch);
			curl_close($ch);
            //trace("[ api ] " . "curl出错{$url},错误码:$error,错误日志:{$responseCode}", 'error');
            return false;
		}
}
