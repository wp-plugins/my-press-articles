<?php
add_filter( 'the_content', 'display_related_posts' );

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
                     "posts_per_page" => 4,
                     "caller_get_posts" =>1
                    );
         $relatedposts = new WP_Query($args);
         if($relatedposts->have_posts()):
             $content.= "<div class='my_press_articles_related_post_main_wraps'>";
             while ($relatedposts->have_posts()) : $relatedposts->the_post();
              $rel_post_permalink = get_permalink($post_id);
              $content.= '<a href="'.$rel_post_permalink."\"><div class='my_press_articles_related_post_sub_wraps'>
                         <div class='my_press_articles_related_posts_img_wraps'>";
              $thumnail =  get_the_post_thumbnail($post_id, array(100,100) );
              if( !$thumnail ) {
                 $thumnail .=  '<img src ="';
                 $thumnailurl = plugins_url('my-press-articles/img/rposts.png');
                 $thumnail.=  $thumnailurl.'"/>';
              }
              $content.= $thumnail;
              $content.=  '</div>
                <div class="my_press_articles_related_post_text_wraps">';
                    $rel_post_title = get_the_title();
                    $content.= $rel_post_title;
                $content.='</div></a></div>';
             endwhile;
          $content.= '</div>';
        endif;
        wp_reset_query();

      }
      return $content;
}
?>