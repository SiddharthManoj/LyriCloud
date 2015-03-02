<?php
/**
 * Created by PhpStorm.
 * User: SidManoj
 * Date: 2/26/15
 * Time: 8:09 PM
 */
#ini_set('allow_url_fopen', 'on');
#ini_set("user_agent", "PHP");
function getLyricsByArtist()
{
    include_once('simple_html_dom.php');
    // Create DOM from URL or file
    $artist = "Britney Spears";
    $artist = str_replace(" ","-",$artist);
    $artist = strtolower($artist);
    $html = file_get_html('http://www.metrolyrics.com/'. $artist . '-lyrics.html');
    $song_links = array();
    $str = "";
    $song_size = 99;
    $massivesonglyrics = "";
    if(count($song_links > 99)){
        $song_size = 99;
    }
    else{
        $song_size = count($song_links);
    }
    echo $song_size;
    foreach($html->find('a') as $element) {
        if (strpos($element,'-lyrics-' . $artist) !== false) {
            $song_links[] = $element->href;
        }
    }
    for($x = 0; $x<$song_size; $x++){
        $htmlsong = file_get_html($song_links[$x]);
        foreach($htmlsong->find('div[id=lyrics-body-text]') as $lyrics ) {
            $str = preg_replace("/\[([^\[\]]++|(?R))*+\]/", "", $lyrics);
            $massivesonglyrics = $massivesonglyrics . $str;
            echo $str;

        }
    }
    return $massivesonglyrics;


}
function getSongsByWord(){
    include_once('simple_html_dom.php');
    // Create DOM from URL or file
    $artist = "Kanye West";
    $word = "nigga";
    $artist = str_replace(" ","-",$artist);
    $artist = strtolower($artist);
    $html = file_get_html('http://www.metrolyrics.com/'. $artist . '-lyrics.html');
    $song_links = array();
    $str = "";
    $song_size = 10;
    if(count($song_links > 10)){
        $song_size = 10;
    }
    else{
        $song_size = count($song_links);
    }
    foreach($html->find('a') as $element) {
        if (strpos($element,'-lyrics-' . $artist) !== false) {
            $song_links[] = $element->href;
        }
    }
    $array_songs = array();
    for($x = 0; $x<$song_size; $x++){
        $htmlsong = file_get_html($song_links[$x]);
        foreach($htmlsong->find('div[id=lyrics-body-text]') as $lyrics ) {
            $str = preg_replace("/\[([^\[\]]++|(?R))*+\]/", "", $lyrics);
            if (strpos($str, strtolower($word)) !== false || strpos($str, strtoupper($word)) !== false ){
                foreach ($htmlsong->find('span[class=title]') as $title) {
                    $array_songs[] = $title;
                }
            }
        }
    }
    return $array_songs;
}


$hello = getSongsByWord();
for($x = 0; $x<count($hello); $x++){
    echo $hello[$x] . "</br>";
}
exit;
#getLyricsByArtist();


?>