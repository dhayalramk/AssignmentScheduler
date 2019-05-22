<?php

include_once 'Interface/IAPI.php';

include_once 'API.php';

$_route = [
    'Schedule' => [
        'fileLocation' => 'Schedule.php',
        'className' => 'Schedule',
        'helpers' => [ 'DateHelper' ],
        'response' => 'JSON'
    ]
];

function loadAPI($apiName)
{
    global $_route;
    $apiConfig = $_route[$apiName];

    // Create API Object
    $fileLocation = $apiConfig['fileLocation'];
    $className = $apiConfig['className'];
    include_once $fileLocation;
    $apiObject = new $className();

    // Adding Helpers
    $helperList = [];
    foreach ($apiConfig['helpers'] as $helperName) {
        $helperList[$helperName] = getHelperObj($helperName);
    }
    $apiObject->attachHelpers($helperList);

    // Adding Response
    $responseName = 'JSON';
    if (isset($apiConfig['response'])) {
        $responseName = $apiConfig['response'];
    }
    $responseObj = getResponseObj($responseName);
    $apiObject->setResponseObject($responseObj);

    // Executing the API
    $apiObject->execute();
}
