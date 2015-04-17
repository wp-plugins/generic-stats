<?php
/*
Plugin Name: Generic Stats
Plugin URI: http://www.geniosity.co.za/tools/wordpress-hacks/generic-statistics-wordpress-plugin/
Description: This plugin allows you to add any stats code to either the Header or Footer of your posts. 
Author: James McMullan
Version: 1.3
Author URI: http://www.geniosity.co.za/
*/

if(!class_exists( 'GenStats_Admin')) {

    class GenStats_Admin {

        function GenStats_Admin() {
            add_action('admin_init', array(&$this,'genstats_init'));
            add_action('admin_menu', array('GenStats_Admin','add_config_page'));
            add_action('wp_head',  array('GenStats_Admin','gsAddHeaderStats'), 10);
            add_action('wp_footer',  array('GenStats_Admin','gsAddFooterStats'), 10);
        }

        function genstats_init() {
            register_setting( 'genstats_options', 'GenStats');
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

        function add_config_page() {
        //add_submenu_page('plugins.php','Generic Stats Configuration', 'Generic Stats', 1, basename(__FILE__),array('GenStats_Admin','config_page'));
            add_options_page('Generic Stats Configuration', 'Generic Stats', 'manage_options', 'genstats_options', array('GenStats_Admin','config_page'));
        } // end add_config_page()

        function config_page() {

            ?>

<div class="wrap">
    <h2>Generic Stats Configuration</h2>
    <div class="postbox" style="width:20%;float:right;padding:10px;">
        <h4 style="padding: 10px; background: #FFAFB2; font-family: Georgia,'Times New Roman','Bitstream Charter',Times,serif;">* Plugin Appreciation</h4>
        If you like this plugin, consider signing up for one of the following services through these links:
        <h4 style="padding: 10px; background: #DFD1D3; font-family: Georgia,'Times New Roman','Bitstream Charter',Times,serif;">Spy on your Visitors</h4>
			If you sign up with <b><a href="http://pmetrics.performancing.com/480">Performancing Metrics</a></b>, you get the option to watch your visitors as they arrive and move around your site.
        <p>
            <b>BEWARE</b>: It's <i>EXTREMELY</i> addictive!
        </p>
        <h4 style="padding: 10px; background: #DFD1D3; font-family: Georgia,'Times New Roman','Bitstream Charter',Times,serif;">AWESOME VPS hosting for WP</h4>
			I currently use <a href="http://manage.aff.biz/z/146/CD2453/&subid1=pl2me">VPS.net</a> for hosting quite a few WordPress websites (amongst others). I <i>fully</i> recommend it.
        <h4 style="padding: 10px; background: #DFD1D3; font-family: Georgia,'Times New Roman','Bitstream Charter',Times,serif;">Follow me on Twitter</h4>
			Here's my Twitter page: <a href="http://twitter.com/geniosity">@geniosity</a>

    </div>

    <div class="main-settings" style="display:table;width:70%;">
        <div class="postbox">
            <h4 style="padding: 10px; background: #DFD1D3; font-family: Georgia,'Times New Roman','Bitstream Charter',Times,serif;">Settings</h4>
            <form method="post" action="options.php">
                            <?php settings_fields('genstats_options'); ?>
                            <?php $options = get_option('GenStats'); ?>
                <div class="submit" style="text-align: right; padding-right:5%;"><input type="submit" class="button-primary" name="submit" value="Update Settings" /></div>
                <h5 style="padding: 10px; background: #DFF1FF; font-family: Georgia,'Times New Roman','Bitstream Charter',Times,serif;">Header Stats</h5>
                <table style="margin: 10px;">
                    <tr>
                        <td>
                            <textarea cols="80" rows="15" name="GenStats[header-stats]"><?php echo stripslashes($options['header-stats']) ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox" id="disable-header-admin-stats" name="GenStats[disable-header-admin-stats]" <?php if ( $options['disable-header-admin-stats'] == true ) echo ' checked="checked" '; ?>/>
                            <label for="disable-header-admin-stats"><b>Don't track the Admin User with the Header Stats</b></label>
                        </td>
                    </tr>
                </table>

                <h5 style="padding: 10px; background: #DFF1FF; font-family: Georgia,'Times New Roman','Bitstream Charter',Times,serif;">Footer Stats</h5>
                <table style="margin: 10px;">
                    <tr>
                        <td>
                            <textarea cols="80" rows="15" name="GenStats[footer-stats]"><?php echo stripslashes($options['footer-stats']) ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox" id="disable-footer-admin-stats" name="GenStats[disable-footer-admin-stats]" <?php if ( $options['disable-footer-admin-stats'] == true ) echo ' checked="checked" '; ?>/>
                            <label for="disable-footer-admin-stats"><b>Don't track the Admin User with the Footer Stats</b></label>
                        </td>
                    </tr>
                </table>
                <div class="submit" style="text-align: right; padding-right:5%;"><input type="submit" class="button-primary" name="submit" value="Update Settings" /></div>
            </form>
        </div>

        <div class="postbox" style="display:table;">
            <h4 style="padding: 10px; background: #DFD1D3; font-family: Georgia,'Times New Roman','Bitstream Charter',Times,serif;">About the Generic Stats Plugin</h4>
            <div class="postbox-content" style="padding: 10px;">
                <p>
                    Generic Stats is a plugin that allows you to add your own stats code without the need of adding it to your template code.<br />
                    This is so that if you feel like trying out a new stats program, you don't have to edit your template to add the new code, and then edit it again to remove it.<br />
                    And, of course, if you decide to change your blog's template, you will already have your stats code available, without having to add it to the new template.<br />
                </p>
                <p>
                    The reason you will see both a "<b>Header Stats</b>" and "<b>Footer Stats</b>" section below is because some stats programs, like <a href="http://www.google.com/analytics/">Google Analytics</a>, prefer that you put the tracking code at the top of your page before your opening &lt;body&gt; tag, whereas others prefer that you put your code just before your closing &lt;/body&gt; tag.
                </p>
            </div>
            <p>
            <h5 style="padding: 10px; background: #DFF1FF; font-family: Georgia,'Times New Roman','Bitstream Charter',Times,serif;">Some Stats Programs I use</h5>
            <div class="postbox-content" style="padding: 10px;">
                <ul>
                    <li><b><a href="http://pmetrics.performancing.com/480">performancing Metrics</a></b> - A free stats counter with the ability to "<b>spy on your visitors</b>"</li>
                    <li><b><a href="http://piwik.org/">piwik</a></b> - A self-hosted, free php statistics package that's going to take over the world!!!</li>
                    <li><b><a href="http://www.google.com/analytics/">Google Analytics</a></b> - A great, EXTENSIVE free stats program from Google</li>
                </ul>
            </div>
            </p>
            <p>
            <h5 style="padding: 10px; background: #DFF1FF; font-family: Georgia,'Times New Roman','Bitstream Charter',Times,serif;">More Info</h5>
            <div class="postbox-content" style="padding: 10px;">
                You can get more info regarding this plugin from the following pages:
                <ul>
                    <li><b><a href="http://www.geniosity.co.za/tools/wordpress-hacks/generic-statistics-wordpress-plugin/">Plugin page</a></b> - If you subscribe to the comments feed you'll keep up with release announcements</li>
                    <li><b><a href="http://wordpress.org/extend/plugins/generic-stats/">WordPress Plugin Page</a></b> - You can download the plugin from here.</li>
                </ul>
            </div>
            </p>
        </div>
    </div>
</div>

        <?php
        }
    }

    $genstatsadmin = new GenStats_Admin();
}

?>
