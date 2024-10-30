<?php
/*
Plugin Name: LinGO Translation
Plugin URI: http://www.ackuna.com/lingo
Description: Translate your text instantly and on-page, with full control of the translated text from your registered Ackuna.com account.
Version: 1.2.0
Author: Ackuna
Author URI: http://www.ackuna.com/
License: GPL2
*/

/*
Copyright 2016 Ackuna (email : info@ackuna.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class AckunaLingoWidget {
	private	$button_path;
	private	$javascript_path	= '/js';
	private	$styles_path		= '/css';
	private	$image_path			= '/img/lingo';
	private $ackuna_lingo_first_save;
	private $ackuna_lingo_show_branding;
	private $ackuna_lingo_username;
	
	// Constructor.
	function AckunaLingoWidget() {
		// Add the full paths.
		$this->button_path		= 'https://ackuna.com';
		$this->javascript_path	= $this->button_path . $this->javascript_path;
		$this->styles_path		= $this->button_path . $this->styles_path;
		$this->image_path		= $this->button_path . $this->image_path;
		// Add functions to the content and excerpt.
		add_filter('the_content', array(&$this, 'codeToContent'));
		add_filter('get_the_excerpt', array(&$this, 'ackunaLingoExcerptTrim'));
		add_filter('plugin_action_links_' . plugin_basename(__FILE__), array(&$this, 'pluginSettingsLink'));
		// Initialize the plugin.
		add_action('admin_menu', array(&$this, '_init'));
		// Display the admin notification
		add_action('admin_notices', array($this, 'plugin_activation'));
		// Get the plugin options.
		$this->ackuna_lingo_first_save		= get_option('ackuna_lingo_first_save', 0);
		$this->ackuna_lingo_show_branding	= get_option('ackuna_lingo_show_branding', 0);
		$this->ackuna_lingo_username		= get_option('ackuna_lingo_username', '');
		// Parameterize variables for script URL.
		$script_name = sprintf(
			'/wp-plugin.js?username=%s', 
			(string)$this->ackuna_lingo_username
		);
		// Register our scripts.
		wp_register_script('ackuna_lingo', $this->javascript_path . $script_name, 'jquery', '3.4.1', true);
	}
	
	function _init() {
		// Add the options page.
		add_options_page('LinGO Settings', 'LinGO', 'manage_options', 'ackuna_lingo', array(&$this, 'pluginOptions'));
		add_submenu_page(null, 'Reset LinGO Settings', 'Reset LinGO', 'manage_options', 'ackuna_lingo_reset', array(&$this, 'pluginReset'));
		// Register our plugin settings.
		register_setting('ackuna_lingo_options', 'ackuna_lingo_username');
		register_setting('ackuna_lingo_options', 'ackuna_lingo_first_save');
		register_setting('ackuna_lingo_options', 'ackuna_lingo_show_branding');
	}
	
	function plugin_activation() {
		if (current_user_can('manage_options') && !$this->ackuna_lingo_first_save) {
			echo <<<EOL
				<div class="error settings-error notice">
					<p><strong>Warning! Your LinGO button is not set up yet!</strong></p>
					<p>Be sure to enter your registered Ackuna account's username and other options under <a href="options-general.php?page=ackuna_lingo">LinGO Settings</a>!</p>
				</div>
EOL;
		}
	}
	
	// Called whenever content is shown.
	function codeToContent($content) {
		// What we add depends on type.
		if (is_feed()) {
			// Add nothing to RSS feed.
			return $content;
		} else if (is_category()) {
			// Add nothing to categories.
			return $content;
		} else if (is_singular()) {
			// For singular pages we add the button to the content normally.
			wp_enqueue_script('ackuna_lingo');
			return $this->getAckunaLingoCode() . $content;
		} else {
			// For everything else add nothing.
			return $content;
		}
	}
	
	// Get the actual button code.
	function getAckunaLingoCode() {
		// Get the proper link
		$ackuna_lingo_code = <<<EOL
			<!-- LinGO button: -->
			<span class="ackuna-lingo notranslate" translate="no"><a href="http://translation-services-usa.com" class="ackuna-lingo-button">translation services</a></span>
			<!-- End LinGO button code. -->
EOL;
		return $ackuna_lingo_code;
	}
	
	// Reset plugin options.
	function pluginReset() {
		if (!current_user_can('manage_options')) {
			wp_die('You do not have sufficient permissions to access this page.');
		}
		?>
		<div class="wrap">
			<form method="post" action="options.php">
				<?php settings_fields('ackuna_lingo_options'); ?>
				<input name="ackuna_lingo_username" type="hidden" value="" />
				<input name="ackuna_lingo_show_branding" type="hidden" value="0" />
				<input name="ackuna_lingo_first_save" type="hidden" value="0" />
				<h2>Reset LinGO Options</h2>
				<p>Click the &quot;Reset Settings&quot; button below to reset the plugin's options to their default settings:</p>
				<table class="widefat">
					<thead>
						<tr>
							<th width="33.333%">Option</th>
							<th width="66.666%">Default Setting</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><b>Registered Ackuna account</b></td>
							<td>none</td>
						</tr>
						<tr>
							<td colspan="2">
								<input type="submit" value="Reset Settings to Default" class="button-primary" /> 
								<a href="options-general.php?page=ackuna_lingo" class="button">Cancel</a>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
		</div>
		<?php
	}
	
	// Admin page display.
	function pluginOptions() {
		if (!current_user_can('manage_options')) {
			wp_die('You do not have sufficient permissions to access this page.');
		}
		?>
		<h2>LinGO Settings</h2>
		<p>Update the settings for the LinGO plugin.</p>
		<div class="wrap">
			<form id="ackuna-lingo-settings" method="post" action="options.php">
				<?php settings_fields('ackuna_lingo_options'); ?>
				<input name="ackuna_lingo_username" type="hidden" value="" />
				<input name="ackuna_lingo_show_branding" type="hidden" value="0" />
				<input name="ackuna_lingo_first_save" type="hidden" value="1" />
				<table class="widefat">
					<tbody>
						<tr>
							<?php
							if ($this->ackuna_lingo_username) {
								?>
								<td style="padding:10px;font-family:Verdana,Geneva,sans-serif;color:#666;border-bottom:1px dotted #ddd;width:50%;">
									<p>Want to edit your site settings or translations? Click the button below to launch the admin panel. (Note: you may need to sign in with your <b><?php echo htmlspecialchars($this->ackuna_lingo_username); ?></b> first.)</p>
									<a href="https://ackuna.com/lingo" target="_blank" class="button" onclick="window.open(this.href, 'Ackuna_Lingo_Site_Configuration', 'scrollbars=yes,width=767,height=600,resizable=yes,toolbar=no,location=no,status=no');return false;">Launch Site Configuration</a>
								</td>
								<?php
							}
							?>
							<td colspan="<?php echo $this->ackuna_lingo_username ? '1' : '2'; ?>" style="padding:10px;font-family:Verdana,Geneva,sans-serif;color:#666;border-bottom:1px dotted #ddd;">
								<p><label for="ackuna_lingo_username">Your Registered Ackuna Account Username</label></p>
								<p>
									<input id="ackuna_lingo_username" name="ackuna_lingo_username" type="text" value="<?php echo htmlspecialchars($this->ackuna_lingo_username); ?>" placeholder="example" />
								<p>
								<?php
								if (!$this->ackuna_lingo_username) {
									?>
									<p><b>Don't have an account?</b> <a href="https://ackuna.com/lingo">Sign up</a> now and get started!</p>
									<?php
								}
								?>
							</td>
						</tr>
						<tr>
							<td colspan="2" style="padding:10px;font-family:Verdana,Geneva,sans-serif;color:#666;">
								<b>Note:</b> if you are using any caching plugins, such as WP Super Cache, you will need to clear your cached pages after updating your LinGO settings.
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<input type="submit" value="Save Settings" class="button-primary" /> 
								<a href="options-general.php?page=ackuna_lingo_reset" class="button">Reset to Default Options</a>
							</td>
						</tr>
					</tbody>
				</table>
				<p><b>LinGO</b> is a project by <a href="http://www.ackuna.com/" target="_blank">Ackuna</a>.</p>
				<p>By using the LinGO Translation plugin, you agree to its terms and conditions as outlined during the signup process at <a href="https://ackuna.com/lingo">Ackuna</a>, and that the plugin may make external AJAX requests, link back to the LinGO website, and offload any required files from the LinGO server for required functionality and to keep the update process as simple as possible.</p>
			</form>
		</div>
		<?php
	}
	
	// Add settings link on plugin page
	function pluginSettingsLink($links) { 
		$settings_link = '<a href="options-general.php?page=ackuna_lingo">Settings</a>'; 
		array_unshift($links, $settings_link); 
		return $links; 
	}
	
	// Remove (what's left of) our button code from excerpts.
	function ackunaLingoExcerptTrim($text) {
		/*
		$pattern		= '/Lingo Translationvar ackuna_lingo_username = "(.*?)";/i';
		$replacement	= '';
		return preg_replace($pattern, $replacement, $text);
		*/
		return $text;
	}
}

$ackuna_lingo &= new AckunaLingoWidget();