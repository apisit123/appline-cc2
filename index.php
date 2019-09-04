<?php

require_once 'vendor/autoload.php';

use LINE\LINEBot;
use LINE\LINEBot\HTTPClient;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\Event;
use LINE\LINEBot\Event\BaseEvent;
use LINE\LINEBot\Event\MessageEvent;
use LINE\LINEBot\Event\AccountLinkEvent;
use LINE\LINEBot\Event\MemberJoinEvent; 
use LINE\LINEBot\MessageBuilder;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\MessageBuilder\StickerMessageBuilder;
use LINE\LINEBot\MessageBuilder\ImageMessageBuilder;
use LINE\LINEBot\MessageBuilder\LocationMessageBuilder;
use LINE\LINEBot\MessageBuilder\AudioMessageBuilder;
use LINE\LINEBot\MessageBuilder\VideoMessageBuilder;
use LINE\LINEBot\ImagemapActionBuilder;
use LINE\LINEBot\ImagemapActionBuilder\AreaBuilder;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapMessageActionBuilder ;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapUriActionBuilder;
use LINE\LINEBot\MessageBuilder\Imagemap\BaseSizeBuilder;
use LINE\LINEBot\MessageBuilder\ImagemapMessageBuilder;
use LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
use LINE\LINEBot\TemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\DatetimePickerTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ImageCarouselTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ImageCarouselColumnTemplateBuilder;
use LINE\LINEBot\QuickReplyBuilder;
use LINE\LINEBot\QuickReplyBuilder\QuickReplyMessageBuilder;
use LINE\LINEBot\QuickReplyBuilder\ButtonBuilder\QuickReplyButtonBuilder;
use LINE\LINEBot\TemplateActionBuilder\CameraRollTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\CameraTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\LocationTemplateActionBuilder;
use LINE\LINEBot\RichMenuBuilder;
use LINE\LINEBot\RichMenuBuilder\RichMenuSizeBuilder;
use LINE\LINEBot\RichMenuBuilder\RichMenuAreaBuilder;
use LINE\LINEBot\RichMenuBuilder\RichMenuAreaBoundsBuilder;

/// การตั้งค่าเกี่ยวกับ bot ใน LINE Messaging API
define('LINE_MESSAGE_CHANNEL_ID','1648723890');
define('LINE_MESSAGE_CHANNEL_SECRET','1e61a9805bde296ff2b3b2fbbe302220');
define('LINE_MESSAGE_ACCESS_TOKEN','ZJtS+TuOmS9FWEHc1Idm7RF2dXjszDOOWHDAUcx2LLMyQP9DStP4PUXeoQjX6gtdYRy9hBD5T5opbbeHMb5zjU3PonwLzSKCbkJ2CQ5scC7uTmojN2I38anReeBjmzdcKGl6sq5758gXHdB21DgeHlGUYhWQfeY8sLGRXgo3xvw=');


$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(LINE_MESSAGE_ACCESS_TOKEN);
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => LINE_MESSAGE_CHANNEL_SECRET]);

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
		error_log("Recv From ".$_uid);
		link_richmenu($_uid,$richmenu[0]);
		break;
	}

	// Message Event = TextMessage
	if (($event instanceof \LINE\LINEBot\Event\MessageEvent\TextMessage)) {

		$_uid = $event->getUserId();

		$buff=strtolower(trim($event->getText()));
        
        $messageText = explode("-",$buff);
        
        error_log("Message :: ".$messageText[0]);

        error_log("Authorization: ".LINE_MESSAGE_ACCESS_TOKEN);
        


		switch ($messageText[0]) {
			case "promotion" :
				//$data = get_promotion($_uid);
                		//post_line($data);

				error_log("promo process");
        		$msg = link_richmenu($_uid,$richmenu[0]);
				$outputText = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($msg);
				break;

      		case "test" :
      			$xx = post_line($_uid, "text", "test text");
      			error_log($xx);
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
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_HTTPHEADER => array(
	    "Authorization: Bearer ".LINE_MESSAGE_ACCESS_TOKEN
	  ),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
	  error_log("cURL Error #:" . $err);
	} else {
	  error_log("Message :: ".$response);
	}

	return $response;
	
}



function post_line($userID, $msgtype, $data_post){

	$myObj->to = $userID;
	$myObj->messages = array('type' => $msgtype,
		'text' => $data_post);

	$data_post = json_encode($myObj);

	error_log($data_post);

    $curl = curl_init();
    
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.line.me/v2/bot/message/push",
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS =>  $data_post,
      CURLOPT_HTTPHEADER => array(
        "Authorization: Bearer ".LINE_MESSAGE_ACCESS_TOKEN
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