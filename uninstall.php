<?php
 if (!defined('ABSPATH') && !defined('WP_UNINSTALL_PLUGIN')){
   exit();
 }

 delete_option( 'my_press_articles_options' );
 delete_option( 'my_press_clean_it_up_remove_revision_options' );
?>