<?php
namespace Logic;
class OAuthLogic {

	/*验证是否超时*/
	public function AuthTimeStamp($requestTimeStamp)
	{
		 $result = "200";
		 $nowTimeStamp =time();
		 $outTimes=abs($nowTimeStamp-$requestTimeStamp);
		 if ($outTimes > 30)          //请求控制在30s之内
            $result = "302";
         return $result;
	}

	/*验证签名是否正确*/
    public function AuthSignature2($requestSignature, $url, $method, $consumerKey, $consumerSecret, $nonce, $timeStamp, $version)
    {
        $result = "200";
        $restoreSignature = $this->GenerateSignature2($url, $method, $consumerKey, $consumerSecret, $nonce, $timeStamp, $version);
        if (strtolower($requestSignature) != strtolower($restoreSignature))
            $result = "301";
        return $result;
    }

    /*保证请求的唯一性*/
    public function AuthOnlyRequest($requestSignature)
    {
        $result = "200";
        $nowTimeStamp =time();

        //if (CommonSignature.getInterface().Contents(requestSignature))
        //{
        //    result = "302";
        //}
        //else
        //{
        //    CommonSignature.getInterface().Add(requestSignature, nowTimeStamp);
        //}
        //CommonSignature.getInterface().ProcessOutTimeSignature();

        return $result;
    }

    /*生成签名*/
    public function GenerateSignature2($url, $httpMethod, $consumerKey, $consumerSecret, $nonce, $timeStamp, $version)
    {
        $normalizedSignature="auth_key=".$consumerKey."&auth_secret=".$consumerSecret."&auth_nonce=".$nonce."&auth_timestamp=".$timeStamp."&auth_version=".$version;
        $signatureBase =$httpMethod."&".$url."&".$normalizedSignature;
        return md5($signatureBase);
    }

}
?>