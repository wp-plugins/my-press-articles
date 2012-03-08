<?php
/*
Plugin Name: my press articles
Plugin URI: http://gadgets-code.com/my-press-articles-tutorial-5-embed-a-google-map-with-clickable-marker
Description: Use shortcodes in your post to render Google Map, Twitter, Facebook and Youtube related services.
Version: 1.4
Author: Gadgets Choose
Author URI: http://wordpress.org/extend/plugins/my-press-articles/
License: GPLv2
*/

/* Copyright 2012 Gadgets-Code.Com (e-mail : morning131@hotmail.com)
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, please visit <http://www.gnu.org/licenses/>.
*/

//short code to render social sharing buttons

function shareB() {

   return '<div style="padding:2px;float:left;margin-top:1px;"><div id="fb-root"></div><script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script><fb:like href="" send="false" layout="box_count" width="53" show_faces="false" font="verdana"></fb:like></div>'.
'<div style="padding:2px;float:left;margin-top:1px;"><g:plusone size="tall"></g:plusone></div>'.'<div style="padding:2px;float:left;"><script type="text/javascript" src="http://platform.linkedin.com/in.js"></script><script type="in/share" data-counter="top"></script></div>'.
'<div style="padding:2px;float:left;"><a href="http://twitter.com/share" class="twitter-share-button" data-count="vertical">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></div>'.'<div style="padding:2px;float:left;margin-top:42px;"><a href="http://www.tumblr.com/share/link?url=<?php echo urlencode(INSERT_URL_HERE) ?>&name=<?php echo urlencode(INSERT_NAME_HERE) ?>&description=<?php echo urlencode(INSERT_DESCRIPTION_HERE) ?>" title="Share on Tumblr" style="display:inline-block; text-indent:-9999px; overflow:hidden; width:81px; height:20px; background:url(\'http://platform.tumblr.com/v1/share_1.png\') top left no-repeat transparent;">Share on Tumblr</a></div>';

}

add_shortcode("shareB","shareB");

//short code to render social sharing buttons on the side of the video

function vid($atts, $content=null) {

  extract(shortcode_atts(array("youtubeurl"=>'',"width"=>'',"height"=>''),$atts));

  $youtube_video_url = preg_match("/http:\/\/youtu.be\/[-\.\w]+/",$youtubeurl,$v_match);

  if($youtube_video_url==1) {

   $tube_share_link = $v_match[0];
   $tube_share_link = str_replace("http://youtu.be/","",$tube_share_link);
   $iframeV = "http://www.youtube.com/embed/$tube_share_link";

   return '<div style="float:left;padding-right:2px;"><div><a href="http://twitter.com/share" class="twitter-share-button" data-url="'.$youtubeurl.'" data-count="vertical">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></div>'.
'<div><div id="fb-root"></div><script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script><fb:like href="'.$youtubeurl.'" send="false" layout="box_count" width="30" show_faces="false" font="arial"></fb:like></div></div>'.
'<iframe title="YouTube video player" class="youtube-player" type="text/html" width="'.$width.'"  height="'.$height.'" src="'.$iframeV.'" frameborder="0" allowFullScreen></iframe>';

  } else {return "";}
}
add_shortcode("vid","vid");

//short code to render google Map

function googleMAP($atts) {

  $map_id_array = array();
  extract(shortcode_atts(array("address"=>'',"width"=>'300',"height"=>'300',"zoom"=>'13', "mapid"=>'new', "note"=>'Hello'),$atts));

  if (in_array($mapid, $map_id_array)) {
     return '';
   } else {
     array_push($map_id_array, $mapid);
     $address = esc_js($address);
     $mapid = esc_js($mapid);
     $width = esc_js($width);
     $height = esc_js($height);
     $note = esc_js($note);
     static $map_script = false;
     $renderMap='';
     if( $map_script == false ) {
       $renderMap .= '<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>';
       $map_script = true;
     }
     return $renderMap."<div id='$mapid' style='width:{$width}px;height:{$height}px;'></div>
      <script>
       function render_$mapid() {
             var geocoder = new google.maps.Geocoder();
             var address = \"$address\";
             var map;
             geocoder.geocode( { 'address': address }, function(results, status) {

              if (status == google.maps.GeocoderStatus.OK) {
                var latlng = results[0].geometry.location;
                var options = {
                  mapTypeId: google.maps.MapTypeId.ROADMAP,
                  center: latlng,
                  zoom: $zoom
                };
                map = new google.maps.Map(document.getElementById('$mapid'), options);

                var marker = new google.maps.Marker({
                  position: latlng,
                  map: map,
                });

                var mapnotes = \"<div class='map_note'><p>$note</p></div>\";
                var infowindow = new google.maps.InfoWindow({
                  content: mapnotes,
                });

                google.maps.event.addListener(marker, 'click', function() {
                   infowindow.open(map,marker);
                });

              }
             });
         }
         google.maps.event.addDomListener(window, 'load', render_$mapid);
       </script>";
    }
}
add_shortcode("googleMAP","googleMAP");

