<?php
include_once ('httprq.php');
function laOtraVozNewsData($url){
    $htmlData = httprq($url);
    libxml_use_internal_errors(true); // Prevents HTML errors from displaying
    $doc = new DOMDocument();
    $doc->loadHTML($htmlData);
    $domDivs= ($doc->getElementsByTagName('div'));
    foreach ($domDivs as $div) {
        if($div->getAttribute('class') == 'entry-content instapaper_body'){
            return  filter_var($div->nodeValue, FILTER_SANITIZE_STRING);
        }
    }
}


// $url ="https://www.laotravoz.info/Guinee-Equatoriale-Coup-d-Etat-manque-ce-jeudi-28-decembre_a2662.html";
// print(laOtraVozNewsData($url));