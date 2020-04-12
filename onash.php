<?php
define('API_KEY','990858867:AAFbugzeGNWbMQkShAHOjmGm_D5qHKLAvXs');
$admin = "621617473"; 
$kanali = "-1001153541413";
$kanal = "@dil_sozlarm";

function joinchat($from){
     global $message_id;
     $gett = bot('getChatMember',[
  'chat_id' =>"-1001153541413",
  'user_id' => $from,
  ]);
  $gget = $gett->result->status;
         if($gget=="creator" or $gget=="administrator" or $gget=="member"){
      return true;
         }else{
$de = bot("sendmessage",[
         "chat_id"=>$from,
         "text"=>"*Quyidagi kanalga obuna boʻling va mendan foydalaning!*",
         'parse_mode'=>'markdown',
         "reply_to_message_id"=>$mid,
"reply_markup"=>json_encode([
"inline_keyboard"=>[
[["text"=>"➕ A‘zo bo‘lish","url"=>"https://t.me/joinchat/AAAAAETBpSWxAFjppkDCow"],],
[["text"=>"✅ Tasdiqlash","callback_data"=>"join"],],
]
]),
]);  
 
return false;
}
}

function reyting($chat_id){
    $text = "🏆 <b>TOP 20 ta eng koʻp qo'shgan foydalanuvchilar:</b>\n\n";
    $daten = [];
    $rev = [];
    $fayllar = glob("./soni/*.*");
    foreach($fayllar as $file){
        if(mb_stripos($file,".txt")!==false){
        $value = file_get_contents($file);
        $id = str_replace(["./soni/",".txt"],["",""],$file);
        $daten[$value] = $id;
        $rev[$id] = $value;
        }
        echo $file;
    }

    asort($rev);
    $reversed = array_reverse($rev);
    for($i=0;$i<20;$i+=1){
        $order = $i+1;
        $id = $daten["$reversed[$i]"];
        $text.= "<b>{$order}</b>. <a href='tg://user?id={$id}'>{$id}</a> - "."<code>".$reversed[$i]."</code>"." <b>soʻm</b>"."\n";
    }
    return $text;
}

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


//METHOD
$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$mid = $message->message_id;
$chat_id = $message->chat->id;
$text = $message->text;
$name = $message->from->first_name;
$title = $message->chat->title;
$from_id = $update->message->from->id;
$cty = $message->chat->type;


//DATA
$data = $update->callback_query->data;
$chat_id2 = $update->callback_query->message->chat->id;
$fromid = $update->callback_query->message->from->id;
$message_id2 = $update->callback_query->message->message_id;
$cqid = $update->callback_query->id; 
$name2 = $update->callback_query->from->first_name;
$fadmin2 = $update->callback_query->from->id;

//CHANNEL
$chan  = $update->channel_post;
$ch_text = $chan->text;
$ch_photo = $chan->photo;
$ch_mid = $chan->message_id;
$ch_cid = $chan->chat->id;

$chpost = $update->channel_post;
$chuser = $chpost->chat->username;
$chpmesid = $chpost->message_id;
$chcaption = $chpost->caption;

//SOZ YODLASH
$replytx = $message->reply_to_message->text;
$url = $message->entities[0]->type;
$user =  $message->entities[1]->type;
$msgs = json_decode(file_get_contents('msgs.json'),true);

$guruhlar = file_get_contents("stat/group.list");
$userlar = file_get_contents("stat/user.list");
$kanallar = file_get_contents("stat/kanal.list");
$step = file_get_contents("stat/$chat_id.step");

$repid = $message->reply_to_message->from->id;
$repname = $message->reply_to_message->from->first_name;
mkdir("soni");
mkdir("soni/$chat_id");
$odam = file_get_contents("soni/$chat_id.txt");
$reply = $message->reply_to_message->text;

$photo = $message->photo;
$sticker = $message->sticker;
$audio = $message->audio;
$voice = $message->voice;
$video = $message->video;
$caption = $message->caption;
$performer = $message->performer;
$gif = $message->animation;
$doc = $message->document;
$forward_ch = $message->forward_from_chat;
$forward = $message->forward_from;

$new_chat_members = $message->new_chat_member->id;
$ismi = $message->new_chat_member->first_name;
$is_bot = $message->new_chat_member->is_bot;
 
 $info = file_get_contents("https://api.telegram.org/bot".API_KEY."/getMe");
$bot_user = json_decode($info)->result->username;
$bot_name = json_decode($info)->result->first_name;
$botid = json_decode($info)->result->id;
$bot_description = json_decode($info)->result->description;

$new = $message->new_chat_member;
$left= $message->left_chat_member;
$id = $message->reply_to_message->from->id;
$repname = $message->reply_to_message->from->first_name;



$key=json_encode([
        'resize_keyboard'=>true,
			'keyboard'=>[
				[['text'=>'💣Guruhga qoshish']], 
[['text'=>'📋 Malumot'],['text'=>'🛠Buyruqlar']],
[['text'=>'📚 Qiziqarli'],['text'=>'📊Statistika']]
			]
		]);
$orqa = json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"🔙Orqaga"],],
]
]);



		
if($text=="/rey" ){
$reyting = reyting();
bot("sendMessage",[
"chat_id"=>$chat_id,
"text"=>"$reyting",
"parse_mode"=>"html",
]);
}

		
if($replytx){
    if($cty=="supergroup"  or $cty=="group"){
   	$replytx = $message->reply_to_message->text;
   	      	if(strpos($msgs[$replytx],"$text") !==false){
   	}else{
		$msgs[$replytx] ="$text|$msgs[$replytx]";
		file_put_contents('msgs.json', json_encode($msgs));
	}
}
}

if($ch_cid){
$dat = file_get_contents("stat/user.dat");
if(mb_stripos($dat,$ch_cid) !== false){
}else{
file_put_contents("stat/user.dat", "$dat\n$ch_cid");
}
}
if(isset($text)){
$guruhlar = file_get_contents("stat/group.list");
if($cty == "group" or $cty == "supergroup"){
if(strpos($guruhlar,"$chat_id") !==false){
}else{
file_put_contents("stat/group.list","$guruhlar\n$chat_id");
}
} 
}
if(isset($text)){
$userlar = file_get_contents("stat/user.list");
if($cty=="private"){
if(strpos($userlar,"$chat_id") !==false){
}else{
file_put_contents("stat/user.list","$userlar\n$chat_id");
}
} 
}
if(isset($chpmesid) and (strtolower($chuser) == strtolower(str_replace("@","",$kanal)))){
unlink("news.dat");
file_put_contents("news.txt",$chpmesid);
$chm = file_get_contents("news.txt");
bot('forwardMessage', [
'chat_id'=>$admin,
'from_chat_id'=>$kanal,
'message_id'=>$chm,
]);
}



if($data=="join"){
$check1 = json_decode(file_get_contents("https://api.telegram.org/bot".API_KEY."/getChatMember?chat_id=$kanali&user_id=$chat_id2"))->result->status;
if($check1 != "member" && $check1 != "creator" && $check1 != "administrator"){
bot('answerCallbackQuery',[
'callback_query_id'=>$cqid,
'text'=>"🚫Kechirasiz ,

Siz Kanalimizga azo bolmadingiz",
'show_alert'=>true
]);
}else{
        bot("deleteMessage",[
"chat_id"=>$chat_id2,
"message_id"=>$message_id2,
]);
		bot('sendphoto',[ 
'photo' =>"https://t.me/hacker_progi/52884",
'chat_id'=>$chat_id2,
'message_id'=>$message_id2,
	'caption'=>"*🙋 Assalomu Aleykum* [$name2](tg://user?id=$chat_id2) , *Mening ismim Onashka🙋‍♀.*
	
 *Men guruhlarda gaplasha olaman va guruh adminlari uchun qulay bo‘lgan buyruqlar orqali guruhni boshqarishga ko‘maklashaman! *

*Meni guruhlarga qo'shing 💁 va Guruhingizga* /panel *buyug'ini yuboring*",
        'parse_mode'=>'markdown',
      'reply_markup'=>json_encode([
        'resize_keyboard'=>true,
			'keyboard'=>[
				[['text'=>'💣Guruhga qoshish']], 
[['text'=>'📋 Malumot'],['text'=>'🛠Buyruqlar']],
[['text'=>'☪Namoz vaqti⏰'],['text'=>'📊Statistika']]
			]
		]),
	]);
	bot('sendMessage', [
'chat_id'=>$chat_id2,
'message_id'=>$message_id2,
'text'=>"Salom, men guruhni qizdiraman va nazorat qilaman
*Meni guruhingizga qo‘shing! *

Guruhga qo'shish uchun 👇👇 bosing",
'parse_mode'=>'markdown',
'reply_markup'=>json_encode([
            'inline_keyboard'=>[
                [['text'=>"➕Guruhga qoshish",'url'=>"https://telegram.me/onashka_bot?startgroup=new"]],
            ]
        ])
]);
}
}


