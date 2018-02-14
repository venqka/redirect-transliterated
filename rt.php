<?php
/*
Plugin Name: Redirect Transliterated
Author:      venqka, vloo
Author URI:  https://shtrak.eu/
Description: This plugin redirects all transliterated urls
Version: 1.0.0
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

/*
Redirect transliterated is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
Redirect transliterated is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with Redirect transliterated. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/

//settings
require( 'rt-settings.php' );

//redirection 
include_once( 'redirect-transliterated.php' );

/**********************************************************************
	Add link to settings page on the plugins page
**********************************************************************/
function plugin_settings_link( $links ) {
	$settings_link = array(
 		'<a href="' . admin_url( 'options-general.php?page=redirect-transliterated-settings' ) . '">Settings</a>',
 	);
	return array_merge( $links, $settings_link );
}
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'plugin_settings_link' );