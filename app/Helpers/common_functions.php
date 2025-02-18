<?php
if (!function_exists('generate_uuid_key')) {
    function generate_uuid_key()
    {
        $contractId = strtotime(date('Y-m-d H:i:s')) . '-' . Str::random(4) . '-' . Str::random(6) . '-' . Str::random(8) . '-' . Str::random(10) . '-' . Str::random(12);
        return $contractId;
    }
}
if (!function_exists('generate_gift_code')) {
    function generate_gift_code()
    {
        $code = random_int(100000000000, 999999999999);
        return $code;
    }
}
if (!function_exists('getRandomLightColor')) {
    function getRandomLightColor($index)
    {
        $colors = array('#9d6a69', '#954daf', '#db38bf', '#60a151', '#b9a024', '#3739ba', '#a57449', '#89ae90', '#38c73e', '#ab473c', '#bf443f', '#842463', '#fd6432', '#c08fe3', '#2451a3', '#b20402', '#19639d', '#e34f64', '#9b27e9');
        return $colors[$index];
        
    }
}