<?php

/*
Plugin Name: Progressive License
Plugin URI: http://wordpress.org/extend/plugins/progressive-license/
Description: Advanced options for selectively applying licenses to your content based on the age.  <a href="options-general.php?page=progressive-license.php">Configure your settings here</a>.
Version: 1.0
Author: Crowd Favorite
Author URI: http://crowdfavorite.com
*/

load_plugin_textdomain('progressive-license');

//Check the currently installed version of wordpress
define('ACC_WP_GTE_25', version_compare($wp_version, '2.5', '>='));

$cc_licenses = array(
	'none' => array(
		'name' => 'No License'
		, 'url' => ''
		, 'rdf' => ''
		, 'image' => ''
	)
	, 'cc-pd' => array(
		'name' => 'CC - Public Domain'
		, 'url' => 'http://creativecommons.org/licenses/publicdomain/'
		, 'rdf' => '<rdf:RDF xmlns="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"><Work rdf:about=""><license rdf:resource="http://creativecommons.org/ns#PublicDomain" /></Work><License rdf:about="http://creativecommons.org/ns#PublicDomain"><permits rdf:resource="http://creativecommons.org/ns#Reproduction" /><permits rdf:resource="http://creativecommons.org/ns#Distribution" /><permits rdf:resource="http://creativecommons.org/ns#DerivativeWorks" /></License></rdf:RDF>'
		, 'image' => '<a href="http://creativecommons.org/licenses/publicdomain/"><img src="http://i.creativecommons.org/l/publicdomain/88x31.png" alt="by" /></a>'
	)
	, 'cc-by-30' => array(
		'name' => 'CC - Attribution 3.0'
		, 'url' => 'http://creativecommons.org/licenses/by/3.0/'
		, 'rdf' => '<rdf:RDF xmlns="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"><Work rdf:about=""><license rdf:resource="http://creativecommons.org/licenses/by/3.0/" /></Work><License rdf:about="http://creativecommons.org/licenses/by/3.0/"><requires rdf:resource="http://creativecommons.org/ns#Attribution" /><permits rdf:resource="http://creativecommons.org/ns#Reproduction" /><permits rdf:resource="http://creativecommons.org/ns#Distribution" /><permits rdf:resource="http://creativecommons.org/ns#DerivativeWorks" /><requires rdf:resource="http://creativecommons.org/ns#Notice" /></License></rdf:RDF>'
		, 'image' => '<a href="http://creativecommons.org/licenses/by/3.0/"><img src="http://i.creativecommons.org/l/by/3.0/88x31.png" alt="by" /></a>'
	)
	, 'cc-by-sa-30' => array(
		'name' => 'CC - Attribution Share Alike 3.0'
		, 'url' => 'http://creativecommons.org/licenses/by-sa/3.0/'
		, 'rdf' => '<rdf:RDF xmlns="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"><Work rdf:about=""><license rdf:resource="http://creativecommons.org/licenses/by-sa/3.0/" /></Work><License rdf:about="http://creativecommons.org/licenses/by-sa/3.0/"><requires rdf:resource="http://creativecommons.org/ns#Attribution" /><permits rdf:resource="http://creativecommons.org/ns#Reproduction" /><permits rdf:resource="http://creativecommons.org/ns#Distribution" /><permits rdf:resource="http://creativecommons.org/ns#DerivativeWorks" /><requires rdf:resource="http://creativecommons.org/ns#ShareAlike" /><requires rdf:resource="http://creativecommons.org/ns#Notice" /></License></rdf:RDF>'
		, 'image' => '<a href="http://creativecommons.org/licenses/by-sa/3.0/"><img src="http://i.creativecommons.org/l/by-sa/3.0/88x31.png" alt="by-sa" /></a>'
	)
	, 'cc-by-nd-30' => array(
		'name' => 'CC - Attribution No Derivatives 3.0'
		, 'url' => 'http://creativecommons.org/licenses/by-nd/3.0/'
		, 'rdf' => '<rdf:RDF xmlns="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"><Work rdf:about=""><license rdf:resource="http://creativecommons.org/licenses/by-nd/3.0/" /></Work><License rdf:about="http://creativecommons.org/licenses/by-nd/3.0/"><requires rdf:resource="http://creativecommons.org/ns#Attribution" /><permits rdf:resource="http://creativecommons.org/ns#Reproduction" /><permits rdf:resource="http://creativecommons.org/ns#Distribution" /><requires rdf:resource="http://creativecommons.org/ns#Notice" /></License></rdf:RDF>'
		, 'image' => '<a href="http://creativecommons.org/licenses/by-nd/3.0/"><img src="http://i.creativecommons.org/l/by-nd/3.0/88x31.png" alt="by-nd" /></a>'
	)
	, 'cc-by-nc-30' => array(
		'name' => 'CC - Attribution Non-commercial 3.0'
		, 'url' => 'http://creativecommons.org/licenses/by-nc/3.0/'
		, 'rdf' => '<rdf:RDF xmlns="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"><Work rdf:about=""><license rdf:resource="http://creativecommons.org/licenses/by-nc/3.0/" /></Work><License rdf:about="http://creativecommons.org/licenses/by-nc/3.0/"><requires rdf:resource="http://creativecommons.org/ns#Attribution" /><permits rdf:resource="http://creativecommons.org/ns#Reproduction" /><permits rdf:resource="http://creativecommons.org/ns#Distribution" /><permits rdf:resource="http://creativecommons.org/ns#DerivativeWorks" /><prohibits rdf:resource="http://creativecommons.org/ns#CommercialUse" /><requires rdf:resource="http://creativecommons.org/ns#Notice" /></License></rdf:RDF>'
		, 'image' => '<a href="http://creativecommons.org/licenses/by-nc/3.0/"><img src="http://i.creativecommons.org/l/by-nc/3.0/88x31.png" alt="by-nc" /></a>'
	)
	, 'cc-by-nc-sa-30' => array(
		'name' => 'CC - Attribution Non-commercial Share Alike 3.0'
		, 'url' => 'http://creativecommons.org/licenses/by-nc-sa/3.0/'
		, 'rdf' => '<rdf:RDF xmlns="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"><Work rdf:about=""><license rdf:resource="http://creativecommons.org/licenses/by-nc-sa/3.0/" /></Work><License rdf:about="http://creativecommons.org/licenses/by-nc-sa/3.0/"><requires rdf:resource="http://creativecommons.org/ns#Attribution" /><permits rdf:resource="http://creativecommons.org/ns#Reproduction" /><permits rdf:resource="http://creativecommons.org/ns#Distribution" /><permits rdf:resource="http://creativecommons.org/ns#DerivativeWorks" /><requires rdf:resource="http://creativecommons.org/ns#ShareAlike" /><prohibits rdf:resource="http://creativecommons.org/ns#CommercialUse" /><requires rdf:resource="http://creativecommons.org/ns#Notice" /></License></rdf:RDF>'
		, 'image' => '<a href="http://creativecommons.org/licenses/by-nc-sa/3.0/"><img src="http://i.creativecommons.org/l/by-nc-sa/3.0/88x31.png" alt="by-nc-sa" /></a>'
	)
	, 'cc-by-nc-nd-30' => array(
		'name' => 'CC - Attribution Non-commercial No Derivatives 3.0'
		, 'url' => 'http://creativecommons.org/licenses/by-nc-nd/3.0/'
		, 'rdf' => '<rdf:RDF xmlns="http://creativecommons.org/ns#" xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"><Work rdf:about=""><license rdf:resource="http://creativecommons.org/licenses/by-nc-nd/3.0/" /></Work><License rdf:about="http://creativecommons.org/licenses/by-nc-nd/3.0/"><requires rdf:resource="http://creativecommons.org/ns#Attribution" /><permits rdf:resource="http://creativecommons.org/ns#Reproduction" /><permits rdf:resource="http://creativecommons.org/ns#Distribution" /><prohibits rdf:resource="http://creativecommons.org/ns#CommercialUse" /><requires rdf:resource="http://creativecommons.org/ns#Notice" /></License></rdf:RDF>'
		, 'image' => '<a href="http://creativecommons.org/licenses/by-nc-nd/3.0/"><img src="http://i.creativecommons.org/l/by-nc-nd/3.0/88x31.png" alt="by-nc-nd" /></a>'
	)
);

