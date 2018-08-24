<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
use think\Response;


/**
 * 获取\think\response\Json对象实例
 * @param mixed   $data 返回的数据
 * @param integer $code 状态码
 * @param array   $header 头部
 * @param array   $options 参数
 * @return \think\response\Json
 */
function json($data = [], $code = 200, $header = [], $options = [])
{
    if ( empty($options) ) {
        $options = [
            'json_encode_param' => JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES
        ];
    }
    return Response::create($data, 'json', $code, $header, $options);
}


/**
 * @param string $url
 * @param string $method
 * @param string $resType
 * @param array $data
 * @param array $param
 * @return mixed
 * @version v1.2.0
 */
function httpCurl( $url='', $method='get', $resType='arr', $data=[] , $param=[]) {
    $urlarr = parse_url($url);
    $host = $urlarr['host'];
    $ch = curl_init();

    if ( $method == 'get' && (!empty($data)) ) {
        ksort($data,SORT_STRING);
        $data = http_build_query($data);
        if ( false === strpos($url,'?') ) {
            $url .= '?' . $data;
        } else {
            $url .= '&' . $data;
        }
    }

    //设置url和返回
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false); //HTTPS支持

    // 设置证书
    if ( isset($param['key']) ) {
        $key_path = $param['key'];
        //默认格式为PEM，可以注释
        curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
        curl_setopt($ch,CURLOPT_SSLCERT,$key_path.'/apiclient_cert.pem');
        //默认格式为PEM，可以注释
        curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
        curl_setopt($ch,CURLOPT_SSLKEY,$key_path.'/apiclient_key.pem');

        curl_setopt($ch,CURLOPT_CAINFO,'PEM');
        curl_setopt($ch,CURLOPT_CAINFO,$key_path.'/rootca.pem');
    }


    // 设置header需要发送的参数
    $header = array(
        "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8",
        "Accept-Encoding: ",
        "Accept-Language: zh-CN,zh;q=0.8,zh-TW;q=0.7,zh-HK;q=0.5,en-US;q=0.3,en;q=0.2",
        "Cache-Control: no-cache",
        "Connection: keep-alive",
        "Host: ".$host,
        "Pragma: no-cache",
        "Upgrade-Insecure-Requests: 1",
        "User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:57.0) Gecko/20100101 Firefox/57.0",
    );
    // 设置header
    if ( isset($param['header']) ) {
        foreach ($param['header'] as $key => $hd) {
            array_push($header,$hd);
        }
    }
    curl_setopt($ch, CURLOPT_HTTPHEADER  , $header);               // 加入header

    $cookie = isset($param['cookie']) ? $param['cookie'] : '';
    //设置cookie
    curl_setopt($ch,CURLOPT_COOKIE,$cookie);
    $cookie_dir = CACHE_PATH;

    $cookie_file = $cookie_dir.$host.'.txt';
    if ( !file_exists($cookie_file) ) {
        if ( !file_exists($cookie_dir) ) {
            mkdir($cookie_dir,0777,true);
        }
        $fp = fopen($cookie_file,'wb');
        fclose($fp);
        chmod($cookie_file,0777);
    }
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);

    if ( $method == 'post' ) {
        //开启post
        curl_setopt($ch,CURLOPT_POST,1);
        //设置post数据
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
    }
    $str = curl_exec($ch);
    $info = curl_getinfo($ch);
    curl_close($ch);

    if ( $resType == 'arr' ) {
        return json_decode($str,true);
    } else {
        return $str;
    }
}

/*微信使用*/
function arrayToXml($arr,$root=true)
{
    // 只处理array的直接下一级
    $str = '';
    $root && $str.='<xml>';
    if ( !is_array($arr) ) {
        return fasle;
    }
    if ( array_key_exists(0,$arr) ) { //没有key=>  'a','b','c'    或者   { },{ },{ }
        // 没有key
        foreach ($arr as $val) { // 外面已经有包裹的标签了
            $str.= '<item>';
            if ( is_array($val) ) {  // 数组
                $str.= arrayToXml($val,false);
            } else {
                if ( is_numeric($val) ) {
                    $str.= $val;  // 数字
                } else {
                    $str.= '<![CDATA['.$val.']]>';  // 字符串
                }
            }
            $str.= '</item>';
        }
    } else {
        // 有key
        foreach ($arr as $key => $val) {
            $str.= '<'.$key.'>';
            if ( is_array($val) ) {
                $str.= arrayToXml($val,false);
            } else {
                if ( is_numeric($val) ) {
                    $str.= $val;  // 数字
                } else {
                    $str.= '<![CDATA['.$val.']]>';  // 字符串
                }
            }
            $str.= '</'.$key.'>';
        }
    }
    $root && $str.='</xml>';
    return $str;
}



/**
 * xml转化为数组
 * @param  Obj $simpleXmlElement    xml对象
 * @return Array
 */
function xmlToArray($simpleXmlElement){
    $simpleXmlElement=(array)$simpleXmlElement;
    foreach($simpleXmlElement as $k=>$v){
        if($v instanceof SimpleXMLElement ||is_array($v)){
            $simpleXmlElement[$k]=xmlToArray($v);
        }
    }
    return $simpleXmlElement;
}

/**
 * 生成随机字字符串nonceStr
 * @param  integer $len [description]
 * @return [type]       [description]
 */
function getRandStr($len=16)
{
    $arr = [];
    for ($i=48; $i <= 57; $i++) {
        $arr[] = chr($i);
    }
    for ($i=65; $i <= 90; $i++) {
        $arr[] = chr($i);
    }
    for ($i=97; $i <= 122; $i++) {
        $arr[] = chr($i);
    }
    $str = implode('',$arr);

    $res = '';
    for ($i=0; $i < $len; $i++) {
        $res .= $str[rand(0,strlen($str)-1)];
    }
    return $res;
}


function table($name='')
{
    return C('database.prefix').$name;
}

/**
 * 根据表名获取表自增id
 * @param  string $table 表名
 * @return [type]        [description]
 */
function getAutoIncrement($table='',$treeTableName=false)
{
    if ( $treeTableName == false ) {
        $table = table($table);
    }
    $sql = 'SELECT AUTO_INCREMENT as at FROM information_schema.tables WHERE table_schema = (select database()) and table_name="'.$table.'"';
    $res = db($table)->query($sql);
    if ( $res ) {
        return $res[0]['at'];
    }
    return null;
}
/**
 * 根据表名获取表的行标识号, 如订单号,运单号等
 * @param  string $table [description]
 * @return [type]        [description]
 */
function getTableUid($table='',$prefix='WX',$randnum=2)
{
    if ( is_array($table) ) {
        $id = getAutoIncrement($table[0],$table[1]);
    } else {
        $id = getAutoIncrement($table);
    }

    $incrId = $id*8+mt_rand(0,7);
    $incrId = sprintf('%05d',$incrId);
    $date = date('Ymd');
    $rand = mt_rand(pow(10,$randnum), 9*pow(10,$randnum));
    return $prefix . $date .  $incrId . $rand;
}