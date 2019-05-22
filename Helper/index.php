<?php



$_helper = [
    'DateHelper' => [ 'fileLocation' => 'DateHelper.php', 'className' => 'DateHelper' ]
];

function getHelperObj($helperName)
{
    global $_helper;
    include_once $_helper[$helperName]['fileLocation'];
    return new $_helper[$helperName]['className']();
}
