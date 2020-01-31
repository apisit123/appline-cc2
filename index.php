<?php

// กรณีต้องการตรวจสอบการแจ้ง error ให้เปิด 3 บรรทัดล่างนี้ให้ทำงาน กรณีไม่ ให้ comment ปิดไป
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'vendor/autoload.php';

///////////// ส่วนของการเรียกใช้งาน class ผ่าน namespace
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



// //productions
define('LINE_MESSAGE_CHANNEL_ID','1648723890');
define('LINE_MESSAGE_CHANNEL_SECRET','dbddc565684d3c6d66cfde44187bd101');
define('LINE_MESSAGE_ACCESS_TOKEN','XuWMr1KtT16go8TtsiDaLBVIRla/IX6JagScETaCaAt7wApMNWb85YDoG19amCG6c6ttH/iQzmhR5gMFQL29qTIDVIjbpJB0VkEsbVhfdnwGM9QkhoP5gKT64yG4lem5jFN9K5yKAYAagLOQybaLWAdB04t89/1O/w1cDnyilFU=');


//test
// define('LINE_MESSAGE_CHANNEL_ID','1648723890');
// define('LINE_MESSAGE_CHANNEL_SECRET','1e61a9805bde296ff2b3b2fbbe302220');
// define('LINE_MESSAGE_ACCESS_TOKEN','ZJtS+TuOmS9FWEHc1Idm7RF2dXjszDOOWHDAUcx2LLMyQP9DStP4PUXeoQjX6gtdYRy9hBD5T5opbbeHMb5zjU3PonwLzSKCbkJ2CQ5scC7uTmojN2I38anReeBjmzdcKGl6sq5758gXHdB21DgeHlGUYhWQfeY8sLGRXgo3xvw=');


$httpClient = new CurlHTTPClient(LINE_MESSAGE_ACCESS_TOKEN);
$bot = new LINEBot($httpClient, array('channelSecret' => LINE_MESSAGE_CHANNEL_SECRET));


// คำสั่งรอรับการส่งค่ามาของ LINE Messaging API
$content = file_get_contents('php://input');
$richmenu = array("richmenu-c23206d2a8500d452551b52271125458");

    $json = json_decode($content, true);
    
    $json["command"] = isset($json["command"]) ? $json["command"] : '';

    if($json["command"] == "paid" && $json["data"]["order"]["order_type"] == "line"){

        $order = $json["data"]["order"];

        require_once('reciept.php');

        $user_id = $order["member"]["line_id"];

        $replyData = make_reciept($order);

        $response = $bot->pushMessage($user_id, $replyData);

        if ($response->isSucceeded()) { 
            echo 'Succeeded!';
            // return;
        }
        // Failed
        echo $response->getHTTPStatus() . ' ' . $response->getRawBody();

    }else{

        // กำหนดค่า signature สำหรับตรวจสอบข้อมูลที่ส่งมาว่าเป็นข้อมูลจาก LINE
        $hash = hash_hmac('sha256', $content, LINE_MESSAGE_CHANNEL_SECRET, true);
        $signature = base64_encode($hash);


        $events = $bot->parseEventRequest($content, $signature);

        $eventObj = $events[0]; // Event Object ของ array แรก
          
        // ดึงค่าประเภทของ Event มาไว้ในตัวแปร มีทั้งหมด 7 event
        $eventType = $eventObj->getType();
          
        // สร้างตัวแปร ไว้เก็บ sourceId ของแต่ละประเภท
        $userId = NULL;
        $groupId = NULL;
        $roomId = NULL;

        // สร้างตัวแปรเก็บ source id และ source type
        $sourceId = NULL;
        $sourceType = NULL;

        // สร้างตัวแปร replyToken และ replyData สำหรับกรณีใช้ตอบกลับข้อความ
        $replyToken = NULL;
        $replyData = NULL;

        // สร้างตัวแปร ไว้เก็บค่าว่าเป้น Event ประเภทไหน
        $eventMessage = NULL;
        $eventPostback = NULL;
        $eventJoin = NULL;
        $eventLeave = NULL;
        $eventFollow = NULL;
        $eventUnfollow = NULL;
        $eventBeacon = NULL;
        $eventAccountLink = NULL;
        $eventMemberJoined = NULL;
        $eventMemberLeft = NULL;

        // เงื่อนไขการกำหนดประเภท Event 
        switch($eventType){
            case 'message': $eventMessage = true; break;    
            case 'postback': $eventPostback = true; break;  
            case 'join': $eventJoin = true; break;  
            case 'leave': $eventLeave = true; break;    
            case 'follow': $eventFollow = true; break;  
            case 'unfollow': $eventUnfollow = true; break;  
            case 'beacon': $eventBeacon = true; break;     
            case 'accountLink': $eventAccountLink = true; break;       
            case 'memberJoined': $eventMemberJoined = true; break;       
            case 'memberLeft': $eventMemberLeft = true; break;                                           
        }

        // สร้างตัวแปรเก็บค่า userId กรณีเป็น Event ที่เกิดขึ้นใน USER
        if($eventObj->isUserEvent()){
            $userId = $eventObj->getUserId();  
            $sourceType = "USER";
        }
        // สร้างตัวแปรเก็บค่า groupId กรณีเป็น Event ที่เกิดขึ้นใน GROUP
        if($eventObj->isGroupEvent()){
            $groupId = $eventObj->getGroupId();  
            $userId = $eventObj->getUserId();  
            $sourceType = "GROUP";
        }
        // สร้างตัวแปรเก็บค่า roomId กรณีเป็น Event ที่เกิดขึ้นใน ROOM
        if($eventObj->isRoomEvent()){
            $roomId = $eventObj->getRoomId();        
            $userId = $eventObj->getUserId();      
            $sourceType = "ROOM";
        }
        // เก็บค่า sourceId ปกติจะเป็นค่าเดียวกันกับ userId หรือ roomId หรือ groupId ขึ้นกับว่าเป็น event แบบใด
        $sourceId = $eventObj->getEventSourceId();
        // ดึงค่า replyToken มาไว้ใช้งาน ทุกๆ Event ที่ไม่ใช่ Leave และ Unfollow Event และ  MemberLeft
        // replyToken ไว้สำหรับส่งข้อความจอบกลับ 
        if(is_null($eventLeave) && is_null($eventUnfollow) && is_null($eventMemberLeft)){
            $replyToken = $eventObj->getReplyToken();    
        }
         
        ////////////////////////////  ส่วนของการทำงาน
        include_once("bot_action.php");
        //////////////////////////
         
        $response = $bot->replyMessage($replyToken,$replyData);
        if ($response->isSucceeded()) {
            echo 'Succeeded!';
            // return;
        }
        // Failed
        echo $response->getHTTPStatus() . ' ' . $response->getRawBody();
    }

?>