if($text== "/start" or $text == "/start@Onashka_bot"){
	if(joinchat($from_id)=="true"){
$chm = file_get_contents("news.txt");
bot('forwardMessage', [
'chat_id'=>$chat_id,
'from_chat_id'=>$kanali,
'message_id'=>$chm,
]);
if($cty == "supergroup" or $cty == "group"){
$st = bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=>"<b>Bot lichkasiga yozing!</b>",
'parse_mode' => 'markdown'
]);
  bot('deleteMessage', [
  'chat_id' => $chat_id,
  'message_id' => $mid,
  ]);
    $stt = $st->result->message_id;
  bot('deleteMessage',[
 'chat_id'=> $chat_id,
 'message_id'=>$stt,
]);
}else{
    bot('sendphoto',[ 
  'chat_id' => $chat_id,
'photo' =>"https://t.me/hacker_progi/52884",
'caption'=>"*🙋 Assalomu Aleykum* [$name](tg://user?id=$chat_id) , *Mening ismim Onashka🙋‍♀.*
	
 *Men guruhlarda gaplasha olaman va guruh adminlari uchun qulay bo‘lgan buyruqlar orqali guruhni boshqarishga ko‘maklashaman! *

*Meni guruhlarga qo'shing 💁 va Guruhingizga* /panel *buyug'ini yuboring*",
        'parse_mode'=>'markdown',
        'reply_markup'=>$key,
	]);
	bot('sendMessage', [
'chat_id'=>$chat_id,
'text'=>"Salom, men guruhni qizdiraman va nazorat qilaman
*Meni guruhingizga qo‘shing! *

Guruhga qo'shish uchun 👇👇 bosing",
'parse_mode'=>'markdown',
'reply_markup'=>json_encode([
            'inline_keyboard'=>[
                [['text'=>"➕Guruhga qoshish",'url'=>"https://telegram.me/onashka_bot?startgroup=new"]],
            ]
        ])
]);
   }
}    
}

if($text == "💣Guruhga qoshish"){
	if(joinchat($from_id)=="true"){
bot('sendMessage', [
'chat_id'=>$chat_id,
'text'=>"Salom, men guruhni qizdiraman va nazorat qilaman
*Meni guruhingizga qo‘shing! *

Guruhga qo'shish uchun 👇👇 bosing",
'parse_mode'=>'markdown',
'reply_markup'=>json_encode([
            'inline_keyboard'=>[
                [['text'=>"➕Guruhga qoshish",'url'=>"https://telegram.me/onashka_bot?startgroup=new"]],
            ]
        ])
]);
}
}
if($text== '🛠Buyruqlar'){
	if(joinchat($from_id)=="true"){
    bot('sendmessage',[
        'chat_id'=>$chat_id,
        'reply_to_message_id'=>$mid,
        'text'=>"*Guruh adminlari ishlatishi mumkin bo‘lgan buyruqlar:*

/panel ➖ *Guruhni sozlash;*

/ro ➖ *Guruh a‘zosini Read - Only rejimiga tushuradi;*
/unro ➖ *Guruh a‘zosidan cheklovni oladi;*
/kick ➖ *Guruh a‘zosini guruhdan chiqaradi;*
/warn ➖ *Guruh a‘zosiga ogohlantirish beradi va ogohlantirishlar soni 3 taga yetganda jazo sifatida guruhdan chiqaradi;*
/unwarn ➖ *Guruh a‘zosidagi  ogohlantirishlarni olib tashlaydi;*
/ban ➖ *Guruh a‘zosini guruhdan chiqaradi, boshqa qaytib kira olmaydi;*
/unban ➖ *Bandan oladi;*
/pin ➖ *Xabarni yuqoriga qistiradi;*
/admin ➖ *Guruh a‘zosini guruhga admin qiladi;*
/deladmin ➖ *Adminlikdan oladi*;
/leave ➖ *Bot guruhni tark etadi;*",
        'parse_mode'=>'markdown',
        'reply_markup'=>$orqa,
	]);
     }  
}
if($text == "📋 Malumot"){
	if(joinchat($from_id)=="true"){
bot('sendMessage', [
'chat_id'=>$chat_id,
'text'=>"⚠️ Qo'lanmani diqqat bilan o'qib chiqing iltimos, Tushnib oling va Botni to'liq ishlating!
👇 Qo'lanmani o'qish uchun pasdagi *KNOPKAGA* bosing!",
'parse_mode'=>'markdown',
'reply_markup'=>json_encode([
            'inline_keyboard'=>[
                [['text'=>"📖Qo'llanma",'url'=>"https://telegra.ph/Onashka-bot-Qollanmasi-04-01"]],
            ]
        ])
]);
}
}

