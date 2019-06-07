<?php
// token telegram
$token = '<your telegram bot token>';

// key reg.ru
$userREG = 'test';
$passREG = 'test';
// sendMessage
function sendMessage($chat_id, $message, $reply_markup){
    global $token;
    $keyboard = '';
    if(!empty($reply_markup)){
        $keyboard = '&reply_markup='.$reply_markup;
    }
    $output = file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$chat_id&text=$message".$keyboard);
    return $output;
}
// REG>RU
function reg($message){
    $checkREG = file_get_contents('https://api.reg.ru/api/regru2/domain/check?input_data={"domains":[{"dname":"'.$message.'"}]}&input_format=json&password=test&username=test');
    $checkREG = json_decode($checkREG, true);
    $result = $checkREG['answer']['domains'][0];
    if(!$result['error_code']){
        $output = $result['result'];
    }else{
        $output = $result['error_code'];
    }
    return $output;
}
function getTranslate($lang, $text){
    global $pdo;
    $queryText = $pdo->query("SELECT * FROM `ali_domain_texts` WHERE `text` = '$text' ")->fetch();
    $getText = $queryText[$lang];
    return $getText;
}
