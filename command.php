<?php

include_once("line_lib.php");


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

case (preg_match("/[^0-9]/", $userMessage) ? true : false):

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