<?php

function my_press_articles_short_code_TinyMCE_buttons() {

   if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
      return;
   }

   if ( get_user_option('rich_editing') == 'true' ) {
      add_filter( 'mce_external_plugins', 'add_plugin' );
      add_filter( 'mce_buttons', 'register_button' );
   }

}

function register_button( $buttons ) {
   array_push( $buttons, "|", "sharebuttons" );
   array_push( $buttons, "|", "googlemaps" );
   return $buttons;
}

function add_plugin( $plugin_array ) {
   $plugin_array['sharebuttons'] = plugins_url('my-press-articles/js/short-code-share-buttons.js');
   $plugin_array['googlemaps'] = plugins_url('my-press-articles/js/short-code-googlemap.js');
   return $plugin_array;
}

add_action('init', 'my_press_articles_short_code_TinyMCE_buttons');
?>