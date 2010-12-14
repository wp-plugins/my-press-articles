<?php
/*
Plugin Name: my press articles
Plugin URI: http://gadgets-code.com
Description: Tweet your own wordpress article and share it with the users of this plugin
Version: 1.1
Author: Gadgets Choose
Author URI: http://gadgets-code.com
*/


/* Copyright 2010 Gadgets-Code.Com (e-mail : morning131@hotmail.com)
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

function my_press_articles_meta_box_init() {

  add_meta_box('my-press-meta',__('Tweet your article after you have published it','press-plugin'),'my_press_meta_box','post','side','default');

}

  add_action('admin_init','my_press_articles_meta_box_init');

function my_press_meta_box ($box) {

  $new_press_id = get_the_ID();
  $new_press_title = get_the_title($new_press_id);
  $new_press_link = get_permalink($new_press_id);
  $new_press_tweet = "powered by my press articles :  $new_press_title";

  echo "<a href=\"http://twitter.com/share\" class=\"twitter-share-button\" data-url=\"$new_press_link\" data-text=\"$new_press_tweet\" data-count=\"none\">Tweet</a><script type=\"text/javascript\" src=\"http://platform.twitter.com/widgets.js\"></script>";

}


function my_press_add_dashboard_widget() {

   wp_add_dashboard_widget('my_press_dashboard_widget',__('Fresh Articles','press-plugin'),'my_press_create_dashboard_widget');
}

function my_press_create_dashboard_widget() {

    $mpurl = "http://search.twitter.com/search.json?q=powered+by+my+press+articles+filter:links&rpp=3";
    $curlHand = curl_init();
    curl_setopt($curlHand,CURLOPT_URL,"$mpurl");
    curl_setopt($curlHand,CURLOPT_RETURNTRANSFER,1);
    $apiRes = curl_exec($curlHand);

    curl_close($curlHand);

    $jsonR = json_decode($apiRes);

    if($jsonR->results) {


      foreach($jsonR->results as $result) {

      $create = $result->created_at;
      $resultTexts = $result->text;
      $resultUser = $result->from_user;
      $pic = $result->profile_image_url;

      $pattern = preg_match_all("/\s+(http\:\/\/)\w+\.{0,1}\w+\.{0,1}\/{0,1}\w+\/{0,1}\w*/",$resultTexts,$matchP);

      $val = $matchP[0][0];
      $val=trim($val);

      $newUrl = " <a href=$val style=\"text-decoration:underline;\" target=\"_blank\">$val</a> ";

      $oldUrl = "/\s+(http\:\/\/)\w+\.{0,1}\w+\.{0,1}\/{0,1}\w+\/{0,1}\w*/";

      $resultTexts = preg_replace($oldUrl,$newUrl,$resultTexts);


      echo "<img style=\"width:39px;height:39px;\" src=$pic style=\"float:left; margin:2px 2px 0 0; \"/>&nbsp;
            <a href=\"http://twitter.com/$resultUser\" style=\"font-size:1.1em;color:orange;text-decoration:none;\" target=\"_blank\" >$resultUser</a><br/>
            <p style=\"text-align:justify;float:left;font-size:0.9em;color:grey;\">$resultTexts Tweet Created at&nbsp;:&nbsp;$create
            </p>
            ";
      }}

      else echo '';
   }

    add_action('wp_dashboard_setup','my_press_add_dashboard_widget');

function my_press_articles_deactivate(){
     $these_blogg = get_bloginfo('url');
     wp_mail("Passionandlove3@hotmail.com","my press articles deactivated","$these_blogg has deactivated your plugin.");
    }

    register_deactivation_hook(__FILE__,'my_press_articles_deactivate');

?>