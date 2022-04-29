<?php

use Morilog\Jalali\Jalalian;


function jalaliDate($date, $format = '%A , %d %B %Y H:i')
{
    return Jalalian::forge($date)->format($format);
    
}