wp_enqueue_script('jquery');
if (!function_exists('wp_prototype_before_jquery')) {
	function wp_prototype_before_jquery( $js_array ) {
		if ( false === $jquery = array_search( 'jquery', $js_array ) )
			return $js_array;
		if ( false === $prototype = array_search( 'prototype', $js_array ) )
			return $js_array;
		if ( $prototype < $jquery )
			return $js_array;
		unset($js_array[$prototype]);
		array_splice( $js_array, $jquery, 0, 'prototype' );
		return $js_array;
	}
    add_filter( 'print_scripts_array', 'wp_prototype_before_jquery' );
}

function acc_the_content($str) {
	global $post, $cc_licenses;
	
	$acc_durations = maybe_unserialize(get_option('acc_durations'));
	$acc_licenses = maybe_unserialize(get_option('acc_license'));
	$acc_settings = maybe_unserialize(get_option('acc_settings'));
	
	$post_date = strtotime($post->post_date);
	$todays_date = time();

	$date_diff = $todays_date - $post_date;
	$date_diff = floor($date_diff/(60*60*24));
	
	$prevDuration = 0;
	$license_image = '';
	$print_license = '';
	
	$license_key = false;
	
	foreach($acc_durations as $duration) {
		$newDuration = $duration['duration'];
		
		if($date_diff > $newDuration) {
			$prevDuration = $newDuration;
		}
		else {
			if($date_diff >= $prevDuration) {
				$license_key = $duration['key'];
				break;
			}
		}
	}
	if (!$license_key && isset($acc_durations['timeframe_expire'])) {
		$license_key = $acc_durations['timeframe_expire']['key'];
	}
	$found = false;
	if(is_array($acc_licenses)) {
		foreach($acc_licenses as $key => $license) {
			if($license_key == $key) {
				$print_license = $license['rdf'];
				if($license['image'] != '') {
					$license_image = '<a href="'.htmlspecialchars($license['url']).'"><img src="'.htmlspecialchars($license['image']).'" alt="'.htmlspecialchars($license['name']).'" /></a>';
				}
				$found = true;
				break;
			}
		}
	}
	if(!$found) {
		foreach($cc_licenses as $key => $license) {
			if($license_key == $key) {
				$license_image = $license['image'];
				$print_license = $license['rdf'];
				$found = true;
				break;
			}
		}
	}
	if (!$found) {
		return $str;
	}
 	if($acc_settings['show_images'] == 'yes') {
		return $str . '<div class="acc_license">' . $license_image . '</div><!--' . $print_license . '-->';
	}
	else {
		if (!empty($print_license)) {
			$str .= '<!--'. $print_license . '-->';
		}
		return $str;
	}
}
add_action('the_content', 'acc_the_content');

