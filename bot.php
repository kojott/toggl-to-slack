<?php

define('APIKEY', '...'); #Add API key for Toggl
define('APIURL', 'https://toggl.com/reports/api/v2/details');
define('APIWORKSPACE', '...'); // ID of a workspace
define('APICLIENT', '...'); // Company
define('APISLACKURL', 'https://hooks.slack.com/services/...'); # add slack webhook URL
define('USERNAME', 'George\'s bot');
define('USERTEXT', 'George\'s work on '); # it continues with a date


require_once 'functions.php';

$date = date('Y-m-d');

$toggl_data = get_data($date);
if(count($toggl_data['data'])>0) {
    foreach ($toggl_data['data'] as $record) {
        $message .= '*' . $record['project'] . '* - ' . $record['description'] . ' - ' . gmdate("H:i:s", (int)$record['dur'] / 1000) . "\n";
    }

    # send data to slack channel
    send_to_slack($message, $date);

}










/*

# get details of a record in time (change APIKEY)
curl -v -u 465462406f568b4dfb63b5ad07454e72:api_token \
    -X GET "https://toggl.com/reports/api/v2/details?workspace_id=111&client_ids=111&since=2017-02-24&until=2017-02-24&user_agent=api_test"


# get clients (change APIKEY)
curl -v -u 465462406f568b4dfb63b5ad07454e72:api_token \
    -X GET https://www.toggl.com/api/v8/clients

/**/


