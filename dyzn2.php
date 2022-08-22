<?php
// 欢迎关注抖音

// 9- 长按复制此条消息，打开抖音搜索，查看TA的更多作品。 https://v.douyin.com/jxEn81T/

$appId = '1'; //对应自己的appId
$appSecret = '1'; //对应自己的appSecret
$wxgzhurl = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appId . "&secret=" . $appSecret;
$access_token_Arr = https_request($wxgzhurl);
$access_token = json_decode($access_token_Arr, true);
$ACCESS_TOKEN = $access_token['access_token']; //ACCESS_TOKEN


// 什么时候恋爱的(格式别错)
$lovestart = strtotime('2022-08-01');
$end = time();
$love = ceil(($end - $lovestart) / 86400);

// 下一个生日是哪一天(格式别错)
$birthdaystart = strtotime('2023-01-25');
$end = time();
$diff_days = ($birthdaystart - $end);
$birthday = (int)($diff_days / 86400);
$birthday = str_replace("-", "", $birthday);


$tianqiurl = 'https://www.yiketianqi.com/free/day?appid=95943915&appsecret=5KNSKu9y&unescape=1&city=武汉'; //修改为自己的
$tianqiapi = https_request($tianqiurl);
$tianqi = json_decode($tianqiapi, true);

$qinghuaqiurl = 'https://v2.alapi.cn/api/qinghua?token=BFlSa9Ny7qTZHwYk'; //修改为自己的
$qinghuaapi = https_request($qinghuaqiurl);
$qinghua = json_decode($qinghuaapi, true);


// 你自己的一句话
$yjh = ''; //可以留空 也可以写上一句
$touser = [
    'oaJGs6RJR62trjg89dEFWdH_bY4E',
    'oaJGs6YY3GZX6Y95ZX8Q7wAUr6mk',
    'oaJGs6YY3GZX6Y95ZX8Q7wAUr6mk'
]; //你的多个女朋友的微信号或者openid

// 多个女朋友发送
foreach ($touser as $key => $value) {
    $template = array(
        'touser' => $value,
        'template_id' => 'zyz7Obpa6FTNi1lBaT8wZX7gfhDw6MZaGie3SLbz1gA', //模板id
        'url' => '', //跳转链接
        'data' => array(
            'first' => array(
                'value' => $yjh,
                'color' => "#000"
            ),
            'keyword1' => array(
                'value' => $tianqi['wea'],
                'color' => "#000"
            ),
            'keyword2' => array(
                'value' => $tianqi['tem_day'],
                'color' => "#000"
            ),
            'keyword3' => array(
                'value' => $love . '天',
                'color' => "#000"
            ),
            'keyword4' => array(
                'value' => $birthday . '天',
                'color' => "#000"
            ),
            'remark' => array(
                'value' => $qinghua['data']['content'],
                'color' => "#f00"
            ),
        )
    );
    $template = json_encode($template);
    $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=' . $ACCESS_TOKEN;
    $res = https_request($url, $template);
    $res = json_decode($res, true);
    if ($res['errcode'] == 0) {
        echo '发送成功';
    } else {
        echo '发送失败';
    }
}

function https_request($url, $data = null)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    if (!empty($data)) {
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);
    return $output;
}
