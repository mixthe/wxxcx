<?php

namespace Mixthe\Wxxcx;

use Mixthe\Wxxcx\Console\Helpers\CurlHelp;

class EnterprisePay
{

    const ENTERPRISE_PAY_SEARCH_URL = 'https://api.mch.weixin.qq.com/mmpaysptrans/query_bank';

    private $appid;
    private $mch_id;
    private $key;
    private $cert_path;
    private $key_path;

    function __construct($appid, $mch_id, $key, $cert_path, $key_path)
    {
        $this->appid = $appid;
        $this->mch_id = $mch_id;
        $this->key = $key;
        $this->cert_path = $cert_path;
        $this->key_path = $key_path;
    }

    /**
     * 企业支付sign生成
     * @param $prepay_id
     * @param $nonceStr
     * @return string、
     */
    public function paySign($prepay_id, $nonceStr)
    {
        $params = [
            'appId' => $this->appid,
            'nonceStr' => $nonceStr,
            'package' => "prepay_id=$prepay_id",
            'signType' => 'MD5',
            'timeStamp' => time(),
            'key' => $this->key
        ];
        $str = urldecode(http_build_query($params));
        return strtoupper(md5($str));
    }


    /**
     * 查询企业付款银行卡 sign
     * @param $nonce_str
     * @param $partner_trade_no
     * @return string
     */
    public function bankSign($nonce_str, $partner_trade_no)
    {
        $params = [
            'mch_id' => $this->mch_id,
            'nonce_str' => $nonce_str,
            'partner_trade_no' => $partner_trade_no,
            'key' => $this->key,
        ];
        $str = urldecode(http_build_query($params));
        return strtoupper(md5($str));
    }

    /**
     * 查询企业付款到银行卡订单
     * @param $partnerTradeNo
     * @return array|mixed
     */
    public function searchWithdrawals($partnerTradeNo)
    {
        $mch_id = $this->mch_id;
        $nonceStr = uniqid();
        $sign = $this->bankSign($nonceStr, $partnerTradeNo);
        $data = [
            'mch_id' => $mch_id,
            'partner_trade_no' => $partnerTradeNo,
            'nonce_str' => $nonceStr,
            'sign' => $sign
        ];
        //构造XML数据
        $xmldata = CurlHelp::array2xml($data);
        $res = CurlHelp::curl_post_ssl(self::ENTERPRISE_PAY_SEARCH_URL, $xmldata, $second = 30, [], $this->cert_path, $this->key_path);
        if (!$res) {
            return ['code' => 403, 'msg' => "Can't connect the server"];
        }
        $content = CurlHelp::xml2array($res);
        return $content;
    }
}