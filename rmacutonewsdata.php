<?php
include_once ('httprq.php');
function rMacutoNewsData($url){
    
        $htmlData = httprq($url);
        libxml_use_internal_errors(true); // Prevents HTML errors from displaying
        $doc = new DOMDocument();
        $doc->loadHTML($htmlData);
        $domDivs = ($doc->getElementsByTagName('article'))[0]->getElementsByTagName('div');
        foreach ($domDivs as $div) {

                $scripts = $div->getElementsByTagName('script');
                foreach($scripts as $script){
                        $div->removeChild($script);
                }

                $styles = $div->getElementsByTagName('style');
                foreach($styles as $style){
                        $div->removeChild($style);
                }
    
                $divs2 = $div->getElementsByTagName('div');
                //$div->removeChild($divs2[0]);
                foreach($divs2 as $div2){
                        if($div2->getAttribute('class') == 'fbck_share'){
                                    $div->removeChild($div2);
                        }elseif($div2->getAttribute('class') == 'huge-it-share-buttons nobackground'){
                            $div->removeChild($div2);
                        }
                        elseif($div2->getAttribute('id') == 'wpdevar_comment_1'){
                            $div->removeChild($div2);
                        }elseif($div2->getAttribute('id') == 'widget'){
                            $div->removeChild($div2);
                        }
                        
                }
                
                $iframes = $div->getElementsByTagName('iframe');
                foreach($iframes as $iframe){
                        if($iframe->getAttribute('id') == ('twitter-widget-0')){
                                    $div->removeChild($iframe);
                        }
                        if($iframe->getAttribute('class') == ('twitter-hashtag-button twitter-hashtag-button-rendered twitter-tweet-button')){
                            $div->removeChild($iframe);
                        }
                }

                $as = $div->getElementsByTagName('a');
                foreach($as as $a){
                        if($a->getAttribute('class') == 'twitter-hashtag-button'){
                            //$div->removeChild($a);
                        }

                        
                }

                return  filter_var($div->nodeValue, FILTER_SANITIZE_STRING);
                                
            
                           
        }
                   
}
                
   


// $urls = "http://www.radiomacuto.cl/2017/09/02/gabon-y-guinea-ecuatorial-por-encima-de-camerun-en-el-ranking-de-consumo-de-alcohol-en-la-zona-cemac/";

// print rMacutoNewsData($urls) . "\n\r";


