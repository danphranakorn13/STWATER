<?php
	/*Get Data From POST Http Request*/
	$datas = file_get_contents('php://input');
	/*Decode Json From LINE Data Body*/
	$deCode = json_decode($datas,true);

	file_put_contents('log.txt', file_get_contents('php://input') . PHP_EOL, FILE_APPEND);

	$replyToken = $deCode['events'][0]['replyToken'];
	$userId = $deCode['events'][0]['source']['userId'];
	$text = $deCode['events'][0]['message']['text'];

    $LINEDatas['url'] = "https://api.line.me/v2/bot/message/reply";
  	$LINEDatas['token'] = "kZG8J6eW1R05gwz68ZkdWl7yPaGygloidwBhEqHoXaTn9c9PTAdm7XXImW5Bed9o7s/Yufj0sfGZJzqCOSGaSE9V/Z5AzBcXrcnZigkESMM4tB9vUGKC09poN3esx+gY1uQO7hNe9APeYO6yHV7ibwdB04t89/1O/w1cDnyilFU=";

	$messages = [];
	$messages['replyToken'] = $replyToken;

	if ( $text == 'เปิดน้ำ' ) {
		$messages['messages'][0] = formatOpenWaterMessage();
	}elseif ( $text == 'ปิดน้ำ' ){
		$messages['messages'][0] = formatCloseWaterMessage();
	}elseif ( $text == 'ดูสถานะ' ){
		$messages['messages'][0] = formatInfoMessage();
	}elseif ( $text == 'ตั้งค่า' ){
		$messages['messages'][0] = formatSettingMessage();
	}else {
		$messages['messages'][0] = formatMenuMessage();
	}

	$encodeJson = json_encode($messages);
  	$results = sentMessage($encodeJson, $LINEDatas);

	/*Return HTTP Request 200*/
	http_response_code(200);

	function formatMenuMessage()
	{
		$dataJson = '{
			"type": "flex",
			"altText": "Flex Message",
			"contents": {
				"type": "bubble",
				"body": {
				  "type": "box",
				  "layout": "vertical",
				  "contents": [
					{
					  "type": "box",
					  "layout": "horizontal",
					  "contents": [
						{
						  "type": "image",
						  "url": "https://danphranakorn.com/stwater/img/picture_info.jpg",
						  "size": "5xl",
						  "aspectMode": "cover",
						  "aspectRatio": "150:196",
						  "gravity": "center",
						  "flex": 1
						},
						{
						  "type": "box",
						  "layout": "vertical",
						  "contents": [
							{
							  "type": "image",
							  "url": "https://danphranakorn.com/stwater/img/picture_info2.jpg",
							  "size": "full",
							  "aspectMode": "cover",
							  "aspectRatio": "150:98",
							  "gravity": "center"
							},
							{
							  "type": "image",
							  "url": "https://scdn.line-apps.com/n/channel_devcenter/img/flexsnapshot/clip/clip9.jpg",
							  "size": "full",
							  "aspectMode": "cover",
							  "aspectRatio": "150:98",
							  "gravity": "center"
							}
						  ],
						  "flex": 1
						}
					  ]
					},
					{
					  "type": "box",
					  "layout": "vertical",
					  "contents": [
						{
						  "type": "button",
						  "action": {
							"type": "message",
							"label": "เปิดน้ำ",
							"text": "เปิดน้ำ"
						  },
						  "style": "secondary"
						},
						{
						  "type": "button",
						  "action": {
							"type": "message",
							"label": "ปิดน้ำ",
							"text": "ปิดน้ำ"
						  },
						  "style": "secondary"
						},
						{
						  "type": "button",
						  "action": {
							"type": "message",
							"label": "ดูสถานะ",
							"text": "ดูสถานะ"
						  },
						  "style": "secondary"
						}
					  ],
					  "spacing": "xl",
					  "paddingAll": "20px"
					}
				  ],
				  "paddingAll": "0px"
				}
			  }
		  }';

		$dataJson = json_decode($dataJson, true);
		return $dataJson;
	}

	function formatOpenWaterMessage()
	{
		$dataJson = '{
			"type": "flex",
			"altText": "Flex Message",
			"contents": {
				"type": "bubble",
				"hero": {
				  "type": "image",
				  "url": "https://danphranakorn.com/stwater/img/picture_open.jpg",
				  "size": "full",
				  "aspectRatio": "20:13",
				  "aspectMode": "cover"
				},
				"body": {
				  "type": "box",
				  "layout": "vertical",
				  "contents": [
					{
					  "type": "text",
					  "text": "สถานะการทำงาน",
					  "weight": "bold",
					  "size": "xl"
					},
					{
					  "type": "box",
					  "layout": "vertical",
					  "margin": "lg",
					  "spacing": "sm",
					  "contents": [
						{
						  "type": "box",
						  "layout": "baseline",
						  "spacing": "sm",
						  "contents": [
							{
							  "type": "text",
							  "text": "ปั้มน้ำ :",
							  "color": "#aaaaaa",
							  "size": "sm",
							  "flex": 2
							},
							{
							  "type": "text",
							  "text": "เปิดอยู่",
							  "wrap": true,
							  "color": "#148F77",
							  "size": "sm",
							  "flex": 3
							}
						  ]
						},
						{
						  "type": "box",
						  "layout": "baseline",
						  "spacing": "sm",
						  "contents": [
							{
							  "type": "text",
							  "text": "เวลาเปิด :",
							  "color": "#aaaaaa",
							  "size": "sm",
							  "flex": 2
							},
							{
							  "type": "text",
							  "text": "07:00 - 07:05 น.",
							  "wrap": true,
							  "color": "#666666",
							  "size": "sm",
							  "flex": 3
							}
						  ]
						},
						{
						  "type": "box",
						  "layout": "baseline",
						  "contents": [
							{
							  "type": "text",
							  "text": "ระดับความชื้น :",
							  "flex": 2,
							  "color": "#aaaaaa",
							  "size": "sm"
							},
							{
							  "type": "text",
							  "text": "40%",
							  "color": "#666666",
							  "size": "sm",
							  "wrap": true,
							  "flex": 3
							}
						  ],
						  "spacing": "sm"
						}
					  ]
					},
					{
					  "type": "text",
					  "text": "ปั้มน้ำจะเปิดเมื่อระดับน้ำน้อยกว่า 20%",
					  "size": "sm",
					  "weight": "regular",
					  "margin": "lg",
					  "wrap": true
					},
					{
					  "type": "text",
					  "text": "ปั้มน้ำจะปิดเมื่อระดับน้ำมากกว่า 80%",
					  "size": "sm",
					  "weight": "regular",
					  "margin": "lg",
					  "wrap": true
					}
				  ]
				}
			  }
		  }';

		$dataJson = json_decode($dataJson, true);
		return $dataJson;
	}

	function formatCloseWaterMessage()
	{
		$dataJson = '{
			"type": "flex",
			"altText": "Flex Message",
			"contents": {
				"type": "bubble",
				"hero": {
				  "type": "image",
				  "url": "https://danphranakorn.com/stwater/img/picture_close.jpg",
				  "size": "full",
				  "aspectRatio": "20:13",
				  "aspectMode": "cover"
				},
				"body": {
				  "type": "box",
				  "layout": "vertical",
				  "contents": [
					{
					  "type": "text",
					  "text": "สถานะการทำงาน",
					  "weight": "bold",
					  "size": "xl"
					},
					{
					  "type": "box",
					  "layout": "vertical",
					  "margin": "lg",
					  "spacing": "sm",
					  "contents": [
						{
						  "type": "box",
						  "layout": "baseline",
						  "spacing": "sm",
						  "contents": [
							{
							  "type": "text",
							  "text": "ปั้มน้ำ :",
							  "color": "#aaaaaa",
							  "size": "sm",
							  "flex": 2
							},
							{
							  "type": "text",
							  "text": "ปิดอยู่",
							  "wrap": true,
							  "color": "#C70039",
							  "size": "sm",
							  "flex": 3
							}
						  ]
						},
						{
						  "type": "box",
						  "layout": "baseline",
						  "spacing": "sm",
						  "contents": [
							{
							  "type": "text",
							  "text": "เวลาเปิด :",
							  "color": "#aaaaaa",
							  "size": "sm",
							  "flex": 2
							},
							{
							  "type": "text",
							  "text": "07:00 - 07:05 น.",
							  "wrap": true,
							  "color": "#666666",
							  "size": "sm",
							  "flex": 3
							}
						  ]
						},
						{
						  "type": "box",
						  "layout": "baseline",
						  "contents": [
							{
							  "type": "text",
							  "text": "ระดับความชื้น :",
							  "flex": 2,
							  "color": "#aaaaaa",
							  "size": "sm"
							},
							{
							  "type": "text",
							  "text": "40%",
							  "color": "#666666",
							  "size": "sm",
							  "wrap": true,
							  "flex": 3
							}
						  ],
						  "spacing": "sm"
						}
					  ]
					},
					{
					  "type": "text",
					  "text": "ปั้มน้ำจะเปิดเมื่อระดับน้ำน้อยกว่า 20%",
					  "size": "sm",
					  "weight": "regular",
					  "margin": "lg",
					  "wrap": true
					},
					{
					  "type": "text",
					  "text": "ปั้มน้ำจะปิดเมื่อระดับน้ำมากกว่า 80%",
					  "size": "sm",
					  "weight": "regular",
					  "margin": "lg",
					  "wrap": true
					}
				  ]
				}
			  }
		  }';

		$dataJson = json_decode($dataJson, true);
		return $dataJson;
	}

	function formatInfoMessage()
	{

		$dataJson = '{
			"type": "flex",
			"altText": "Flex Message",
			"contents": {
				"type": "bubble",
				"hero": {
				  "type": "image",
				  "url": "https://danphranakorn.com/stwater/img/picture_info.jpg",
				  "size": "full",
				  "aspectRatio": "20:13",
				  "aspectMode": "cover"
				},
				"body": {
				  "type": "box",
				  "layout": "vertical",
				  "contents": [
					{
					  "type": "text",
					  "text": "สถานะการทำงาน",
					  "weight": "bold",
					  "size": "xl"
					},
					{
					  "type": "box",
					  "layout": "vertical",
					  "margin": "lg",
					  "spacing": "sm",
					  "contents": [
						{
						  "type": "box",
						  "layout": "baseline",
						  "spacing": "sm",
						  "contents": [
							{
							  "type": "text",
							  "text": "ปั้มน้ำ :",
							  "color": "#aaaaaa",
							  "size": "sm",
							  "flex": 2
							},
							{
							  "type": "text",
							  "text": "เปิดอยู่",
							  "wrap": true,
							  "color": "#148F77",
							  "size": "sm",
							  "flex": 3
							}
						  ]
						},
						{
						  "type": "box",
						  "layout": "baseline",
						  "spacing": "sm",
						  "contents": [
							{
							  "type": "text",
							  "text": "เวลาเปิด :",
							  "color": "#aaaaaa",
							  "size": "sm",
							  "flex": 2
							},
							{
							  "type": "text",
							  "text": "07:00 - 07:05 น.",
							  "wrap": true,
							  "color": "#666666",
							  "size": "sm",
							  "flex": 3
							}
						  ]
						},
						{
						  "type": "box",
						  "layout": "baseline",
						  "contents": [
							{
							  "type": "text",
							  "text": "ระดับความชื้น :",
							  "flex": 2,
							  "color": "#aaaaaa",
							  "size": "sm"
							},
							{
							  "type": "text",
							  "text": "40%",
							  "color": "#666666",
							  "size": "sm",
							  "wrap": true,
							  "flex": 3
							}
						  ],
						  "spacing": "sm"
						}
					  ]
					},
					{
					  "type": "text",
					  "text": "ปั้มน้ำจะเปิดเมื่อระดับน้ำน้อยกว่า 20%",
					  "size": "sm",
					  "weight": "regular",
					  "margin": "lg",
					  "wrap": true
					},
					{
					  "type": "text",
					  "text": "ปั้มน้ำจะปิดเมื่อระดับน้ำมากกว่า 80%",
					  "size": "sm",
					  "weight": "regular",
					  "margin": "lg",
					  "wrap": true
					}
				  ]
				}
			  }
		  }';

		$dataJson = json_decode($dataJson, true);
		return $dataJson;
	}

	function formatSettingMessage()
	{
		$datas = [];
		$datas['type'] = 'text';
		$datas['text'] = 'ปิดปรับปรุง';
		return $datas;
	}

	function sentMessage($encodeJson,$datas)
	{
		$datasReturn = [];
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => $datas['url'],
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => $encodeJson,
		  CURLOPT_HTTPHEADER => array(
		    "authorization: Bearer ".$datas['token'],
		    "cache-control: no-cache",
		    "content-type: application/json; charset=UTF-8",
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		    $datasReturn['result'] = 'E';
		    $datasReturn['message'] = $err;
		} else {
		    if($response == "{}"){
			$datasReturn['result'] = 'S';
			$datasReturn['message'] = 'Success';
		    }else{
			$datasReturn['result'] = 'E';
			$datasReturn['message'] = $response;
		    }
		}

		return $datasReturn;
	}
?>