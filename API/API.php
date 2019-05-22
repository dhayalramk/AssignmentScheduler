<?php

class API
{
    protected $helpers = [];
    protected $responseObj = null;

    public function __construct()
    {
    }

    public function attachHelpers($helperList)
    {
        foreach ($helperList as $helperName => $helperObj) {
            $this->attachHelper($helperName, $helperObj);
        }
    }

    public function attachHelper($helperName, $helperObj)
    {
        $this->helpers[$helperName] = $helperObj;
    }

    public function setResponseObject($responseObj)
    {
        $this->responseObj = $responseObj;
    }

    public function getHelper($helperName)
    {
        if (isset($this->helpers[$helperName])) {
            return $this->helpers[$helperName];
        }
        return null;
    }
}
