<?php
   	$curl_init=curl_init();
	$clientId='300746';
	$secretHash='2ee86a66e5d97e3fadc400c9f19b065d';
	curl_setopt($curl_init,CURLOPT_URL,'https://secure.snd.payu.com/pl/standard/user/oauth/authorize');
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
		
	
		$array_products = 
		[
			'notifyUrl' => 'https://notifyUrl',
			'customerIp' => '**.**.**.**',
			'merchantPosId' => '*******',
			'description' => 'test_description',
			'currencyCode' => 'PLN',
			'totalAmount' => 1000,
			'products' => 
			[
				[
					'name' => 'Wireless mouse',
					'unitPrice' => 15000,
					'quantity' => 1,
				],
				[
					'name' => 'HDMI cable',
					'unitPrice' => 6000,
					'quantity' => 1,
				],
			]
		];
		
		
		
		//curl_close($curl_init);
		//var_dump($array_filds);
		
		$json_encode=json_encode($array_products); 	
		
		$authorization = 'Authorization: Bearer '.$access_token;
		
		curl_setopt($curl_init,CURLOPT_URL,'https://secure.snd.payu.com/api/v2_1/orders');	
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
