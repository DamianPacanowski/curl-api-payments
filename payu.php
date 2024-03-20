<?php
   	if(isset($_GET['production']))
	{
		$Id='145227';
		$Hash='12f071174cb7eb79d4aac5bc2f07563f';
		$Url_con='https://secure.payu.com/pl/standard/user/oauth/authorize';
		$Url_orders='https://secure.payu.com/api/v2_1/orders';
	}
	else
	{
		$Id='300746';
		$Hash='2ee86a66e5d97e3fadc400c9f19b065d';
		$Url_con='https://secure.snd.payu.com/pl/standard/user/oauth/authorize';
		$Url_orders='https://secure.snd.payu.com/api/v2_1/orders';
	}
	
	$curl_init=curl_init();
	$clientId=$Id;
	$secretHash=$Hash;
	curl_setopt($curl_init,CURLOPT_URL,$Url_con);
	curl_setopt($curl_init,CURLOPT_HEADER,false);
	curl_setopt($curl_init,CURLOPT_SSL_VERIFYPEER,false);
	curl_setopt($curl_init,CURLOPT_POST,true);
	curl_setopt($curl_init,CURLOPT_RETURNTRANSFER,true);
	curl_setopt($curl_init,CURLOPT_USERPWD,$clientId.':'.$secretHash);
	curl_setopt($curl_init,CURLOPT_POSTFIELDS,'grant_type=client_credentials');
	$curl_exec = curl_exec($curl_init);
	if(empty($curl_exec)) 
	{
		die('Error: No response.');
	} 
	else 
	{
		$json_decode=json_decode($curl_exec);
		$access_token=$json_decode->access_token;
		$products = 
		[
			'notifyUrl' => 'https://'.$_SERVER['SERVER_NAME'].'/?notifyUrl',
			'customerIp' => $_SERVER['REMOTE_ADDR'],
			'merchantPosId' => $Id,
			'description' => 'description',
			'currencyCode' => 'PLN',
			'totalAmount' => 1000,
			'products' => 
			[
				[
					'name' => 'name',
					'unitPrice' => 15000,
					'quantity' => 1,
				],
				[
					'name' => 'name',
					'unitPrice' => 6000,
					'quantity' => 1,
				],
			]
		];
		$json_encode=json_encode($products);
		$authorization = 'Authorization: Bearer '.$access_token;
		curl_setopt($curl_init,CURLOPT_URL,$Url_orders);	
		curl_setopt($curl_init,CURLOPT_HTTPHEADER,array('Content-Type: application/json',$authorization));
		curl_setopt($curl_init,CURLOPT_POST,true);
		curl_setopt($curl_init,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($curl_init,CURLOPT_POSTFIELDS,$json_encode);
		$curl_exec=curl_exec($curl_init);
		
		
		if(empty($curl_exec)) 
		{
			die('Error: No response.');
		} 
		else 
		{
			$json_decode=json_decode($curl_exec);
			var_dump($json_decode);
		}
	}	
	curl_close($curl_init);
?>
