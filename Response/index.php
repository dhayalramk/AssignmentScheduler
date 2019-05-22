<?php

include_once 'Interface/IResponse.php';

$_response = [
    'JSON' => [ 'fileLocation' => 'JSONResponse.php', 'className' => 'JSONResponse' ]
];

function getResponseObj($responseName)
{
    global $_response;
    include_once $_response[$responseName]['fileLocation'];
    return new $_response[$responseName]['className']();
}
