<?php
//short code to change text color
function textcolor($atts, $content = null) {

  extract(shortcode_atts(array("color"=>'red'),$atts));

  return "<span style=\"color:$color;\">$content</span>";
}

add_shortcode("textcolor","textcolor");

//short code to render social sharing buttons
function shareB($atts, $content = null) {

   return '<div class="my-press-share-buttons-main"><div class="my-press-share-buttons"><div id="fb-root"></div><script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script><fb:like href="" send="false" layout="box_count" width="53" show_faces="false" font="verdana"></fb:like></div>'.
'<div class="my-press-share-buttons"><g:plusone size="tall"></g:plusone></div>'.'<div class="my-press-share-buttons"><script type="text/javascript" src="http://platform.linkedin.com/in.js"></script><script type="in/share" data-counter="top"></script></div>'.
'<div class="my-press-share-buttons"><a href="http://twitter.com/share" class="twitter-share-button" data-count="vertical">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></div>'.'<div class="my-press-share-buttons"><a href="http://www.tumblr.com/share/link?url=<?php echo urlencode(INSERT_URL_HERE) ?>&name=<?php echo urlencode(INSERT_NAME_HERE) ?>&description=<?php echo urlencode(INSERT_DESCRIPTION_HERE) ?>" title="Share on Tumblr" style="display:inline-block; text-indent:-9999px; overflow:hidden; width:81px; height:20px; background:url(\'http://platform.tumblr.com/v1/share_1.png\') top left no-repeat transparent;">Share on Tumblr</a></div></div>';

}

add_shortcode("shareB","shareB");

//short code to render social sharing buttons at the side of the video
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

add_action('wp_footer','show_map_overlay');
add_filter( 'comment_text', 'do_shortcode' );
add_filter('widget_text', 'shortcode_unautop');
add_filter('widget_text', 'do_shortcode');
?>