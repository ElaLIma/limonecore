<?php
function fetchXmlNewsTitle($item){
    return (string)$item->title;
}

function fetchXmlNewsExcerpt($item){
    
    return (string)$item->description;
}

function fetchXmlNewsContent($item){
    
    return (string)$item->content[":encoded"];
}

function fetchXmlNewsLink($item){
    
    return (string)$item->link;
}

function fetchXmlNewsPubDate($item){

    // print($item->pubDate . "\n");
    $date = DateTime::createFromFormat('D, d M Y H:i:s T', $item->pubDate);
    $dateString = $date->format('Y-m-d G:i:s');
    // $dateObj = DateTime::createFromFormat('Y-m-d G:i:s', $dateString);
    // print($date->format('Y-m-d G:i:s'));
    // print date("D, d M Y H:i:s T", strtotime($item->pubDate))->format('Y-m-d G:i:s');
    return $dateString;
    // return DateTime::createFromFormat('Y-m-d G:i:s',DateTime::createFromFormat('D, d M Y H:i:s T', $item->pubDate)->format('Y-m-d G:i:s'));
    
}

function fetchXmlNewsPubDateLOV($item){

    // return date("D, d M Y H:i:s T", strtotime($item->date));
    print($item);
    // return DateTime::createFromFormat('Y-m-d G:i:s',DateTime::createFromFormat('D, d M Y H:i:s T', $item->dc[":date"])->format(DATE_W3C));
    
}

function fetchXmlNewsImg($item){
    
    return (string)$item->photo[":imgsrc"];
}


?>