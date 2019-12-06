<?php

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

// define("siam", "Too Fast To Sleep\nสยาม");
// define("swu", "Too Fast To Sleep\nมศว");
// define("sasin", "Too Fast Coffee\nศศินทร์");
// define("samyan", "Too Fast To Sleep\nสามย่าน");
// define("ku", "Too Fast To Sleep\nเกษตร");
// define("salaya", "Too Fast To Sleep\nศาลายา");
// define("cmu", "Too Fast To Sleep\nเชียงใหม่");

define("directdebit", "SCB Direct Debit/ATM");
define("linepay", "Rabbit LINE Pay");
define("promptpay", "PromptPay");


function make_reciept($order){

    \PHPQRCode\QRcode::png('CC'.$order["doc_no"], 'images/CC'.$order["doc_no"].'.png', 'L', 4, 2);

    $order_items = $order["order_items"];
    $promo = [];
    $total = number_format(intval($order["total_price"]), 2, '.', '');
    $vatable = number_format($total*100/107, 2, '.', '');
    $vat = number_format($total - $vatable, 2, '.', '');
    $sub_total = number_format(intval($order["old_total_price"]), 2, '.', '');
    $promo_used = false;
    

    foreach ($order_items as $value) {
        $topping = [];       
        $product_name = $value["name"];
        // $product_name = str_replace("  "," ", $product_name);

        foreach ($value["order_item_toppings"] as $value_topping) {
            $topping[] = new BoxComponentBuilder(
                "horizontal",
                array(
                    new TextComponentBuilder("             - x".$value_topping["amount"]."   ". $value_topping["name"], 5, NULL, "xs", "start", NULL, TRUE, NULL, NULL,"#bdbdbd"),
                    new TextComponentBuilder($value_topping["price"]."  ", 1, NULL, "xs", "end", NULL, TRUE, NULL, NULL,"#bdbdbd")
                )
            );
        }

        if(sizeof($value["promotion_used"]) > 0){
            $promo_used = true;
            foreach (array_combine($value["promotion_used"], $value["promotion_price"]) as $promo_meta => $promo_value){
                # code...
                $promo[] = new BoxComponentBuilder(
                    "horizontal",
                    array(
                        new TextComponentBuilder("        - ". $promo_meta, 0, NULL, "xs", "end", NULL, TRUE, NULL, NULL,"#ff8c00"),
                        new TextComponentBuilder(str_replace("|","", $promo_value)."  ", NULL, NULL, "xs", "end", NULL, TRUE, NULL, NULL,"#ff8c00")
                    )
                );
            }
        }


        $arr[] = new BoxComponentBuilder(
                "horizontal",
                array(
                    new TextComponentBuilder("   x".$value["amount"]. " ", 1, NULL, "xs", "start", NULL, TRUE, NULL, NULL,"#111111"),
                    new TextComponentBuilder($product_name." ".$value["recipe_type_name"]." ".$value["recipe_name"], 4, NULL, "xs", NULL, NULL, TRUE, NULL, NULL,"#555555"),
                    new TextComponentBuilder($value["price"]."  ", 1, NULL, "xs", "end", NULL, TRUE, NULL, NULL,"#111111")
                )
            );

        if(sizeof($topping) > 0){
            $arr[] = new BoxComponentBuilder(
                    "vertical",
                    $topping
                );
        }
    }

    $arr[] = new SeparatorComponentBuilder("xl");

    $arr[] = new BoxComponentBuilder(
                "horizontal",
                array(
                    new TextComponentBuilder("   "."Subtotal", 0, NULL, "xs", NULL, NULL, NULL, NULL, NULL,"#555555"),
                    new TextComponentBuilder(sizeof($order_items)." ", 1, "md", "xs", "end", NULL, NULL, NULL, NULL,"#111111"),
                    new TextComponentBuilder($sub_total."  ", NULL, NULL, "xs", "end", NULL, NULL, NULL, NULL,"#111111")
                )
            );


    if($promo_used){

        $total_str = "Total";

        $arr[] = new BoxComponentBuilder(
                    "vertical",
                    array(
                        new TextComponentBuilder("   "."Discounts", 0, NULL, "xs", NULL, NULL, TRUE, NULL, NULL,"#555555"),
                    )
                );

        $arr[] = new BoxComponentBuilder(
                    "vertical",
                    $promo
                );

    }else{
        $total_str = "Total";
    }

    $arr[] = new BoxComponentBuilder(
                "horizontal",
                array(
                    new TextComponentBuilder("   "."Vatable", 0, NULL, "xs", NULL, NULL, TRUE, NULL, NULL,"#555555"),
                    new TextComponentBuilder($vatable."  ", NULL, NULL, "xs", "end", NULL, TRUE, NULL, NULL,"#111111")
                )
            );

    $arr[] = new BoxComponentBuilder(
                "horizontal",
                array(
                    new TextComponentBuilder("   "."Vat", 0, NULL, "xs", NULL, NULL, TRUE, NULL, NULL,"#555555"),
                    new TextComponentBuilder($vat."  ", NULL, NULL, "xs", "end", NULL, TRUE, NULL, NULL,"#111111")
                )
            );

    $arr[] = new BoxComponentBuilder(
                "horizontal",
                array(
                    new TextComponentBuilder("   ".$total_str, 0, NULL, "xs", NULL, NULL, TRUE, NULL, "bold","#555555"),
                    new TextComponentBuilder($total."  ", NULL, NULL, "xs", "end", NULL, TRUE, NULL, "bold","#111111")
                )
            );
    $arr[] = new SeparatorComponentBuilder("xl");

    $arr[] = new BoxComponentBuilder(
                "horizontal",
                array(
                    new TextComponentBuilder("   "."Order ID", 0, NULL, "xs", NULL, NULL, TRUE, NULL, NULL,"#aaaaaa"),
                    new TextComponentBuilder($order["doc_no"]."  ", NULL, NULL, "xs", "end", NULL, TRUE, NULL, NULL,"#aaaaaa")
                )
            );
    $arr[] = new BoxComponentBuilder(
                "horizontal",
                array(
                    new TextComponentBuilder("   "."Payment Type", 0, NULL, "xs", NULL, NULL, TRUE, NULL, NULL,"#aaaaaa"),
                    new TextComponentBuilder(constant($order["payment_type"])."  ", NULL, NULL, "xs", "end", NULL, TRUE, NULL, NULL,"#aaaaaa")
                )
            );


    $arr[] = new BoxComponentBuilder(
                "vertical",
                array(
                    new TextComponentBuilder("คิวที่ ".$order["queue_no"], NULL, "xxl", "lg", "center", NUll, true, NULL, "bold"),
                )
            );





    $arr[] = new BoxComponentBuilder(
                "vertical",
                array(
                    new ImageComponentBuilder("https://appline.cctfts.com:8001/images/".'CC'.$order["doc_no"].'.png', NULL, "xxl", NULL, NULL, "md", NULL, "cover")
                )
            );

    $arr[] = new BoxComponentBuilder(
                "vertical",
                array(
                    new TextComponentBuilder("You can recieve the order by using this QRcode", NULL, "xxl", "xs", "center", NULL, TRUE, NULL, NULL,"#aaaaaa")
                )
            );



    $textReplyMessage = new BubbleContainerBuilder(
        "ltr",NULL,NULL,
        new BoxComponentBuilder(
            "vertical",
            array(
                new ImageComponentBuilder("https://appline.cctfts.com:8001/images/ico.png?v=123", NULL, NULL, NULL, NULL, "sm", NULL, "cover"),
                //                          text   flex  margin size align gravt  wrap maxLi  weight  color
                // new TextComponentBuilder("Too Fast To Sleep", NULL, "md", "lg", "center", NUll, NULL, NULL, "bold"),
                new TextComponentBuilder(constant($order["branch"]), NULL, NULL, "lg", "center", NUll, true, NULL, "bold"),
                new SeparatorComponentBuilder()
            )
        ),
         new BoxComponentBuilder(
            "vertical",
            $arr,
            NULL,
            "sm",
            "xs"
        )

    );

    $replyData = new FlexMessageBuilder("This is a Flex Message",$textReplyMessage);

    return $replyData;
}


?>