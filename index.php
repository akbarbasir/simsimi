<?php
/*
copyright @ medantechno.com
Modified by Ilyasa
2017
*/
require_once('./line_class.php');

$channelAccessToken = 'JOnw8q0B9Zo4ZGPVoCjvrzZd0vfwGHp0Mev5GneTrFBlcUUGZwRSow8okjz2di7nifzJadGzYJhkiQKWhRAw/YIqIvnBFBclMD6EkKjndiOsmCCXFT7XhZtQup06v5c7ua4JMux6hUW+1UYz/MMTwAdB04t89/1O/w1cDnyilFU='; //Your Channel Access Token
$channelSecret = 'cc6d151623241254466815c5a81baf20';//Your Channel Secret

$client = new LINEBotTiny($channelAccessToken, $channelSecret);

$userId 	= $client->parseEvents()[0]['source']['userId'];
$replyToken = $client->parseEvents()[0]['replyToken'];
$message 	= $client->parseEvents()[0]['message'];
$profil = $client->profil($userId);
$pesan_datang = $message['text'];

if($message['type']=='sticker')
{	
	$balas = array(
							'UserID' => $profil->userId,	
                                                        'replyToken' => $replyToken,							
							'messages' => array(
								array(
										'type' => 'text',									
										'text' => 'Terima Kasih Stikernya But Jellek stikermu.'										
									
									)
							)
						);
						
}
else
$pesan=str_replace(" ", "%20", $pesan_datang);
$key = '4f561ef5-6f7f-47e3-99bf-5f06c0481f58'; //API SimSimi
$url = 'http://sandbox.api.simsimi.com/request.p?key='.$key.'&lc=id&ft=1.0&text='.$pesan;
$json_data = file_get_contents($url);
$url=json_decode($json_data,1);
$diterima = $url['response'];
if($message['type']=='text')
{
if($url['result'] == 404)
	{
		$balas = array(
							'UserID' => $profil->userId,	
                                                        'replyToken' => $replyToken,													
							'messages' => array(
								array(
										'type' => 'text',					
										'text' => 'Mohon Gunakan Bahasa Indonesia Yang Benar :D.'
									)
							)
						);
				
	}
else
if($url['result'] != 100)
	{
		
		
		$balas = array(
							'UserID' => $profil->userId,
                                                        'replyToken' => $replyToken,														
							'messages' => array(
								array(
										'type' => 'text',					
										'text' => 'Maaf '.$profil->displayName.' Server Kami Sedang Sibuk Sekarang.Sudah mi dulu capekka beb $profil'displayName.'  '
									)
							)
						);
				
	}
	else{
		$balas = array(
							'UserID' => $profil->userId,
                                                        'replyToken' => $replyToken,														
							'messages' => array(
								array(
										'type' => 'text',					
										'text' => ''.$diterima.''
									)
							)
						);
						
	}
}
 
$result =  json_encode($balas);

file_put_contents('./reply.json',$result);


$client->replyMessage($balas);
