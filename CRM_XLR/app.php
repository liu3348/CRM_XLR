<?php
/** 抓取百度关键词排名
 * User: wanghui
 * Date: 16/10/25
 * Time: 下午6:10
 */
header('Content-type: text/html;charset=utf-8');
/**
 * @param $string 关键词
 * @param $url 网址
 */
function matchKeyword($keyword = "", $url = "") {
    // 排名 0表示未匹配到
    $sort = 0;
    $urlString = urlencode($keyword);// 防止存在特殊字符,对url进行编码
//    echo $urlString;
    // 百度请求地址拼接
    $bdUrl = "https://www.baidu.com/s?wd=".$urlString;
//    echo $bdUrl;
    $content = getByCurl($bdUrl);
    preg_match_all("/]*?class=\"result\s*c-container[\s\S]*?<span\s*class=\"c-pingjia\">/", $content, $result);
//    var_dump($result);
    foreach($result[0] as $value){
        preg_match("/class=\"c-showurl\"\s*style=\"text-decoration:none;\">\S*\&nbsp;/", $value, $valUrl);
        $sort ++;
        // 想要查找链接是否是查到的链接的子链接
        if(strstr($value, $url)){
            return $sort;
//            var_dump($valUrl);
        }

    }
    return $sort;
}

// 抓取百度网页搜索结果
function  getByCurl($url) {
//    百度验证了user-agent 不声明就抓取不到数据
    $opts = array(
        'http'=>array(
            'user_agent' => $_SERVER['HTTP_USER_AGENT']
        )
    );

    $context = stream_context_create($opts);

    $info=file_get_contents($url, false, $context);
    return $info;

}

echo "string";

// 接收参数并调用方法
$sort = matchKeyword($_GET['keyword'], $_GET['url']);
echo  $sort;