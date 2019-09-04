<?php

require_once 'vendor/autoload.php';


$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient("Bearer a9Kj4XxQXy/VyXbSB804kWHqZMGZ2ZZbrrMpTFlm7hd9ZdQ37U1cqC7LBYkJrXQR1Gis4bXMNQb/L0sYfkRV897EmhEq/Ir2P4SSNTx2tBV87aAouxozywtwVvi2wBXRzmv8KMsfMuxnNBwfrigDyAdB04t89/1O/w1cDnyilFU=");
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => "d77dbc05ab9394717939433eb2e8f7e3"]);
$signature = $_SERVER['HTTP_' . \LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];

$richmenu = array("richmenu-3d2c1619e7bc6e109d68fc5fb6d1c3a1","richmenu-f9ad5af743a6c61b04b04ee47d9c1936","richmenu-548104a047e4b13410a5d102610522ce", "richmenu-2b5232638184e538e0c48d1232a11f9e");
$events = '';

try {
  $events = $bot->parseEventRequest(file_get_contents('php://input'), $signature);
} catch(\LINE\LINEBot\Exception\InvalidSignatureException $e) {
  error_log('parseEventRequest failed. InvalidSignatureException => '.var_export($e, true));
} catch(\LINE\LINEBot\Exception\UnknownEventTypeException $e) {
  error_log('parseEventRequest failed. UnknownEventTypeException => '.var_export($e, true));
} catch(\LINE\LINEBot\Exception\UnknownMessageTypeException $e) {
  error_log('parseEventRequest failed. UnknownMessageTypeException => '.var_export($e, true));
} catch(\LINE\LINEBot\Exception\InvalidEventRequestException $e) {
  error_log('parseEventRequest failed. InvalidEventRequestException => '.var_export($e, true));
}

if (is_array($events) || is_object($events))
foreach ($events as $event) {
	// Postback Event
	
	if (($event instanceof \LINE\LINEBot\Event\FollowEvent)) {
		$_uid = $event->getUserId();
		$response = $bot->linkRichMenu($_uid, $richmenu[0]);
		break;
	}

	if (($event instanceof \LINE\LINEBot\Event\PostbackEvent)) {
    	$data = $event->getPostbackData();
    	$_uid = $event->getUserId();
    	switch ($data) {
    		
    		case "-nextto2-" :
				link_richmenu($_uid,$richmenu[0]);
				break;

			case "-backto1-" :
				link_richmenu($_uid,$richmenu[0]);
				break;
    	}
    	break;
  	}

	// Message Event = TextMessage
	if (($event instanceof \LINE\LINEBot\Event\MessageEvent\TextMessage)) {
		$buff=strtolower(trim($event->getText()));
        
        $messageText = explode("-",$buff);
        
        
        
		$dir = dirname(__FILE__)."/database/".(string)$_uid.".csv";
		$file =  $_uid.".txt";
		//$link = "https://thawing-basin-91531.herokuapp.com/";


		switch ($messageText[0]) {
			case "promotion" :
				//$data = get_promotion($_uid);
                		//post_line($data);
        link_richmenu($_uid,$richmenu[0]);
				image_map_promo($_uid);
				$outputText = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder();
			break;

      case "test" :
        //$data = get_promotion($_uid);
        $outputText = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("ทดสอบ");
      break;
			
			default:
			    $outputText = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder("default");
				break;
		}
		
		$response = $bot->replyMessage($event->getReplyToken(), $outputText);
	}
}
  


function link_richmenu($userID,$richID) {
    $curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => "https://api.line.me/v2/bot/user/".$userID."/richmenu/".$richID,
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS => "",
	  CURLOPT_HTTPHEADER => array(
	    "Authorization: Bearer XuWMr1KtT16go8TtsiDaLBVIRla/IX6JagScETaCaAt7wApMNWb85YDoG19amCG6c6ttH/iQzmhR5gMFQL29qTIDVIjbpJB0VkEsbVhfdnwGM9QkhoP5gKT64yG4lem5jFN9K5yKAYAagLOQybaLWAdB04t89/1O/w1cDnyilFU=",
	    "Cache-Control: no-cache",
	    "Postman-Token: 017fa460-0c75-45f7-9f28-5b046dfd245e"
	  ),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
	  echo "cURL Error #:" . $err;
	} else {
	  echo $response;
	}
}


