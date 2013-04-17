<?php
// create my press articles option settings menu
add_action( 'admin_menu', 'my_press_articles_create_menu' );

//create menu page
function my_press_articles_create_menu() {

	//create new top-level menu
	add_menu_page( 'Option Settings Page', 'My Press Articles', 'manage_options', 'my_press_main_menu', 'my_press_main_plugin_page',  plugins_url('my-press-articles/img/mpr.png'), 6 );
	//call register settings function
	add_action( 'admin_init', 'my_press_articles_register_settings' );

}

//register plugin's settings
function my_press_articles_register_settings() {
	register_setting( 'my-press-articles-settings-group', 'my_press_articles_options' );
}

//menu page function callback
function my_press_main_plugin_page() {
?>
    <h2 class="my_press_header_setting"></h2>
    <div class="main_mypress">
	    <div class="left_mypress">
		    <h2 class="my_press_analytic"></h2>
		    <form method="post" action="options.php">
			    <?php settings_fields( 'my-press-articles-settings-group' ); ?>
			    <?php $my_press_articles_options = get_option( 'my_press_articles_options' ); ?>
			    <table class="form-table">
				    <tr valign="top">
					    <td>
					    	<textarea id="mpa_ga" name="my_press_articles_options[ga]" cols="60" rows="3"><?php echo esc_html( stripslashes( $my_press_articles_options["ga"] ) ); ?></textarea>
					    </td>
				    </tr>
                    <tr valign="top">
                        <td>
                            <p class="option"><input type="checkbox" name="my_press_articles_options[track_outbound_link]" value="1" <?php checked( '1', $my_press_articles_options["track_outbound_link"] ); ?> />   Tracking Outbound Click</p>
                        </td>
                    </tr>
                </table>
                <hr class="mypress" />
                <h2 class="my_press_quick_note" ></h2>
                <table class="form-table">
				    <tr valign="top">
					    <td>
					    	<textarea id="mpa_note" name="my_press_articles_options[note]" cols="60" rows="3"><?php echo esc_html( stripslashes( $my_press_articles_options["note"] ) ); ?></textarea>
					    </td>
				    </tr>
                </table>
                <hr class="mypress" />
                <h2 class="my_press_social_buttons" ></h2>
                <table class="form-table">
                    <tr valign="top">
                        <td>
				            <p class="option">
                               <input type="checkbox" name="my_press_articles_options[twitter]" value="1" <?php checked( '1', $my_press_articles_options["twitter"] ); ?> />   Twitter
                               <input type="checkbox" name="my_press_articles_options[facebook]" value="1" <?php checked( '1', $my_press_articles_options["facebook"] ); ?> />   Facebook
                               <input type="checkbox" name="my_press_articles_options[linkedIn]" value="1" <?php checked( '1', $my_press_articles_options["linkedIn"] ); ?> />    LinkedIn
                               <input type="checkbox" name="my_press_articles_options[google]" value="1" <?php checked( '1', $my_press_articles_options["google"] ); ?> />   Google+
                            </p>
                        </td>
                    </tr>
                </table>
		        <hr class="mypress" />
                <h2 class="my_press_relatred_posts_feature"></h2>
                <table class="form-table">
                    <tr valign="top">
                        <td>
				            <p class="option">
                                <input type="checkbox" name="my_press_articles_options[relpost]" value="1" <?php checked( '1', $my_press_articles_options["relpost"] ); ?> />   Use Related Post
                            </p>
                        </td>
                    </tr>
                </table>
                <hr class="mypress" />
                <p class="submit">
				    <input type="submit" class="button-primary" value="Save Changes" />
			    </p>
            </form>
	    </div>
        <div class="right_mypress">
            <h2 class="my_press_articles_share_plugins"></h2>
            <table class="form-table">
                    <tr valign="top">
                        <td>
                            <div class="my-press-share-buttons"><div id="fb-root"></div><script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script><fb:like href="http://wordpress.org/extend/plugins/my-press-articles/" send="false" layout="box_count" width="53" show_faces="false" font="verdana"></fb:like></div>
                            <div class="my-press-share-buttons"><script src="//platform.linkedin.com/in.js" type="text/javascript">lang: en_US</script>
                                <script type="IN/Share" data-url="http://wordpress.org/extend/plugins/my-press-articles/" data-counter="top"></script>
                            </div>
                            <div class="my-press-share-buttons"><a href="http://twitter.com/share" class="twitter-share-button" data-count="vertical" data-url="http://wordpress.org/extend/plugins/my-press-articles/">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></div>
                        </td>
                    </tr>
                    <tr valign="top">
                     <td>
                        <p class="option">
                          If you like this plugin, please help me to spread the words, thanks.
                        </p>
                     </td>
                    </tr>
            </table>
            <hr class="mypress" />
            <h2 class="my_press_articles_help"></h2>
            <table class="form-table">
                    <tr valign="top">
                        <td>
                            <p class="option">
                                If you need help, please visit <a href="http://wordpress.org/support/plugin/my-press-articles" target="_blank">the plugin's forum</a>.
                                Visit the <a href="http://onmouseenter.com/category/my-press-articles-plugin/" target="_blank">Tutorial Page</a> to learn how to use this plugin.
                                Also visit the <a href="http://wordpress.org/support/view/plugin-reviews/my-press-articles" target="_blank">Review Page</a> to review this plugin and leave any suggestions.
                            </p>
                        </td>
                    </tr>
            </table>
            <hr class="mypress" />
            <h2 class="my_press_recommend"></h2>
            <table class="form-table">
                    <tr valign="top">
                        <td>
                            <p class="option">
                               If you like this plugin, here are another two light weight plugins that you might want to download and try it out. <a href="http://wordpress.org/extend/plugins/my-beautiful-tubes/" target="_blank">1) my beautiful tubes is a light weight video plugin</a>. <a href="http://wordpress.org/extend/plugins/smart-ad-tags/" target="_blank">2) Smart AD Tags is an advertisement plugin</a>.
                            </p>
                        </td>
                    </tr>
            </table>
        </div>
    </div>

<?php
}
?>