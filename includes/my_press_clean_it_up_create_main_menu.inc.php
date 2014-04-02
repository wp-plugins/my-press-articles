<?php
function my_press_clean_it_up_remove_revision_validate_options($input) {

	global $select_options, $wpdb;
	
	if ( !isset( $input['remove_empty_tag'] ) )
		$input['remove_empty_tag'] = null;
	$input['remove_empty_tag'] = ( $input['remove_empty_tag'] == 1 ? 1 : 0 );
	
	if($input['remove_empty_tag'] == 1) {
		
   	    $wpdb->query( "
					DELETE FROM $wpdb->terms WHERE term_id IN (SELECT term_id FROM $wpdb->term_taxonomy WHERE count = 0 AND taxonomy = 'post_tag' )
				");
   	    $wpdb->query( "
					DELETE FROM $wpdb->term_taxonomy WHERE term_id not IN (SELECT term_id FROM $wpdb->terms)
				");
   	    $wpdb->query( "
					DELETE FROM $wpdb->term_relationships WHERE term_taxonomy_id not IN (SELECT term_taxonomy_id FROM $wpdb->term_taxonomy)
				");
	}
	
	if ( !isset( $input['remove_empty_category'] ) )
		$input['remove_empty_category'] = null;
	$input['remove_empty_category'] = ( $input['remove_empty_category'] == 1 ? 1 : 0 );
	
	if($input['remove_empty_category'] == 1) {
		
   	    $wpdb->query( "
					DELETE FROM $wpdb->terms WHERE term_id IN (SELECT term_id FROM $wpdb->term_taxonomy WHERE count = 0 AND taxonomy = 'category' )
				");
   	    $wpdb->query( "
					DELETE FROM $wpdb->term_taxonomy WHERE term_id not IN (SELECT term_id FROM $wpdb->terms)
				");
   	    $wpdb->query( "
					DELETE FROM $wpdb->term_relationships WHERE term_taxonomy_id not IN (SELECT term_taxonomy_id FROM $wpdb->term_taxonomy)
				");
	}
	
	if ( ! isset( $input['remove_post_revision'] ) )
		$input['remove_post_revision'] = null;
	$input['remove_post_revision'] = ( $input['remove_post_revision'] == 1 ? 1 : 0 );
	
	if($input['remove_post_revision'] == 1) {
		$query = $wpdb->prepare(
	            "
	            DELETE a,b,c 
                FROM $wpdb->posts a 
	            LEFT JOIN $wpdb->term_relationships b ON (a.ID = b.object_id) 
	            LEFT JOIN $wpdb->postmeta c ON (a.ID = c.post_id) 
	            WHERE a.post_type = %s", 'revision' );
   	    $wpdb->query( $query );
	}
	
	if ( ! isset( $input['remove_trash_post'] ) )
		$input['remove_trash_post'] = null;
	$input['remove_trash_post'] = ( $input['remove_trash_post'] == 1 ? 1 : 0 );
	
	if($input['remove_trash_post'] == 1) {
		$query = $wpdb->prepare(
	            "
	            DELETE a,b,c 
                FROM $wpdb->posts a 
	            LEFT JOIN $wpdb->term_relationships b ON (a.ID = b.object_id) 
	            LEFT JOIN $wpdb->postmeta c ON (a.ID = c.post_id) 
	            WHERE a.post_status = %s", 'trash' );
   	    $wpdb->query( $query );
	}
	
	if ( ! isset( $input['remove_autodraft_post'] ) )
		$input['remove_autodraft_post'] = null;
	$input['remove_autodraft_post'] = ( $input['remove_autodraft_post'] == 1 ? 1 : 0 );
	
	if($input['remove_autodraft_post'] == 1) {
		$query = $wpdb->prepare(
	            "
	            DELETE a,b,c 
                FROM $wpdb->posts a 
	            LEFT JOIN $wpdb->term_relationships b ON (a.ID = b.object_id) 
	            LEFT JOIN $wpdb->postmeta c ON (a.ID = c.post_id) 
	            WHERE a.post_status = %s", 'auto-draft' );
   	    $wpdb->query( $query );
	}
	
	if ( ! isset( $input['remove_unapproved_comments'] ) )
		$input['remove_unapproved_comments'] = null;
	$input['remove_unapproved_comments'] = ( $input['remove_unapproved_comments'] == 1 ? 1 : 0 );
	
	if($input['remove_unapproved_comments'] == 1) {
		$wpdb->query( "
					DELETE FROM $wpdb->comments WHERE comment_approved = 0
				");
		$wpdb->query( "
					DELETE FROM $wpdb->commentmeta WHERE comment_id
					NOT IN (
						SELECT comment_id
						FROM $wpdb->comments
					)
				");
	}
	
	if ( ! isset( $input['remove_spam_comments'] ) )
		$input['remove_spam_comments'] = null;
	$input['remove_spam_comments'] = ( $input['remove_spam_comments'] == 1 ? 1 : 0 );
	
	if($input['remove_spam_comments'] == 1) {
		$wpdb->query( "
					DELETE FROM $wpdb->comments WHERE comment_approved = 'spam'
				");
		$wpdb->query( "
					DELETE FROM $wpdb->commentmeta WHERE comment_id
					NOT IN (
						SELECT comment_id
						FROM $wpdb->comments
					)
				");
	}
	
	if ( ! isset( $input['remove_trash_comments'] ) )
		$input['remove_trash_comments'] = null;
	$input['remove_trash_comments'] = ( $input['remove_trash_comments'] == 1 ? 1 : 0 );
	
	if($input['remove_trash_comments'] == 1) {
		$wpdb->query( "
					DELETE FROM $wpdb->comments WHERE comment_approved = 'trash'
				");
		$wpdb->query( "
					DELETE FROM $wpdb->commentmeta WHERE comment_id
					NOT IN (
						SELECT comment_id
						FROM $wpdb->comments
					)
				");
	}
	
	if ( ! isset( $input['remove_pingback_comments'] ) )
		$input['remove_pingback_comments'] = null;
	$input['remove_pingback_comments'] = ( $input['remove_pingback_comments'] == 1 ? 1 : 0 );
	
	if($input['remove_pingback_comments'] == 1) {
		$wpdb->query( "
					DELETE FROM $wpdb->comments WHERE comment_type = 'pingback'
				");
		$wpdb->query( "
					DELETE FROM $wpdb->commentmeta WHERE comment_id
					NOT IN (
						SELECT comment_id
						FROM $wpdb->comments
					)
				");
	}
	
	if ( ! isset( $input['remove_trackbacks_comments'] ) )
		$input['remove_trackbacks_comments'] = null;
	$input['remove_trackbacks_comments'] = ( $input['remove_trackbacks_comments'] == 1 ? 1 : 0 );
	
	if($input['remove_trackbacks_comments'] == 1) {
		$wpdb->query($wpdb->prepare("DELETE FROM $wpdb->comments WHERE comment_type = '%s' ", 'trackback'));
		$wpdb->query( "
					DELETE FROM $wpdb->commentmeta WHERE comment_id
					NOT IN (
						SELECT comment_id
						FROM $wpdb->comments
					)
				");
	}
	
	if ( ! isset( $input['remove_transient'] ) )
		$input['remove_transient'] = null;
	$input['remove_transient'] = ( $input['remove_transient'] == 1 ? 1 : 0 );
	
	if($input['remove_transient'] == 1) {
		$wpdb->query($wpdb->prepare("DELETE FROM $wpdb->options WHERE option_name LIKE %s ", '%_transient_%'));
	}
	
	if ( ! isset( $input['remove_orphaned_postmeta'] ) )
		$input['remove_orphaned_postmeta'] = null;
	$input['remove_orphaned_postmeta'] = ( $input['remove_orphaned_postmeta'] == 1 ? 1 : 0 );
	
	if($input['remove_orphaned_postmeta'] == 1) {
		$wpdb->query( "
					DELETE wpm FROM $wpdb->postmeta wpm
					LEFT JOIN $wpdb->posts wp ON wp.ID = wpm.post_id
					WHERE wp.ID IS NULL
				");
	}
	
	if ( ! isset( $input['remove_rss_cache'] ) )
		$input['remove_rss_cache'] = null;
	$input['remove_rss_cache'] = ( $input['remove_rss_cache'] == 1 ? 1 : 0 );
	
	if($input['remove_rss_cache'] == 1) {
		$wpdb->query($wpdb->prepare("DELETE FROM $wpdb->options WHERE option_name LIKE %s ", '_transient_feed_%'));
	}
	
	if ( ! isset( $input['optimize_table'] ) )
		$input['optimize_table'] = null;
	$input['optimize_table'] = ( $input['optimize_table'] == 1 ? 1 : 0 );
	
	if($input['optimize_table'] == 1) {
		$all_tables = $wpdb->get_results('SHOW TABLES',ARRAY_A);
		foreach ($all_tables as $tables){
			$table = array_values($tables);
			$wpdb->query("OPTIMIZE TABLE ".$table[0]);
		}
	}
	
	return $input;
}

function my_press_clean_it_up_settings_page() {
	global $wpdb;
	$options = get_option( 'my_press_clean_it_up_remove_revision_options' );
	$revision_count = "SELECT COUNT(post_type) FROM $wpdb->posts WHERE post_type = 'revision'";
	$post_revision_count = $wpdb->get_var($revision_count);
	$trash_count = "SELECT COUNT(post_status) FROM $wpdb->posts WHERE post_status = 'trash'";
	$post_trash_count = $wpdb->get_var($trash_count);
	$autodraft_count = "SELECT COUNT(post_status) FROM $wpdb->posts WHERE post_status = 'auto-draft'";
	$post_autodraft_count = $wpdb->get_var($autodraft_count);
	$empty_category_count = "SELECT COUNT(taxonomy) FROM $wpdb->term_taxonomy WHERE taxonomy = 'category' AND count = '0'";
	$post_empty_category_count = $wpdb->get_var($empty_category_count);
	$empty_tag_count = "SELECT COUNT(taxonomy) FROM $wpdb->term_taxonomy WHERE taxonomy = 'post_tag' AND count = '0'";
	$post_empty_tag_count = $wpdb->get_var($empty_tag_count);
	$unapproved_comment_count = "SELECT COUNT(comment_approved) FROM $wpdb->comments WHERE comment_approved = 0";
	$post_unapproved_comment_count = $wpdb->get_var($unapproved_comment_count);
	$spam_comment_count = "SELECT COUNT(comment_approved) FROM $wpdb->comments WHERE comment_approved = 'spam'";
	$post_spam_comment_count = $wpdb->get_var($spam_comment_count);
	$trash_comment_count = "SELECT COUNT(comment_approved) FROM $wpdb->comments WHERE comment_approved = 'trash'";
	$post_trash_comment_count = $wpdb->get_var($trash_comment_count);
?>
	<div class="wrap">
		<div class="my_press_articles_settings_header"><div class="my_press_header_text">Optimize Settings Page</div></div>
		<form action="options.php" method="post">
			<?php settings_fields('my_press_clean_it_up_remove_revision_options'); ?>
			<div class="my-press-table">
				<table class="form-table">
					<tr valign="top">		
						<td>
							<input name='my_press_clean_it_up_remove_revision_options[remove_empty_tag]' type="checkbox" value="1" <?php checked( '1', $options['remove_empty_tag'] ); ?> />
							<label for="my_press_clean_it_up_remove_revision_options[remove_empty_tag]"><?php _e( "$post_empty_tag_count empty tag(s)" ); ?></label><br/>
							<input name='my_press_clean_it_up_remove_revision_options[remove_empty_category]' type="checkbox" value="1" <?php checked( '1', $options['remove_empty_category'] ); ?> />
							<label for="my_press_clean_it_up_remove_revision_options[remove_empty_category]"><?php _e( "$post_empty_category_count empty category(s)" ); ?></label><br/>
							<input name='my_press_clean_it_up_remove_revision_options[remove_post_revision]' type="checkbox" value="1" <?php checked( '1', $options['remove_post_revision'] ); ?> />
							<label for="my_press_clean_it_up_remove_revision_options[remove_post_revision]"><?php _e( "$post_revision_count revision post(s) in the database" ); ?></label><br/>
							<input name='my_press_clean_it_up_remove_revision_options[remove_autodraft_post]' type="checkbox" value="1" <?php checked( '1', $options['remove_autodraft_post'] ); ?> />
							<label for="my_press_clean_it_up_remove_revision_options[remove_autodraft_post]"><?php _e( "$post_autodraft_count autodraft post(s) in the database" ); ?></label><br/>
							<input name='my_press_clean_it_up_remove_revision_options[remove_trash_post]' type="checkbox" value="1" <?php checked( '1', $options['remove_trash_post'] ); ?> />
							<label for="my_press_clean_it_up_remove_revision_options[remove_trash_post]"><?php _e( "$post_trash_count trash posts/pages in the database" ); ?></label><br/>
							<input name='my_press_clean_it_up_remove_revision_options[remove_unapproved_comments]' type="checkbox" value="1" <?php checked( '1', $options['remove_unapproved_comments'] ); ?> />
							<label for="my_press_clean_it_up_remove_revision_options[remove_unapproved_comments]"><?php _e( "$post_unapproved_comment_count unapproved comment(s) in the database" ); ?></label><br/>
							<input name='my_press_clean_it_up_remove_revision_options[remove_spam_comments]' type="checkbox" value="1" <?php checked( '1', $options['remove_spam_comments'] ); ?> />
							<label for="my_press_clean_it_up_remove_revision_options[remove_spam_comments]"><?php _e( "$post_spam_comment_count spam comment(s) in the database" ); ?></label><br/>
							<input name='my_press_clean_it_up_remove_revision_options[remove_trash_comments]' type="checkbox" value="1" <?php checked( '1', $options['remove_trash_comments'] ); ?> />
							<label for="my_press_clean_it_up_remove_revision_options[remove_trash_comments]"><?php _e( "$post_trash_comment_count trash comment(s) in the database" ); ?></label><br/>
							<input name='my_press_clean_it_up_remove_revision_options[remove_pingback_comments]' type="checkbox" value="1" <?php checked( '1', $options['remove_pingback_comments'] ); ?> />
							<label for="my_press_clean_it_up_remove_revision_options[remove_pingback_comments]"><?php _e( "Remove all pingback in the database" ); ?></label><br/>
							<input name='my_press_clean_it_up_remove_revision_options[remove_trackbacks_comments]' type="checkbox" value="1" <?php checked( '1', $options['remove_trackbacks_comments'] ); ?> />
							<label for="my_press_clean_it_up_remove_revision_options[remove_trackbacks_comments]"><?php _e( "Remove all trackback in the database" ); ?></label><br/>
							<input name='my_press_clean_it_up_remove_revision_options[remove_transient]' type="checkbox" value="1" <?php checked( '1', $options['remove_transient'] ); ?> />
							<label for="my_press_clean_it_up_remove_revision_options[remove_transient]"><?php _e( "Remove all transient in the database" ); ?></label><br/>
							<input name='my_press_clean_it_up_remove_revision_options[remove_rss_cache]' type="checkbox" value="1" <?php checked( '1', $options['remove_rss_cache'] ); ?> />
							<label for="my_press_clean_it_up_remove_revision_options[remove_rss_cache]"><?php _e( "Remove all rss cache in the database" ); ?></label><br/>
							<input name='my_press_clean_it_up_remove_revision_options[remove_orphaned_postmeta]' type="checkbox" value="1" <?php checked( '1', $options['remove_orphaned_postmeta'] ); ?> />
							<label for="my_press_clean_it_up_remove_revision_options[remove_orphaned_postmeta]"><?php _e( "Remove all orphaned postmeta in the database" ); ?></label><br/>
							<input name='my_press_clean_it_up_remove_revision_options[optimize_table]' type="checkbox" value="1" <?php checked( '1', $options['optimize_table'] ); ?> />
							<label for="my_press_clean_it_up_remove_revision_options[optimize_table]" class="clean-it-up-table"><?php _e( "Optimize database tables." ); ?></label>
						</td>
					</tr>
				</table>
			</div>
			<div class="clean-it-up-button">
				<input name="clean" class="button-primary" type="submit" value="Clean Database" / >
			</div>
		</form> 
	</div>
<?php
}
?>