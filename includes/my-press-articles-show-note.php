<?php
function note($content) {
 $my_press_articles_options = get_option( 'my_press_articles_options' );
 $notecolor =   $my_press_articles_options["notecolor"];
 $shows_note  = $my_press_articles_options["note"];
 $note = '';
 if(is_single() && $shows_note)   {

  $note = "<div class='my_press_note' style='background-color:" .$notecolor. ";'>". $shows_note."</div>";

 }
 return $content.$note;
}

add_filter('the_content', 'note');
?>