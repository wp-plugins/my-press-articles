<?php
function note($content) {
 $my_press_articles_options = get_option( 'my_press_articles_options' );
 $shows_note  = $my_press_articles_options["note"];
 $note = '';
 if(is_single() && $shows_note)
  $note = "<div class='my_press_note'>".$shows_note."</div>";
 return $content.$note;
}

add_filter('the_content', 'note');
?>