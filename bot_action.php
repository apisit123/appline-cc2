<?php
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

use LINE\LINEBot\Constant\Flex\ComponentIconSize;
use LINE\LINEBot\Constant\Flex\ComponentImageSize;
use LINE\LINEBot\Constant\Flex\ComponentImageAspectRatio;
use LINE\LINEBot\Constant\Flex\ComponentImageAspectMode;
use LINE\LINEBot\Constant\Flex\ComponentFontSize;
use LINE\LINEBot\Constant\Flex\BubleContainerSize;
use LINE\LINEBot\Constant\Flex\ComponentFontWeight;
use LINE\LINEBot\Constant\Flex\ComponentMargin;
use LINE\LINEBot\Constant\Flex\ComponentSpacing;
use LINE\LINEBot\Constant\Flex\ComponentButtonStyle;
use LINE\LINEBot\Constant\Flex\ComponentButtonHeight;
use LINE\LINEBot\Constant\Flex\ComponentSpaceSize;
use LINE\LINEBot\Constant\Flex\ComponentGravity;
use LINE\LINEBot\MessageBuilder\FlexMessageBuilder;
use LINE\LINEBot\MessageBuilder\Flex\BubbleStylesBuilder;
use LINE\LINEBot\MessageBuilder\Flex\BlockStyleBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ContainerBuilder\BubbleContainerBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ContainerBuilder\CarouselContainerBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\BoxComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\ButtonComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\IconComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\ImageComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\SpacerComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\FillerComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\SeparatorComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\TextComponentBuilder;
use LINE\LINEBot\MessageBuilder\Flex\ComponentBuilder\SpanComponentBuilder;

define("siam", "สยาม");
define("swu", "มศว");
define("sasin", "ศศินทร์");
define("samyan", "สามย่าน");
define("ku", "เกษตร");
define("salaya", "ศาลายา");
define("cmu", "เชียงใหม่");

