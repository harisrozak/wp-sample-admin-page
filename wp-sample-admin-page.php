<?php
/*
Plugin Name: Sample Admin Page
Description: Sample admin page with $_POST request
Version: 1.0
Author: harisrozak
Author URI: https://harisrozak.github.io/
Contributor: Haris Ainur Rozak
*/

add_action( 'admin_action_wpse10500', 'wpse10500_admin_action' );
function wpse10500_admin_action() {
	// check nonce
	check_admin_referer('admin-page-wpse10500');

	// do whatever you want
    update_option('example-data', sanitize_text_field($_POST['data']));

    // redirect
    wp_redirect(add_query_arg( 'updated', '1', $_SERVER['HTTP_REFERER'] ));
    exit();
}

add_action( 'admin_menu', 'wpse10500_admin_menu' );
function wpse10500_admin_menu() {
    add_menu_page( 'Sample Page', 'Sample Page', 'administrator', 'wpse10500', 'wpse10500_do_page' );
}

function wpse10500_do_page() {
	$data = get_option('example-data', '');
	$updated = isset($_GET['updated']) ? $_GET['updated'] : false;
	?>
	<div class="wrap">
		<h2>Sample Admin Page</h2>
		
		<?php if($updated): ?>
		<div class="updated notice">
		    <p>Something has been updated, awesome</p>
		</div>
		<?php endif ?>

		<p>Your saved post data: <strong><?php echo $data ?></strong></p>
		<form method="POST" action="<?php echo admin_url('admin.php'); ?>">
		    <!-- key for admin_action -->
		    <input type="hidden" name="action" value="wpse10500" />

		    <!-- nonce -->
		    <?php wp_nonce_field('admin-page-wpse10500'); ?>
		    
		    <!-- your form -->
		    <input type="text" name="data" value="<?php echo $data ?>" /><br><br>
		    <input type="submit" value="Save Data" class="button button-primary" />
		</form>
	</div>
	<?php
}