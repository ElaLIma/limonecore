<?php


class News{
    private $title, $excerpt,$pubDate,$content,$src,$link,$destImg;

    function __construct($title,$excerpt,$pubDate,$content,$src,$link,$destImg) {
    $this.$title = $title;
    $this.$excerpt = $excerpt;
    $this.$pubDate = $pubDate;
    $this.$content = $content;
    $this.$src = $src;
    $this.$link = $link;
    $this.$destImg = $destImg;        
    }

    public function getTitle(){
        return $this.$title;
    }
    public function getExcerpt(){
        return $this.$excerpt;
    }
    public function getPubDate(){
        return $this.$pubDate;
    }
    public function getContent(){
        return $this.$content;
    }
    public function getSrc(){
        return $this.$src;
    }
    public function getLink(){
        return $this.$lik;
    }
    public function getDestImg(){
        return $this.$destImg;
    }
}
?>