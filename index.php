<?php

define('API_KEY', '1297794420:AAGqPUEDc0rkogT36ocpaYdI4MDCQKYdOkE');

function bot($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}
function sendmessage($chat_id, $text){
 bot('sendMessage',[
 'chat_id'=>$chat_id,
 'text'=>$text,
 'parse_mode'=>"MarkDown"
 ]);
 } 
function objectToArrays($object)
    {
        if (!is_object($object) && !is_array($object)) {
            return $object;
        }
        if (is_object($object)) {
            $object = get_object_vars($object);
        }
        return array_map("objectToArrays", $object);
    }

$update = json_decode(file_get_contents('php://input'));
$message = $update->message; 
$oyatillo="api.mostafa-am.ir";
$chat_id = $message->chat->id;
$text = $message->text;
$inline = $update->inline_query->query;

if($text == '/start'){
bot('sendMessage',[
 'chat_id'=>$chat_id,
 'text'=>"☝ Assalomu alaykum bu bot sizga o'zingiz haqingizda ma'lumot beradi",
 'parse_mode'=>"MarkDown",
 'reply_markup'=>json_encode([
            'inline_keyboard'=>[
              [['text' => "🔱 Men haqimda", 'switch_inline_query' => "haqida"]]
              ]
        ])
 ]);
}
if($inline) {
$ali1 = json_decode(file_get_contents("http://$oyatillo/painting-name/$inline"));
    $tik2 = objectToArrays($ali1);
    $ok = $tik2["result"];  
    $a2 = $ok["0"]["name"];
    $a3 = $ok["1"]["name"];
    $a4 = $ok["2"]["name"];
   $a5 = $ok["3"]["name"];
  $a6 = $ok["4"]["name"];
  $a7 = $ok["5"]["name"];
 $a8 = $ok["6"]["name"];
$a9 = $ok["7"]["name"];
$a10 = $ok["8"]["name"];
$a11 = $ok["9"]["name"];
$a12 = $ok["10"]["name"];
     bot('answerInlineQuery', [
        'inline_query_id' => $update->inline_query->id,
        'results' => json_encode([[
            'type' => 'article',
            'thumb_url'=>"http://tikappteam.ir/t/t.jpg",
            'id' => base64_encode(rand(5,555)),
            'title' => "$a2",
            'input_message_content' => ['parse_mode' => 'HTML', 'message_text' => "$a2"],
        ],[
            'type' => 'article',
            'thumb_url'=>"http://tikappteam.ir/t/t.jpg",
            'id' => base64_encode(rand(5,555)),
            'title' => "$a3",
            'input_message_content' => ['parse_mode' => 'HTML', 'message_text' => "$a3"],
        ],[
            'type' => 'article',
            'thumb_url'=>"http://tikappteam.ir/t/t.jpg",
            'id' => base64_encode(rand(5,555)),
            'title' =>"$a4",
            'input_message_content' => ['parse_mode' => 'HTML', 'message_text' => "$a4"],
        ],[
            'type' => 'article',
            'thumb_url'=>"http://tikappteam.ir/t/t.jpg",
            'id' => base64_encode(rand(5,555)),
            'title' => "$a5",
            'input_message_content' => ['parse_mode' => 'HTML', 'message_text' => "$a5"],
        ],[
            'type' => 'article',
            'thumb_url'=>"http://tikappteam.ir/t/t.jpg",
            'id' => base64_encode(rand(5,555)),
            'title' => "$a6",
            'input_message_content' => ['parse_mode' => 'HTML', 'message_text' => "$a6"],
        ],[
            'type' => 'article',
            'thumb_url'=>"http://tikappteam.ir/t/t.jpg",
            'id' => base64_encode(rand(5,555)),
            'title' => "$a7",
            'input_message_content' => ['parse_mode' => 'HTML', 'message_text' => "$a7"],
        ],[
            'type' => 'article',
            'thumb_url'=>"http://tikappteam.ir/t/t.jpg",
            'id' => base64_encode(rand(5,555)),
            'title' =>"$a8",
            'input_message_content' => ['parse_mode' => 'HTML', 'message_text' => "$a8"],
        ],[
            'type' => 'article',
            'thumb_url'=>"http://tikappteam.ir/t/t.jpg",
            'id' => base64_encode(rand(5,555)),
            'title' =>"$a9",
            'input_message_content' => ['parse_mode' => 'HTML', 'message_text' => "$a9"],
        ],[
            'type' => 'article',
            'thumb_url'=>"http://tikappteam.ir/t/t.jpg",
            'id' => base64_encode(rand(5,555)),
            'title' =>"$a10",
            'input_message_content' => ['parse_mode' => 'HTML', 'message_text' => "$a10"],
        ],[
            'type' => 'article',
            'thumb_url'=>"http://tikappteam.ir/t/t.jpg",
            'id' => base64_encode(rand(5,555)),
            'title' => "$a10",
            'input_message_content' => ['parse_mode' => 'HTML', 'message_text' => "$a12"],
        ]])
    ]);
}

?>
