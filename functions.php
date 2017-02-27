<?php


function get_data($date){
    $url = APIURL.'?workspace_id='.APIWORKSPACE.'&client_ids='.APICLIENT.'&since='.$date.'&until='.$date.'&user_agent=api_test&order_field=date&order_desc=off';
    $ch = curl_init($url);

    //Tell cURL that we want to send a POST request.
    curl_setopt($ch, CURLOPT_POST, 1);
    //Attach our encoded JSON string to the POST fields.
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_USERPWD, APIKEY . ':api_token');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    //Execute the request
    $result = curl_exec($ch);

    return json_decode($result, true);

}


function send_to_slack($message, $date){
    //API Url
    $url = APISLACKURL;

    //Initiate cURL.
    $ch = curl_init($url);

    # The JSON data.
    $payload = array(
        'username' => USERNAME,
        "icon_emoji" => ":run:",
        "channel" => "#general",
        'text' => USERTEXT.$date."\n\n".$message,
        "mrkdwn" => true,
    );

    //Encode the array into JSON.
    $jsonDataEncoded = json_encode($payload);
    //Tell cURL that we want to send a POST request.
    curl_setopt($ch, CURLOPT_POST, 1);
    //Attach our encoded JSON string to the POST fields.
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
    //Set the content type to application/json
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //Execute the request
    $result = curl_exec($ch);

}