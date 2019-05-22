<?php

class JSONResponse implements IResponse
{
    public function __construct()
    {
    }
    public function output($data)
    {
        echo json_encode($data);
    }
}
