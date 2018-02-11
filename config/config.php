<?php

return [
    'appid' => 'your AppID',//小程序APPID
    'secret' => 'your AppSecret',//小程序Secret
    'mch_id' => '商户id',
    'key' => '微信支付自定义key,微信后台设置',
    'cert_path' => env('WECHAT_PAYMENT_CERT_PATH', '../../apiclient_cert.pem'),    // XXX: 绝对路径！！！！
    'key_path' => env('WECHAT_PAYMENT_KEY_PATH', '../../apiclient_key.pem'),      // XXX: 绝对路径！！！！
    'rsa_public_key_path' => env('WECHAT_RSA_PUBLIC_KEY_PATH', '../../rsa_public.pem'),
    'notify_url' => '', // 默认支付结果通知地址
    /**
     * 小程序登录凭证 code 获取 session_key 和 openid 地址，不需要改动
     */
    'code2session_url' => "https://api.weixin.qq.com/sns/jscode2session?appid=%s&secret=%s&js_code=%s&grant_type=authorization_code",
];
