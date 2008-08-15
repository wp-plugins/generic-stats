<?php
/*
Plugin Name: Generic Stats
Plugin URI: http://www.geniosity.co.za/tools/wordpress/
Description: This plugin allows you to add any stats code to either the Header of Footer of your posts.
Author: James McMullan
Version: 1.1
Author URI: http://www.geniosity.co.za/
*/

if ( ! class_exists( 'GenStats_Admin' ) ) {

	class GenStats_Admin {
		function add_config_page() {
			global $wpdb;
			if ( function_exists('add_submenu_page') ) {
				add_submenu_page('plugins.php','Generic Stats Configuration', 'Generic Stats', 1, basename(__FILE__),array('GenStats_Admin','config_page'));
			}
		} // end add_config_page()

		function config_page() {
			if ( isset($_POST['submit']) ) {
				if (!current_user_can('manage_options')) die(__('You cannot edit the GenStats plugin options.'));
				check_admin_referer('genstats-udpatesettings');
			}

			if ( isset($_POST['submit']) ) {
				if (!current_user_can('manage_options')) die(__('You cannot edit the Robots Meta options.'));
				check_admin_referer('genstats-udpatesettings');

				if (isset($_POST['header-stats'])) {
					$options['header-stats'] = $_POST['header-stats'];
				}

				if (isset($_POST['disable-header-admin-stats'])) {
					$options['disable-header-admin-stats'] = true;
				} else {
					$options['disable-header-admin-stats'] = false;
				}
				
				if (isset($_POST['footer-stats'])) {
					$options['footer-stats'] = $_POST['footer-stats'];
				}

				if (isset($_POST['disable-footer-admin-stats'])) {
					$options['disable-footer-admin-stats'] = true;
				} else {
					$options['disable-footer-admin-stats'] = false;
				}

				
				update_option('GenStats', $options);

			}
			
			$options = get_option('GenStats');


			?>
			<div class="wrap">
				<style type="text/css" media="screen">
					p {
						max-width: 600px;
					}
				</style>
				<h2>Generic Stats Configuration</h2>
				<fieldset>
					<form action="" method="post" id="genstats-conf">
						<?php if (function_exists('wp_nonce_field')) { wp_nonce_field('genstats-udpatesettings'); } ?>
						<h3>- Header Stats -</h3>
						<span style="float: right; margin-top: -30px;" class="submit"><input type="submit" name="submit" value="Update Settings &raquo;" /></span>
						<table style="border: 1px solid grey; padding: 5px;">
							<tr>
								<td style="width: 30px;">
									<textarea cols="100" rows="15" name="header-stats"><?php echo stripslashes($options['header-stats']) ?></textarea>
								</td>
							</tr>
							<tr>
								<td style="width: 30px;">
									<input type="checkbox" id="disable-header-admin-stats" name="disable-header-admin-stats" <?php if ( $options['disable-header-admin-stats'] == true ) echo ' checked="checked" '; ?>/>
									<label for="disable-header-admin-stats"><b>Don't track the Admin User with the Header Stats</b></label>
								</td>
							</tr>
						</table>

						<h3>- Footer Stats -</h3>
						<table style="border: 1px solid grey; padding: 5px;">
							<tr>
								<td style="width: 30px;">
									<textarea cols="100" rows="15" name="footer-stats"><?php echo stripslashes($options['footer-stats']) ?></textarea>
								</td>
							</tr>
							<tr>
								<td style="width: 30px;">
									<input type="checkbox" id="disable-footer-admin-stats" name="disable-footer-admin-stats" <?php if ( $options['disable-footer-admin-stats'] == true ) echo ' checked="checked" '; ?>/>
									<label for="disable-footer-admin-stats"><b>Don't track the Admin User with the Footer Stats</b></label>
								</td>
							</tr>
						</table>
						<span style="float: right; margin-top: -30px;" class="submit"><input type="submit" name="submit" value="Update Settings &raquo;" /></span>
					</form>
				</fieldset>
				<br/><br/>

			</div>
			<div class="wrap">
				<h2>About Generic Stats</h2>
				<p>
					Generic Stats is a plugin that allows you to add your own stats code without the need of adding it to your template code.<br />
					This is so that if you feel like trying out a new stats program, you don't have to edit your template to add the new code, and then edit it again to remove it.<br />
					And, of course, if you decide to change your blog's template, you will already have your stats code available, without having to add it to the new template.<br />
				</p>
				<p>
					The reason you will see both a "<b>Header Stats</b>" and "<b>Footer Stats</b>" section below is because some stats programs, like <a href="http://www.google.com/analytics/">Google Analytics</a>, prefer that you put the tracking code at the top of your page before your opening &lt;body&gt; tag, whereas others prefer that you put your code just after your closing &lt;/body&gt; tag.
				</p>
				<p>
					<h3>Some Stats Programs I use</h3>
					<ul>
						<li><b><a href="http://www.google.com/analytics/">Google Analytics</a></b> - A great, EXTENSIVE free stats program from Google</li>
						<li><b><a href="http://www.statcounter.com">StatCounter</a></b> - A handy free stats tool I use for the "<b>Recent Visitor Activity</b>" section for a quick overview of what's happening on my site</li>
						<li><b><a href="http://pmetrics.performancing.com/480">performancing Metrics</a></b> - A free stats counter with the ability to "<b>spy on your visitors</b>"</li>
						<li><b><a href="http://www.reinvigorate.net/">ReInvigorate</a></b> - A GREAT looking free Stats package</li>
						<li><b><a href="http://www.phpmyvisites.us/">phpMyVisites</a></b> - A self-hosted, free php statistics package.</li>
					</ul>
				</p>
				<p>
					<h3>More Info</h3>
					You can get more info regarding this plugin from the following pages:
					<ul>
						<li><b><a href="http://www.geniosity.co.za/musings/wordpress/wordpress-generic-statistics-plugin/">Plugin Announcement page</a></b> - If you subscribe to the comments feed you'll keep up with release announcements</li>
						<li><b><a href="http://www.geniosity.co.za/wordpress/generic-statistics-wordpress-plugin">Plugin Homepage</a></b> - You can download the plugin and see screenshots of the plugin from this pag</li>
						<li><b><a href="http://www.geniosity.co.za/forums/tools/wordpress/generic-stats-plugin">Generic Stats Plugin Forum</a></b> - Discuss the plugin in the forums if you've found bugs or have any requests...</li>
					</ul>
				</p>
			</div>

<?php			
		}
	}
}

function gsAddHeaderStats() {
	$options = get_option('GenStats');
	
	if ($options['header-stats'] != "") {
		if (($options['disable-header-admin-stats'] && !current_user_can('edit_posts')) || !$options['disable-header-admin-stats']) {
			echo "\n" . stripslashes($options['header-stats']) . "\n";
		}
	}

}
function gsAddFooterStats() {
	$options = get_option('GenStats');
	
	if ($options['footer-stats'] != "") {
		if (($options['disable-footer-admin-stats'] && !current_user_can('edit_posts')) || !$options['disable-footer-admin-stats']) {
			echo "\n" . stripslashes($options['footer-stats']) . "\n";
		}
	}

}

add_action('admin_menu', array('GenStats_Admin','add_config_page'));
add_action('wp_head', 'gsAddHeaderStats', 10);
add_action('wp_footer', 'gsAddFooterStats', 10);

?>
