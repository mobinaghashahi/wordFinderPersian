<?php
include 'Telegram.php';

date_default_timezone_set("asia/tehran");
$bot_id = "Bot_Token";
$telegram = new Telegram($bot_id);
//دریافت پیام
$result = $telegram->getData();
//بدست آوردن تکست
$text = $telegram->Text();
//بدست آوردن چت آیدی
$chat_id = $telegram->ChatID();
$username = $telegram->Username();
$firstName = $telegram->FirstName();
$lastName = $telegram->LastName();

$url = "https://www.vajehyab.com/dehkhoda/" . urlencode($text);;

$result = file_get_contents($url);

$row = explode("\n", $result);

$findSearch=false;

foreach ($row as $value) {
    if (preg_match('/<div itemprop="articleBody"><p><span class="hl">/', $value)) {
        $data = preg_replace('/<div itemprop="articleBody"><p><span class="hl">/', chr(10), $value);
        $data = preg_replace('/<\/span>/', chr(10), $data);
        $data = preg_replace('/<br><br><br><\/p><\/div>/', chr(10), $data);
        $data = preg_replace('/<p class="author">/', chr(10), $data);
        $data = preg_replace('/<p class="author">/', chr(10), $data);
        $data = preg_replace('/<\/p>/', chr(10), $data);
        $data = preg_replace('/<br>/', chr(10), $data);
        $data = preg_replace('/<span class="hl">/', null, $data);
        $data = preg_replace('/<\/span>/', null, $data);
        $data = preg_replace('/<span class="hl" dir="ltr">/', null, $data);

        $content = array('chat_id' => $chat_id, 'text' => $data);
        $telegram->sendMessage($content);


        $findSearch=true;
    }

}
if($findSearch==false)
{
    $message='دوست عزیز '.$username.' برای جست و جوی شما واژه ای یافت نشد.';
    $content = array('chat_id' => $chat_id, 'text' => $message);
    $telegram->sendMessage($content);
}
