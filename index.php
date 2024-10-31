<?php
/**

 * Plugin Name: SEO Pyramid

 * Plugin URI: https://seopyramid.io/

 * Description: Simplified Search Engine Optimization plugin.

 * Version: 1.9.8

 * Author: Chibueze Okechukwu

 * Author URI: https://chibuezeokechukwu.com

 * Text Domain: seo-pyramid

 * Domain Path: /languages/


 **/


// Include the functions file 

include( "seo_pyramid_functions.php" );

class seo_pyramid_add_settings_link {

  public function __construct() {

    add_filter( 'plugin_action_links', array( $this, 'seo_pyramid_plugin_action_links'), 10, 2 );

  }


// add menu links to the plugin entry in the plugins menu

function seo_pyramid_plugin_action_links( $links, $file ) {

  static $this_plugin;

  if ( !$this_plugin ) {

    $this_plugin = plugin_basename( __FILE__ );
  }


  if ( $file == $this_plugin ) {

    $plugin_links[] = '<a href="' . get_bloginfo( 'wpurl' ) . '/wp-admin/options-general.php?page=seo-pyramid">Settings</a>';

    foreach ( $plugin_links as $link ) {
      array_unshift( $links, $link );

    }


  }

  return $links;


}


}

if ( is_admin() )
$addSettingLink = new seo_pyramid_add_settings_link();
?>