define('RICHMENU', 'richmenu-c23206d2a8500d452551b52271125458');

 
// ส่วนของการทำงาน
if(!is_null($events)){

  $response = $bot->getProfile($userId);
  if ($response->isSucceeded()) {
      $profile = $response->getJSONDecodedBody();
      // echo $profile['displayName'];
      // echo $profile['pictureUrl'];
      // echo $profile['statusMessage'];
  }
 
    // ถ้า bot ถูก invite เพื่อเข้า Join Event ให้ bot ส่งข้อความใน GROUP ว่าเข้าร่วม GROUP แล้ว
    if(!is_null($eventJoin)){
        $textReplyMessage = "ขอเข้าร่วมด้วยน่ะ $sourceType ID:: ".$sourceId;
        $replyData = new TextMessageBuilder($textReplyMessage);                 
    }
     
    // ถ้า bot ออกจาก สนทนา จะไม่สามารถส่งข้อความกลับได้ เนื่องจากไม่มี replyToken
    if(!is_null($eventLeave)){


    }   
     
    // ถ้า bot ถูกเพื่มเป้นเพื่อน หรือถูกติดตาม หรือ ยกเลิกการ บล็อก
    if(!is_null($eventFollow)){

      $respRichMenu = $bot->linkRichMenu($userId,RICHMENU);

      $greetMSG = "สวัสดีค่ะ คุณ {$profile['displayName']} \n
ขอบคุณที่เป็นเพื่อนกับทูฟาสออเดอร์นะคะ \u{100079}";

      $replyData = new MultiMessageBuilder();
      $replyData  -> add(new TextMessageBuilder($greetMSG))
                  -> add(new VideoMessageBuilder("https://storage.googleapis.com/toofast-bucket/video%20cc2/ccamazon.mp4", "https://storage.googleapis.com/toofast-bucket/video%20cc2/ccamazon_Moment.jpg"))
                  -> add(new TextMessageBuilder("สำหรับขั้นตอนการสั่งเครื่องดื่มผ่าน Line@ Too Fast Order\nสามารถดูตาม video ด้านบนได้เลยจ้า \u{10002E}"))
                  -> add(new TextMessageBuilder("หากต้องการความช่วยเหลือเพิ่มเติมสามารถพิมพ์ \"help\" ได้เลย\nหรือติดต่อแคชเชียร์หน้าร้านเพื่อสอบถามข้อมูลหรือปัญหาต่างๆ"))
                  -> add(new ImagemapMessageBuilder(
                              "https://storage.googleapis.com/toofast-bucket/linebot/help_txt.png?_ignored=",
                              'HELP',
                              new BaseSizeBuilder(300,1040),
                              array(
                                new ImagemapMessageActionBuilder(
                                    'HELP',
                                    new AreaBuilder(0,0,1040,300)
                                    )
                              )
                            ));
                
    }
     
    // ถ้า bot ถูกบล็อก หรือเลิกติดตาม จะไม่สามารถส่งข้อความกลับได้ เนื่องจากไม่มี replyToken
    if(!is_null($eventUnfollow)){

        error_log("Unfollow event by id : ".$userId);
        error_log("................name : ".$profile);
        error_log("...............image : ".$profile['pictureUrl']);
 
        $replyData = new TextMessageBuilder("ขอบคุณที่เป็นเพื่อนกับเรานะคะ\nหากมีสิ่งใดที่ทำให้ลูกค้าไม่พึงพอใจ\nสามารถแจ้งได้ที่กล่องแสดงความคิดเห็นหน้าเคาเตอร์นะคะ");   
 
    }       
     
    // ถ้ามีสมาชิกคนอื่น เข้ามาร่วมใน room หรือ group 
    // room คือ สมมติเราคุยกับ คนหนึ่งอยู่ แล้วเชิญคนอื่นๆ เข้ามาสนทนาด้วย จะกลายเป็นห้องใหม่
    // group คือ กลุ่มที่เราสร้างไว้ มีชื่อกลุ่ม แล้วเราเชิญคนอื่นเข้ามาในกลุ่ม เพิ่มร่วมสนทนาด้วย
    if(!is_null($eventMemberJoined)){
            $arr_joinedMember = $eventObj->getEventBody();
            $joinedMember = $arr_joinedMember['joined']['members'][0];
            if(!is_null($groupId) || !is_null($roomId)){
                if($eventObj->isGroupEvent()){
                    foreach($joinedMember as $k_user=>$v_user){
                        if($k_user=="userId"){
                            $joined_userId = $v_user;
                        }
                    }                       
                    $response = $bot->getGroupMemberProfile($groupId, $joined_userId);
                }
                if($eventObj->isRoomEvent()){
                    foreach($joinedMember as $k_user=>$v_user){
                        if($k_user=="userId"){
                            $joined_userId = $v_user;
                        }
                    }                   
                    $response = $bot->getRoomMemberProfile($roomId, $joined_userId);    
                }
            }else{
                $response = $bot->getProfile($userId);
            }
            if ($response->isSucceeded()) {
                $userData = $response->getJSONDecodedBody(); // return array     
                // $userData['userId']
                // $userData['displayName']
                // $userData['pictureUrl']
                // $userData['statusMessage']
                $textReplyMessage = 'สวัสดีครับ คุณ '.$userData['displayName'];     
            }else{
                $textReplyMessage = 'สวัสดีครับ ยินดีต้อนรับ';
            }
//        $textReplyMessage = "ยินดีต้อนรับกลับมาอีกครั้ง ".json_encode($joinedMember);
        $replyData = new TextMessageBuilder($textReplyMessage);                     
    }
     
    // ถ้ามีสมาชิกคนอื่น ออกจากก room หรือ group จะไม่สามารถส่งข้อความกลับได้ เนื่องจากไม่มี replyToken
    if(!is_null($eventMemberLeft)){
     
    }   
 
    // ถ้ามีกาาเชื่อมกับบัญชี LINE กับระบบสมาชิกของเว็บไซต์เรา
    if(!is_null($eventAccountLink)){
        // หลักๆ ส่วนนี้ใช้สำรหบัเพิ่มความภัยในการเชื่อมบัญตี LINE กับระบบสมาชิกของเว็บไซต์เรา 
        $textReplyMessage = "AccountLink ทำงาน ".$replyToken." Nonce: ".$eventObj->getNonce();
        $replyData = new TextMessageBuilder($textReplyMessage);                         
    }
             
    // ถ้าเป็น Postback Event
    if(!is_null($eventPostback)){
        $dataPostback = NULL;
        $paramPostback = NULL;
        // แปลงข้อมูลจาก Postback Data เป็น array
        parse_str($eventObj->getPostbackData(),$dataPostback);
        // ดึงค่า params กรณีมีค่า params
        $paramPostback = $eventObj->getPostbackParams();
         
        $moreResult = "";
        // ส่วนทำงานสำหรับเชื่อม Rich Menu ไปยังผู้ใช้นั้นๆ
        if(isset($dataPostback['action']) && $dataPostback['action']=="more_richmenu"){
            $respRichMenu = $bot->linkRichMenu($userId,$dataPostback['richmenuid']);
            $moreResult = $respRichMenu->getRawBody();
            $result = json_decode($respRichMenu->getRawBody(),TRUE); 
        }       
        // ส่วนทำงานสำหรับยกเลิกการเชื่อมกับ Rich Menu ของ ผู้ใช้
        if(isset($dataPostback['action']) && $dataPostback['action']=="back_richmenu"){
            $respRichMenu = $bot->unlinkRichMenu($userId);
            $moreResult = $respRichMenu->getRawBody();
            $result = json_decode($respRichMenu->getRawBody(),TRUE); 
        }               
        // ส่วนทำงานสำหรับลบ Rich Menu
        if(isset($dataPostback['action']) && $dataPostback['action']=="delete_richmenu"){
            $respRichMenu = $bot->deleteRichMenu($dataPostback['richMenuId']);
            $moreResult = $respRichMenu->getRawBody();
            $result = json_decode($respRichMenu->getRawBody(),TRUE); 
        }
        // ส่วนทำงานสำหรับดูข้อมูลของ Rich Menu นั้นๆ
        if(isset($dataPostback['action']) && $dataPostback['action']=="get_richmenu"){
            $respRichMenu = $bot->getRichMenu($dataPostback['richMenuId']);
            $moreResult = $respRichMenu->getRawBody();
            $result = json_decode($respRichMenu->getRawBody(),TRUE); 
        }
        // ส่วนทำงานสำหรับกำหนดเป็น เมนูหลัก
        if(isset($dataPostback['action']) && $dataPostback['action']=="s_default_richmenu"){
            $respRichMenu = $httpClient->post("https://api.line.me/v2/bot/user/all/richmenu/".$dataPostback['richMenuId'],array());
            $moreResult = $respRichMenu->getRawBody();
            $result = json_decode($respRichMenu->getRawBody(),TRUE); 
        }   
        // ส่วนทำงานสำหรับยกเลิกเมนูหลัก    
        if(isset($dataPostback['action']) && $dataPostback['action']=="c_default_richmenu"){
            $respRichMenu = $httpClient->delete("https://api.line.me/v2/bot/user/all/richmenu");
            $moreResult = $respRichMenu->getRawBody();
            $result = json_decode($respRichMenu->getRawBody(),TRUE); 
        }           
        // ส่วนทำงานดึงข้อมูลเมนูหลัก หรือ Rich Menu ที่เป็นเมนูหลัก ถ้ามี
        if(isset($dataPostback['action']) && $dataPostback['action']=="g_default_richmenu"){
            $respRichMenu = $httpClient->get("https://api.line.me/v2/bot/user/all/richmenu");
            $moreResult = $respRichMenu->getRawBody();
            $result = json_decode($respRichMenu->getRawBody(),TRUE); 
        }       
        // ส่วนทำงานอัพโหลดรูปให้กับ Rich Menu  
        if(isset($dataPostback['action']) && $dataPostback['action']=="upload_richmenu"){
            $richMenuImg = str_replace('Rich Menu ','',$dataPostback['richMenuName']);
            if(!file_exists("rich-menu/rich-menu-0".$richMenuImg.".png")){
                $richMenuImg = substr(str_replace('Rich Menu ','',$dataPostback['richMenuName']),0,1);
            }
            $respRichMenu = $bot->uploadRichMenuImage($dataPostback['richMenuId'],"rich-menu/rich-menu-0".$richMenuImg.".png","image/png");
            $moreResult = $respRichMenu->getRawBody();
            $result = json_decode($respRichMenu->getRawBody(),TRUE); 
        }                   
         
        // ทดสอบแสดงข้อความที่เกิดจาก Postaback Event
        $textReplyMessage = "ข้อความจาก Postback Event Data : DataPostback = ";        
        $textReplyMessage.= json_encode($dataPostback);
        $textReplyMessage.= " ParamPostback = ".json_encode($paramPostback);
        $textReplyMessage.= " RsponseMore = ".$moreResult;
        $replyData = new TextMessageBuilder($textReplyMessage);     
    }
    // ถ้าเป้น Message Event 
    if(!is_null($eventMessage)){
         
        // สร้างตัวแปรเก็ยค่าประเภทของ Message จากทั้งหมด 7 ประเภท
        $typeMessage = $eventObj->getMessageType();  
        //  text | image | sticker | location | audio | video | file  
        // เก็บค่า id ของข้อความ
        $idMessage = $eventObj->getMessageId();          
        // ถ้าเป็นข้อความ
        if($typeMessage=='text'){
            $userMessage = $eventObj->getText(); // เก็บค่าข้อความที่ผู้ใช้พิมพ์
        }
        // ถ้าเป็น image
        if($typeMessage=='image'){
 
        }               
        // ถ้าเป็น audio
 
        if($typeMessage=='audio'){
 
        }       
        // ถ้าเป็น video
        if($typeMessage=='video'){
 
        }   
        // ถ้าเป็น file
        if($typeMessage=='file'){
            $FileName = $eventObj->getFileName();
            $FileSize = $eventObj->getFileSize();
        }               
        // ถ้าเป็น image หรือ audio หรือ video หรือ file และต้องการบันทึกไฟล์
        if(preg_match('/image|audio|video|file/',$typeMessage)){            
            $responseMedia = $bot->getMessageContent($idMessage);
            if ($responseMedia->isSucceeded()) {
                // คำสั่ง getRawBody() ในกรณีนี้ จะได้ข้อมูลส่งกลับมาเป็น binary 
                // เราสามารถเอาข้อมูลไปบันทึกเป็นไฟล์ได้
                $dataBinary = $responseMedia->getRawBody(); // return binary
                // ดึงข้อมูลประเภทของไฟล์ จาก header
                $fileType = $responseMedia->getHeader('Content-Type');    
                switch ($fileType){
                    case (preg_match('/^application/',$fileType) ? true : false):
//                      $fileNameSave = $FileName; // ถ้าต้องการบันทึกเป็นชื่อไฟล์เดิม
                        $arr_ext = explode(".",$FileName);
                        $ext = array_pop($arr_ext);
                        $fileNameSave = time().".".$ext;                            
                        break;                  
                    case (preg_match('/^image/',$fileType) ? true : false):
                        list($typeFile,$ext) = explode("/",$fileType);
                        $ext = ($ext=='jpeg' || $ext=='jpg')?"jpg":$ext;
                        $fileNameSave = time().".".$ext;
                        break;
                    case (preg_match('/^audio/',$fileType) ? true : false):
                        list($typeFile,$ext) = explode("/",$fileType);
                        $fileNameSave = time().".".$ext;                        
                        break;
                    case (preg_match('/^video/',$fileType) ? true : false):
                        list($typeFile,$ext) = explode("/",$fileType);
                        $fileNameSave = time().".".$ext;                                
                        break;                                                      
                }
                $botDataFolder = 'botdata/'; // โฟลเดอร์หลักที่จะบันทึกไฟล์
                $botDataUserFolder = $botDataFolder.$userId; // มีโฟลเดอร์ด้านในเป็น userId อีกขั้น
                if(!file_exists($botDataUserFolder)) { // ตรวจสอบถ้ายังไม่มีให้สร้างโฟลเดอร์ userId
                    mkdir($botDataUserFolder, 0777, true);
                }   
                // กำหนด path ของไฟล์ที่จะบันทึก
                $fileFullSavePath = $botDataUserFolder.'/'.$fileNameSave;
//              file_put_contents($fileFullSavePath,$dataBinary); // เอา comment ออก ถ้าต้องการทำการบันทึกไฟล์
                $textReplyMessage = "บันทึกไฟล์เรียบร้อยแล้ว $fileNameSave";
                $replyData = new TextMessageBuilder($textReplyMessage);
//              $failMessage = json_encode($fileType);              
//              $failMessage = json_encode($responseMedia->getHeaders());
                $replyData = new TextMessageBuilder($failMessage);                      
            }else{
                $failMessage = json_encode($idMessage.' '.$responseMedia->getHTTPStatus() . ' ' . $responseMedia->getRawBody());
                $replyData = new TextMessageBuilder($failMessage);          
            }
        }
        // ถ้าเป็น sticker
        if($typeMessage=='sticker'){
            $packageId = $eventObj->getPackageId();
            $stickerId = $eventObj->getStickerId();
        }
        // ถ้าเป็น location
        if($typeMessage=='location'){
            $locationTitle = $eventObj->getTitle();
            $locationAddress = $eventObj->getAddress();
            $locationLatitude = $eventObj->getLatitude();
            $locationLongitude = $eventObj->getLongitude();
        }       
         
         
        switch ($typeMessage){ // กำหนดเงื่อนไขการทำงานจาก ประเภทของ message
            case 'text':  // ถ้าเป็นข้อความ
                $userMessage = strtolower($userMessage); // แปลงเป็นตัวเล็ก สำหรับทดสอบ
                switch ($userMessage) {
                        case (preg_match('(update)', $userMessage) ? true : false):
                          $respRichMenu = $bot->linkRichMenu($userId,RICHMENU);
                          
                          if(json_encode($respRichMenu) == "{}"){
                            $textReplyMessage = "อัพเดทระบบเรียบร้อยแล้ว";
                          }else{
                            $textReplyMessage = "ไม่สามารถอัพเดทระบบได้ในขณะนี้ โปรดติดต่อผู้พัฒนาระบบ";
                          }
                          
                          $replyData = new MultiMessageBuilder();
                          $replyData  -> add(new TextMessageBuilder($textReplyMessage))
                                      -> add(new ImagemapMessageBuilder(
                              "https://storage.googleapis.com/toofast-bucket/linebot/call_richmenu.png?_ignored=",
                              'Update RichMenu',
                              new BaseSizeBuilder(1040,1040),
                              array(
                                new ImagemapMessageActionBuilder(
                                    '...',
                                    new AreaBuilder(0,0,1,1)
                                    )
                              )
                            ));
                          break;

                        case "promotion" :

                          $discount_line20 = "https://storage.googleapis.com/toofast-bucket/promote/too%20fast%20order%20%E0%B9%82%E0%B8%9B%E0%B8%A3%E0%B9%82%E0%B8%A1%E0%B8%97.png";
                          $tato_free_top = "https://storage.googleapis.com/toofast-bucket/Promotion/%E0%B8%8A%E0%B8%B2%E0%B8%99%E0%B8%A1%E0%B9%84%E0%B8%82%E0%B9%88%E0%B8%A1%E0%B8%B8%E0%B8%81.jpg";
                          $replyData = new MultiMessageBuilder();
                          $replyData -> add(new ImageMessageBuilder($discount_line20, $discount_line20))
                                     -> add(new ImageMessageBuilder($tato_free_top, $tato_free_top));

                          break;

                        case "history" :

                          $replyData = new TextMessageBuilder("ฟังก์ชัน \"history\" ยังไม่เปิดใช้บริการค่ะ"); 

                          break;

                        case "faq" :

                          $replyData = new TextMessageBuilder(""); 

                          break;

                        case "help" :
                          $imageMapUrl = 'https://storage.googleapis.com/toofast-bucket/linebot/help.png?_ignored=';

                          $replyData = new ImagemapMessageBuilder(
                              $imageMapUrl,
                              'HELP',
                              new BaseSizeBuilder(1040,1040),
                              array(
                                new ImagemapMessageActionBuilder(
                                    'How to order',
                                    new AreaBuilder(31,191,982,230)
                                    ),
                                new ImagemapMessageActionBuilder(
                                    'Solve RichMenu problem',
                                    new AreaBuilder(31,442,982,230)
                                    ),
                                new ImagemapMessageActionBuilder(
                                    'FAQ',
                                    new AreaBuilder(31,677,982,230)
                                    )
                              )
                            );
                          

                          break;

                        case "solve richmenu problem" :

                          $respRichMenu = $bot->linkRichMenu($userId,RICHMENU);
                          
                          if(json_encode($respRichMenu) == "{}"){
                            $textReplyMessage = "อัพเดทระบบเรียบร้อยแล้ว";
                          }else{
                            $textReplyMessage = "ไม่สามารถอัพเดทระบบได้ในขณะนี้ โปรดติดต่อผู้พัฒนาระบบ";
                          }
                          
                          $replyData = new MultiMessageBuilder();
                          $replyData  -> add(new TextMessageBuilder($textReplyMessage))
                                      -> add(new ImagemapMessageBuilder(
                              "https://storage.googleapis.com/toofast-bucket/linebot/call_richmenu.png?_ignored=",
                              'Update RichMenu',
                              new BaseSizeBuilder(1040,1040),
                              array(
                                new ImagemapMessageActionBuilder(
                                    '...',
                                    new AreaBuilder(0,0,1,1)
                                    )
                              )
                            ));


                          break;

                        case "how to order" :
                          $imageMapUrl = 'https://storage.googleapis.com/toofast-bucket/linebot/how_to_order.png?_ignored=';
                            
                            $replyData = new MultiMessageBuilder();
                            

                            $replyData -> add(new ImagemapMessageBuilder(
                                            $imageMapUrl,
                                            'HOW TO ORDER',
                                            new BaseSizeBuilder(1486,1040),
                                            array(
                                              new ImagemapMessageActionBuilder(
                                                  '...',
                                                  new AreaBuilder(0,0,1,1)
                                                  )
                                            )
                                          ))
                                      -> add(new ImagemapMessageBuilder(
                                          "https://storage.googleapis.com/toofast-bucket/linebot/PokeNowwwwwwwwwwwwwwwwwwwwwwwwww.png?_ignored=",
                                          'จิ้มเล๊ยยยยยยยยยยยยยยยยยยยยยยยยย',
                                          new BaseSizeBuilder(700,1040),
                                          array(
                                            new ImagemapUriActionBuilder(
                                                "line://app/1615865486-AoPxqqQr",
                                                new AreaBuilder(0,0,1040,700)
                                                )
                                          )
                                        ));
                          break;

                        case "queue" :

                          $imageMapUrl = 'https://storage.googleapis.com/toofast-bucket/linebot/queue.png?_ignored=';

                          $replyData = new MultiMessageBuilder();
                          $replyData -> add(new TextMessageBuilder("กรุณาเลือกสาขาที่ต้องการตรวจสอบจำนวนคิว"))
                                     -> add(new ImagemapMessageBuilder(
                              $imageMapUrl,
                              'Select Branch',
                              new BaseSizeBuilder(900,1040),
                              array(
                                  new ImagemapMessageActionBuilder(
                                      'QUEUE_SIAM',
                                      new AreaBuilder(530,189,500,150)
                                      ),
                                  new ImagemapMessageActionBuilder(
                                      'QUEUE_SWU',
                                      new AreaBuilder(10,190,500,150)
                                      ),
                                  new ImagemapMessageActionBuilder(
                                      'QUEUE_SASIN',
                                      new AreaBuilder(530,358,500,150)
                                      ),
                                  new ImagemapMessageActionBuilder(
                                      'QUEUE_SAMYAN',
                                      new AreaBuilder(10,360,500,150)
                                      ),
                                  new ImagemapMessageActionBuilder(
                                      'QUEUE_KU',
                                      new AreaBuilder(530,530,500,150)
                                      ),
                                  new ImagemapMessageActionBuilder(
                                      'QUEUE_SALAYA',
                                      new AreaBuilder(10,530,500,150)
                                      ),
                                  new ImagemapMessageActionBuilder(
                                      'QUEUE_CMU',
                                      new AreaBuilder(530,700,500,150)
                                      )

                              )));

                          break;


                          case "reciept":

                          $array = array("Jon","Smith");


                            $textReplyMessage = new BubbleContainerBuilder(
                                "ltr",NULL,NULL,
                                new BoxComponentBuilder(
                                    "vertical",
                                    array(
                                        //                          text   flex  margin size align gravt  wrap maxLi  weight  color
                                        new TextComponentBuilder("RECEIPT", NULL, NULL, "sm", NULL, NULL, NULL, NULL, "bold","#1DB446"),
                                        new TextComponentBuilder("Brown Store", NULL, "md", "xxl", NULL, NUll, NULL, NULL, "bold"),
                                        new TextComponentBuilder("Miraina Tower, 4-1-6 Shinjuku, Tokyo", NULL, NULL, "xs", NULL, NUll, true, NULL, NULL,"#aaaaaa"),
                                        new SeparatorComponentBuilder()
                                    )
                                ),
                                 new BoxComponentBuilder(
                                    "vertical",
                                    array(
                                        foreach($array as $value) {
                                            new BoxComponentBuilder(
                                                "horizontal",
                                                array(
                                                    new TextComponentBuilder($value, 0, NULL, "sm", NULL, NULL, NULL, NULL, NULL,"#555555"),
                                                    new TextComponentBuilder("$0.99", NULL, NULL, "sm", "end", NULL, NULL, NULL, NULL,"#111111")
                                                )
                                            ),
                                        }
                                        
                                    ),
                                    NULL,
                                    "sm",
                                    "xxl"
                                )
                            );
                            $replyData = new FlexMessageBuilder("This is a Flex Message",$textReplyMessage);



                          break;


                          case (preg_match('/(สั่ง)/', $userMessage) ? true : false):

                            $imageMapUrl = 'https://storage.googleapis.com/toofast-bucket/linebot/how_to_order.png?_ignored=';
                            
                            $replyData = new MultiMessageBuilder();
                            

                            $replyData -> add(new ImagemapMessageBuilder(
                                            $imageMapUrl,
                                            'HOW TO ORDER',
                                            new BaseSizeBuilder(1486,1040),
                                            array(
                                              new ImagemapMessageActionBuilder(
                                                  '...',
                                                  new AreaBuilder(0,0,1,1)
                                                  )
                                            )
                                          ))
                                      -> add(new ImagemapMessageBuilder(
                                          "https://storage.googleapis.com/toofast-bucket/linebot/PokeNowwwwwwwwwwwwwwwwwwwwwwwwww.png?_ignored=",
                                          'จิ้มเล๊ยยยยยยยยยยยยยยยยยยยยยยยยย',
                                          new BaseSizeBuilder(700,1040),
                                          array(
                                            new ImagemapUriActionBuilder(
                                                "line://app/1615865486-AoPxqqQr",
                                                new AreaBuilder(0,0,1040,700)
                                                )
                                          )
                                        ));                                      

                                        

                        break;


                        case (preg_match('/[0-9]/', $userMessage) ? true : false):

                            $imageMapUrl = 'https://storage.googleapis.com/toofast-bucket/linebot/how_to_order.png?_ignored=';
                            
                            $replyData = new MultiMessageBuilder();
                            

                            $replyData -> add(new ImagemapMessageBuilder(
                                            $imageMapUrl,
                                            'HOW TO ORDER',
                                            new BaseSizeBuilder(1486,1040),
                                            array(
                                              new ImagemapMessageActionBuilder(
                                                  '...',
                                                  new AreaBuilder(0,0,1,1)
                                                  )
                                            )
                                          ))
                                      -> add(new ImagemapMessageBuilder(
                                          "https://storage.googleapis.com/toofast-bucket/linebot/PokeNowwwwwwwwwwwwwwwwwwwwwwwwww.png?_ignored=",
                                          'จิ้มเล๊ยยยยยยยยยยยยยยยยยยยยยยยยย',
                                          new BaseSizeBuilder(700,1040),
                                          array(
                                            new ImagemapUriActionBuilder(
                                                "line://app/1615865486-AoPxqqQr",
                                                new AreaBuilder(0,0,1040,700)
                                                )
                                          )
                                        ));                                      

                                        

                        break;


                        case (preg_match('(wi)', $userMessage) ? true : false):
                            $replyData = new MultiMessageBuilder();
                            $replyData  -> add(new TextMessageBuilder("Line@ Too Fast Order เป็นระบบอัตโนมัติ"))
                                        -> add(new TextMessageBuilder("หากลูกค้าต้องการสอบถามรหัส wifi กรุณาติดต่อที่เคาน์เตอร์แคชเชียร์นะคะ"))
                                        -> add(new TextMessageBuilder("Too Fast Order ขอบคุณค่ะ"));
                        break;


                        case (preg_match('/(queue_)/', $userMessage) ? true : false):

                            $paramBranch = explode("_",$userMessage);
                            $url = "https://cctfts.com/api/v2/".$paramBranch[1]."/queue/queues";

                            $curl = curl_init();

                            curl_setopt_array($curl, array(
                              CURLOPT_URL => $url,
                              CURLOPT_RETURNTRANSFER => true,
                              CURLOPT_ENCODING => "",
                              CURLOPT_MAXREDIRS => 10,
                              CURLOPT_TIMEOUT => 30,
                              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                              CURLOPT_CUSTOMREQUEST => "GET"
                            ));

                            $response = curl_exec($curl);

                            $response = json_decode($response);
                            
                            $txt = "Inqueue \t\t : ".sizeof($response->queue->inqueue)." ออเดอร์\n"."cooking \t\t : ".sizeof($response->queue->cooking)." ออเดอร์\n"."done \t\t\t : ".sizeof($response->queue->done)." ออเดอร์\n";

                            
                            $replyData = new MultiMessageBuilder();
                            $replyData -> add(new TextMessageBuilder("สถานะคิวของสาขา ".constant($paramBranch[1])))
                                       -> add(new TextMessageBuilder($txt));

                        break;
                         
                        case "qrss":
                            $postback = new PostbackTemplateActionBuilder(
                                'Postback', // ข้อความแสดงในปุ่ม
                                http_build_query(array(
                                    'action'=>'buy',
                                    'item'=>100
                                )), // ข้อมูลที่จะส่งไปใน webhook ผ่าน postback event
                                 'Buy'  // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                            );
                            $txtMsg = new MessageTemplateActionBuilder(
                                'ข้อความภาษาไทย',// ข้อความแสดงในปุ่ม
                                'thai' // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                            );
                            $datetimePicker = new DatetimePickerTemplateActionBuilder(
                                'Datetime Picker', // ข้อความแสดงในปุ่ม
                                http_build_query(array(
                                    'action'=>'reservation',
                                    'person'=>5
                                )), // ข้อมูลที่จะส่งไปใน webhook ผ่าน postback event
                                'datetime', // date | time | datetime รูปแบบข้อมูลที่จะส่ง ในที่นี้ใช้ datatime
                                substr_replace(date("Y-m-d H:i"),'T',10,1), // วันที่ เวลา ค่าเริ่มต้นที่ถูกเลือก
                                substr_replace(date("Y-m-d H:i",strtotime("+5 day")),'T',10,1), //วันที่ เวลา มากสุดที่เลือกได้
                                substr_replace(date("Y-m-d H:i"),'T',10,1) //วันที่ เวลา น้อยสุดที่เลือกได้
                            );
                             
                            $quickReply = new QuickReplyMessageBuilder(
                                array(
                                    new QuickReplyButtonBuilder(new LocationTemplateActionBuilder('เลือกตำแหน่ง')),
                                    new QuickReplyButtonBuilder(new CameraTemplateActionBuilder('ถ่ายรูป')),
                                    new QuickReplyButtonBuilder(new CameraRollTemplateActionBuilder('เลือกรูปภาพ')),
                                    new QuickReplyButtonBuilder($postback),
                                    new QuickReplyButtonBuilder($datetimePicker),
                                    new QuickReplyButtonBuilder(
                                        $txtMsg,
                                        "https://www.ninenik.com/images/ninenik_page_logo.png"
                                    ),
                                )
                            );
                            $textReplyMessage = "ส่งพร้อม quick reply ";
                            $replyData = new TextMessageBuilder($textReplyMessage,$quickReply);                             
                            break;                                                                         
                    default:
                        $respRichMenu = $bot->linkRichMenu($userId,RICHMENU);

                        $replyData = new MultiMessageBuilder();
                        $replyData  -> add(new TextMessageBuilder("Line@ Too Fast Order เป็นระบบอัตโนมัติ"))
                                    -> add(new TextMessageBuilder("หากลูกค้ามีข้อสงสัยเพิ่มเติม กรุณาติดต่อที่ Cashier แต่ละสาขานะคะ ^^"))
                                    -> add(new TextMessageBuilder("สำหรับการจองห้องประชุม\n   - สามย่าน โทร 086-300-9955\n   - สยาม โทร 081-899-1551\n   - เกษตร โทร 097-158-9000\nสาขาอื่นๆ ที่ ศาลายา, มศว, เชียงใหม่\nทุกสาขาเปิด 24 ชั่วโมงค่ะ!"));
                        break;                                      
                }
                break;                                                  
            default:
                if(!is_null($replyData)){
                     
                }else{
                    // กรณีทดสอบเงื่อนไขอื่นๆ ผู้ใช้ไม่ได้ส่งเป็นข้อความ
                    // $textReplyMessage = 'สวัสดีครับ คุณ '.$typeMessage;   
                    $respRichMenu = $bot->linkRichMenu($userId,RICHMENU);
                    $textReplyMessage = '';      
                    $replyData = new TextMessageBuilder($textReplyMessage);         
                }
                break;  
        }
    }
}
?>