function acc_menu_items() {
	if (current_user_can('manage_options')) {
		add_options_page(
			__('Progressive License', 'progressive-license')
			, __('Progressive License', 'progressive-license')
			, 10
			, basename(__FILE__)
			, 'acc_check_page'
		);
	}

	// Checks to see if the options are actually set, and if they are not sets them
	// Just for redundancy's sake
	$acc_settings = maybe_unserialize(get_option('acc_settings'));
	$acc_durations = maybe_unserialize(get_option('acc_durations'));
	
	if(!is_array($acc_durations)) {
		$set_options = array( 'timeframe_1' => array('key' => 'none', 'duration' => '0'), 'timeframe_expire' => array('key' => 'none'));
		
		update_option('acc_durations', serialize($set_options));
	}
	if(!is_array($acc_settings)) {
		$acc_settings = array('show_images' => 'no');
		update_option('acc_settings', serialize($acc_settings));	
	}
}
add_action('admin_menu', 'acc_menu_items');

function acc_check_page() {
	
	if(isset($_GET['acc_page'])) {
		$check_page = $_GET['acc_page'];
	}
	else {
		$check_page = '';
	}
	
	switch($check_page) {
		case 'main':
			acc_options_form();
			break;
		case 'licenses':
			acc_license_list();
			break;
		case 'create':
			acc_new_edit();
			break;
		default:
			acc_options_form();
			break;
	}

}

function acc_request_handler() {
	
	if(current_user_can('manage_options')) {
		if(isset($_POST['acc_action'])) {
			switch ($_POST['acc_action']) {
				case 'update_settings':
					if(is_array($_POST['acc_data']) && isset($_POST['show_images']) && $_POST['show_images'] != '') {
						if (in_array($_POST['show_images'], array('yes', 'no'))) {
							$show_images = $_POST['show_images'];
						}
						else {
							$show_images = 'no';
						}
						$acc_data = stripslashes_deep($_POST['acc_data']);
						acc_update_settings($_POST['acc_data'], $show_images);
						wp_redirect(get_bloginfo('wpurl').'/wp-admin/options-general.php?page=progressive-license.php&acc_msg=settings');
					}
					break;
				case 'edited':
					if(isset($_POST['acc_license_key']) && isset($_POST['acc_license']) && is_array($_POST['acc_license'])) {
						$license_key = stripslashes($_POST['acc_license_key']);
						$acc_license = stripslashes_deep($_POST['acc_license']);
						acc_edit_license($license_key, $acc_license);
						wp_redirect(get_bloginfo('wpurl').'/wp-admin/options-general.php?page=progressive-license.php&acc_page=licenses&acc_msg=license_edited');
					}
					break;
				case 'delete':
					if(isset($_POST['acc_license_key'])) {
						acc_delete_license(stripslashes($_POST['acc_license_key']));
						wp_redirect(get_bloginfo('wpurl').'/wp-admin/options-general.php?page=progressive-license.php&acc_page=licenses&acc_msg=license_deleted');
					}
					break;
				case 'add':
					if(is_array($_POST['acc_license'])) {
						$license_data = stripslashes_deep($_POST['acc_license']);
						acc_create_license($license_data);
						wp_redirect(get_bloginfo('wpurl').'/wp-admin/options-general.php?page=progressive-license.php&acc_page=licenses&acc_msg=license_created');
					}
					break;
			}
		}
	}

}
add_action('init', 'acc_request_handler');

function acc_delete_license($license_key = '') {
	$license_list = maybe_unserialize(get_option('acc_license'));
	if($license_key != '' && isset($license_list[$license_key])) {
	 	unset($license_list[$license_key]);
		update_option('acc_license', serialize($license_list));
	}
}

function acc_create_license($license = array()) {

	if(!empty($license['name'])) {
		$current = maybe_unserialize(get_option('acc_license'));

		$license_key = sanitize_title($license['name']);
		if (isset($current[$license_key])) {
			for ($i = 0; $i < 9999; $i++) {
				$new_key = $license_key.'_'.$i;
				if (!isset($current[$new_key])) {
					$license_key = $new_key;
					$i = 10000;
				}
			}
		}
		
		$current[$license_key] = $license;
		
		update_option('acc_license', serialize($current));
	}
	else {
		wp_redirect(get_bloginfo('wpurl').'/wp-admin/options-general.php?page=progressive-license.php&acc_page=create&fail=name');
	}
	
}

