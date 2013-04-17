<?php
add_action( 'wp_head', 'my_press_articles_ga_outbound' );
add_action( 'wp_head', 'my_press_articles_ga' );
add_action('wp_head', 'my_press_articles_share_button_code');

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

    <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
<?php
}

//include analytics code in the footer
function my_press_articles_ga() {
	    $my_press_articles_options = get_option( 'my_press_articles_options' );
        $my_press_articles_ga  = stripslashes($my_press_articles_options["ga"]);
        echo $my_press_articles_ga;
}

//include outbound link tracking code in the footer
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