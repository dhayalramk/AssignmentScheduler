
<?php

interface IAPI
{
    public function execute();
    public function initialize();
    public function checkInput();
    public function logic();
    public function output();
}