function acc_edit_license($license_key = '', $license_info = array()) {
	$license_list = maybe_unserialize(get_option('acc_license'));
	if($license_key != '' && isset($license_list[$license_key])) {
		$license_list[$license_key] = $license_info;
		update_option('acc_license', serialize($license_list));		
	}
	else {
		wp_redirect(get_bloginfo('wpurl').'/wp-admin/options-general.php?page=progressive-license.php&acc_page=create&fail=edit');
	}
}

function acc_update_settings($acc_data = array(), $acc_show_images) {
	update_option('acc_durations', serialize($acc_data));
	$acc_settings = array('show_images' => $acc_show_images);
	update_option('acc_settings', serialize($acc_settings));
}

function acc_msgs() {
	if ( isset($_GET['acc_msg']) ) {
		switch ($_GET['acc_msg']) {
			case 'settings':
				$msg = __('Settings updated.', 'progressive-license');
				break;
			case 'license_edited':
				$msg = __('License updated.', 'progressive-license');
				break;
			case 'license_deleted':
				$msg = __('License deleted.', 'progressive-license');
				break;
			case 'license_created':
				$msg = __('License created.', 'progressive-license');
				break;
		}
		print('
			<div id="message" class="updated fade">
				<p>'.$msg.'</p>
			</div>
		');
	}
	if ( isset($_GET['fail'])) {
		switch ($_GET['fail']) {
			case 'name':
				print('
					<div id="message" class="error fade">
						<p>'.__('Sorry, you must specify a license name.', 'progressive-license').'</p>
					</div>
				');
				break;
			case 'edit':
				print('
					<div id="message" class="error fade">
						<p>'.__('Sorry, something unexpected happened.', 'progressive-license').'</p>
					</div>
				');
				break;
		}
	}
}

function acc_options_form() {
	
	global $cc_licenses;
	
	$license_list = maybe_unserialize(get_option('acc_license'));
	$license_settings = maybe_unserialize(get_option('acc_durations'));
	
	is_array($license_list) ? $license_count = count($license_list) : $license_count = 0;
	is_array($license_settings) ? $license_settings_count = count($license_settings) : $license_settings_count = 0;


	$license_images = maybe_unserialize(get_option('acc_settings'));
	if($license_images['show_images'] == 'yes') {
		$yes_text = ' selected=selected';
		$no_text = '';
	}
	else {
		$yes_text = '';
		$no_text = ' selected=selected';
	}

	acc_msgs();
	
	print('
		<div id="wpbody">
			<div class="wrap">
				<h2>'.__('Choose License Settings', 'progressive-license').'</h2>
					'.acc_pages('main').'
					<form action="'.get_bloginfo('wpurl').'/wp-admin/options-general.php" method="post">
						<table class="widefat">
							<thead>
								<tr>
									<th scope="col" width="115px" style="text-align: center;">'.__('Duration (Days)', 'progressive-license').'</th>
									<th scope="col">'.__('Pick License', 'progressive-license').'</th>
									<th scope="col" width="100px" style="text-align: center;">'.__('Used Until', 'progressive-license').'<a href="#used_until">*</a></th>
									<th scope="col" width="40px" style="text-align: center;">&nbsp;</th>								
								</tr>
							</thead>
							<tbody>');
							if($license_settings_count > 0) {
								foreach($license_settings as $key_setting => $setting) {
									if($key_setting == 'timeframe_1') {
										$disabled_text = ' disabled';
									}
									else {
										$disabled_text = '';
									}
									if($key_setting != 'timeframe_expire') {
										$key_num = str_replace('timeframe_', '', $key_setting);
										print('<tr id="acc_row_'.$key_num.'">
											<td style="text-align: center;" id="enddate">
												<span id="acc_duration_start_'.$key_num.'">0</span> + <input type="text" name="acc_data[timeframe_'.$key_num.'][duration]" id="acc_enddate_'.$key_num.'" value="'.$setting['duration'].'" size="4" maxlength="4" class="acc_input" />
											</td>
											<td>
												<select name="acc_data[timeframe_'.$key_num.'][key]" id="acc_table_select">
												');
												foreach($cc_licenses as $key => $license) {
													if($key == $license_settings[$key_setting]['key']) {
														$selected_text = ' selected="selected"';
													}
													else {
														$selected_text = '';
													}
													print('<option value="'.$key.'"'.$selected_text.'>'.htmlspecialchars(trim_add_elipsis($license['name'])).'</option>');
												}
												foreach($license_list as $key => $license) {
													if($key == $license_settings[$key_setting]['key']) {
														$selected_text = ' selected="selected"';
													}
													else {
														$selected_text = '';
													}
													print('<option value="'.$key.'"'.$selected_text.'>'.__('User - ', 'progressive-license').htmlspecialchars(trim_add_elipsis($license['name'])).'</option>');
												}
												print('
												</select>
											</td>
											<td style="text-align: center; vertical-align: middle;">
												<span id="acc_duration_'.$key_num.'">&infin;</span>
											</td>
											<td style="text-align: center;" class="acc_button">
												<p class="submit" style="border-top: none;">
														<input type="hidden" id="acc_total_previous_'.$key_num.'" value="0" />
												');
												if($key_num != '1') {
													print('
														<input type="button"'.$disabled_text.' id="acc_delete_'.$key_num.'" value="'.__('Delete', 'progressive-license').'" />
													');
												}
												print('
												</p>
											</td>
										</tr>');
									}
								}
							}
							print('</tbody>
							<tfoot>
								<tr>
									<td style="vertical-align: middle;">
										'.__('If all licenses expire use this license:', 'progressive-license').'
									</td>
									<td colspan="3">
										<select name="acc_data[timeframe_expire][key]" id="acc_table_select">
										');
										if($license_settings_count > 0) {
											$expire_string = $license_settings['timeframe_expire']['key'];
										}
										else {
											$expire_string = '';
										}
										foreach($cc_licenses as $key => $license) {
											if($expire_string == $key) {
												$selected = ' selected="selected"';
											}
											else {
												$selected = '';
											}
											print('<option value="'.$key.'"'.$selected.'>'.htmlspecialchars(trim_add_elipsis($license['name'])).'</option>');
										}
										foreach($license_list as $key => $license) {
											if($expire_string == $key) {
												$selected = ' selected="selected"';
											}
											else {
												$selected = '';
											}
											print('<option value="'.$key.'"'.$selected.'>'.__('User - ', 'progressive-license').htmlspecialchars(trim_add_elipsis($license['name'])).'</option>');
										}
										print('
										</select>
									</td>
								</tr>
								<tr>
									<td colspan="4" class="acc_button" style="background-color: #eee;">
										<p class="submit" style="border-top: none;">
											<input type="button" name="acc_add_license" id="acc_add_license" value="'.__('Add New Timeframe', 'progressive-license').'" />
										</p>
									</td>
								</tr>
							</tfoot>
						</table>
						<div class="acc_show_images">
							<label for="show_images">'.__('Show license image and link at the end of each post?', 'progressive-license').'</label> 
							<select name="show_images" id="show_images">
								<option value="yes"'.$yes_text.'>'.__('Yes', 'progressive-license').'</option>
								<option value="no"'.$no_text.'>'.__('No', 'progressive-license').'</option>
							</select>
						</div>
						<p class="submit" style="border-top: none;">
							<input type="hidden" name="acc_action" value="update_settings" />
							<input type="hidden" name="acc_infinity" id="acc_infinity" value="&#8734;" />
							<input type="submit" name="submit" value="'.__('Update License Settings', 'progressive-license').'" />
						</p>
						<p id="used_until">'.__('* As you select your licenses, the Used Until column will update to let you know how long that license will be applied to content that is published today.', 'progressive-license').'</p>
					</form>
				</div>
			</div>
			<script type="text/javascript">
				acc_updateDate("1", false, 0);
			</script>
		</div>
	');
}

function acc_license_list() {

	$license_list = maybe_unserialize(get_option('acc_license'));
	
	is_array($license_list) ? $license_count = count($license_list) : $license_count = 0;	
	
	acc_msgs();
	
	print('
		<div class="wrap">
			<h2>'.__('Current Licenses', 'progressive-license').'</h2>
			<div id="acc_list_div">
				'.acc_pages('licenses').'
				<table class="widefat" id="acc_interior_table">
					<thead>
						<tr>
							<th scope="col">
								'.__('License Name', 'progressive-license').'
							</th>
							<th scope="col">
								'.__('URL', 'progressive-license').'
							</th>
							<th scope="col" width="40">
								'.__('Edit', 'progressive-license').'
							</th>
							<th scope="col" width="40">
								'.__('Delete', 'progressive-license').'
							</th>
						</tr>
					</thead>
					<tbody>
					');
					
					if($license_count != 0) {
						foreach($license_list as $key => $license) {
							print('
								<tr>
									<td style="vertical-align: middle;">
										'.htmlspecialchars($license['name']).'
									</td>
									<td style="vertical-align: middle;">
										<a href="'.htmlspecialchars($license['url']).'">'.htmlspecialchars(trim_add_elipsis($license['url'])).'</a>
									</td>
									<td style="vertical-align: middle;">
										<input type="button" name="edit_license" value="'.__('Edit', 'progressive-license').'" class="button-secondary edit" rel="'.$key.'" />
									</td>
									<td style="vertical-align: middle;">
										<form action="'.get_bloginfo('wpurl').'/wp-admin/options-general.php" method="post" class="delete_license">
											<input type="submit" name="delete_license" value="'.__('Delete', 'progressive-license').'" class="button-secondary delete" />
											<input type="hidden" name="acc_license_key" value="'.$key.'" />
											<input type="hidden" name="acc_action" value="delete" />													
										</form>
									</td>
								</tr>
							');
						}
					}
					else {
						print('
							<tr>
								<td colspan="4" style="vertical-align: middle;">
									<h3>
										'.__('No custom licenses have been added.', 'progressive-license').'  <a href="'.get_bloginfo('wpurl').'/wp-admin/options-general.php?page=progressive-license.php&acc_page=create">'.__('Add a License', 'progressive-license').'</a>
									</h3>
								</td>
							</tr>
						');
					}
					print('
					</tbody>
				</table>
			</div>
		</div>
	');
}

function acc_new_edit() {
	
	
	if(isset($_GET['acc_license_key'])) {
		$license_list = maybe_unserialize(get_option('acc_license'));
		if (!isset($license_list[$_GET['acc_license_key']])) {
			wp_die('Sorry, no license found.');
		}
		$license_key = $_GET['acc_license_key'];
		$license_edit = $license_list[$license_key];
		$title = __('Edit License', 'progressive-license');
	}
	else {
		$license_key = '';
		$license_edit = '';
		$title = __('Add New License', 'progressive-license');
	}
	
	if ( $_GET['settings-updated'] ) {
		print('
			<div id="message" class="updated fade">
				<p>'.__('Settings updated.', 'progressive-license').'</p>
			</div>
		');
	}
	
	print('
		<div class="wrap">
			<h2>'.$title.'</h2>
			<div class="acc_enc_div">
				');
				if(is_array($license_edit)) {
					print(acc_pages('edit'));
				}
				else {
					print(acc_pages('create'));
				}
				print('
				<form action="'.get_bloginfo('wpurl').'/wp-admin/options-general.php" method="post">
					<div id="poststuff">
						<div id="post-body">
							<div id="titlediv">
								<h3>'.__('License Name', 'progressive-license').'</h3>
								<div id="titlewrap">
									');
										if(is_array($license_edit)) {
											print('<input type="text" id="title" name="acc_license[name]" tabindex="1" size="60" value="'.htmlspecialchars($license_edit['name']).'" />');
										}
										else {
											print('<input type="text" id="title" name="acc_license[name]" tabindex="1" size="60" />');
										}
									print('
								</div>
							</div>
							<div id="titlediv">
								<h3>'.__('License URL', 'progressive-license').'</h3>
								<div id="titlewrap">
									');
										if(is_array($license_edit)) {
											print('<input type="text" id="title" name="acc_license[url] size="60" tabindex="2" value="'.htmlspecialchars($license_edit['url']).'" />');
										}
										else {
											print('<input type="text" id="title" name="acc_license[url]" tabindex="2" size="60" />');
										}
									print('
								</div>
							</div>
							<div id="titlediv">
								<h3>'.__('License Image URL', 'progressive-license').'</h3>
								<div id="titlewrap">
									');
										if(is_array($license_edit)) {
											print('<input type="text" id="title" name="acc_license[image] size="60" tabindex="2" value="'.htmlspecialchars($license_edit['image']).'" />');
										}
										else {
											print('<input type="text" id="title" name="acc_license[image]" tabindex="2" size="60" />');
										}
									print('
								</div>
							</div>
							<div id="postdiv" class="postarea">
								<h3>'.__('Machine Code', 'progressive-license').'</h3>
								<div id="acc_editorcontainer">
									');
										if(is_array($license_edit)) {
											print('<textarea id="content" class="" tabindex="3" name="acc_license[rdf]" cols="40" rows="10">'.htmlspecialchars($license_edit['rdf']).'</textarea>');
										}
										else {
											print('<textarea id="content" class="" tabindex="3" name="acc_license[rdf]" cols="40" rows="10"></textarea>');
										}
									print('
								</div>
							</div>
						</div>
					</div>
					<p class="submit" style="border-top: none;">
						');
						if(is_array($license_edit)) {
							print('
								<input type="hidden" name="acc_action" value="edited" />
								<input type="hidden" name="acc_license_key" value="'.htmlspecialchars($license_key).'" />
								<input type="submit" name="submit" value="'.__('Save Changes', 'progressive-license').'" />
							');
						}
						else {
							print('
								<input type="hidden" name="acc_action" value="add" />
								<input type="submit" name="submit" value="'.__('Submit New License', 'progressive-license').'" />
							');
						}
						print('
					</p>
				</form>
			</div>
		</div>
	');
}

function acc_pages($page = '') {

	$license_list = maybe_unserialize(get_option('acc_license'));
	
	is_array($license_list) ? $license_count = count($license_list) : $license_count = 0;	
	
	switch($page) {
		case 'main':
			$main_text = ' class="current"';
			$license_text = '';
			$create_text = '';
			break;
		case 'licenses':
			$main_text = '';
			$license_text = ' class="current"';
			$create_text = '';
			break;
		case 'create':
			$main_text = '';
			$license_text = '';
			$create_text = ' class="current"';
			break;
		default:
			$main_text = '';
			$license_text = '';
			$create_text = '';
			break;
	}
			
	
	$header_text = '
					<ul class="subsubsub">
						<li>
							<a href="'.get_bloginfo('wpurl').'/wp-admin/options-general.php?page=progressive-license.php&acc_page=main"'.$main_text.'>'.__('Selected Licenses', 'progressive-license').'</a> | 
						</li>
						<li>
							<a href="'.get_bloginfo('wpurl').'/wp-admin/options-general.php?page=progressive-license.php&acc_page=licenses"'.$license_text.'>'.__('Custom Licenses', 'progressive-license').' ('.$license_count.')</a> | 
						</li>
						<li>
							<a href="'.get_bloginfo('wpurl').'/wp-admin/options-general.php?page=progressive-license.php&acc_page=create"'.$create_text.'>'.__('Add a License', 'progressive-license').'</a>
						</li>
					</ul>
	';


	return $header_text;	
}

function acc_admin_css_js() {
	
	global $cc_licenses;
	
	$option_list = '';
	
	$license_list = maybe_unserialize(get_option('acc_license'));
	$settings_list = maybe_unserialize(get_option('acc_durations'));
	
	is_array($license_list) ? $license_count = count($license_list) : $license_count = 0;	
	is_array($settings_list) ? $settings_count = count($settings_list) : $settings_count = 0;

	foreach($cc_licenses as $key => $license) { $option_list .= '<option value="'.$key.'">'.htmlspecialchars(trim_add_elipsis($license['name'])).'</option>'; }
	if($license_count > 0) {
		foreach($license_list as $key => $license) { $option_list .= '<option value="'.$key.'">'.__('User - ', 'progressive-license').htmlspecialchars(trim_add_elipsis($license['name'])).'</option>'; }
	}
	
	$changeText = '';
	
	if($settings_count > 0) {
		$previous = '0';
		$changeText .= "
		jQuery(document).ready(function() {
		";
		foreach($settings_list as $key => $setting) {
			if($key != 'timeframe_expire') {
				$key_num = str_replace('timeframe_', '', $key);
				
				
				$changeText .= "
			jQuery('#acc_delete_".$key_num."').click(function() {
				if(confirm('".__('Are you sure you want to delete this?', 'progressive-license')."')) {
					var id = jQuery(this).attr('id');
					var thisId = id.replace('acc_delete_', '');
					var prevID = jQuery('#acc_row_'+thisId).prev().attr('id').replace('acc_row_', '');

					jQuery('#acc_row_' + thisId).remove();

					acc_updateDate('',answer, prevID);
					
					return false;
				}
			});
			jQuery('#acc_enddate_".$key_num."').change(function() {
				if(isNaN(parseInt(jQuery(this).val()))) {
					alert('".__('This needs to be a number!', 'progressive-license')."');
					jQuery(this).val('0').focus();
				}
				var thisRow = jQuery('#acc_row_".$key_num."');
			";
			if($previous == 0) {
				$changeText .= "prevID = 0;";
			}
			else {
				$changeText .= "var prevID = thisRow.prev().attr('id').replace('acc_row_', '');";
			}
			$changeText .= "
				acc_updateDate('".$key_num."',false,prevID);

				if( thisRow.nextSibling ) {
					var nextID = thisRow.next().attr('id').replace('acc_row_', '');
					acc_updateDate(nextID, false, '".$key_num."');
				}
			});
			if(jQuery('#acc_row_".$key_num."').prev().attr('id')) {
				var prevID = jQuery('#acc_row_".$key_num."').prev().attr('id').replace('acc_row_','');
				jQuery('#acc_duration_start_".$key_num."').html(jQuery('#acc_total_previous_'+prevID).val());
			}
				";
				
				$previous = $key_num;
			}
		}
		$changeText .= "
		});
		";

	}
?>
<style type="text/css">
	.acc_input {
		text-align: center;
	}
	.form-table .acc_button {
		margin: 0;
	}
	.form-table .acc_button p {
		margin: 0;
		padding: 0;
	}
	.acc_button .submit {
		margin: 0;
		padding: 0;
	}
	#acc_interior_table .acc_button_th {
		width: 40px;
	}
	#acc_interior_table .acc_name_th {
		width: 200px;
		text-align: left;
	}
	#acc_interior_table .acc_url_th {
		width: 600px;
		text-align: left;
	}
	#acc_interior_table .acc_list_td {
		text-align: left;
	}
	#acc_interior_table .acc_input_disabled {
		background-color: lightgrey;
	}
	#acc_editorcontainer {
		border-collapse:separate;
		border-style:solid;
		border-width:1px;
		padding:6px;
		border-color: #CCCCCC;
	}
	#acc_editorcontainer #content {
		padding: 0;
		line-height: 150%;
		border: 0 none;
		outline: none;
		resize: none;
	}
	.acc_show_images {
		vertical-align: middle; 
		padding: 5px; 
		line-height: 25px;	
	}
<?
	if(!ACC_WP_GTE_25) {
?>
	.subsubsub {
		font-size:12px;
		list-style-image:none;
		list-style-position:outside;
		list-style-type:none;
		margin:14px 0 8px;
		padding:0;
		white-space:nowrap;	
	}
	.subsubsub li {
		display: inline;
		margin: 0;
		padding: 0;
	}
	.acc_button .submit {
		text-align: left;
	}
<?
	}
?>
</style>
<script type="text/javascript">
	var todaysDate = new Date().valueOf();
	var infinityValue;
	jQuery(document).ready(function() {
	
		infinityValue = jQuery('#acc_infinity').val();
		var lastchanged = '1';
		
		jQuery('input[name="edit_license"]').click(function() {
			location.href = "<?php echo get_bloginfo('wpurl').'/wp-admin/options-general.php?page=progressive-license.php&acc_page=create&acc_license_key='; ?>" + jQuery(this).attr('rel');
			return false;
		});
		
		jQuery('form.delete_license').submit(function() {
			return confirm("<?php _e('Are you sure you want to delete this?', 'progressive-license'); ?>");
		});
		
		jQuery('#acc_add_license').click(function() {

			if(jQuery('#acc_enddate_'+lastchanged).val() == '0') {
				alert("<?php _e('Please enter a duration to add a new timeframe', 'progressive-license'); ?>");
			}
			else {
				var id = new Date().valueOf();
				var section = id.toString();
				
				addRow(section);
				
				jQuery('#acc_delete_'+section).click(function() {
					if(confirm("<?php _e('Are you sure you want to delete this?', 'progressive-license'); ?>")) {
						var thisId = jQuery(this).attr('id').replace('acc_delete_', '');
						var prevID = jQuery('#acc_row_'+thisId).prev().attr('id').replace('acc_row_', '');
	
						jQuery('#acc_row_' + thisId).remove();
	
						acc_updateDate('',answer, prevID);
						
						return false;
					}
				});
				jQuery('#acc_enddate_'+section).change(function() {
	
					if(isNaN(parseInt(jQuery(this).val()))) {
						alert("<?php _e('This needs to be a number!', 'progressive-license'); ?>");
						jQuery(this).val('0').focus();
					}
					var thisRow = jQuery('#acc_row_'+section);
					var prevID = thisRow.prev().attr('id').replace('acc_row_', '');
	
					acc_updateDate(section,false,prevID);
	
					if( thisRow.next().attr('id') ) {
						var nextID = thisRow.next().attr('id').replace('acc_row_', '');
						acc_updateDate(nextID, false, section);
					}
				});
				
				if(jQuery('#acc_row_'+section).prev().attr('id')) {
					var prevID = jQuery('#acc_row_'+section).prev().attr('id').replace('acc_row_','');
					jQuery('#acc_duration_start_'+section).html(jQuery('#acc_total_previous_'+prevID).val());
				}
				
				lastchanged = section;
			}
		});
	});
	<?php print($changeText); ?>	
	function acc_updateDate(section, answer, prevId) {
		if(answer) {
			var id = prevId.replace('acc_delete_', '');
			if(jQuery('#acc_row_'+id).next().attr('id')) {
				var section = jQuery('#acc_row_'+id).next().attr('id').replace('acc_row_','');
			}
		}

		var addDays = jQuery('#acc_enddate_'+section).val();
		
		if(addDays != 0) {
			if(prevId != 0) {
				var origDays = jQuery('#acc_total_previous_'+prevId).val();
	
				var origMilli = origDays*1000*60*60*24;
				var newMilli = addDays*1000*60*60*24;
				var total = todaysDate+origMilli+newMilli;
				var duration = new Date(total);
	
				var newTotal = parseInt(origDays)+parseInt(addDays);
				jQuery('#acc_total_previous_'+section).val(newTotal);
			}
			else {
				var newMilli = addDays*1000*60*60*24;
				var total = todaysDate+newMilli;
				var duration = new Date(total);
	
				var newTotal = parseInt(addDays);
				jQuery('#acc_total_previous_'+section).val(newTotal);
			}
			
			var month;
			var day;
			var year;
			
			month = duration.getMonth() + 1
			day = duration.getDate();
			year = duration.getFullYear();
			
			if(month < 10) {
				month = "0" + month;
			}
			if(day < 10) {
				day = "0" + day;
			}
			
			var durationDate = year+'-'+month+'-'+day;
			jQuery('#acc_duration_'+section).html(durationDate);
		}
		else {
			jQuery('#acc_duration_'+section).html(infinityValue);
		}

		var thisRow = jQuery('#acc_row_'+section);
		if(thisRow.attr('id')) {
			var nextID = thisRow.attr('id').replace('acc_row_',  '');
			jQuery('#acc_duration_start_'+nextID).html(jQuery('#acc_total_previous_'+prevId).val());
			if(thisRow.next().attr('id')) {
				acc_updateDate(thisRow.next().attr('id').replace('acc_row_',''), false, thisRow.attr('id').replace('acc_row_', ''));
			}
		}
	}
	
	function addRow(section) {
		var html = '<tr id="acc_row_###SECTION###"><td style="text-align: center; vertical-align: middle;" id="enddate"><span id="acc_duration_start_###SECTION###">0</span> + <input type="text" name="acc_data[timeframe_###SECTION###][duration]" id="acc_enddate_###SECTION###" size="4" maxlength="4" class="acc_input" value="0" /></td><td><select name="acc_data[timeframe_###SECTION###][key]" id="acc_table_select"><?php print($option_list); ?></select></td><td style="text-align: center; vertical-align: middle;"><span id="acc_duration_###SECTION###">&infin;</span></td><td style="text-align: center;" class="acc_button"><p class="submit" style="border-top: none;"><input type="button" id="acc_delete_###SECTION###" value="Delete" /><input type="hidden" id="acc_total_previous_###SECTION###" value="0" /></p></td></tr>';
		html = html.replace(/###SECTION###/g, section);
		jQuery('#wpbody tbody').append(html);
	}
</script>
<?
}
add_action('admin_head', 'acc_admin_css_js');

if (!function_exists('trim_add_elipsis')) {
function trim_add_elipsis($string, $limit = 100) {
	if (strlen($string) > $limit) {
		if (function_exists('mb_substr')) {
			$string = mb_substr($string, 0, $limit)."...";
		}
		else {
			$string = substr($string, 0, $limit)."...";
		}
	}
	return $string;
}
}

?>