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

      $respRichMenu = $bot->linkRichMenu($userId,"richmenu-c23206d2a8500d452551b52271125458");

      $greetMSG = "สวัสดีค่ะ คุณ{$profile['displayName']} \n
ขอบคุณที่เป็นเพื่อนกับทูฟาสออเดอร์นะคะ \u{100079}\n
เราจะทำให้การสั่งอาหารของคุณ ไม่ต้องรอนานอีกต่อไป \u{100037}";

      $replyData = new MultiMessageBuilder();
      $replyData -> add(new TextMessageBuilder($greetMSG))
                 -> add(new StickerMessageBuilder(1, 4))
                 -> add(new VideoMessageBuilder("https://storage.googleapis.com/toofast-bucket/video%20cc2/ccamazon.mp4", "https://storage.googleapis.com/toofast-bucket/video%20cc2/ccamazon_Moment.jpg"))
                 -> add(new TextMessageBuilder("สำหรับขั้นตอนการสั่งเครื่องดื่มผ่าน LineOrder\nสามารถดูตาม video ด้านบนได้เลยจ้า \u{10002E}"));
                
    }
     
    // ถ้า bot ถูกบล็อก หรือเลิกติดตาม จะไม่สามารถส่งข้อความกลับได้ เนื่องจากไม่มี replyToken
    if(!is_null($eventUnfollow)){
 
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
                        case "update" :
                          $respRichMenu = $bot->linkRichMenu($userId,"richmenu-c23206d2a8500d452551b52271125458");
                          error_log(json_encode($respRichMenu));
                          if(json_encode($respRichMenu) == "{}"){
                            $textReplyMessage = "อัพเดทระบบเรียบร้อยแล้ว";
                          }else{
                            $textReplyMessage = "ไม่สามารถอัพเดทระบบได้ในขณะนี้ โปรดติดต่อผู้พัฒนาระบบ";
                          }
                          $replyData = new TextMessageBuilder($textReplyMessage);  
                          break;

                        case "อัพเดท" :
                          $respRichMenu = $bot->linkRichMenu($userId,"richmenu-c23206d2a8500d452551b52271125458");
                          error_log(json_encode($respRichMenu));
                          if(json_encode($respRichMenu) == "{}"){
                            $textReplyMessage = "อัพเดทระบบเรียบร้อยแล้ว";
                          }else{
                            $textReplyMessage = "ไม่สามารถอัพเดทระบบได้ในขณะนี้ โปรดติดต่อผู้พัฒนาระบบ";
                          }
                          $replyData = new TextMessageBuilder($textReplyMessage);  
                          break;


                        case "promotion" :

                          $img_url = "https://storage.googleapis.com/toofast-bucket/promote/too%20fast%20order%20%E0%B9%82%E0%B8%9B%E0%B8%A3%E0%B9%82%E0%B8%A1%E0%B8%97.png";
                          $replyData = new LINE\LINEBot\MessageBuilder\ImageMessageBuilder($img_url, $img_url);

                          break;

                        case "history" :

                          break;

                        case "queue" :

                          break;

                        case "fl": // ส่วนทดสอบโต้ตอบข้อควมม flex
                            $textReplyMessage = new BubbleContainerBuilder(
                                "ltr",NULL,NULL,
                                new BoxComponentBuilder(
                                    "vertical",
                                    array(
                                        new TextComponentBuilder("hello"),
                                        new TextComponentBuilder("world")
                                    )
                                )
                            );
                            $replyData = new FlexMessageBuilder("This is a Flex Message",$textReplyMessage);                                                                
                            break;


                        case (preg_match('/(q_)/', $userMessage) ? true : false):

                            $paramBranch = explode("_",$userMessage);
                            $url = "https://cctfts.com/api/v2/".$paramBranch[1]."/queue/queues";

                            $replyData = new TextMessageBuilder($url);  

                        break;


                        case (preg_match('/^cr-/',$userMessage) ? true : false):
                            $paramRichMenu = explode(">",$userMessage);
                            if(!isset($paramRichMenu) || !is_array($paramRichMenu) || count($paramRichMenu)<3){
                                exit;
                            }
                            $patternSet = $paramRichMenu[0];
                            $numberID = $paramRichMenu[1];
                            $actionSet = $paramRichMenu[2];
                            $actionArr_prepare = array();
                            if(isset($actionSet)){
                                $actionArr_prepare = explode(")",$actionSet);
                                array_pop($actionArr_prepare);
                            }
                            $imgTypePattern = str_replace("cr-","",$patternSet);
                            $areaBound_arr = array(
                                "a"=>array(0,0,833,843),
                                "b"=>array(833,0,833,843),
                                "c"=>array(1666,0,834,843),
                                "d"=>array(0,843,833,843),
                                "e"=>array(833,843,833,843),
                                "f"=>array(1666,843,834,843),
                                "g"=>array(0,0,1250,843),
                                "h"=>array(1250,0,1250,843),
                                "i"=>array(0,843,1250,843),
                                "j"=>array(1250,843,1250,843),
                                "k"=>array(0,0,2500,843),
                                "l"=>array(0,0,1666,1686),
                                "m"=>array(0,843,2500,843),
                                "n"=>array(0,0,1250,1686),
                                "o"=>array(1250,0,1250,1686),
                                "p"=>array(0,0,2500,1686)
                            );
                            $imgTypePatternArea_arr = array(
                                "1"=>array("a","b","c","d","e","f"),
                                "2"=>array("g","h","i","j"),
                                "3"=>array("k","d","e","f"),
                                "4"=>array("l","c","f"),
                                "5"=>array("k","m"),
                                "6"=>array("n","o"),
                                "7"=>array("p")
                            );
                             
                            function makeFRM($imgType){
                                global $areaBound_arr,$imgTypePatternArea_arr,$actionSet,$actionArr_prepare;
                                $dataArr = array();
                                $Area_arr = $imgTypePatternArea_arr[$imgType];
                                for($i=1;$i<=count($imgTypePatternArea_arr[$imgType]);$i++){                                 
                                    if(preg_match('/^p\(/',$actionArr_prepare[$i-1])){
                                        list($ac,$data) = explode("(",$actionArr_prepare[$i-1]);
                                        $actionVal = new PostbackTemplateActionBuilder('p',$data);
                                    }elseif(preg_match('/^m\(/',$actionArr_prepare[$i-1])){
                                        list($ac,$data) = explode("(",$actionArr_prepare[$i-1]);
                                        $actionVal = new MessageTemplateActionBuilder('m',$data);                                   
                                    }elseif(preg_match('/^u\(/',$actionArr_prepare[$i-1])){
                                        list($ac,$data) = explode("(",$actionArr_prepare[$i-1]);
                                        $actionVal = new UriTemplateActionBuilder('u',$data);   
                                    }elseif(preg_match('/^c\(/',$actionArr_prepare[$i-1])){
                                        list($ac,$data) = explode("(",$actionArr_prepare[$i-1]);
                                        $actionVal = new UriTemplateActionBuilder('u',"line://nv/camera/");     
                                    }elseif(preg_match('/^cs\(/',$actionArr_prepare[$i-1])){
                                        list($ac,$data) = explode("(",$actionArr_prepare[$i-1]);
                                        $actionVal = new UriTemplateActionBuilder('u',"line://nv/cameraRoll/single/");  
                                    }elseif(preg_match('/^cm\(/',$actionArr_prepare[$i-1])){
                                        list($ac,$data) = explode("(",$actionArr_prepare[$i-1]);
                                        $actionVal = new UriTemplateActionBuilder('u',"line://nv/cameraRoll/multi/");                                                       
                                    }elseif(preg_match('/^l\(/',$actionArr_prepare[$i-1])){
                                        list($ac,$data) = explode("(",$actionArr_prepare[$i-1]);
                                        $actionVal = new UriTemplateActionBuilder('u',"line://nv/location");                                            
                                    }elseif(preg_match('/^d\(/',$actionArr_prepare[$i-1])){
                                        list($ac,$data) = explode("(",$actionArr_prepare[$i-1]);
                                        $actionVal = new DatetimePickerTemplateActionBuilder('d',$data,'datetime');
                                    }elseif(preg_match('/^n\(/',$actionArr_prepare[$i-1])){
                                        $actionVal = NULL;
                                        continue;
                                    }else{
                                        $actionVal = NULL;
                                        continue;
                                    }
                                    $patternLetter = $Area_arr[$i-1];
                                    array_push($dataArr,
                                            new RichMenuAreaBuilder(
                                                new RichMenuAreaBoundsBuilder(...$areaBound_arr[$patternLetter]),$actionVal
                                            )                   
                                    );
                                }
                                return $dataArr;                        
                            }
//                          $arrayRichMenu = makeFRM();
                            // $sizeBuilder, $selected, $name, $chatBarText, $areaBuilders // 1686, 843.  // 2500
                            // ($x, $y, $width, $height)
                            $_idRichMenu = $imgTypePattern."-".$numberID;
                            $respRichMenu = $bot->createRichMenu(
                                new RichMenuBuilder(
                                    new RichMenuSizeBuilder(1686,2500),true,"Rich Menu $_idRichMenu",
                                    "เมนู",
                                    makeFRM($imgTypePattern)
                                )
                            );
                            // ทำอื่นๆ 
                            $textReplyMessage = " การสร้าง Rich Menu ".$respRichMenu->getRawBody()." Res = ".json_encode($dataArr);
                            $replyData = new TextMessageBuilder($textReplyMessage);                                     
                            break;                              
                                                                                      
                        case "ot":
                            // ทำอื่นๆ 
                            break;
                        case "l": // เงื่อนไขทดสอบถ้ามีใครพิมพ์ L ใน GROUP / ROOM แล้วให้ bot ออกจาก GROUP / ROOM
                                $sourceId = $eventObj->getEventSourceId();
                                if($eventObj->isGroupEvent()){
                                    $bot->leaveGroup($sourceId);
                                }
                                if($eventObj->isRoomEvent()){
                                    $bot->leaveRoom($sourceId);  
                                }                                                                                         
                            break;                          
                        case "qr":
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
                        $respRichMenu = $bot->linkRichMenu($userId,"richmenu-c23206d2a8500d452551b52271125458");
                        $url = "https://bots.dialogflow.com/line/80a5e0d6-016f-46f5-b8b8-0302c02896b3/webhook";
                        $headers = getallheaders();
            //          file_put_contents('headers.txt',json_encode($headers, JSON_PRETTY_PRINT));          
            //          file_put_contents('body.txt',file_get_contents('php://input'));
                        $headers['Host'] = "bots.dialogflow.com";
                        $json_headers = array();
                        foreach($headers as $k=>$v){
                            $json_headers[]=$k.":".$v;
                        }
                        $inputJSON = file_get_contents('php://input');
                        // // ส่วนของการส่งการแจ้งเตือนผ่านฟังก์ชั่น cURL
                        $ch = curl_init();
                        curl_setopt( $ch, CURLOPT_URL, $url);
                        curl_setopt( $ch, CURLOPT_POST, 1);
                        curl_setopt( $ch, CURLOPT_BINARYTRANSFER, true);
                        curl_setopt( $ch, CURLOPT_POSTFIELDS, $inputJSON);
                        curl_setopt( $ch, CURLOPT_HTTPHEADER, $json_headers);
                        curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 2); // 0 | 2 ถ้าเว็บเรามี ssl สามารถเปลี่ยนเป้น 2
                        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 1); // 0 | 1 ถ้าเว็บเรามี ssl สามารถเปลี่ยนเป้น 1
                        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
                        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
                        $result = curl_exec( $ch );
                        curl_close( $ch );
                        exit;       
                        break;                                      
                }
                break;                                                  
            default:
                if(!is_null($replyData)){
                     
                }else{
                    // กรณีทดสอบเงื่อนไขอื่นๆ ผู้ใช้ไม่ได้ส่งเป็นข้อความ
                    // $textReplyMessage = 'สวัสดีครับ คุณ '.$typeMessage;   
                    $textReplyMessage = '';      
                    $replyData = new TextMessageBuilder($textReplyMessage);         
                }
                break;  
        }
    }
}
?>