<?php

error_reporting(0);
use Twlve\Bookingcom\Booking;
include 'config.php';

function dot($str){  
    if ((strlen($str) > 1) && (strlen($str) < 31)) {  
        $ca = preg_split("//",$str);  
        array_shift($ca);  
        array_pop($ca);  
        $head = array_shift($ca);  
        $dotres = dot(join('',$ca));  
        $dotresult = array();  
        foreach($dotres as $dotvalue){  
            $dotresult[] = $head . $dotvalue;  
            $dotresult[] = $head . '.' .$dotvalue;  
        }  
        return $dotresult;  
    }  
    return array($str);  
}  


function bocom($val,$password,$n){
    require 'vendor/autoload.php';
    include 'config.php';
    $rand = rand(0,9999999);
    $booking = new Booking();
    $hotels  = ['3326463', '4984319'];
    echo "\n$okegreen**$white Creating user\n";
    $email = $val."@gmail.com";
    //$password = $password.$rand;
    $register = $booking->register($email, $password);
    if (!$register->success) {
        checkConnection($register);
        echo "$red!!$white ERROR : " . $register->error_message . "\n";
        die();
    }
    echo "$okegreen**$white Register Success\n";
    echo "$okegreen**$white Claim Reward\n";
    sleep(20);
    $booking->setAuthToken($register->data->auth_token);
    $createWishList = $booking->createWishList();
    if (!$createWishList->success) {
        checkConnection($createWishList);
        echo "$red!!$white ERROR : " . $createWishList->error_message . "\n";
        die();
    }
    foreach ($hotels as $hotel) {
        $saveWishList = $booking->saveWishList($createWishList->data->id, $hotel);
        if (!$saveWishList->success) {
            checkConnection($saveWishList);
            echo "!$red!!$white ERROR : " . $saveWishList->error_message . "\n";
            die();
        }
        if ($saveWishList->data->gta_add_three_items_campaign_status->status == 'reward_given_wallet') {
            $newfile = fopen("akun.txt", "a");
                fwrite($newfile, $email.";".$password."\n");
                fclose($newfile);
                echo "$okegreen**$white Sukses\n";
                echo "$okegreen**$white Email : $email\n";
                echo "$okegreen**$white Password : $password\n";
            
        }
    }
}

$showoff = "
    __
  <(o )___          \033[1m[SGB TEAM]\033[0m
   ( ._> /  \033[1mDONT SHOW OFF WITHOUT TRICK !!!\033[0m
    `---' 
============================================\n";
$banner = "[+]Bocom Dot Trick - By [fb.me/extgfx]
============================================\n\n";
echo $showoff;
echo $banner;

$res = dot(readline("Username (tanpa @gmail.com): "));
echo "$yellow??$white Password : ";
$password = trim(fgets(STDIN));
foreach($res as $val){
    bocom($val,$password,$n+1);
}




function checkConnection($data)
{
    if (strtolower($data->error_message) == 'no connection') {
        echo "\n\n";
        echo "!! ERROR : " . $data->error_message . "\n";
        echo " ______     ________ ______     ________ _ _ _ \n";
        echo "|  _ \ \   / /  ____|  _ \ \   / /  ____| | | |\n";
        echo "| |_) \ \_/ /| |__  | |_) \ \_/ /| |__  | | | |\n";
        echo "|  _ < \   / |  __| |  _ < \   / |  __| | | | |\n";
        echo "| |_) | | |  | |____| |_) | | |  | |____|_|_|_|\n";
        echo "|____/  |_|  |______|____/  |_|  |______(_|_|_)\n";
        echo "  _____ _    _ _    _ _______ _____   ______          ___   _ _ _ _ \n";
        echo " / ____| |  | | |  | |__   __|  __ \ / __ \ \        / / \ | | | | |\n";
        echo "| (___ | |__| | |  | |  | |  | |  | | |  | \ \  /\  / /|  \| | | | |\n";
        echo " \___ \|  __  | |  | |  | |  | |  | | |  | |\ \/  \/ / | . ` | | | |\n";
        echo " ____) | |  | | |__| |  | |  | |__| | |__| | \  /\  /  | |\  |_|_|_|\n";
        echo "|_____/|_|  |_|\____/   |_|  |_____/ \____/   \/  \/   |_| \_(_|_|_)\n";
        sleep(2);
        die();
    }
}
