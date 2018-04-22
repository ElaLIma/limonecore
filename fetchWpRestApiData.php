<?php

function fetchWpRestApiNewsTitle($json){
    $title = "";
    if($json["title"]["rendered"] != null){
        $title = $json["title"]["rendered"];
    }
    return $title;
}

function fetchWpRestApiNewsContent($json){
    $content= "";
    if($json["content"]["rendered"] != null){
        $content = $json["content"]["rendered"];
    }
    return $content;
}

function fetchWpRestApiNewsPubDate($json){
    $date = "";
    if($json["date"] != null){
        $date = $json["date"];
    }
    return $date;
}

function fetchWpRestApiNewsLink($json){
    $link = "";
    if($json["link"] != null){
        $link = $json["link"];
    }
    return $link;
}

function fetchWpRestApiNewsExcerpt($json){
    $except = "";
    if($json["excerpt"]["rendered"] != null){
        $excerpt = $json["excerpt"]["rendered"];
    }
    return $excerpt;
}

function fetchWpRestApiNewsImgs($json){
    $destimg= "";
    if($json["_links"]["wp:featuredmedia"] != null){
        $destimg = $json["_links"]["wp:featuredmedia"];
    }
    return $destimg;
}

function fetchWpRestApiNewsDestImgDataLink($json){
    $destimglink = "";
    if($json["_links"]["wp:featuredmedia"][0]["href"] != null){
        $destimglink = $json["_links"]["wp:featuredmedia"];
    }
    
    return $destimglink;
}

function fetchWpRestApiNewsDestImg($json){
    $ndestimglink = "";
    if((jsondata(httpRQ($json[0]["href"])))["guid"]["rendered"] != null){
        $ndestimglink = (jsondata(httpRQ($json[0]["href"])))["guid"]["rendered"];
    }
    return $ndestimglink;
}

function fetchWpRestApiNewsImgsDetails($json){
    $ndestimglink = "";
    if((jsondata(httpRQ($json[0]["href"])))["guid"]["rendered"] != null){
        $ndestimglink = (jsondata(httpRQ($json[0]["href"])))["media_details"];
    }
    return $ndestimglink;
}

function fetchWpRestApiSiteCats($json){
    $cats = "";
    if($json != null){
        $cast = $json;
    }
    return $cats;
}

function fetchWpRestApiCatName($json){
    $name = "";
    if($json["name"] != null){
        $name = $json["name"];
    }
    return $name;
}

function fetchWpRestApiCatId($json){
    $id = "";
    if($json["id"] != null){
        $id = $json["id"];
    }
    return $id;
}

function fetchWpRestApiPostId($json){
    $id = "";
    if($json["id"] != null){
        $id = $json["id"];
    }
    return $id;
}

function fetchWpRestApiPostCatIds($json){
    $catid = "";
    if($json["categories"] != null){
        $catid = $json["categories"];
    }
    return $catid;
}

function fetchWpRestApiPostTagsIds($json){
    $tagsids = "";
    if($json["tags"] != null){
        $tagsids = $json["tags"];
    }
    return $tagsids;
}

function fetchWpRestApiPostAuthor($json){
    $author = "";
    if($json["author"] != null){
        $author = $json["author"];
    }
    return $author;
}