function post_line($data_post){

    $curl = curl_init();
    
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.line.me/v2/bot/message/push",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS =>  $data_post,
      CURLOPT_HTTPHEADER => array(
        "Authorization: Bearer XuWMr1KtT16go8TtsiDaLBVIRla/IX6JagScETaCaAt7wApMNWb85YDoG19amCG6c6ttH/iQzmhR5gMFQL29qTIDVIjbpJB0VkEsbVhfdnwGM9QkhoP5gKT64yG4lem5jFN9K5yKAYAagLOQybaLWAdB04t89/1O/w1cDnyilFU=",
        "Cache-Control: no-cache",
        "Content-Type: application/json",
        "Postman-Token: 9c1e2414-9a6d-4022-9bc2-fa308f64584d"
      ),
    ));
    
    $response = curl_exec($curl);
    $err = curl_error($curl);
    
    curl_close($curl);
    
    return $response;

}



function send_data($_uid,$csvFilePath, $type){
    
    $data = file_get_contents($csvFilePath);
    $array = explode(",",$data,-1);

    $data_1 = '
    {
        "to": "'.$_uid.'",
        "messages":[
        	{  
      "type": "flex",
      "altText": "this is a flex message",
      "contents": {
          "type": "bubble",
          "hero": {
            "type": "image",
            "url": "https://cafe.iniqbot.com/wp-content/uploads/2018/07/30728665_2182507208431845_2365661484056313856_o.jpg",
            "size": "full",
            "aspectRatio": "16:9",
            "aspectMode": "cover"
          },
          
          
          "body": {
            "type": "box",
            "layout": "vertical",
            "spacing": "md",
            "action": {
              "type": "uri",
              "uri": "https://linecorp.com"
            },
            "contents": [
              {
                "type": "text",
                "align": "center",
                "text": "'.$type.'",
                "size": "xl"
              },
              {
                "type": "text",
                "align": "center",
                "text": "> Your Order ID <",
                "size": "md"
              }
            ]
          },
          "footer": {
            "type": "box",
            "layout": "vertical",
            "spacing": "sm",
            "contents": [';
            
              $data_3 = '
              {
                "type": "spacer",
                "size": "sm"
              }
            ],
            "flex": 1
          }
        }
       }
      ]
    }';
    

    $len = count($array);
    if($type == "history"){
            $len = 0;
        }else{
            $len = $len - 3;        
        }
    $cnt = 0;
    foreach($array as $a){
        if($cnt >= $len){
            $data_2 .= '
              {
                "type": "button",
                "style": "primary",
                "color": "#121a48",
                "height": "sm",
                "action": {
                  "type":"message",
                  "label":"'.$a.'",
                  "text":"id-'.$type."-".$a.'"
                }
              },';
        }
        $cnt += 1;
    }
    
    return $data_1.$data_2.$data_3;
    
}


function wait_data($_uid, $queue, $es_time){

    return '{
        "to": "'.$_uid.'",
        "messages":[
        	{  
              "type": "flex",
              "altText": "this is a flex message",
              "contents": {
                  "type": "bubble",
                  "styles": {
                    "footer": {
                      "separator": true
                    }
                  },
                  "body": {
                    "type": "box",
                    "layout": "vertical",
                    "contents": [
                      {
                        "type": "text",
                        "text": "Waiting Time",
                        "align": "center",
                        "weight": "bold",
                        "color": "#121a48",
                        "size": "xxl"
                      }
                    ]
                  },
                  "footer": {
                    "type": "box",
                    "layout": "horizontal",
                    "spacing": "md",
                    "contents": [
                      {
                        "type": "box",
                        "layout": "vertical",
                        "flex": 1,
                        "contents": [
                          {
                            "type": "image",
                            "url": "https://cafe.iniqbot.com/wp-content/uploads/2018/07/hourglass.png",
                            "aspectMode": "cover",
                            "aspectRatio": "1:1",
                            "size": "sm",
                            "gravity": "bottom"
                          }
                        ]
                      },
                      {
                        "type": "box",
                        "layout": "vertical",
                        "flex": 2,
                        "contents": [
                          {
                            "type": "text",
                            "text": "Queue  : '.$queue.'",
                            "gravity": "top",
                            "size": "xl",
                            "flex": 1
                          },
                          {
                            "type": "separator"
                          },
                          {
                            "type": "text",
                            "text": "Wait : '.$es_time.'",
                            "gravity": "center",
                            "size": "xl",
                            "flex": 2
                          }
                        ]
                      }
                    ]
                  }
                }
            }
        ]
        
    }';
    
}


