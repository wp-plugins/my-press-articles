<?php
//Remove comment link
function remove_comment_link($fields) {
        $my_press_articles_options = get_option( 'my_press_articles_options' );
        $remove_link  = $my_press_articles_options["comment_link"];
        if($remove_link == 1) {
	      unset($fields['url']);
        }
	    return $fields;
}
add_filter('comment_form_default_fields','remove_comment_link');

//Social buttons at top and bottom of content
function add_social_buttons($content) {
        $my_press_articles_options = get_option( 'my_press_articles_options' );
        $social_top  = $my_press_articles_options["social_top"];
        $social_bottom  = $my_press_articles_options["social_bottom"];
        $sharing_buttons = '<div class="my-press-share-buttons-main-content-area">
                             <div class="my-press-share-buttons"><div id="fb-root"></div><script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script><fb:like send="false" layout="box_count" width="53" show_faces="false" font="verdana"></fb:like></div>
                             <div class="my-press-share-buttons">
                                <script src="//platform.linkedin.com/in.js" type="text/javascript">lang: en_US</script>
                                <script type="IN/Share" data-counter="top"></script>
                             </div>
                             <div class="my-press-share-buttons">
                                <su:badge layout="5"></su:badge>
                             </div>
                             <div class="my-press-share-buttons">
                                <g:plusone size="tall"></g:plusone>
                             </div>
                             <div class="my-press-share-buttons"><a href="http://twitter.com/share" class="twitter-share-button" data-count="vertical">Tweet</a></div>
                            </div>';
        if($social_top == 1) {
	      $content = $sharing_buttons.$content;
        }
        if($social_bottom == 1) {
	      $content = $content.$sharing_buttons;
        }
	    return $content;
}
add_filter('the_content','add_social_buttons');
?>