if($text == '🔙Orqaga'){
	if(joinchat($from_id)=="true"){
    bot('sendphoto',[ 
  'chat_id' => $chat_id,
'photo' =>"https://t.me/hacker_progi/52884",
'caption'=>"*🙋 Assalomu Aleykum* [$name](tg://user?id=$chat_id) , *Mening ismim Onashka🙋‍♀.*
	
 *Men guruhlarda gaplasha olaman va guruh adminlari uchun qulay bo‘lgan buyruqlar orqali guruhni boshqarishga ko‘maklashaman! *

*Meni guruhlarga qo'shing 💁 va Guruhingizga* /panel *buyug'ini yuboring*",
        'parse_mode'=>'markdown',
        'reply_markup'=>$key,
	]);
	bot('sendMessage', [
'chat_id'=>$chat_id,
'text'=>"Salom, men guruhni qizdiraman va nazorat qilaman
*Meni guruhingizga qo‘shing! *

Guruhga qo'shish uchun 👇👇 bosing",
'parse_mode'=>'markdown',
'reply_markup'=>json_encode([
            'inline_keyboard'=>[
                [['text'=>"➕Guruhga qoshish",'url'=>"https://telegram.me/onashka_bot?startgroup=new"]],
            ]
        ])
]);
 }      
}
if($text == "📊Statistika"){
if(joinchat($from_id)=="true"){
$vaq = date("⏰H:i  📅d_m_Y",strtotime("3 hour"));
$dat = file_get_contents("stat/user.dat");
$gr = substr_count($guruhlar,"\n"); 
$us = substr_count($userlar,"\n"); 
$kn = substr_count($dat,"\n");
$obsh = $gr + $us + $kn;
     bot('sendMessage',[
     'chat_id'=>$chat_id,
     'text'=>"*
┌ 📊Botimiz natijalari
├ 👤A`zolar: *$us* dona
├ 👥Guruhlar: *$gr* dona
├📡 Kanallar: *$kn*
└ 🌍Hammasi bo'lib: *$obsh* dona *

➖➖➖➖➖➖➖
⏳ Bugun sana: [$vaq]",
     'parse_mode'=>'markdown',
             'reply_markup'=>$key,
     ]);
     }}



if($text == '📚 Qiziqarli'){
	if(joinchat($from_id)=="true"){
    bot('sendmessage',[
        'chat_id'=>$chat_id,
       'reply_to_message_id'=>$mid,
        'text'=>"Test rejimda😝",
        'parse_mode'=>'markdown',
        'reply_markup'=>$m,
	]);
 }      
}



if($new_chat_members == bot('getMe')->result->id){
    $get = bot('getChatMembersCount', ['chat_id' => $chat_id])->result;
    if ($get <= 20) {
        bot('sendMessage', [
            'chat_id' =>$chat_id,
            'text' => "Meni Guruhingizga qo'shishingiz uchun 20 kishidan koproq odam bolish kere🙁🖤",
        ]);
        bot('leaveChat', [
            'chat_id' => $chat_id
        ]);
    } else {
        bot('sendMessage', [
            'chat_id' => $chat_id,
            'text' => "🙋Salom barchaga endi men $title guruhi uchun xizmat qilaman
🤖Meni guruhingizga sozlash uchun /panel buyrug'ini yuboring!
💎Bosh homiy: [@Dil_Sozlarm]",
         'parse_mode' => 'markdown',
     'reply_markup'=>json_encode([
            'inline_keyboard'=>[
                [['text'=>"Dardlarim...😔","url"=>"https://t.me/joinchat/AAAAAETBpSWxAFjppkDCow"]],
            ]
        ])
]);
    }
}

if($new_chat_members == bot('getMe')->result->id){
    $get = bot('getChatMembersCount', ['chat_id' => $chat_id])->result;
$us = bot('getChatMembersCount',[
'chat_id'=>$chat_id,
]);
$count = $us->result;
    if ($get <= 50) {
          $input = array("💁 Gruppada aholi soni $count ta ekan, muncha kamchilimiza☹️","💁 Gruppada aholi soni $count ta ekan, o'ziyam chirigan gruppaga kirib qommanu 😆","💁 Gruppada aholi soni $count ta ekan, itam yo'ku gruppada😂");
  $rand=rand(0,3);
  $soz="$input[$rand]";
  $a=json_encode(bot('sendmessage',[
   'chat_id'=>$chat_id,
   'text'=>"$soz",
   'parse_mode'=> 'markdown'
        ]));
    } else {
        bot('sendMessage', [
            'chat_id' => $chat_id,
            'text' => "",
        ]);
    }
}

if(stristr($text,"ض") or stristr($text, 'ص') or stristr($text, 'ث') or stristr($text, 'ق') or stristr($text, 'ف') or stristr($text, 'غ') or stristr($text, 'ع') or stristr($text, 'ه') or stristr($text, 'خ') or stristr($text, 'ح') or stristr($text, 'ج') or stristr($text, 'ش') or stristr($text, 'س') or stristr($text, 'ي') or stristr($text, 'ب') or stristr($text, 'ل') or stristr($text, 'ا') or stristr($text, 'ت') or stristr($text, 'ن') or stristr($text, 'م') or stristr($text, 'ك') or stristr($text, 'ط') or stristr($text, 'ذ') or stristr($text, 'ء') or stristr($text, 'ؤ') or stristr($text, 'ر') or stristr($text, 'ى') or stristr($text, 'ئ') or stristr($text, 'ة') or stristr($text, 'و') or stristr($text, 'ز') or stristr($text, 'ظ') or stristr($text, 'د') or stristr($text, 'أ') or stristr($text, 'إ') or stristr($text, 'آ')){
bot('deletemessage',[
        'chat_id'=>$chat_id,
        'message_id'=>$mid,
      ]);
bot('restrictChatMember',[
        'chat_id'=>$chat_id,
        'user_id'=>$from_id,
        'until_date'=>strtotime("+ 30 minutes "),
      ]);

   bot('sendmessage',[
        'chat_id'=>$chat_id,
        'text'=>"<a href='tg://user?id=$from_id'>$name</a> Habarida Arab Harflari Qatnashgani Uchun MUTE Qilindi",
        'parse_mode'=>'html',
      ]);
  }


if((mb_stripos($text,"@") !==false) or (stripos($caption,"@")!==false) or (stripos($text,"@")!==false) or (stripos($text,"@")!==false)){
if($cty == "group" or $cty == "supergroup"){
$gett = bot('getChatMember', [
'chat_id' => $chat_id,
'user_id' => $from_id,
]);
$get = $gett->result->status;
if($get =="member"){
bot ('deleteMessage', [
'chat_id'=>$chat_id,
'message_id'=> $mid,
]);
$send = bot('SendMessage', [
'chat_id'=>$cid,
'text'=>"<a href='tg://user?id=$from_id'>$name</a>  😡<b>Kechirasiz bu guruhda ReklamA tashlash mumkin emas!\n\nChunki Guruhda</b> <a href='tg://user?id=$botid'>$bot_name</a><b>Bor</b>",
'parse_mode'=>"html",
     'reply_markup'=>json_encode([
            'inline_keyboard'=>[
                [['text'=>"Dardlarim...😔","url"=>"https://t.me/joinchat/AAAAAETBpSWxAFjppkDCow"]],
            ]
        ])
])->result->message_id;
sleep(30);
bot('deletemessage', [
'chat_id' => $chat_id, 
'message_id' => $send
]);
}}}





if(isset($new) or isset($left)){
    bot('deleteMessage',[
        'chat_id'=>$message->chat->id,
        'message_id'=>$message->message_id,
    ]);
}


if($text == "/ro" or $text == "Ro" or $text == "RO" or $text == "rO"){
$gett = bot('getChatMember', [
'chat_id' => $chat_id,
'user_id' => $from_id,
]);
$get = $gett->result->status;
if($get =="administrator" or $get == "creator"){
  $minut = strtotime("+120 minutes");
  bot('restrictChatMember', [
      'chat_id' => $chat_id,
      'user_id' => $id,
      'until_date' => $minut,
      'can_send_messages' => false,
      'can_send_media_messages' => false,
      'can_send_other_messages' => false,
      'can_add_web_page_previews' => false
  ]);
  bot('sendmessage', [
      'chat_id' => $chat_id,
      'text' => "<a href='tg://user?id=$id'>$repname</a> Siz <b>Read - Only</b> rejimiga tushirildingiz!",
      'parse_mode' => 'html'
  ]);
}
}

    if($text == "/Kick"  or  $text == "kick"  or $text == "/kick"){
$gett = bot('getChatMember', [
'chat_id' => $chat_id,
'user_id' => $from_id,
]);
$get = $gett->result->status;
if($get =="administrator" or $get == "creator"){
  $vaqti = strtotime("+1 minutes");
  bot('kickChatMember', [
      'chat_id' => $chat_id,
      'user_id' => $id,
      'until_date'=> $vaqti,
  ]);
  bot('unbanChatMember', [
        'chat_id' => $chat_id,
        'user_id' => $id,
    ]);
  bot('sendmessage', [
      'chat_id' => $chat_id,
      'text' => "<a href='tg://user?id=$id'>$repname</a> guruhdan <b>KICK</b> bo‘ldi!",
      'parse_mode' => 'html'
  ]);
}
}


if((stripos($text,"/panel")!==false) or (stripos($text,"/sozlama")!==false) or (stripos($text,"/warn")!==false) or (stripos($text,"/kick")!==false) or (stripos($text,"/unwarn")!==false) or (stripos($text,"/info")!==false) or (stripos($text,"/sozlamalar")!==false) or (stripos($text,"/ban")!==false) and $from_id !== $admin){
    $gett = bot('getChatMember', [
   'chat_id' => $chat_id,
   'user_id' => $from_id,
   ]);
  $get = $gett->result->status;
  if($get =="member"){
 $minut = strtotime("+1 minutes");
    bot('restrictChatMember', [
        'chat_id' => $chat_id,
        'user_id' => $from_id,
        'until_date' => $minut,
        'can_send_messages' => false,
        'can_send_media_messages' => false,
        'can_send_other_messages' => false,
        'can_add_web_page_previews' => false
    ]);
    bot('deleteMessage', [
       'chat_id' => $chat_id,
       'message_id' => $mid
    ]);
 $send = bot('sendmessage', [
        'chat_id' => $chat_id,
        'text' => "<a href='tg://user?id=$from_id'>$repname</a> <b>1 minut</b>ga <b>Read - Only</b> rejimiga tushdirildi.n<b>Sabab: admin buyruqlarini ishlatdi!</b> ",
        'parse_mode' => 'html',
    'disable_web_page_preview'=>true,
'reply_markup'=>json_encode([
'inline_keyboard' => [
[['text'=>'Kanalim❤','url'=>'https://t.me/joinchat/AAAAAETBpSWxAFjppkDCow']]
]
]),
])->result->message_id;
sleep(20);
bot('deletemessage', [
'chat_id' => $chat_id, 
'message_id' => $send
]);
}
}

 if($text == "/admin" or $text == "addpm"){
$gett = bot('getChatMember', [
'chat_id' => $chat_id,
'user_id' => $from_id,
]);
$get = $gett->result->status;
if($get =="administrator" or $get == "creator"){
  bot('promoteChatMember',[
    'chat_id'=>$chat_id,
    'user_id'=>$id,
    'can_change_info'=>true,
    'can_post_messages'=>false,
    'can_edit_messages'=>false,
    'can_delete_messages'=>true,
    'can_invite_users'=>true,
    'can_restrict_members'=>true,
    'can_pin_messages'=>true,
    'can_promote_members'=>false
  ]);
  bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"<a href='tg://user?id=$id'>$repname</a> Sizni tabriklayman, Siz endi guruh <b>administratorisiz❗️</b>",
    'parse_mode'=>'html'
  ]);
}
}

   if($text == "/deladmin" or $text == "delpm"){
$gett = bot('getChatMember', [
'chat_id' => $chat_id,
'user_id' => $from_id,
]);
$get = $gett->result->status;
if($get == "administrator" or $get == "creator"){
bot('promoteChatMember',[
    'chat_id'=>$chat_id,
    'user_id'=>$id,
    'can_change_info'=>false,
    'can_post_messages'=>false,
    'can_edit_messages'=>false,
    'can_delete_messages'=>false,
    'can_invite_users'=>false,
    'can_restrict_members'=>false,
    'can_pin_messages'=>false,
    'can_promote_members'=>false
  ]);
  bot('sendmessage',[
    'chat_id'=> $chat_id,
    'text'=>"<a href='tg://user?id=$id'>$repname</a> Siz endi guruh administratori <b>emassiz</b>❗️",
    'parse_mode'=>'html'
  ]);
}
}

  if($text == "/unro" or $text == "UNRO" or $text == "unro"){
 $gett = bot('getChatMember', [
'chat_id' => $chat_id,
'user_id' => $from_id,
]);
$get = $gett->result->status;
if($get =="administrator" or $get == "creator"){
  bot('restrictChatMember',[
    'chat_id'=>$chat_id,
    'user_id'=>$id,
    'can_send_messages'=>true,
    'can_send_media_messages'=>true,
    'can_send_other_messages'=>true,
    'can_add_web_page_previews'=>true
  ]);
  bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"<a href='tg://user?id=$id'>$repname</a> Sizdan cheklov olindi, guruhda <b>yozishingiz mumkin!</b>nEndi qoidani <b>buzmaysiz</b> degan umiddaman❗️",
    'parse_mode'=>'html'
  ]);
}
}

if ($text=='/del'&&$from_id==$admin) {
   bot('deleteMessage', [
    'chat_id'=>$chat_id,
    'message_id'=>$mid
  ]);
  bot('deleteMessage', [
    'chat_id'=>$chat_id,
    'message_id'=>$mid
  ]);
  }

if($text == "/pin" or $text == "Pin" or $text == "PIn" or $text == "PIN" or $text == "piN" or $text == "pIN" or $text == "pIn" or $text == "pIN"){
$gett = bot('getChatMember', [
'chat_id' => $chat_id,
'user_id' => $from_id,
]);
$get = $gett->result->status;
if($get =="administrator" or $get == "creator"){
  bot('pinChatMessage',[
    'chat_id'=>$chat_id,
    'message_id'=>$mid
  ]);
}
}

if($text=="/leave"&&$from_id==$admin) {
  bot('sendmessage', [
      'chat_id' => $chat_id,
      'text' => "<b>Ho‘p xo‘jayin, guruhni tark etaman!</b>.",
      'parse_mode' => 'html'
  ]);
  bot('leaveChat',[
    'chat_id'=>$chat_id
  ]);
}


 if($text == "ban" or $text == "Ban" or $text== "/Ban" or  $text == "/ban"){
$gett = bot('getChatMember', [
'chat_id' => $chat_id,
'user_id' => $from_id,
]);
$get = $gett->result->status;
if($get =="administrator" or $get == "creator"){
       $vaqti = strtotime("+108000000 minutes");
      bot('kickChatMember', [
        'chat_id' => $chat_id,
        'user_id' => $id,
        'until_date' => $vaqti,
      ]);
    bot('sendMessage', [
        'chat_id'=>$chat_id,
        'text' => "<a href='tg://user?id=$id'>$repname</a> guruhdan <b>BAN</b> bo‘ldi!",
        'parse_mode'=>'html'
    ]);
  }
  }

 if($text == "Unban"  or  $text == "/unban"){
$gett = bot('getChatMember', [
'chat_id' => $chat_id,
'user_id' => $from_id,
]);
$get = $gett->result->status;
if($get =="administrator" or $get == "creator"){
    bot('unbanChatMember', [
        'chat_id' => $chat_id,
        'user_id' => $id,
    ]);
    bot('sendMessage', [
        'chat_id'=>$chat_id,
        'text' => "<a href='tg://user?id=$id'>$repname</a> <b>ban</b>dan olindi!",
        'parse_mode'=>'html'
    ]);
}
}

if($text == "warn" or $text == "Warn" or $text == "/warn"){
  $gett = bot('getChatMember', [
'chat_id' => $chat_id,
'user_id' => $from_id,
]);
$get = $gett->result->status;
if($get =="administrator" or $get == "creator"){
$warn = file_get_contents("warn/$chat_id&$id.dat");
if($warn){
$warn +=1;
file_put_contents("warn/$chat_id&$id.dat","$warn");
if($warn !=3){
$oldi = bot('sendmessage',[
  'chat_id'=>$chat_id,
  'text'=>"<a href='tg://user?id=$id'>$repname</a> <b>ogohlantirish oldi.</b>nEndi undagi ogohlantirishlar soni: <b>$warn</b>/3.",
  'parse_mode'=>'html'
  ]);
}else{
 bot('sendmessage',[
  'chat_id'=>$chat_id,
  'text'=>"<a href='tg://user?id=$id'>$repname</a> shu vaqtgacha unga berilgan ogohlantirishlarga <b>befarq bo‘ldi</b>, jazo sifatida esa guruhdan <b>chetlatiladi!</b>",
  'parse_mode'=>'html'
  ]);
 $vaqti = strtotime("+120 minutes");
  bot('kickChatMember', [
        'chat_id' => $chat_id,
        'user_id' => $id,
        'until_date' => $vaqti,
      ]);
 $warn = 0;
file_put_contents("warn/$chat_id&$id.dat","$warn");
}
}else{
$warn = 1;
file_put_contents("warn/$chat_id&$id.dat","$warn");
  bot('sendmessage',[
  'chat_id'=>$chat_id,
  'text'=>"<a href='tg://user?id=$id'>$repname</a> <b>Ogohlantirish oldi.</b>nEndi undagi ogohlantirishlar soni <b>$warn</b>/3.",
  'parse_mode'=>'html'
  ]);
}
}
}

  if($text == "unwarn" or $text == "Unwarn" or $text == "/unwarn"){
  $gett = bot('getChatMember', [
'chat_id' => $chat_id,
'user_id' => $from_id,
]);
$get = $gett->result->status;
if($get =="administrator" or $get == "creator"){
 $warn = 0;
 file_put_contents("warn/$chat_id&$id.dat","$warn");
  bot('sendmessage',[
  'chat_id'=>$chat_id,
  'text'=>"<a href='tg://user?id=$id'>$repname</a> dan barcha <b>ogohlantirishlar</b> olib tashlandi.nEndi undagi ogohlantirishlar soni <b>$warn</b>/3.",
  'parse_mode'=>'html'
  ]);
} 
}






if(isset($text)){
$get = file_get_contents("panel/$chat_id");
if($get){
}else{
$baza = [
"stiker"=>"true",
"audio"=>"true",
"voice"=>"true",
"photo"=>"true",
"video"=>"true",
"fayl"=>"true",
"giflar"=>"true",
"forward"=>"false",
"qopol"=>"false",
"kirish"=>"false",
"suxbat"=>"false",
];
file_put_contents("panel/$chat_id",json_encode($baza));
}
}


$baza = json_decode(file_get_contents("panel/$chat_id"),true);
$Sstiker = $baza["stiker"];
$Saudio  = $baza["audio"];
$Svoice = $baza["voice"];
$Svideo = $baza["video"];
$Sphoto = $baza["photo"];
$Sfayl = $baza["fayl"];
$Sgif = $baza["giflar"];
$Sforward = $baza["forward"];
$Sqopol = $baza["qopol"];
$Skirish = $baza["kirish"];
$Ssuxbat = $baza["suxbat"];


mkdir("panel");

$fadmin2 = $update->callback_query->from->id;
$imid = $callback->inline_message_id;
if($text == "/panel" or $text == "/panel@Onashka_bot"){
	bot('deleteMessage', [
    'chat_id'=>$chat_id,
    'message_id'=>$mid
  ]);
$gett2 = bot('getChatMember', [
'chat_id'=> $chat_id,
'user_id'=> $from_id,
]);
$get2 = $gett2->result->status;
if($get2 =="administrator" or $get2 == "creator"){
$baza = json_decode(file_get_contents("panel/$chat_id"),true);
$gets = bot("getChat",[
"chat_id"=>"$chat_id",
]);
$title = $gets->result->title;
$username = $gets->username;
$stiker = $baza["stiker"];
if($stiker == "false"){
$stiker = "☑️Taqiqlangan";
}else{
$stiker = "✅Ruhsat etilgan";
}
$audio = $baza["audio"];
if($audio == "false"){
$audio = "☑️Taqiqlangan";
}else{
$audio = "✅Ruhsat etilgan";
}
$voice = $baza["voice"];
if($voice == "false"){
$voice = "☑️Taqiqlangan";
}else{
$voice = "✅Ruhsat etilgan";
}
$photo = $baza["photo"];
if($photo == "false"){
$photo = "☑️Taqiqlangan";
}else{
$photo = "✅Ruhsat etilgan";
}
$video = $baza["video"];
if($video == "false"){
$video = "☑️Taqiqlangan";
}else{
$video = "✅Ruhsat etilgan";
}
$fayl = $baza["fayl"];
if($fayl == "false"){
$fayl = "☑️Taqiqlangan";
}else{
$fayl = "✅Ruhsat etilgan";
}
$gif = $baza["giflar"];
if($gif == "false"){
$gif = "☑️Taqiqlangan";
}else{
$gif = "✅Ruhsat etilgan";
}
$forward = $baza["forward"];
if($forward == "true"){
$forward = "✅Ruhsat etilgan";
}else{
$forward = "☑️Taqiqlangan";
}
$kirish = $baza["kirish"];
if($kirish == "true"){
$kirish = " ☑️Ochrilgan";
}else{
$kirish = "✅Yoqilgan";
}
$qopol = $baza["qopol"];
if($qopol == "true"){
$qopol = "✅Ruhsat etilgan";
}else{
$qopol = "☑️Taqiqlangan";
}
$suxbat = $baza["suxbat"];
if($suxbat == "true"){
$suxbat = "☑️Taqiqlangan";
}else{
$suxbat = "✅Ruhsat etilgan";
}

bot('sendmessage', [
'chat_id'=>$chat_id,
'text'=>"<a href='https://t.me/$username'>$title</a> <b>guruhini sozlash uchun quyidagi tugmalardan foydalaning:👇</b>
✅<b>Ruhsat etilgan
☑Taqiqlangan</b>",
'parse_mode'=>'html',
'inline_message_id'=>$imid,
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[["callback_data"=>"null","text"=>"🙋Kutib olish"],["callback_data"=>"M()kirish","text"=>"$kirish"],],[["callback_data"=>"null","text"=>"💭Suxbatlashish"],["callback_data"=>"M()suxbat","text"=>"$suxbat"],],
[["callback_data"=>"null","text"=>"🗣️Sokinishlar"],["callback_data"=>"M()qopol","text"=>"$qopol"],],
[["callback_data"=>"null","text"=>"📂Fayllar"],["callback_data"=>"M()fayl","text"=>"$fayl"],],
[["callback_data"=>"null","text"=>"✨Rasmlar"],["callback_data"=>"M()photo","text"=>"$photo"],],
[["callback_data"=>"null","text"=>"⛺Giflar"],["callback_data"=>"M()giflar","text"=>"$gif"],],
[["callback_data"=>"null","text"=>"🎧Musiqalar"],["callback_data"=>"M()audio","text"=>"$audio"],],
[["callback_data"=>"null","text"=>"🎤Goloslar"],["callback_data"=>"M()voice","text"=>"$voice"],],
[["callback_data"=>"null","text"=>"🎥Videolar"],["callback_data"=>"M()video","text"=>"$video"],],
[["callback_data"=>"null","text"=>"🎭Stickerlar"],["callback_data"=>"M()stiker","text"=>"$stiker"],],
[["callback_data"=>"null","text"=>"➡Forwardlar"],["callback_data"=>"M()forward","text"=>"$forward"],],
[['text'=>"🗑Menu yopish",'callback_data'=>"exit"],],
]
]),
]);
}else{
bot('answerCallbackQuery',[
'callback_query_id'=>$cqid,
'text'=>"👷Faqat adminlar uchun",
'show_alert'=>true,
]);
}
}

$callback = $update->callback_query;
$dataa = $callback->data;
$dataa = explode("()",$dataa);
if($dataa[0] == "M"){
$cid = $callback->from->id;
$mid = $callback->message->message_id;
$imid = $callback->inline_message_id;
$gett2 = bot('getChatMember', [
'chat_id'=> $chat_id2,
'user_id'=> $fadmin2,
]);
$get2 = $gett2->result->status;
if($get2 =="administrator" or $get2 == "creator"){
$gets = bot("getChat",[
"chat_id"=>"$chat_id2",
]);
$title = $gets->result->title;
$baza = json_decode(file_get_contents("panel/$chat_id2"),true);
if($baza["$dataa[1]"] == "true"){
$input = "false";
}else{
$input = "true";
}
$baza["$dataa[1]"] = $input;
file_put_contents("panel/$chat_id2",json_encode($baza));
$baza = json_decode(file_get_contents("panel/$chat_id2"),true);


$link = $baza["link"];
if($link == "false"){
$link = "☑️Taqiqlangan";
}else{
$link = "✅Ruhsat etilgan";
}
$stiker = $baza["stiker"];
if($stiker == "false"){
$stiker = "☑️Taqiqlangan";
}else{
$stiker = "✅Ruhsat etilgan";
}
$audio = $baza["audio"];
if($audio == "false"){
$audio = "☑️Taqiqlangan";
}else{
$audio = "✅Ruhsat etilgan";
}
$voice = $baza["voice"];
if($voice == "false"){
$voice = "☑️Taqiqlangan";
}else{
$voice = "✅Ruhsat etilgan";
}
$photo = $baza["photo"];
if($photo == "false"){
$photo = "☑️Taqiqlangan";
}else{
$photo = "✅Ruhsat etilgan";
}
$video = $baza["video"];
if($video == "false"){
$video = "☑️Taqiqlangan";
}else{
$video = "✅Ruhsat etilgan";
}
$fayl = $baza["fayl"];
if($fayl == "false"){
$fayl = "☑️Taqiqlangan";
}else{
$fayl = "✅Ruhsat etilgan";
}
$gif = $baza["giflar"];
if($gif == "false"){
$gif = "☑️Taqiqlangan";
}else{
$gif = "✅Ruhsat etilgan";
}
$forward = $baza["forward"];
if($forward == "true"){
$forward = "✅Ruhsat etilgan";
}else{
$forward = "☑️Taqiqlangan";
}
$kirish = $baza["kirish"];
if($kirish == "true"){
$kirish = " ☑️Ochrilgan";
}else{
$kirish = "✅Yoqilgan";
}
$qopol = $baza["qopol"];
if($qopol == "true"){
$qopol = "✅Ruhsat etilgan";
}else{
$qopol = "☑️Taqiqlangan";
}
$suxbat = $baza["suxbat"];
if($suxbat == "true"){
$suxbat = "☑️Taqiqlangan";
}else{
$suxbat = "✅Ruhsat etilgan";
}
bot('editMessageText', [
'chat_id'=>$chat_id2,
'message_id'=>$message_id2,
'text'=>"<a href='https://t.me/$username'>$title</a> <b>guruhini sozlash uchun quyidagi tugmalardan foydalaning:👇</b>
✅<b>Ruhsat etilgan
☑Taqiqlangan</b>",
'parse_mode'=>'html',
'inline_message_id'=>$imid,
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[["callback_data"=>"null","text"=>"🙋Kutib olish"],["callback_data"=>"M()kirish","text"=>"$kirish"],],[["callback_data"=>"null","text"=>"💭Suxbatlashish"],["callback_data"=>"M()suxbat","text"=>"$suxbat"],],
[["callback_data"=>"null","text"=>"🗣️Sokinishlar"],["callback_data"=>"M()qopol","text"=>"$qopol"],],
[["callback_data"=>"null","text"=>"📂Fayllar"],["callback_data"=>"M()fayl","text"=>"$fayl"],],
[["callback_data"=>"null","text"=>"✨Rasmlar"],["callback_data"=>"M()photo","text"=>"$photo"],],
[["callback_data"=>"null","text"=>"⛺Giflar"],["callback_data"=>"M()giflar","text"=>"$gif"],],
[["callback_data"=>"null","text"=>"🎧Musiqalar"],["callback_data"=>"M()audio","text"=>"$audio"],],
[["callback_data"=>"null","text"=>"🎤Goloslar"],["callback_data"=>"M()voice","text"=>"$voice"],],
[["callback_data"=>"null","text"=>"🎥Videolar"],["callback_data"=>"M()video","text"=>"$video"],],
[["callback_data"=>"null","text"=>"🎭Stickerlar"],["callback_data"=>"M()stiker","text"=>"$stiker"],],
[["callback_data"=>"null","text"=>"➡Forwardlar"],["callback_data"=>"M()forward","text"=>"$forward"],],
[['text'=>"🗑Menu yopish",'callback_data'=>"exit"],],
]
]),
]);
}else{
bot('answerCallbackQuery',[
'callback_query_id'=>$cqid,
'text'=>"👷Faqat adminlar uchun",
'show_alert'=>true,
]);
}
}


    if (($new_chat_members != NUll)&&($is_bot!=false)) {
$gett = bot('getChatMember', [
'chat_id' => $chat_id,
'user_id' => $from_id,
]);
$get = $gett->result->status;
if($get =="member"){
   $vaqti = strtotime("+999999999999 minutes");
  bot('kickChatMember', [
      'chat_id' => $chat_id,
      'user_id' => $new_chat_members,
      'until_date'=> $vaqti,
  ]);
 $send = bot('sendmessage', [
      'chat_id' => $chat_id,
      'text' => "👷Guruhga faqat adminlar bot qo'shishi mumkin!",
      'parse_mode' => 'html',
  'disable_web_page_preview'=>true,
'reply_markup'=>json_encode([
'inline_keyboard' => [
[['text'=>'Kanalim❤','url'=>'https://t.me/joinchat/AAAAAETBpSWxAFjppkDCow']]
]
]),
])->result->message_id;
sleep(20);
bot('deletemessage', [
'chat_id' => $chat_id, 
'message_id' => $send
]);
}
}

if($cty=="supergroup" or $cty=="group"){
if ((mb_stripos($text,"http")!==false) or (mb_stripos($caption,"http")!==false) or (mb_stripos($performer,"http")!==false) or (mb_stripos($text,"t.me")!==false) or (mb_stripos($text,"telegram.me")!==false)){
$gett = bot('getChatMember', [
'chat_id'=> $chat_id,
'user_id'=> $from_id,
]);
$get = $gett->result->status;
if($get =="member"){
bot ('deleteMessage', [
'chat_id'=> $chat_id,
'message_id'=> $mid,
]);
$send = bot ('SendMessage', [
'chat_id'=> $chat_id,
'text'=>"⚠ <a href='tg://user?id=$from_id'>$name</a>  kechirasiz bu guruhda reklama tashlash mumkin emas.",
'parse_mode'=>"html",
'disable_web_page_preview'=>true,
'reply_markup'=>json_encode([
'inline_keyboard' => [
[['text'=>'Kanalim❤','url'=>'https://t.me/joinchat/AAAAAETBpSWxAFjppkDCow']]
]
]),
])->result->message_id;
sleep(20);
bot('deletemessage', [
'chat_id' => $chat_id, 
'message_id' => $send
]);
}
}
}


if(isset($update) and $Sforward == "false"){
if ((isset($forward)!==false) or (isset($forward_ch)!==false)){
$gett = bot('getChatMember', [
'chat_id'=> $chat_id,
'user_id'=> $from_id,
]);
$get = $gett->result->status;
if($get =="member"){
bot ('deleteMessage', [
'chat_id'=> $chat_id,
'message_id'=> $mid,
]);
$send = bot ('SendMessage', [
'chat_id'=> $chat_id,
'text'=>"⚠<a href='tg://user?id=$from_id'>$name</a>  kechirasiz bu guruhda forward qilish mumkin emas.",
'parse_mode'=>"html",
'disable_web_page_preview'=>true,
'reply_markup'=>json_encode([
'inline_keyboard' => [
[['text'=>'Kanalim❤','url'=>'https://t.me/joinchat/AAAAAETBpSWxAFjppkDCow']]
]
]),
])->result->message_id;
sleep(15);
bot('deletemessage', [
'chat_id' => $chat_id, 
'message_id' => $send
]);
}
}
}


if(isset($update) and $Saudio == "false"){
if (isset($audio)!==false){
$gett = bot('getChatMember', [
'chat_id'=> $chat_id,
'user_id'=> $from_id,
]);
$get = $gett->result->status;
if($get =="member"){
bot ('deleteMessage', [
'chat_id'=> $chat_id,
'message_id'=> $mid,
]);
$send = bot ('SendMessage', [
'chat_id'=> $chat_id,
'text'=>"⚠<a href='tg://user?id=$from_id'>$name</a>  kechirasiz bu guruhda musiqa tashlash mumkin emas.",
'parse_mode'=>"html",
'disable_web_page_preview'=>true,
'reply_markup'=>json_encode([
'inline_keyboard' => [
[['text'=>'Kanalim❤','url'=>'https://t.me/joinchat/AAAAAETBpSWxAFjppkDCow']]
]
]),
])->result->message_id;
sleep(15);
bot('deletemessage', [
'chat_id' => $chat_id, 
'message_id' => $send
]);
}
}
}

if(isset($update) and $Svoice == "false"){
if (isset($voice)!==false){
$gett = bot('getChatMember', [
'chat_id'=> $chat_id,
'user_id'=> $from_id,
]);
$get = $gett->result->status;
if($get =="member"){
bot ('deleteMessage', [
'chat_id'=> $chat_id,
'message_id'=> $mid,
]);
$send = bot ('SendMessage', [
'chat_id'=> $chat_id,
'text'=>"⚠<a href='tg://user?id=$from_id'>$name</a>  kechirasiz bu guruhda ovozli xabar tashlash mumkin emas.",
'parse_mode'=>"html",
'disable_web_page_preview'=>true,
'reply_markup'=>json_encode([
'inline_keyboard' => [
[['text'=>'Kanalim❤','url'=>'https://t.me/joinchat/AAAAAETBpSWxAFjppkDCow']]
]
]),
])->result->message_id;
sleep(15);
bot('deletemessage', [
'chat_id' => $chat_id, 
'message_id' => $send
]);
}
}
}

if(isset($update) and $Svideo == "false"){
if (isset($video)!==false){
$gett = bot('getChatMember', [
'chat_id'=> $chat_id,
'user_id'=> $from_id,
]);
$get = $gett->result->status;
if($get =="member"){
bot ('deleteMessage', [
'chat_id'=> $chat_id,
'message_id'=> $mid,
]);
$send = bot ('SendMessage', [
'chat_id'=> $chat_id,
'text'=>"⚠<a href='tg://user?id=$from_id'>$name</a>  kechirasiz bu guruhda video tashlash mumkin emas.",
'parse_mode'=>"html",
'disable_web_page_preview'=>true,
'reply_markup'=>json_encode([
'inline_keyboard' => [
[['text'=>'Kanalim❤','url'=>'https://t.me/joinchat/AAAAAETBpSWxAFjppkDCow']]
]
]),
])->result->message_id;
sleep(15);
bot('deletemessage', [
'chat_id' => $chat_id, 
'message_id' => $send
]);
}
}
}

if(isset($update) and $Sstiker == "false"){
if (isset($sticker)!==false){
$gett = bot('getChatMember', [
'chat_id'=> $chat_id,
'user_id'=> $from_id,
]);
$get = $gett->result->status;
if($get =="member"){
bot ('deleteMessage', [
'chat_id'=> $chat_id,
'message_id'=> $mid,
]);
$send = bot ('SendMessage', [
'chat_id'=> $chat_id,
'text'=>"⚠<a href='tg://user?id=$from_id'>$name</a>  kechirasiz bu guruhda stiker tashlash mumkin emas.",
'parse_mode'=>"html",
'disable_web_page_preview'=>true,
'reply_markup'=>json_encode([
'inline_keyboard' => [
[['text'=>'Kanalim❤','url'=>'https://t.me/joinchat/AAAAAETBpSWxAFjppkDCow']]
]
]),
])->result->message_id;
sleep(15);
bot('deletemessage', [
'chat_id' => $chat_id, 
'message_id' => $send
]);
}
}
}

if(isset($update) and $Sgif == "false"){
if (isset($gif)!==false){
$gett = bot('getChatMember', [
'chat_id'=> $chat_id,
'user_id'=> $from_id,
]);
$get = $gett->result->status;
if($get =="member"){
bot ('deleteMessage', [
'chat_id'=> $chat_id,
'message_id'=> $mid,
]);
$send = bot ('SendMessage', [
'chat_id'=> $chat_id,
'text'=>"⚠<a href='tg://user?id=$from_id'>$name</a>  kechirasiz bu guruhda gif tashlash mumkin emas.",
'parse_mode'=>"html",
'disable_web_page_preview'=>true,
'reply_markup'=>json_encode([
'inline_keyboard' => [
[['text'=>'Kanalim❤','url'=>'https://t.me/joinchat/AAAAAETBpSWxAFjppkDCow']]
]
]),
])->result->message_id;
sleep(15);
bot('deletemessage', [
'chat_id' => $chat_id, 
'message_id' => $send
]);
}
}
}

if(isset($update) and $Sfayl == "false"){
if (isset($doc)!==false){
$gett = bot('getChatMember', [
'chat_id'=> $chat_id,
'user_id'=> $from_id,
]);
$get = $gett->result->status;
if($get =="member"){
bot ('deleteMessage', [
'chat_id'=> $chat_id,
'message_id'=> $mid,
]);
$send = bot ('SendMessage', [
'chat_id'=> $chat_id,
'text'=>"⚠<a href='tg://user?id=$from_id'>$name</a>  kechirasiz bu guruhda fayl tashlash mumkin emas.",
'parse_mode'=>"html",
'disable_web_page_preview'=>true,
'reply_markup'=>json_encode([
'inline_keyboard' => [
[['text'=>'Kanalim❤','url'=>'https://t.me/joinchat/AAAAAETBpSWxAFjppkDCow']]
]
]),
])->result->message_id;
sleep(15);
bot('deletemessage', [
'chat_id' => $chat_id, 
'message_id' => $send
]);
}
}
}

if(isset($update) and $Sphoto == "false"){
if ((isset($photo)!==false) or (isset($photo)!==false)){
$gett = bot('getChatMember', [
'chat_id'=> $chat_id,
'user_id'=> $from_id,
]);
$get = $gett->result->status;
if($get =="member"){
bot ('deleteMessage', [
'chat_id'=> $chat_id,
'message_id'=> $mid,
]);
$send = bot ('SendMessage', [
'chat_id'=> $chat_id,
'text'=>"⚠<a href='tg://user?id=$fadmin'>$name</a>  kechirasiz bu guruhda Rasm tashlash mumkin emas.",
'parse_mode'=>"html",
'disable_web_page_preview'=>true,
'reply_markup'=>json_encode([
'inline_keyboard' => [
[['text'=>'Kanalim❤','url'=>'https://t.me/joinchat/AAAAAETBpSWxAFjppkDCow']]
]
]),
])->result->message_id;
sleep(15);
bot('deletemessage', [
'chat_id' => $chat_id, 
'message_id' => $send
]);
}
}
}
if(isset($update) and $Sqopol == "false"){
    if((stripos($text,"dalbayop")!==false)  or (stripos($text,"oneni")!==false)  or (stripos($text,"skaman")!==false) or (stripos($text,"sikaman")!==false) or (stripos($text,"Axmoq")!==false) or (stripos($text,"chumo")!==false)  or  (stripos($text,"dalbayob")!==false) or  (stripos($text,"skay")!==false) or (stripos($text,"seks")!==false) or (stripos($text,"dalban")!==false) or (stripos($text,"yiban")!==false) or (stripos($text,"jalab")!==false) or (stripos($text,"скаман")!==false) or (stripos($text,"qanjiq")!==false) or (stripos($text,"чумо")!==false)  or  (stripos($text,"далбаёб")!==false) or  (stripos($text,"скай")!==false) or (stripos($text,"секс")!==false) or (stripos($text,"далбан")!==false) or (stripos($text,"йибан")!==false) or (stripos($text,"haqorat")!==false) or (stripos($text,"жалаб")!==false) or (stripos($text,"кутинга")!==false) or (stripos($text,"kotinga")!==false) or  (stripos($text,"куток")!==false)  or  (stripos($text,"qotoq")!==false) or  (stripos($text,"naxuy")!==false) or (stripos($text,"хуй")!==false) or (stripos($text,"сучка")!==false) or (stripos($text,"suchka")!==false) or (stripos($text,"омини")!==false) or (stripos($text,"омнга")!==false) or  (stripos($text,"сикаман")!==false)  or  (stripos($text,"гандон")!==false) or  (stripos($text,"сука")!==false) or (stripos($text,"жопа")!==false) or (stripos($text,"omingni")!==false) or (stripos($text,"ominga")!==false) or (stripos($text,"gandon")!==false) and $from_id !== $admin){
    $gett = bot('getChatMember', [
   'chat_id' => $chat_id,
   'user_id' => $from_id,
   ]);
  $get = $gett->result->status;
  if($get =="member"){
     $minut = strtotime("+10800 minutes");
    bot('restrictChatMember', [
        'chat_id' => $chat_id,
        'user_id' => $from_id,
        'until_date' => $minut,
        'can_send_messages' => false,
        'can_send_media_messages' => false,
        'can_send_other_messages' => false,
        'can_add_web_page_previews' => false
    ]);
    bot('deleteMessage', [
       'chat_id' => $chat_id,
       'message_id' => $mid
    ]);
 $send = bot('sendmessage', [
        'chat_id' => $chat_id,
        'text' => "⚠<a href='tg://user?id=$fadmin'>$name</a> <b>3 kun</b>ga <b>Read - Only</b> rejimiga tushdirildi.\n<b>Sabab: Haqorat qildi!</b> ",
        'parse_mode' => 'html',
'disable_web_page_preview'=>true,
'reply_markup'=>json_encode([
'inline_keyboard' => [
[['text'=>'Kanalim❤','url'=>'https://t.me/joinchat/AAAAAETBpSWxAFjppkDCow']]
]
]),
])->result->message_id;
sleep(20);
bot('deletemessage', [
'chat_id' => $chat_id, 
'message_id' => $send
]);
}
}
}

if(isset($update) and $Skirish == "false"){
$new_chat_members = $message->new_chat_member->id;
 if ($new_chat_members) {
    $us = bot('getChatMembersCount',[
'chat_id'=>$chat_id
]);
$count = $us->result;
$z = bot('getChat',[
    'chat_id'=>$chat_id,
    ]);
    $id = $z->result->id;
    $usernam = $z->result->username;
    $des = $z->result->description;
$send = bot('sendmessage', [
'chat_id' => $chat_id,
'text'=>"👋*Salom*, [$ismi](tg://user?id=$new_chat_members)

🎊*Sizni * [$title](tg://user?id=$id) *Guruhida ko'rganimizdan xursandmiz .*
*👥Guruh a'zolari soni*: $count
",
'parse_mode'=>'markdown',
'disable_web_page_preview'=>true,
'reply_markup'=>json_encode([
'inline_keyboard' => [
[['text'=>'Kanalim❤','url'=>'https://t.me/joinchat/AAAAAETBpSWxAFjppkDCow']]
]
]),
]);
}
}
if(isset($update) and $Ssuxbat == "false"){
if($cty=="supergroup" or $cty=="group"){
    $ex = $msgs[$text];
$ex = explode("|",$ex);
    $txt = $ex[rand(0,count($ex)-1)];
bot("sendmessage",[
	'chat_id'=>$message->chat->id,
	'text'=>"$txt",
	'reply_to_message_id'=>$mid
	]);
}
}

if($text == '/code' and $chat_id == $admin){
bot('sendDocument',[
'chat_id'=>$chat_id,
'document'=>new CURLFile(__FILE__),
'caption'=>" <b>code</b>",
'parse_mode'=>"html",
'reply_to_message_id'=>$mid,
]);
}

if ($data == "null"){
bot('answerCallbackQuery',[
'callback_query_id'=>$cqid,
'text'=> "❎Bu bo'lim o'zgarmaydi.!",
'show_alert'=>false,
]);
}

if($data=="exit" ){
bot('deletemessage',[
'chat_id'=>$chat_id2,
'message_id'=>$message_id2,
 ]);
bot('answerCallbackQuery',[
'callback_query_id'=>$cqid,
'text'=>"🗑Menu yopildi",
]);
}




$sana = date('d-M Y',strtotime('3 hour'));
$soat = date('H:i', strtotime('3 hour'));
$kun3 = date('N',strtotime('3 hour')); 
$hafta="1Dushanba1 2Seshanba2 3Chorshanba3 4Payshanba4 5Juma  muborak🌸5 6Shanba6 7Yakshanba7"; 
$ex=explode("$kun3",$hafta); 
$hafta1="$ex[1]"; 

$tedadmsg = $update->message->message_id;
$oynomi = date('F',strtotime('3 hour'));
$buoy = date('t',strtotime('3 hour'));
if(true){
bot('setChatDescription',[
'chat_id'=>$chat_id,
'description'=>"
┌👋Guruhimizga xush kelibsiz!
├🗓Bugun: $sana-yil
├⌚️Soat: $soat
├🔵Hafta kuni: $hafta1
├🌎Hozir $oynomi oyi
├ 📅Bu oy $buoy kundan iborat
├👥Guruh a'zolari: $count
└📡Bosh homiy: @DiL_SozLaRM
",
]);
}


if($new){
  bot('deletemessage',[
    'chat_id'=>$chat_id,
    'message_id'=>$mid
  ]);
  bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"",
    'parse_mode'=>'html'
   ]);
  $odam = file_get_contents("soni/$chat_id/$from_id.txt");
  $op = $odam + 1;
  file_put_contents("soni/$chat_id/$from_id.txt","$op");
}

if($get == "administrator" or $get == "creator" or $get == "member"){
if($text =="/soni" or $text == "/soni@Onashka_bot"){
 $rodam = file_get_contents("soni/$chat_id/$repid.txt");
  bot('sendmessage',[    
    'chat_id'=>$chat_id, 
    'user_id'=>$repid, 
    'reply_to_message_id'=>$mid,  
    'parse_mode'=>'html',   
    'text'=>"<b>$repname</b> bugungi kungacha guruhga <b>$rodam</b> ta odam qo'shgan!",
  ]);   
}
if($text == "/soni" or $text == "/soni@Onashka_bot"){
 $odam = file_get_contents("soni/$chat_id/$from_id.txt");
  bot('sendmessage',[    
    'chat_id'=>$chat_id, 
    'user_id'=>$user_id,  
    'parse_mode'=>'html',   
    'text'=>"<b>$name</b> siz bugungi kungacha guruhga <b>$odam</b> ta odam qo'shdingiz!",
  ]);   
}
}



//send buyruqlari

$penlist = file_get_contents("data/pen.txt");
$key = json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[['text'=>"📤Send oddiy"],['text'=>"📤Send Forward"]],
[['text'=>"📤Guruh oddiy"],['text'=>"📤Guruh Forward"]],
[['text'=>"Bekor qilish⛔"],['text'=>"PHPni olish📥"],],
]
]);
 

 
if($text == "/xabar" and $chat_id==$admin){

 bot('SendMessage',[ 
'chat_id'=>$chat_id,
'message_id'=>$mid,
'parse_mode'=>'markdown',
'text'=>"🔹*Siz adminsiz kerakli bo'limni tanlang:*",
'reply_markup'=>$key,
]);
}



if($text == "Bekor qilish⛔"&&$from_id==$admin){
      bot('sendmessage',[
'chat_id'=>$admin,
'text'=>"Xabar yuborish Bekor qilindi!",
'parse_mode'=>"html",
'reply_markup'=>$key,
]);
unlink("stat/$chat_id.step");
      unlink("viki/send.ok");
      unlink("viki/send.no");
      unlink("stat/Rasm.jpg");
      unlink("stat/$chat_id.matn11");
      unlink("stat/$chat_id.jpg");
      unlink("stat/$chat_id.matn");
      unlink("stat/$chat_id.matn1");
      }
    
    if ($text == "📤Send oddiy" && $chat_id == $admin ){
        file_put_contents("stat/$chat_id.step", "send");
        bot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "Xabaringizni yuboring",
            'reply_to_message_id'=>$mid,
            'reply_markup'=>$key
        ]);
    } 
if ($step== "send") {
        file_put_contents("stat/$chat_id.step", "no");
        $fp = fopen("stat/user.list", 'r');
        while (!feof($fp)) {
            $ckar = fgets($fp);
            bot('sendMessage', [
'chat_id'=>$ckar,
'text'=>$text,
]);
        }
        bot('sendMessage', [
            'chat_id' => $chat_id,
            'text' => "Xabar muofaqiyatli yuborildi",
            'reply_to_message_id'=>$mid,
            'reply_markup' => $key
        ]);
    } 
if ($text == "📤Send Forward" && $chat_id == $admin){
        file_put_contents("stat/$chat_id.step", "fwd");
        bot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "Xabaringizni yuboring",
            'reply_to_message_id'=>$mid,
            'reply_markup'=>$key
        ]);
    } 
if ($step == 'fwd') {
        file_put_contents("stat/$chat_id.step", "no");
        $forp = fopen("stat/user.list", 'r');
        while (!feof($forp)) {
            $fakar = fgets($forp);
            bot('forwardMessage', [
'chat_id'=>$fakar,
'from_chat_id'=>$chat_id,
'message_id'=>$mid,
]);
        }
        bot('sendMessage', [
            'chat_id' => $chat_id,
            'text' => "Xabar yuborildi",
            'reply_to_message_id'=>$mid,
            'reply_markup' => $key
        ]);
    } 

    if ($text == "📤Guruh oddiy" && $chat_id == $admin ){
        file_put_contents("stat/$chat_id.step", "snd");
        bot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "Xabaringizni yuboring",
            'reply_to_message_id'=>$mid,
            'reply_markup'=>$key
        ]);
    } 
if ($step== "snd") {
        file_put_contents("stat/$chat_id.step", "no");
        $fp = fopen("stat/group.list", 'r');
        while (!feof($fp)) {
            $ckar = fgets($fp);
            bot('sendMessage', [
'chat_id'=>$ckar,
'text'=>$text,
]);
        }
        bot('sendMessage', [
            'chat_id' => $chat_id,
            'text' => "Xabar muofaqiyatli yuborildi",
            'reply_to_message_id'=>$mid,
            'reply_markup' => $key
        ]);
    } 
if ($text == "📤Guruh Forward" && $chat_id == $admin){
        file_put_contents("stat/$chat_id.step", "fd");
        bot('sendmessage', [
            'chat_id' => $chat_id,
            'text' => "Xabaringizni yuboring",
            'reply_to_message_id'=>$mid,
            'reply_markup'=>$key
        ]);
    } 
if ($step == 'fd') {
        file_put_contents("stat/$chat_id.step", "no");
        $forp = fopen("stat/group.list", 'r');
        while (!feof($forp)) {
            $fakar = fgets($forp);
            bot('forwardMessage', [
'chat_id'=>$fakar,
'from_chat_id'=>$chat_id,
'message_id'=>$mid,
]);
        }
        bot('sendMessage', [
            'chat_id' => $chat_id,
            'text' => "Xabar yuborildi",
            'reply_to_message_id'=>$mid,
            'reply_markup' => $key
        ]);
    } 
    
if($text == 'PHPni olish📥' and $chat_id == $admin){
bot('sendDocument',[
'chat_id'=>$chat_id,
'document'=>new CURLFile(__FILE__),
'caption'=>"@Onashka_bot <b>code</b>",
'parse_mode'=>"html",
'reply_to_message_id'=>$mid,
]);
}
