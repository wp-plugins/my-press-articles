<?php
add_filter( 'the_content', 'display_related_posts', 1 );

function display_related_posts($content){
      global $post;
      $my_press_articles_options = get_option( 'my_press_articles_options' );
      $shows_related_posts  = $my_press_articles_options["relpost"];
      if(is_single() && $shows_related_posts) {

         $categories = get_the_category($post->ID);
         $catname = $categories[0]->cat_name;
         $args = array(
                     "category_name" => $catname,
                     "post__not_in" => array($post->ID),
                     "posts_per_page" => 7,
                     "caller_get_posts" =>1
                    );
         $relatedposts = new WP_Query($args);
         if($relatedposts->have_posts()):
             $content.= '<div class="my_press_articles_related_post_main_wraps"><p class="my_press_articles_related_post_heading">Related Post</p>';
             while ($relatedposts->have_posts()) : $relatedposts->the_post();
              $rel_post_permalink = get_permalink($post_id);
              $rel_post_title = get_the_title();
              $content.= '<div class="my_press_articles_related_post_text_wraps"><a href="'.$rel_post_permalink.'">'.$rel_post_title.'</a></div>';
             endwhile;
             $content.= '</div>';
         endif;
         wp_reset_query();

      }
      return $content;
}
?>