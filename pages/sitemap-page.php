<?php

class SEOPyramidSitemap {

  private $seo_pyramid_sitemap_options;

  public function __construct() {

    add_action( 'admin_menu', array( $this, 'seo_pyramid_sitemap_add_plugin_page' ) );

    add_action( 'admin_init', array( $this, 'seo_pyramid_sitemap_page_init' ) );

  }

  public function seo_pyramid_sitemap_add_plugin_page() {

    add_options_page(

      'SEO Pyramid Sitemap',

      'SEO Pyramid Sitemap',

      'manage_options',

      'seo-pyramid-sitemap',

      array( $this, 'seo_pyramid_sitemap_create_admin_page' )

    );

  }

  public function seo_pyramid_sitemap_create_admin_page() {

    $this->seo_pyramid_sitemap_options = get_option( 'seo_pyramid_sitemap_option_name' );
      
    $seo_pyramid_path = plugin_dir_path( __DIR__ ) . '/parts';

    ?>
<div id="seo_pyramid_settings_form" class="sm">
  <h2 class="seo_pyramid_settings_title">SEO Pyramid</h2>
 <?php include($seo_pyramid_path . "/settings-navigation.php"); ?>
  <?php // settings_errors(); ?>
  <form method="post" action="options.php">
    <?php

    settings_fields( 'seo_pyramid_sitemap_option_group' );

    do_settings_sections( 'seo-pyramid-sitemap-admin' );

    submit_button();

    ?>
  </form>
  <?php

  $seo_pyramid_sitemap_enabler = '<em class="seo_pyramid_enabler">*Enable a feature and save changes to generate a sitemap</em>';

  printf( __( '%s', 'seo-pyramid' ), $seo_pyramid_sitemap_enabler );

  // Check if sitemap is enabled 

  $seo_pyramid_sitemap_options = get_option( 'seo_pyramid_sitemap_option_name' );

  if ( !empty( $seo_pyramid_sitemap_options[ 'change_frequency_0' ] ) ||

    ( !empty( $seo_pyramid_sitemap_options[ 'page_priority_1' ] ) ) ||

    ( !empty( $seo_pyramid_sitemap_options[ 'last_modified_2' ] ) ) ) {

    ?>
  <style type="text/css">

		.seo_pyramid_enabler {

			display: none!important;
		}

	</style>
  <?php

  $seo_pyramid_ready_message = '<div class="seo_pyramid_notice">After you save your changes, an XML sitemap will be generated based on your preferences. However, the "Page Priority" and "Change Frequency" for each page must be set and updated through page/post edit and update window.' . '</br></br>' . ' <a href="' . get_site_url() . '/sitemap.xml"' . 'target="_blank"><span class="dashicons dashicons-external"></span> Preview your sitemap</a> </div>';

  printf( __( '%s', 'seo-pyramid' ), $seo_pyramid_ready_message );

  }

  ?>
</div>
<?php

}

public function seo_pyramid_sitemap_page_init() {

  register_setting(

    'seo_pyramid_sitemap_option_group',

    'seo_pyramid_sitemap_option_name',

    array( $this, 'seo_pyramid_sitemap_sanitize' )

  );


  add_settings_section(

    'seo_pyramid_sitemap_setting_section',

    __('Sitemap Settings', 'seo-pyramid'),

    array( $this, 'seo_pyramid_sitemap_section_info' ),

    'seo-pyramid-sitemap-admin'

  );


  add_settings_field(

    'change_frequency_0',

    __('Change Frequency', 'seo-pyramid'),

    array( $this, 'change_frequency_0_callback' ),

    'seo-pyramid-sitemap-admin',

    'seo_pyramid_sitemap_setting_section'

  );


  add_settings_field(

    'page_priority_1',

    __('Page Priority', 'seo-pyramid'),

    array( $this, 'page_priority_1_callback' ),

    'seo-pyramid-sitemap-admin',

    'seo_pyramid_sitemap_setting_section'

  );


  add_settings_field(

    'last_modified_2',

    __('Last Modified', 'seo-pyramid'),

    array( $this, 'last_modified_2_callback' ),

    'seo-pyramid-sitemap-admin',

    'seo_pyramid_sitemap_setting_section'

  );


}


public function seo_pyramid_sitemap_sanitize( $input ) {

  $sanitary_values = array();

  if ( isset( $input[ 'change_frequency_0' ] ) ) {

    $sanitary_values[ 'change_frequency_0' ] = $input[ 'change_frequency_0' ];

  }


  if ( isset( $input[ 'page_priority_1' ] ) ) {

    $sanitary_values[ 'page_priority_1' ] = $input[ 'page_priority_1' ];

  }


  if ( isset( $input[ 'last_modified_2' ] ) ) {

    $sanitary_values[ 'last_modified_2' ] = $input[ 'last_modified_2' ];

  }

  return $sanitary_values;

}

public function seo_pyramid_sitemap_section_info() {

}

public function change_frequency_0_callback() {

  printf(

    '<label class="switch"><input type="checkbox" name="seo_pyramid_sitemap_option_name[change_frequency_0]" id="change_frequency_0" value="change_frequency_0" %s><span class="slider round"></span></label>',

    ( isset( $this->seo_pyramid_sitemap_options[ 'change_frequency_0' ] ) && $this->seo_pyramid_sitemap_options[ 'change_frequency_0' ] === 'change_frequency_0' ) ? 'checked' : ''

  );

}


public function page_priority_1_callback() {

  printf(

    '<label class="switch"><input type="checkbox" name="seo_pyramid_sitemap_option_name[page_priority_1]" id="page_priority_1" value="page_priority_1" %s><span class="slider round"></span></label>',

    ( isset( $this->seo_pyramid_sitemap_options[ 'page_priority_1' ] ) && $this->seo_pyramid_sitemap_options[ 'page_priority_1' ] === 'page_priority_1' ) ? 'checked' : ''

  );

}


public function last_modified_2_callback() {

  printf(

    '<label class="switch"><input type="checkbox" name="seo_pyramid_sitemap_option_name[last_modified_2]" id="last_modified_2" value="last_modified_2" %s><span class="slider round"></span></label>',

    ( isset( $this->seo_pyramid_sitemap_options[ 'last_modified_2' ] ) && $this->seo_pyramid_sitemap_options[ 'last_modified_2' ] === 'last_modified_2' ) ? 'checked' : ''

  );

}

}

