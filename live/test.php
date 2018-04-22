#!/usr/bin/php
<?php
include ('inc.php');

$db = dbConnect();

foreach ($sites as $site){
    if($site["fetchType"] == "rss1-2"){
        print("\n".$site["name"]);
        //Obtaining data
        $tblname = $site["tblname"] ; 
        $xmlurl = $site["url"] . $site["datapath"];
        $xmldata = httpRQ($xmlurl);
        $xml = simplexml_load_string($xmldata);
       
        switch($site["site-code"]){
            case 'asdg2':
            case 'lgc':{
                $rss = new DOMDocument();
                $rss->load($xmlurl);
                $feed = array();
                foreach ($rss->getElementsByTagName('item') as $node) {
                            $title = $node->getElementsByTagName('title')->item(0)->nodeValue;
                            $link = $node->getElementsByTagName('link')->item(0)->nodeValue;
                            $pubDate = $node->getElementsByTagName('pubDate')->item(0)->nodeValue;
                            $description = $node->getElementsByTagName('description')->item(0)->nodeValue;
                            $content = $node->getElementsByTagName('encoded')->item(0)->nodeValue;
                            $content = iconv(mb_detect_encoding($content, mb_detect_order(), true), "UTF-8", $content);
                            if($site["site-code"] == "lgc"){
                                $destimg = explode("\"",$content)[1];

                            }else{
                                $destimg = "http://www.asodeguesegundaetapa.org/wp-content/themes/asodegueseg/images/header/Asodegue-logo-cabecera.png";
                            }
                            $dbdata = array($title,$content,$pubdate,$link,$destimg); 
                            //print_r ($dbdata);
                            dbInsertXML($tblname,$dbdata,$db);
            
                }
            }
            break;
            case 'lov':{
                foreach($xml->channel->item as $itm){
                    $title =  fetchXmlNewsTitle($itm);
                    $pubdate = fetchXmlNewsPubDate($itm);
                    $link = fetchXmlNewsLink($itm);
                    $destimg = fetchXmlNewsImg($itm);
                    $content = fetchXmlNewsExcerpt($itm);
                    $content = iconv(mb_detect_encoding($content, mb_detect_order(), true), "UTF-8", $content);
                    $dbdata = array($title,$content,$pubdate,$link,$destimg); 
                    dbInsertXML($tblname,$dbdata,$db);

                }
                

            }
            break;
            case 'gepress':{
                foreach($xml->channel->item as $itm){
                    $title =  fetchXmlNewsTitle($itm);
                    $pubdate = fetchXmlNewsPubDate($itm);
                    $link = fetchXmlNewsLink($itm);
                    $destimg = gePressNewsData($link,1);
                    $subheading = gePressNewsData($link,0);
                    $content = gePressNewsData($link,2);
                    $content = iconv(mb_detect_encoding($content, mb_detect_order(), true), "UTF-8", $content);
                    $dbdata = array($title,$content,$pubdate,$link,$destimg); 
                    dbInsertXML($tblname,$dbdata,$db);
                }
                
            }
            break;
            default:
            break;

    }
        
    }else if ($site["fetchType"] == "wprestapi"){
        $tblname = $site["tblname"] ; 
        $jsonURL = $site["url"] . $site["datapath"];
        $jsonData = jsonData(httpRQ($jsonURL));
        foreach($jsonData as $json){
            $title = fetchWpRestApiNewsTitle($json);
            $link = fetchWpRestApiNewsLink($json);
            $content = fetchWpRestApiNewsContent($json);
            $content = iconv(mb_detect_encoding($content, mb_detect_order(), strict), "UTF-8", $content);
            $pubDate = fetchWpRestApiNewsPubDate($json);
            $destimg = fetchWpRestApiNewsDestImg(fetchWpRestApiNewsImgs($json));
            $excerpt = fetchWpRestApiNewsExcerpt($json);
            $excerpt = iconv(mb_detect_encoding($excerpt, mb_detect_order(), strict), "UTF-8", $excerpt);

            $dbdata = array($title,$content,$excerpt,$pubDate,$link,$destimg); 
            dbInsertWPRESTAPI($tblname,$dbdata,$db);

        }
    }
}

?>


