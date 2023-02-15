<?php

function dswa_GetToken()
{
    if (!getSystemSetting('ds_api_key')) {
        setSystemSetting('ds_api_key', DS_WA_DEVICE_TOKEN);
    }
    return getSystemSetting('ds_api_key', DS_WA_DEVICE_TOKEN);
}

function sendWANotifikasi($phone, $url = null)
{
    $message = 'Percobaan Siap';
    $message .= "
";
    $message .= "
";
    $message .= 'Woke';
    dswa_send($phone, $message, $url);
}

/**
 * dswa_Configuration
 *
 * @param  $type [send, connect, getqr]
 * @return void
 */
function dswa_Configuration($type)
{
    $data['api_key'] = dswa_GetToken();
    if ($type = 'send') {
        $data['url'] = getSystemSetting('ds_url_send');
    } elseif ($type == 'connect') {
        $data['url'] = getSystemSetting('ds_url_connect');
    } elseif ($type == 'getqr') {
        $data['url'] = getSystemSetting('ds_url_getqr');
    }
    return $data;
}

// DripSender
/**
 * pushWA
 *
 * @param $phone, $text, $urlfile
 * phone 6285103743402
 * text pesan
 * urlfile -> link media
 * @return void
 */
function dswa_send($phone, $text, $urlfile = null)
{
    $config = dswa_Configuration('send');

    $jsonData = [
        'api_key' => $config['api_key'],
        'phone' => $phone,
        'text' => $text
    ];
    if (!empty($urlfile)) {
        $jsonData['media_url'] = $urlfile;
    }
    return dswa_request($config['url'], $jsonData);
}

function dswa_request($url, $jsonData)
{
    // PHP Code
    //Initiate cURL.

    $ch = curl_init($url);
    //Encode the array into JSON.
    $jsonDataEncoded = json_encode($jsonData);
    //Tell cURL that we want to send a POST request.
    curl_setopt($ch, CURLOPT_POST, 1);

    //Attach our encoded JSON string to the POST fields.
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);

    //Set the content type to application/json
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

    //Execute the request
    $result = curl_exec($ch);
    return $result;
}
