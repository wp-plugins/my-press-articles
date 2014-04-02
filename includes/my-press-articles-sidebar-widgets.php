<?php
//register social buttons sidebar widget
wp_register_sidebar_widget(
    'my_press_sticky_post_widget',   // unique widget id
    'Sticky Posts Widget',          // widget name
    'my_press_sticky_posts_widget_display',  // callback function
    array(                  // options
        'description' => 'Display Sticky Posts'
    )
);

//callback function for my_press_sticky_post_widget
function my_press_sticky_posts_widget_display() {

 // only shows on single post and homepage
 if( is_single() || is_home() ) {

  $my_press_articles_options = get_option( 'my_press_articles_options' );
  $args = array(
   'posts_per_page' => 10,
   'post__in' => get_option('sticky_posts'),
   'order'=>'DESC'
  );
  query_posts( $args );
  if ( have_posts() ) :
   echo "<h3 class=\"my_press_articles_sticky_widgets_header\">Feature Post</h3>";
   while ( have_posts() ) : the_post();
     echo "<div id='my_press_articles_sticky_posts_widget' class='widget my_press_articles_sticky_posts_widget'>";
    ?>
   <div class="my_press_articles_sticky_posts_img_wraps">
        <?php
         if($sticky_post_thumnail = get_the_post_thumbnail($post_id, array(100, 100)))  {
           $sicky_post_permalink =  get_permalink($post_id);
           $sticky_thumnail =  '<a href="'.$sicky_post_permalink.'">'.$sticky_post_thumnail.'</a>';
           echo $sticky_thumnail;
         } else {
           $sicky_post_permalink =  get_permalink($post_id);
           $sticky_post_thumnail .=  '<a href="'.$sicky_post_permalink.'"><img src ="';
           $sticky_posts_thumnail = plugins_url('my-press-articles/img/sposts.png');
           $sticky_post_thumnail.=  $sticky_posts_thumnail.'"/></a>';
           echo $sticky_post_thumnail;
         }
         ?>
    </div>
    <div class="my_press_articles_sticky_posts_text_wraps">
        <a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>" style="color:<?php echo $my_press_articles_options['featurepost_color']?>;"><?php the_title() ?></a>
    </div>
 <?php
     echo "</div>";
   endwhile;
 endif;
 wp_reset_query();
 }
}

//register social buttons sidebar widget
wp_register_sidebar_widget(
    'my_press_social_widget',        	// unique widget id
    'Social Button',          		// widget name
    'my_press_social_widget_display',  		// callback function
    array(                  // options
        'description' => 'Display Social Buttons'
    )
);

//callback function for my_press_social_widget
function my_press_social_widget_display() {
 // only shows on single post
 if(is_single()) {
 ?>
   <div class="my_press_widgets_wraps">
    <h3 class="my_press_articles_sidebar_widgets_header"></h3>
   <?php
     $my_press_articles_options = get_option( 'my_press_articles_options' );
     $tw  = $my_press_articles_options["twitter"];
     $fb  = $my_press_articles_options["facebook"];
     $li  = $my_press_articles_options["linkedIn"];
     $google  = $my_press_articles_options["google"];

     if( $tw == 1 ) {
    ?>
     	<div class="my_press_social_widgets_wraps">
		    <a href="http://twitter.com/share" class="twitter-share-button" data-count="vertical">Tweet</a>
     	</div>
    <?php
     }
     if($google == 1) {
     ?>
     <div class="my_press_social_widgets_wraps">
        <div class="g-plusone" data-size="tall"></div>
     </div>
    <?php
     }
     if( $li == 1 ) {
    ?>

     <div class="my_press_social_widgets_wraps">
	    <script src="//platform.linkedin.com/in.js" type="text/javascript">
            lang: en_US
        </script>
        <script type="IN/Share" data-counter="top"></script>
     </div>
     <?php
     }
     if( $fb == 1 ) {
    ?>
     	<div class="my_press_social_widgets_wraps">
		    <div id="fb-root"></div>
            <div class="fb-like" data-send="false" data-layout="box_count" data-width="450" data-show-faces="false" data-font="tahoma"></div>
        </div>

       <?php
    } ?>
    </div>
    <hr class='my_press_articles_widget_seperator'/>
   <?php
  }
 }

//register facebook fanpage sidebar widget
wp_register_sidebar_widget(
    'my_press_facebookfan_widget',        	// unique widget id
    'Facebook Fan Page',          		// widget name
    'my_press_facebookfanpage_widget_display',  		// callback function
    array(                  // options
        'description' => 'Display Facebook Fan Page'
    )
);

//callback function for my_press_facebookfan_widget
function my_press_facebookfanpage_widget_display() {
 // only shows on single post and homepage
 if(is_single() || is_home()) {
 ?>
   <?php
     $my_press_articles_options = get_option( 'my_press_articles_options' );
     $fb_url  = $my_press_articles_options["facebook_fan_url"];
     $fb_wid  = $my_press_articles_options["facebook_fan_width"];
     $fb_ht  = $my_press_articles_options["facebook_fan_height"];

     if( $fb_url ) {
    ?>
          <div class="my_press_facebook_fanpage_widgets_wraps">
		    <div class="fb-like-box" data-href="<?php echo $fb_url; ?>"
             data-width="<?php echo $fb_wid?$fb_wid:250; ?>" data-height="<?php echo $fb_ht? $fb_ht:250; ?>" data-show-faces="true" data-stream="true" data-header="true">
            </div>
          </div>
    <?php
     }?>
    <hr class='my_press_articles_widget_seperator'/>
   <?php
  }
 }
?>