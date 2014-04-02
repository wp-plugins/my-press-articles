<?php
add_action( 'wp_head', 'my_press_articles_ga_outbound' );
add_action( 'wp_head', 'my_press_articles_ga' );
add_action('wp_head', 'my_press_articles_share_button_code');
add_action('admin_init', 'my_press_articles_includes_scripts_styles');
add_action( 'login_enqueue_scripts', 'my_press_articles_login_img' );

//display custom make style sheet for login form
function my_press_articles_login_img() {
   $my_press_articles_options = get_option( 'my_press_articles_options' );
   $login_bg_img =  $my_press_articles_options['login_bg_img'];
   $login_header_img = $my_press_articles_options['login_header_img'];
   $login_form_img = $my_press_articles_options['login_form_img'];
   $login_customize = $my_press_articles_options['login_customize'];
   if($login_customize == 1) {
?>
    <style type="text/css">
        body.login {
           background-image: url(<?php echo $login_bg_img; ?>);
        }
        body.login div#login h1 a {
           background-image: url(<?php echo $login_header_img ?>);
        }
        body.login div#login form#loginform {
           background-image: url(<?php echo $login_form_img ?>);
        }
    </style>
<?php
   }
}

//include script and styles for creating customize login form at option page
function my_press_articles_includes_scripts_styles() {
    if (isset($_GET['page']) && $_GET['page'] == 'my_press_main_menu') {
        add_action('admin_print_scripts', 'my_press_articles_login_admin_scripts');
        add_action('admin_print_styles', 'my_press_articles_login_admin_styles');
    }

}

function my_press_articles_login_admin_scripts() {
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    wp_register_script('login-form-images-upload', WP_PLUGIN_URL.'/my-press-articles/js/login-form-images-upload.js', array('jquery','media-upload','thickbox'));
    wp_enqueue_script('login-form-images-upload');
}

function my_press_articles_login_admin_styles() {
    wp_enqueue_style('thickbox');
}

//include social buttons code in header
function my_press_articles_share_button_code() {
?>
    <script type="text/javascript">
        (function() {
            var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
             po.src = 'https://apis.google.com/js/plusone.js';
             var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
        })();
    </script>

    <script>
        (function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>

    <script type="text/javascript">
        (function() {
             var li = document.createElement('script'); li.type = 'text/javascript'; li.async = true;
             li.src = ('https:' == document.location.protocol ? 'https:' : 'http:') + '//platform.stumbleupon.com/1/widgets.js';
             var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(li, s);
        })();
    </script>

    <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
<?php
}

//include analytics code in the header
function my_press_articles_ga() {
	    $my_press_articles_options = get_option( 'my_press_articles_options' );
        $my_press_articles_ga  = stripslashes($my_press_articles_options["ga"]);
        if ( strpos($my_press_articles_ga, "<script>") )  {
          echo $my_press_articles_ga;
        }
}

//include outbound link tracking code in the header
function my_press_articles_ga_outbound() {

	    $my_press_articles_options = get_option( 'my_press_articles_options' );
        $my_press_articles_track_outbound_link  = $my_press_articles_options["track_outbound_link"];
        if( $my_press_articles_track_outbound_link == 1 ) {
        ?>
            <script>
		    $("a").click(function() {
			    var $a = $(this);
			    var href = $a.attr("href");
			    // see if the link is external
			    if ( (href.match(/^http/)) && (! href.match(document.domain)) ) {
				    var category = "outgoing"; // set category to 'outgoing'
				    var event = "click"; // set event to 'click'
			    	var label = href; // set label to 'href'
				    _gaq.push(['_trackEvent'],category, event, label);
			    }
		    }
            </script>
<?php
        }
}
?>