#!/usr/bin/php
<?php
include_once ('httprq.php');


function gePressNewsData($url,$data){
    $subHeading = 0;
    $img = 1;
    $text = 2;

    $htmlData = httprq($url);
    libxml_use_internal_errors(true); // Prevents HTML errors from displaying
    $doc = new DOMDocument();
    $doc->loadHTML($htmlData);
    $domDivs = $doc->getElementsByTagName('div');
    foreach ($domDivs as $div) {
        if($div->getAttribute('class') == 'content_container_left'){
            switch($data){

                case $subHeading:
                case $text:

                    $spans = $div->getElementsByTagName('span');
                    foreach($spans as $span){
                        if($data == $subHeading){
                            if($span->getAttribute('class') == 'textolow texto_separadora negrita'){
                                return  filter_var($span->nodeValue, FILTER_SANITIZE_STRING);
                            }
                        }
                        else{
                            if($span->getAttribute('class') == 'textonoticia'){
                               $scripts = $span->getElementsByTagName('script');
                                foreach($scripts as $script){
                                        $span->removeChild($script);
                                 }

                                $divs2 = $span->getElementsByTagName('div');
                                foreach($divs2 as $div2){
                                     if($div2->getAttribute('id') == 'gallery'){
                                         $span->removeChild($div2);
                                     }
                                 }
                                return  filter_var($span->nodeValue, FILTER_SANITIZE_STRING);
                            }
                        }
                       
                    }
                break;

                case $img:
                    $as = $div->getElementsByTagName('a');
                    foreach($as as $a){
                        if($a->getAttribute('id') == 'primerafoto'){
                            return  filter_var($a->getAttribute('href'), FILTER_SANITIZE_STRING);
                        }
                    }
                break;
            }
            
        }
    }
}


/*$urls = "http://www.guineaecuatorialpress.com/noticia.php?id=10264";

print gePressNewsDOMElement($urls,0) . "\n\r";
print gePressNewsDOMElement($urls,1) . "\n\r";
print gePressNewsDOMElement($urls,2) . "\n\r";*/