function status_data($_uid, $order_id, $status, $queue, $est_time){
        return '{
        "to": "'.$_uid.'",
        "messages":[
        	{  
              "type": "flex",
              "altText": "this is a flex message",
              "contents": {
                  "type": "bubble",
                  "styles": {
                    "footer": {
                      "separator": true
                    }
                  },
                  "hero": {
                    "type": "image",
                    "url": "https://app.toofasttosleep.co:443/wp-content/uploads/2018/08/30728665_2182507208431845_2365661484056313856_o.jpg",
                    "size": "full",
                    "aspectRatio": "16:9",
                    "aspectMode": "cover",
                    "action": {
                      "type": "uri",
                      "uri": "https://app.toofasttosleep.co:443/wp-content/uploads/2018/08/30728665_2182507208431845_2365661484056313856_o.jpg"
                    }
                  },
                  "body": {
                    "type": "box",
                    "layout": "vertical",
                    "contents": [
                      {
                        "type": "text",
                        "text": "Status",
                        "weight": "bold",
                        "color": "#121a48",
                        "align": "center",
                        "size": "xxl"
                      },
                      {
                        "type": "text",
                        "text": "Order ID :  #'.$order_id.'",
                        "color": "#aaaaaa",
                        "size": "xl",
                        "margin": "md"
                      },
                      {
                        "type": "separator",
                        "margin": "xxl"
                      },
                      {
                        "type": "box",
                        "layout": "vertical",
                        "margin": "xxl",
                        "spacing": "sm",
                        "contents": [
                          {
                            "type": "box",
                            "layout": "horizontal",
                            "contents": [
                              {
                                "type": "text",
                                "text": "Queue : '.$queue.'",
                                "size": "xl",
                                "color": "#555555",
                                "flex": 0
                              }
                            ]
                          },
                          {
                            "type": "box",
                            "layout": "horizontal",
                            "contents": [
                              {
                                "type": "text",
                                "text": "Status : '.$status.'",
                                "size": "xl",
                                "color": "#555555",
                                "flex": 0
                              }
                            ]
                          },
                          {
                            "type": "box",
                            "layout": "horizontal",
                            "contents": [
                              {
                                "type": "text",
                                "text": "Est Time : '.$est_time.'",
                                "size": "xl",
                                "color": "#555555",
                                "flex": 0
                              }
                            ]
                          }
                        ]
                      }
                    ]
                  }
                }
            }
        ]
        
    }';
}


function image_map_promo($_uid){
    	$data = shell_exec("curl -X GET https://siam.toofasttosleep.co/api/v1/promo/promotions");
    	$data = json_decode($data, true);
	foreach($data["promotions"] as $json){

$str = '{
	"to" : "'.$_uid.'",
	"messages": [{
	  "type": "imagemap",
	  "baseUrl": "'.$json["picture"].'?_ignored=",
	  "altText": "This is an imagemap",
	  "baseSize": {
	      "width": 1040,
	      "height": 1040
	  },
	  "actions": [
	      {
	          "type": "uri",
	          "linkUri": "'.$json["picture"].'",
	          "area": {
	              "x": 0,
	              "y": 0,
	              "width": 1040,
	              "height": 1040
	          }
	      }
	  ]
	}
  ]
}';

	post_line($str);

	}

}


function get_promotion($_uid){
    
    $data = shell_exec("curl -X GET https://siam.toofasttosleep.co/api/v1/promo/promotions");
    $data = json_decode($data, true);
    
    foreach($data["promotions"] as $json){
        $xxxx .= '{
                    "imageUrl": "'.$json["picture"].'",
                    "action": {
                      "type": "uri",
                      "uri": "'.$json["picture"].'"
                    }
                  },';
        
    }
    $rest = substr($xxxx, 0, -1);
    return '
    {
        "to": "'.$_uid.'",
        "messages":[
          {
          "type": "template",
          "altText": "this is a image carousel template",
          "template": {
              "type": "image_carousel",
              "columns": [
                  '.$rest.'
              ]
          }
        }
    ]
  }';
}