//short code for google map overlay

function googleMapOverlay($atts) {

  $map_id_array = array();
  extract(shortcode_atts(array("address"=>'',"width"=>'300',"height"=>'300',"zoom"=>'13', "mapid"=>'newmap'),$atts));

  if (in_array($mapid, $map_id_array)) {
     return '';
   } else {
     array_push($map_id_array, $mapid);
     $address = esc_js($address);
     $mapid = esc_js($mapid);
     $width = esc_js($width);
     $height = esc_js($height);
     static $map_script = false;
     $renderMap='';
     if( $map_script == false ) {
       $renderMap .= '<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>';
       $map_script = true;
     }
     return $renderMap."<div id='$mapid' style='width:{$width}px;height:{$height}px;margin-top:3px;margin-bottom:2px;'></div>
      <script>
       function render_overlay_$mapid() {
             var geocoder = new google.maps.Geocoder();
             var address = \"$address\";
             var map;
             geocoder.geocode( { 'address': address }, function(results, status) {

              if (status == google.maps.GeocoderStatus.OK) {
                var latlng = results[0].geometry.location;
                var options = {
                  mapTypeId: google.maps.MapTypeId.HYBRID,
                  center: latlng,
                  zoom: $zoom
                };
                map = new google.maps.Map(document.getElementById('$mapid'), options);

                var marker = new google.maps.Marker({
                  position: latlng,
                  map: map,
                });

                google.maps.event.addListener(marker, 'click', function() {
                   googlemapOverlay();
                });

              }
             });
         }
         google.maps.event.addDomListener(window, 'load', render_overlay_$mapid);
       </script>";
    }
}
add_shortcode("googleoverlay","googleMapOverlay");

//render the google map overlay panel
function show_map_overlay() {
 global $post;
 $whichevercode = get_post_meta($post->ID, 'presscode', true);

 if (!empty($whichevercode) && is_single()) {
  echo "<script>
     jQuery(document).ready(function() {

      jQuery('body').append('<div id=\"mypressback-map-ground\"></div>');
      jQuery('body').append('<div id=\"mypress-panel\">".$whichevercode."<br/><a href=\"#\" id=\"close-panel\">close</a></div>');

     });
     </script>";

 echo "<script>
  function googlemapOverlay() {
     jQuery(\"#mypressback-map-ground, #mypress-panel\").fadeIn(3300);
     jQuery(\"#mypress-panel a#close-panel\").click(function() {
      jQuery(\"#mypressback-map-ground, #mypress-panel\").fadeOut(2300);
     });
   }
   </script>";

 }
}

//short code to show and hide content based on referrer website

function show_hide_content($attrs,$content=null) {
   extract(shortcode_atts(array("url"=>''),$attrs));
   if($url == '') {
    return '';
   } else {
    $reff = $_SERVER['HTTP_REFERER'];
    $lookup = strpos($reff,$url);
    if($lookup) {
     return $content;
    } else {
     return '';
    }
  }
}
add_shortcode("showContent","show_hide_content");

add_action( 'wp_dashboard_setup', 'gadget_dashboard_feed' );
function gadget_dashboard_feed() {
     wp_add_dashboard_widget( 'dashboard_gadget_new', 'Developer News', 'gadget_dashboard_new');
}
function gadget_dashboard_new() {
     $gadgets_rss_feed = 'http://feeds2.feedburner.com/gadgets-code/bSHq';
     //show developer RSS feed
     echo '<div class="rss-widget">';
     wp_widget_rss_output( array(
      'url' => $gadgets_rss_feed,
      'title' => 'Developer News',
      'items' => 1,
      'show_summary' => 1,
      'show_author' => 0,
      'show_date' => 1
     ) );
     echo '</div>';
}

//include stylesheet code can be found in http://codex.wordpress.org

add_action('wp_enqueue_scripts', 'add_mypress_stylesheet');
wp_enqueue_script( 'jquery');

function add_mypress_stylesheet() {
  $myStyleUrl = plugins_url('/css/styles.css', __FILE__); // Respects SSL, styles.css is relative to the current file
  $myStyleFile = WP_PLUGIN_DIR . '/my-press-articles/css/styles.css';
  if ( file_exists($myStyleFile) ) {
   wp_register_style('mypressStyleSheets', $myStyleUrl);
   wp_enqueue_style( 'mypressStyleSheets');
  }
}

add_action('wp_footer','show_map_overlay');
add_filter( 'comment_text', 'do_shortcode' );
add_filter('widget_text', 'shortcode_unautop');
add_filter('widget_text', 'do_shortcode');
?>