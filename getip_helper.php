<?php
/**
*	@author liwei
*	@date 2014-6-10
*	@desc get client ip
*
*/

function get_ip(){
	if(getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"),"unknown")){
		$ip = getenv();
	}else if(getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"),"unknown" )){
		$ip = getenv("HTTP_X_FORWARDED_FOR");
	}else if(getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"),"unknown")){
		$ip = getenv("REMOTE_ADDR");
	}else if(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")){
		$ip = $_SERVER['REMOTE_ADDR'];
	}else{
		$ip = 'unknown';
	}
	return $ip;
}

//��IPת��Ϊ����
function ipton($ip)
{
	$ip_arr=explode('.',$ip);//�ָ�ip��
	$ipstr='' ;
	foreach ($ip_arr as $value)
	{
		$iphex=dechex($value);//��ÿ��ipת����16����
		if(strlen($iphex)<2)//255��16���Ʊ�ʾ��ff������ÿ��ip��16���Ƴ��Ȳ��ᳬ��2
		{
			$iphex='0'.$iphex;//���ת�����16����������С��2������ǰ���һ��0
			//û�г���Ϊ2���ҵ�һλ��0��16���Ʊ�ʾ������Ϊ���ڽ�����ת����ipʱ���ô���
		}
		$ipstr.=$iphex;//���Ķ�IP��16�����������������õ�һ��16�����ַ���������Ϊ8
	}
	return hexdec($ipstr);//��16�����ַ���ת����10���ƣ��õ�ip�����ֱ�ʾ
}


//������ת��ΪIP���������溯�����������
function ntoip($n)
{
	$iphex=dechex($n);//��10��������ת����16����
	$len=strlen($iphex);//�õ�16�����ַ����ĳ���
	if(strlen($iphex)<8)
	{
		$iphex='0'.$iphex;//�������С��8������ǰ���0
		$len=strlen($iphex); //���µõ�16�����ַ����ĳ���
	}
	//������Ϊipton�����õ���16�����ַ����������һλΪ0����ת�������ֺ��ǲ�����ʾ��
	//���ԣ��������С��8���϶�Ҫ�ѵ�һλ��0����ȥ
	//Ϊʲôһ���ǵ�һλ��0�أ���Ϊ��ipton�����У�������μӵ�'0'�����м䣬ת�������ֺ󣬲�����ʧ
	for($i=0,$j=0;$j<$len;$i=$i+1,$j=$j+2)
	{//ѭ����ȡ16�����ַ�����ÿ�ν�ȡ2������
		$ippart=substr($iphex,$j,2);//�õ�ÿ��IP����Ӧ��16������
		$fipart=substr($ippart,0,1);//��ȡ16�������ĵ�һλ
		if($fipart=='0')
		{//�����һλΪ0��˵��ԭ��ֻ��1λ
			$ippart=substr($ippart,1,1);//��0��ȡ��
		}
		$ip[]=hexdec($ippart);//��ÿ��16������ת���ɶ�Ӧ��10����������IP���ε�ֵ
	}
	$ip = array_reverse($ip);
	 
	return implode('.', $ip);//���Ӹ��Σ�����ԭIPֵ
}