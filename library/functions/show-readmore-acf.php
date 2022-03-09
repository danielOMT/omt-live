<?php
function showBeforeMore($fullText){
    if(strpos($fullText, '</h2')){
        $startpos = strpos($fullText, '</h2>');
        $fullText = substr($fullText, $startpos);
    } elseif(strpos($fullText, '<!--more-->')){
        $morePos = strpos($fullText, '<!--more-->');
        print substr($fullText,0,$morePos);
//print "<span class=\"read-more\"><a href=\"". get_permalink() . "\" class=\"read-more-link\">Read More</a></span>";
    } else {
        print strip_tags(substr($fullText, 0 , 222)) . "...";
    }
}

function generate_excerpt_magazin($fullText)
{
    if (strpos($fullText, '<!--more-->')) {
        $morePos = strpos($fullText, '<!--more-->');
        print substr($fullText, 0, $morePos);
//print "<span class=\"read-more\"><a href=\"". get_permalink() . "\" class=\"read-more-link\">Read More</a></span>";
    } else {
        $string = strip_tags(substr($fullText, 0, 200));
        if (strpos($string, "]") > 0) { //if theres a shortcode in the beginning of the article string, we position ourselves behind the closing ]
            $string = strip_tags(substr($fullText, 0, 400));
            $string = trim(substr($string, strpos($string, ']')));
            echo substr($string, 1, 200);
        } else {
            print $string;
        }
    }
}