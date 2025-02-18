<?php

function randomNumber(){
    return  rand(1111,9999);
}
function storeFile($file, $path="storage"){
    $file=$file;
    $filename=rand().'.'.$file->getClientOriginalExtension();
    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }
    $file->move(public_path($path),$filename);
    return $path . '/' . $filename;
}

function decimalFormatNumber($number){
    return number_format($number,2);
}
