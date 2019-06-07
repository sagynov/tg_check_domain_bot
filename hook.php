<?php
require_once 'db.php';
require_once 'functions.php';
// JSON
$file = file_get_contents('php://input');
// $fp = fopen('data.txt', 'w');
// fwrite($fp, $file);
// fclose($fp);
$json = json_decode($file, true);
$chat_id = $json['message']['chat']['id'];
$message = $json['message']['text'];
$message = urlencode($message);

$command = '';
$req = $pdo->query("SELECT * FROM `ali_domain_users` WHERE `chat_id` = $chat_id ");
if ($req->rowCount()) {
    $res = $req->fetch();
    $command = $res['command'];
    $lang = $res['lang'];
}else{
    $lang = $json['message']['from']['language_code'];
    $pdo->prepare("INSERT INTO `ali_domain_users` SET
                `chat_id` = ?,
                `lang` = ?,
                `command` = 'start'
            ")->execute([
                $chat_id,
                $lang,
            ]);
           
}
switch ($message) {
    case "start":
        sendMessage($chat_id, getTranslate($lang, 'Welcome'), '');
        $pdo->exec("UPDATE `ali_domain_users` SET `command` = '' WHERE `chat_id` = " . $chat_id);
        
        break;
    case "check":
        sendMessage($chat_id, getTranslate($lang, 'Enter_domain'), '');
        $pdo->exec("UPDATE `ali_domain_users` SET `command` = 'check' WHERE `chat_id` = " . $chat_id);
        
        break;
    case "lang":
        sendMessage($chat_id, getTranslate($lang, 'Choose_language'), '{"keyboard":[["en"], ["ru"], ["kz"]],"resize_keyboard":true, "one_time_keyboard": true}');
        $pdo->exec("UPDATE `ali_domain_users` SET `command` = 'lang' WHERE `chat_id` = " . $chat_id);
        
        break;    
    case "help":
        sendMessage($chat_id, 'Здесь будут информации');
        break;    
    
    default:
        //sendMessage($chat_id, 'Выберите команду');
        break;
}
switch ($command) {  
    case "check":
        $check = reg($message);
        switch ($check) {
            case 'Available':
                $url = "www.reg.ru/choose/domain/?rlink=reflink-398759";
                $reply = '{"inline_keyboard":[[{"text":"'.getTranslate($lang, 'Register_now').'","url":"'.$url.'"}]], "resize_keyboard":true}';
                break;
            
            default:
                
                break;
        }
        $answer = getTranslate($lang, $check);
        sendMessage($chat_id, $answer, $reply);
        $pdo->exec("UPDATE `ali_domain_users` SET `command` = '' WHERE `chat_id` = " . $chat_id);
        $command = '';
        break;
    case "lang":
        if($message == 'en'){
           $pdo->exec("UPDATE `ali_domain_users` SET `lang` = 'en' WHERE `chat_id` = " . $chat_id);
           $lang = 'en';
        }elseif($message == 'ru'){
            $pdo->exec("UPDATE `ali_domain_users` SET `lang` = 'ru' WHERE `chat_id` = " . $chat_id);
            $lang = 'ru';
        }elseif($message == 'kz'){
            $pdo->exec("UPDATE `ali_domain_users` SET `lang` = 'kz' WHERE `chat_id` = " . $chat_id);
            $lang = 'kz';
        }else{
            $pdo->exec("UPDATE `ali_domain_users` SET `lang` = 'en' WHERE `chat_id` = " . $chat_id);
        }
        sendMessage($chat_id, getTranslate($lang, 'Language_successfully_changed'), '{"remove_keyboard": true}'); 
        $pdo->exec("UPDATE `ali_domain_users` SET `command` = '' WHERE `chat_id` = " . $chat_id);
        $command = '';
        break;
    case "help":
        $type = 'Help';
        sendMessage($chat_id, $type, '');
        break;    
    
    default:
        //sendMessage($chat_id, 'Выберите команду');
        break;
}

// $answer = '';
// foreach ($checkKZ as $key){
//     $answer .= ' '.$key;
// }

// $answer = reg($message); 
// sendMessage($chat_id, $answer);
$pdo = null; 
?>
