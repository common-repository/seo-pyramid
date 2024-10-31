<?php

$seo_pyramid_options = get_option( 'seo_pyramid_option_name' );

class SEOPyramid {

  private $seo_pyramid_options;

  public function __construct() {

    add_action( 'admin_menu', array( $this, 'seo_pyramid_add_plugin_page' ) );

    add_action( 'admin_init', array( $this, 'seo_pyramid_page_init' ) );

  }


  public function seo_pyramid_add_plugin_page() {

    add_options_page(

      'SEO Pyramid', // page_title

      'SEO Pyramid', // menu_title

      'manage_options', // capability

      'seo-pyramid', // menu_slug

      array( $this, 'seo_pyramid_create_admin_page' )

    );

  }


  public function seo_pyramid_create_admin_page() {

    $this->seo_pyramid_options = get_option( 'seo_pyramid_option_name' );

    $seo_pyramid_path = plugin_dir_path( __DIR__ ) . '/parts';

    ?>
<div id="seo_pyramid_settings_form">
  <h2 class="seo_pyramid_settings_title">SEO Pyramid</h2>
  <?php include($seo_pyramid_path . "/settings-navigation.php"); ?>
  <?php // settings_errors(); ?>
  <form method="post" action="options.php">
    <?php


    settings_fields( 'seo_pyramid_option_group' );


    do_settings_sections( 'seo-pyramid-admin' );


    submit_button();


    ?>
  </form>
</div>
<?php


}


public function seo_pyramid_page_init() {


  register_setting(


    'seo_pyramid_option_group',


    'seo_pyramid_option_name',


    array( $this, 'seo_pyramid_sanitize' )


  );


  add_settings_section(


    'seo_pyramid_setting_section',


    __('General Settings', 'seo-pyramid'),


    array( $this, 'seo_pyramid_section_info' ),


    'seo-pyramid-admin'


  );


  add_settings_section(


    'seo_pyramid_setting_section_1',


    __('Analytics and Verififications', 'seo-pyramid'),


    array( $this, 'seo_pyramid_section_info' ),


    'seo-pyramid-admin'


  );


  add_settings_field(


    'page_title_0',


    __('Page Title', 'seo-pyramid'),


    array( $this, 'page_title_0_callback' ),


    'seo-pyramid-admin',


    'seo_pyramid_setting_section'


  );


  add_settings_field(


    'page_description_1',


    __('Page Description', 'seo-pyramid'),


    array( $this, 'page_description_1_callback' ),


    'seo-pyramid-admin',


    'seo_pyramid_setting_section'


  );


  add_settings_field(


    'robots_directive_2',


    __('Robots Directive', 'seo-pyramid'),


    array( $this, 'robots_directive_2_callback' ),


    'seo-pyramid-admin',


    'seo_pyramid_setting_section'


  );


  add_settings_field(


    'canonical_tag_3',


    __('Canonical Tag', 'seo-pyramid'),


    array( $this, 'canonical_tag_3_callback' ),


    'seo-pyramid-admin',


    'seo_pyramid_setting_section'


  );


  add_settings_field(


    'redirect_4',


    __('Page Redirects', 'seo-pyramid'),


    array( $this, 'redirect_4_callback' ),


    'seo-pyramid-admin',


    'seo_pyramid_setting_section'


  );


  add_settings_field(


    'google_analytics_id_5',


    __('Google Tracking ID', 'seo-pyramid'),


    array( $this, 'google_analytics_id_5_callback' ),


    'seo-pyramid-admin',


    'seo_pyramid_setting_section_1'


  );


  add_settings_field(


    'bing_analytics_id_6',


    __('Bing Verification ID', 'seo-pyramid'),


    array( $this, 'bing_analytics_id_6_callback' ),


    'seo-pyramid-admin',


    'seo_pyramid_setting_section_1'


  );


  add_settings_field(


    'yandex_verification_id_7',


    __('Yandex Verification ID', 'seo-pyramid'),


    array( $this, 'yandex_verification_id_7_callback' ),


    'seo-pyramid-admin',


    'seo_pyramid_setting_section_1'


  );


  add_settings_field(


    'baidu_verification_id_8',


    __('Baidu Verification ID', 'seo-pyramid'),


    array( $this, 'baidu_verification_id_8_callback' ),


    'seo-pyramid-admin',


    'seo_pyramid_setting_section_1'


  );


  add_settings_field(


    'facebook_verification_id_9',


    __('Facebook Pixel ID', 'seo-pyramid'),


    array( $this, 'facebook_verification_id_9_callback' ),


    'seo-pyramid-admin',


    'seo_pyramid_setting_section_1'


  );
	
 add_settings_field(


    'language_filter',


    __('Profanity Filter', 'seo-pyramid'),


    array( $this, 'language_filter_callback' ),


    'seo-pyramid-admin',


    'seo_pyramid_setting_section'


  );


}


public function seo_pyramid_sanitize( $input ) {


  $sanitary_values = array();


  if ( isset( $input[ 'page_title_0' ] ) ) {


    $sanitary_values[ 'page_title_0' ] = $input[ 'page_title_0' ];


  } else {


    $sanitary_values[ 'page_title_0' ] = "disabled";


  }


  if ( isset( $input[ 'page_description_1' ] ) ) {


    $sanitary_values[ 'page_description_1' ] = $input[ 'page_description_1' ];


  } else {


    $sanitary_values[ 'page_description_1' ] = "disabled";


  }


  if ( isset( $input[ 'robots_directive_2' ] ) ) {


    $sanitary_values[ 'robots_directive_2' ] = $input[ 'robots_directive_2' ];


  }


  if ( isset( $input[ 'canonical_tag_3' ] ) ) {


    $sanitary_values[ 'canonical_tag_3' ] = $input[ 'canonical_tag_3' ];


  }


  if ( isset( $input[ 'redirect_4' ] ) ) {


    $sanitary_values[ 'redirect_4' ] = $input[ 'redirect_4' ];


  }


  if ( isset( $input[ 'google_analytics_id_5' ] ) ) {


    $sanitary_values[ 'google_analytics_id_5' ] = sanitize_text_field( $input[ 'google_analytics_id_5' ] );


  }


  if ( isset( $input[ 'bing_analytics_id_6' ] ) ) {


    $sanitary_values[ 'bing_analytics_id_6' ] = sanitize_text_field( $input[ 'bing_analytics_id_6' ] );


  }


  if ( isset( $input[ 'yandex_verification_id_7' ] ) ) {


    $sanitary_values[ 'yandex_verification_id_7' ] = sanitize_text_field( $input[ 'yandex_verification_id_7' ] );


  }


  if ( isset( $input[ 'baidu_verification_id_8' ] ) ) {


    $sanitary_values[ 'baidu_verification_id_8' ] = sanitize_text_field( $input[ 'baidu_verification_id_8' ] );


  }


  if ( isset( $input[ 'facebook_verification_id_9' ] ) ) {


    $sanitary_values[ 'facebook_verification_id_9' ] = sanitize_text_field( $input[ 'facebook_verification_id_9' ] );

  }
	
if ( isset( $input[ 'language_filter' ] ) ) {


    $sanitary_values[ 'language_filter' ] = sanitize_text_field( $input[ 'language_filter' ] );

  }

  return $sanitary_values;

}


public function seo_pyramid_section_info() {

}

public function page_title_0_callback() {

  // Enable title tag by default

  if ( empty( $this->seo_pyramid_options[ 'page_title_0' ] ) ) {

    $this->seo_pyramid_options[ 'page_title_0' ] = "";

    if ( esc_attr( $this->seo_pyramid_options[ 'page_title_0' ] ) !== "disabled" ) {

      $this->seo_pyramid_options[ 'page_title_0' ] = 'page_title_0';

    }

  }


  printf(


    '<label class="switch"><input type="checkbox" name="seo_pyramid_option_name[page_title_0]" id="page_title_0" value="page_title_0" %s> <span class="slider round"></span></label>',


    ( isset( $this->seo_pyramid_options[ 'page_title_0' ] ) && $this->seo_pyramid_options[ 'page_title_0' ] === 'page_title_0' ) ? 'checked' : ''


  );


}


public function page_description_1_callback() {


  // Enable description tag by default 


  if ( empty( $this->seo_pyramid_options[ 'page_description_1' ] ) ) {


    $this->seo_pyramid_options[ 'page_description_1' ] = "";


    if ( esc_attr( $this->seo_pyramid_options[ 'page_description_1' ] ) !== "disabled" ) {


      $this->seo_pyramid_options[ 'page_description_1' ] = 'page_description_1';


    }


  }


  printf(


    '<label class="switch"><input type="checkbox" name="seo_pyramid_option_name[page_description_1]" id="page_description_1" value="page_description_1" %s> <span class="slider round"></span></label>',


    ( isset( $this->seo_pyramid_options[ 'page_description_1' ] ) && $this->seo_pyramid_options[ 'page_description_1' ] === 'page_description_1' ) ? 'checked' : ''


  );


}


public function robots_directive_2_callback() {


  printf(


    '<label class="switch"><input type="checkbox" name="seo_pyramid_option_name[robots_directive_2]" id="robots_directive_2" value="robots_directive_2" %s> <span class="slider round"></span></label>',


    ( isset( $this->seo_pyramid_options[ 'robots_directive_2' ] ) && $this->seo_pyramid_options[ 'robots_directive_2' ] === 'robots_directive_2' ) ? 'checked' : ''


  );


}


public function canonical_tag_3_callback() {


  printf(


    '<label class="switch"><input type="checkbox" name="seo_pyramid_option_name[canonical_tag_3]" id="canonical_tag_3" value="canonical_tag_3" %s> <span class="slider round"></span></label>',


    ( isset( $this->seo_pyramid_options[ 'canonical_tag_3' ] ) && $this->seo_pyramid_options[ 'canonical_tag_3' ] === 'canonical_tag_3' ) ? 'checked' : ''


  );


}


public function redirect_4_callback() {

  printf(

    '<label class="switch"><input type="checkbox" name="seo_pyramid_option_name[redirect_4]" id="redirect_4" value="redirect_4" %s> <span class="slider round"></span></label>',

    ( isset( $this->seo_pyramid_options[ 'redirect_4' ] ) && $this->seo_pyramid_options[ 'redirect_4' ] === 'redirect_4' ) ? 'checked' : ''

  );

}
	
public function language_filter_callback() {

  printf(

    '<label class="switch"><input type="checkbox" name="seo_pyramid_option_name[language_filter]" id="language_filter" value="language_filter" %s> <span class="slider round"></span></label>',

    ( isset( $this->seo_pyramid_options[ 'language_filter' ] ) && $this->seo_pyramid_options[ 'language_filter' ] === 'language_filter' ) ? 'checked' : ''

  );

}


public function google_analytics_id_5_callback() {

  printf(

    '<input class="regular-text" type="text" name="seo_pyramid_option_name[google_analytics_id_5]" id="google_analytics_id_5" value="%s"> <i class="material-icons what_is_this">school<div class="seo_pyramid_learn"><a href="https://support.google.com/analytics/answer/7372977?hl=en" target="_blank">How to get Google Analytics ID</a></div></i>',

    isset( $this->seo_pyramid_options[ 'google_analytics_id_5' ] ) ? esc_attr( $this->seo_pyramid_options[ 'google_analytics_id_5' ] ) : ''

  );

}


public function baidu_verification_id_8_callback() {

  printf(

    '<input class="regular-text" type="text" name="seo_pyramid_option_name[baidu_verification_id_8]" id="baidu_verification_id_8" value="%s"> <i class="material-icons what_is_this">school<div class="seo_pyramid_learn"><a href="https://www.theegg.com/seo/china/verifying-your-site-for-baidu-webmaster-tools/" target="blank">How to get Baidu verification ID</a></div></i>',

    isset( $this->seo_pyramid_options[ 'baidu_verification_id_8' ] ) ? esc_attr( $this->seo_pyramid_options[ 'baidu_verification_id_8' ] ) : ''

  );

}

public function bing_analytics_id_6_callback() {

  printf(

    '<input class="regular-text" type="text" name="seo_pyramid_option_name[bing_analytics_id_6]" id="bing_analytics_id_6" value="%s"> <i class="material-icons what_is_this">school<div class="seo_pyramid_learn"><a href="https://www.bing.com/webmaster/help/how-to-verify-ownership-of-your-site-afcfefc6" target="blank">How to get Bing Analytics ID</a></div></i>',

    isset( $this->seo_pyramid_options[ 'bing_analytics_id_6' ] ) ? esc_attr( $this->seo_pyramid_options[ 'bing_analytics_id_6' ] ) : ''

  );

}

public function yandex_verification_id_7_callback() {

  printf(

    '<input class="regular-text" type="text" name="seo_pyramid_option_name[yandex_verification_id_7]" id="yandex_verification_id_7" value="%s"> <i class="material-icons what_is_this">school<div class="seo_pyramid_learn"><a href="https://searchfacts.com/yandex-webmaster-tools/" target="_blank">How to get Yandex verification ID</a></div></i>',

    isset( $this->seo_pyramid_options[ 'yandex_verification_id_7' ] ) ? esc_attr( $this->seo_pyramid_options[ 'yandex_verification_id_7' ] ) : ''

  );


}


public function facebook_verification_id_9_callback() {

  printf(

    '<input class="regular-text" type="text" name="seo_pyramid_option_name[facebook_verification_id_9]" id="facebook_verification_id_9" value="%s"> <i class="material-icons what_is_this">school<div class="seo_pyramid_learn"><a href="https://www.youtube.com/watch?v=GAmlaeiB-4M" target="_blank">How to get Facebook Pixel ID</a></div></i>',

    isset( $this->seo_pyramid_options[ 'facebook_verification_id_9' ] ) ? esc_attr( $this->seo_pyramid_options[ 'facebook_verification_id_9' ] ) : ''

  );


}


}

if ( is_admin() )
  $seo_pyramid = new SEOPyramid();