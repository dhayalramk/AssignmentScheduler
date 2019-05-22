<?php


class DateHelper
{
    public function nextDate($currentDate)
    {
        return date('Y-m-d', strtotime($currentDate. ' + 1 days'));
    }
    public function isWeekDay($currentDay)
    {
        return !in_array(date('w', strtotime($currentDay)), [0,6]);
    }
}