if ( is_admin() )
  $seo_pyramid_sitemap = new SEOPyramidSitemap();


// Create Sitemap 


class seo_pyramid_create_sitemap {

	
  public function __construct() {


    $this->create_sitemap();


  }


  public function create_sitemap() {


      $seo_pyramid_sitemap_options = get_option( 'seo_pyramid_sitemap_option_name' );
	  
	 // $currParValue = get_current_screen();

     
	  if(isset($_POST["submit"]) && is_admin()) {
      if ( !empty( $seo_pyramid_sitemap_options[ 'change_frequency_0' ] ) ||


        ( !empty( $seo_pyramid_sitemap_options[ 'page_priority_1' ] ) ) ||


        ( !empty( $seo_pyramid_sitemap_options[ 'last_modified_2' ] ) ) ) {


        $opts = [


          "http" => [


            "method" => "GET",


            "header" => "Accept-language: en\r\n"


          ]

        ];


        $my_plugin = plugins_url('seo-pyramid') . "/builders";


        $context = stream_context_create( $opts );


        $content = file_get_contents( $my_plugin . '/sitemap.php', false, $context );


        clearstatcache();


        $fp = fopen( $_SERVER[ 'DOCUMENT_ROOT' ] . "/sitemap.xml", "w+" ) or die( "Unable to open file!" );


        fwrite( $fp, $content );


        fclose( $fp );



}

  }


}


}


$seo_pyramid_create_sitemap = new seo_pyramid_create_sitemap();


// Remove menu from menu
function remove_menu_items() {
  remove_submenu_page( 'options-general.php', 'seo-pyramid-sitemap' );

}

add_action( 'admin_menu', 'remove_menu_items', 999 );