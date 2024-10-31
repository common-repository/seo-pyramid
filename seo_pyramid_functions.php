<?php

class seo_pyramd_check_currPages {

  public function __construct() {

    $this->checkCurrUrl();

  }

  public function checkCurrUrl() {

    $homeUrl = rtrim( get_home_url(), "/" );

    $currUrl = rtrim( get_page_link(), "/" );

    if ( $homeUrl === $currUrl ) {

      $currpage = "do_not_analyze";

    } else {

      $currpage = str_replace( '-', ' ', get_post_field( 'post_name', get_post() ) );
    }

    return $currpage;
  }

}


// Redirect class

class seo_pyramid_redirect {

  public function __construct() {

    add_action( 'wp_head', array( $this, 'add_seo_pyramid_add_redirect' ) );

  }


  function add_seo_pyramid_add_redirect() {

    global $post;
	  
	if( !is_object($post) )
        return;

    $redirect = $runRedirect = $date = $today = "";
	  
    // Check if date is in the past
	if(!empty($post->ID)):
    $date = new DateTime( get_post_meta( $post->ID, 'seo_pyramid_redirect_date', true ) );
    $today = new DateTime();
	endif;

    if ( $date < $today ) {
      $runRedirect = "No";
    }
    if ( get_post_meta( $post->ID, 'seo_pyramid_redirect_switch', true ) === "Active" ) {

      $redirect = get_post_meta( $post->ID, 'seo_pyramid_redirect', true );

    } else {

      $redirect = "";

    }


    if ( $redirect !== "" && $runRedirect !== "No" ) {

      if ( headers_sent() ) {

        ?>
<script>location.href = '<?php echo  $redirect ?>'</script>
<?php

} else {

  wp_redirect( $redirect, true, 302 );

  exit;

}

}

}

}


$seo_pyramid_redirect = new seo_pyramid_redirect();


// Add the custom column to the post type

add_filter( 'manage_pages_columns', 'sp_add_custom_column' );

add_filter( 'manage_posts_columns', 'sp_add_custom_column' );


function sp_add_custom_column( $columns ) {

  $columns[ 'seo' ] = 'SEO';

  return $columns;

}


// Adding the data to the custom column

add_action( 'manage_pages_custom_column', 'sp_add_custom_column_data', 10, 2 );

add_action( 'manage_posts_custom_column', 'sp_add_custom_column_data', 10, 2 );


function sp_add_custom_column_data( $column, $post_id ) {


  switch ( $column ) {


    case 'seo':


      include( "builders/shared-analyzer.php" );


      $allStatus = round( substr_count( "$urlWordDiffClass .  '' . $wordDiffClass . ' ' . $pcWordDiffClass . ' ' . $titleCharLengthClass . ' ' . $descCharLengthClass . ' ' . $indexOrNotClass", "good" ) / 6 * 100 );


      if ( $allStatus > 69 ) {


        $title = "Yay: This page is ready!";


        $status = "all-good";


      } elseif ( $allStatus >= 60 ) {


        $title = "SEO issues exist on this page";

        $status = "not-good";


      } else {


        $title = "SEO issues exist on this page";

        $status = "really-bad";


      }


      $post = get_post( $post_id );


      echo '<div class="seo_pyramid_run ' . $status . '" aria-label="' . $title . '">' .


      $allStatus . '% <span class="grader"></span></div>';

      break;

  }

}


// Make the custom column sortable

add_filter( 'manage_edit-page_sortable_columns', 'sp_add_custom_column_make_sortable' );

add_filter( 'manage_edit-post_sortable_columns', 'sp_add_custom_column_make_sortable' );


function sp_add_custom_column_make_sortable( $columns ) {

  $columns[ 'seo' ] = 'seo';

  return $columns;

}


// Add custom column sort request to post list page

add_action( 'load-edit.php', 'sp_add_custom_column_sort_request' );


function sp_add_custom_column_sort_request() {

  add_filter( 'request', 'itsg_add_custom_column_do_sortable' );

}


// Handle the custom column sorting

function itsg_add_custom_column_do_sortable( $vars ) {

  // check if sorting has been applied

  if ( isset( $vars[ 'orderby' ] ) && 'modified' == $vars[ 'orderby' ] ) {


    // apply the sorting to the post list

    $vars = array_merge(

      $vars,

      array(

        'orderby' => 'post_modified'

      )

    );

  }


  return $vars;

}


// SEO Pyramid menu

function wpdocs_register_seo_pyramid_menu() {


  add_menu_page(


    __( 'SEO Pyramid', 'seo-pyramid' ),


    'SEO Pyramid',


    'manage_options',


    '/options-general.php?page=seo-pyramid',


    '',


    plugins_url( '/seo-pyramid/img/seo-pyramid-logo-icon.jpg' ), 999


  );


}


add_action( 'admin_menu', 'wpdocs_register_seo_pyramid_menu' );


// Load text domain

add_action( 'plugins_loaded', 'seo_pyramid_load_text_domain' );


function seo_pyramid_load_text_domain() {


  load_plugin_textdomain( 'seo-pyramid', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );


}




// Call settings function 


$seo_pyramid_options = get_option( 'seo_pyramid_option_name' );


// Title Tag Handling

class seo_pyramid_change_page_title {


  public function __construct() {


    add_filter( 'pre_get_document_title', array( $this, 'change_page_title' ) );


  }


  public function change_page_title( $title ) {


    global $post, $seo_pyramid_options;

    $siteName = $pageTitle = $titleDivider = "";


    if ( !is_404() ) {

      $seo_pyramid_page_title = get_post_meta( $post->ID, 'seo_pyramid_title', true );


      $native_title = esc_html( get_the_title( $post->ID ) );

    }


    // Add separator and sitename to title if it is not home


    if ( !is_home() && !is_front_page() ) {


      $siteName = get_bloginfo( "name" );


    }


    // Remove divider if user did not provide title


    if ( ( ( $siteName ) && !empty( $seo_pyramid_page_title ) && !is_home() && !is_front_page() )


      ||

      ( !empty( $native_title ) && !empty( $siteName ) && !is_front_page() && !is_home() ) ) {


      $titleDivider = " - ";


    }


    if ( !is_404() ) {


      if ( empty( $seo_pyramid_page_title ) ) {


        $seo_pyramid_page_title = $native_title;


      }


      // Construct title if one doesn't exist


      if ( empty( $seo_pyramid_page_title ) && empty( $seo_pyramid_page_title ) ) {


        $seo_pyramid_page_title = ucwords( str_replace( "-", " ", $post->post_name ) );


      }


      $pageTitle = $seo_pyramid_page_title . $titleDivider . $siteName;


    }


    if ( $pageTitle ) {


      return $pageTitle;


    }


    return $title;


  }


}


$changePageTitle = new seo_pyramid_change_page_title();


// Canonical Link Handling


class seo_pyramid_handle_canonical {


  public function __construct() {


    $this->seo_pyramid_enable_canonical();


  }


  public function seo_pyramid_enable_canonical() {


    global $seo_pyramid_options;


    if ( !empty( $seo_pyramid_options[ 'canonical_tag_3' ] ) ) {


      remove_action( 'wp_head', 'rel_canonical' );


    }


  }


}


$seo_pyramid_canonical = new seo_pyramid_handle_canonical();


/* Addd tags to head section */


add_action( 'wp_head', 'add_seo_pyramid_to_header' );


$canonical = $redirect = $robd = $desc = "";


$bing_id = $google_id = $yandex_id = $baidu_id = $open_graph_enable = $twitter_card_enable = $open_graph_image = "";


function add_seo_pyramid_to_header() {


  global $post, $seo_pyramid_options;


  // Variable for enabled fields


  if ( !is_404() ) {


    $canonical = get_post_meta( $post->ID, 'seo_pyramid_canonical', true );


    if ( empty( $canonical ) ) {

      $canonical = get_the_permalink();

    }


    $redirect = get_post_meta( $post->ID, 'seo_pyramid_redirect', true );

    $robd = get_post_meta( $post->ID, 'seo_pyramid_robots', true );

    $desc = get_post_meta( $post->ID, 'seo_pyramid_description', true );


    // use auto description if no value is provided

    if ( $desc === "" ):

      global $post;

    $desc = wp_strip_all_tags( $post->post_content );

    $desc = mb_substr( $desc, 0, 180 );

    endif;
	  
    if ( is_array( $seo_pyramid_options ) ) {
	  global $bing_id;
      $bing_id = $seo_pyramid_options[ "bing_analytics_id_6" ];
    }
    ?>

<!-- SEO Pyramid Print Meta Tags -->
<?php if($desc) { ?>
<meta name="description" content="<?php echo $desc; ?>">
<?php }; if($robd) { ?>
<meta name="robots" content="<?php echo $robd; ?>" >
<?php
};
if ( ( $canonical ) && ( !empty( $seo_pyramid_options[ 'canonical_tag_3' ] ) ) ) {
  ?>
<link rel="canonical" href="<?php echo $canonical ?>" />

<!-- SEO Pyramid Print Site Verications -->
<?php }; if(!empty($seo_pyramid_options[ 'baidu_verification_id_8' ])) { ?>
<meta name="baidu-site-verification" content='<?php echo $seo_pyramid_options[ 'baidu_verification_id_8' ]; ?>'/>
<?php }; if(!empty($bing_id)) { ?>
<meta name="msvalidate.01" content='<?php echo $bing_id; ?>'/>
<?php }; if(!empty($seo_pyramid_options[ "yandex_verification_id_7" ])) { ?>
<meta name="yandex-verification" content="<?php echo $seo_pyramid_options[ "yandex_verification_id_7" ] ?>" />
<?php
}

};

if ( is_array( $seo_pyramid_options ) ) {
  global $google_id;
  $google_id = $seo_pyramid_options[ 'google_analytics_id_5' ];
}

if (!empty($google_id)) {
  ?>

<!-- SEO Pyramid Print Google tracking code --> 
<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $google_id ?>"></script> 
<script>
 window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', '<?php echo $google_id ?>');
</script>
<?php
}

if ( !empty( $seo_pyramid_options[ 'facebook_verification_id_9' ] ) ) {
  $facebook_pixel_id = $seo_pyramid_options[ 'facebook_verification_id_9' ];
  if ( $facebook_pixel_id ) {
    ?>

<!-- SEO Pyramid Print Facebook Pixel code --> 
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '<?php echo $facebook_pixel_id ?>');
  fbq('track', 'PageView');
</script>
<noscript>
<img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=<?php echo $facebook_pixel_id ?>&ev=PageView&noscript=1"/>
</noscript>
<?php
}
}

// OG TC Call
$seo_pyramid_og_and_tc_options = get_option( 'seo_pyramid_og_and_tc_option_name' );
	
global $open_graph_image, $open_graph_enable, $twitter_card_enable;

if ( is_array( $seo_pyramid_og_and_tc_options ) ) {
	
  $open_graph_image = $seo_pyramid_og_and_tc_options[ 'open_graph_image_1' ];

  $open_graph_admin = $seo_pyramid_og_and_tc_options[ 'open_graph_admin_5' ];

  $open_graph_app = $seo_pyramid_og_and_tc_options[ 'open_graph_app_6' ];

  $twitter_card_image = $seo_pyramid_og_and_tc_options[ 'twitter_card_image_3' ];

  $twitter_card_handle = $seo_pyramid_og_and_tc_options[ 'twitter_card_handle_4' ];

  $open_graph_enable = $seo_pyramid_og_and_tc_options[ 'open_graph_0' ];

  $twitter_card_enable = $seo_pyramid_og_and_tc_options[ 'twitter_card_2' ];

}

$contentTYpe = $width = $height = "";

// Check if page has featured image
if ( has_post_thumbnail() ) {
  $facebookFeaturedImage = get_the_post_thumbnail_url();
} else {
	
  $facebookFeaturedImage = $open_graph_image;
}

// Define content type
$contentTYpe = "Website";
if ( !is_home() ) {
  $contentType = "Article";
}

// Get the image Dimensions 
if ( empty( $facebookFeaturedImage ) ) {
  // Do nothing
} else {
  list( $width, $height, $type, $attr ) = getimagesize( $facebookFeaturedImage );
}

if ( $open_graph_enable ) {
  ?>

<!--  SEO Pyramid Print Open Graph -->
<meta property="og:locale" content="<?php echo get_locale() ?>" />
<?php if($contentType) { ?>
<meta property="og:type" content="<?php echo $contentType ?>" />
<?php } ?>
<meta property="og:title" content="<?php echo the_title() ?>" />
<meta property="og:site_name" content="<?php echo str_replace('www.','', $_SERVER['SERVER_NAME']); ?>" />
<?php if(!empty($desc)) { ?>
<meta property="og:description" content="<?php echo $desc; ?>" />
<?php } ?>
<meta property="og:url" content="<?php echo the_permalink() ?>" />
<?php if($open_graph_admin) { ?>
<meta property="fb:admins" content="<?php echo $open_graph_admin ?>" />
<?php } if($open_graph_app) { ?>
<meta property="fb:pages" content="<?php echo $open_graph_app ?>" />
<?php } if($open_graph_image) { ?>
<meta property="og:image" content="<?php echo $facebookFeaturedImage ?>" />
<?php } if($width) { ?>
<meta property="og:image:width" content="<?php echo $width ?>" />
<?php } if($height) { ?>
<meta property="og:image:height" content="<?php echo $height ?>" />
<?php } } if($twitter_card_enable) { ?>

<!--  SEO Pyramid Print Twitter Card -->
<meta name="twitter:card" content="summary" />
<?php if(!empty($desc)) { ?>
<meta name="twitter:description" content="<?php echo $desc; ?>" />
<?php } ?>
<meta name="twitter:title" content="<?php echo the_title(); ?>" />
<?php if($twitter_card_handle) { ?>
<meta name="twitter:site" content="<?php echo $twitter_card_handle ?>" />
<?php } if($twitter_card_image) { ?>
<meta name="twitter:image" content="<?php echo $twitter_card_image ?>" />
<?php } } ?>
<?php ?>

<!-- SEO Pyramid Print JSON-LD -->
<?php
$seo_pyramid_schema_settings_options = get_option( 'seo_pyramid_schema_settings_option_name' );
if ( !empty( $seo_pyramid_schema_settings_options[ 'enable_schema_0' ] ) ): include( "builders/schema.php" );
endif;
}

/* Register Fields */
function add_seo_pyramid() {

  $screens = [ 'post', 'page' ];

  foreach ( $screens as $screen ) {

    add_meta_box(

      'seo_pyramid',

      '<div class="seo-pyramid-header">' . 'SEO Pyramid' . '</div>',

      'seo_pyramid_fields',

      $screen

    );

  }

}


add_action( 'add_meta_boxes', 'add_seo_pyramid' );

function seo_pyramid_fields( $post ) {

  include( "seo_pyramid_form.php" );

}


/* Register and add SEO Pyramid local assets */

class seo_pyramid_add_assets {

  public function __construct() {

    add_action( 'admin_enqueue_scripts', array( $this, 'seo_pyramid_enqueue_assets' ) );

  }


  public function seo_pyramid_enqueue_assets() {

    // Custom jQuery
    wp_enqueue_style( 'seo_pyramid_style', plugins_url( '/assets/css/seo_pyramid_style.css', __FILE__ ) );

    // Custom CSS
    wp_enqueue_script( 'seo_pyramid_script', plugins_url( '/assets/js/seo_pyramid_jquery.js', __FILE__ ), array( 'jquery' ) );


    // Material Icons
    wp_enqueue_style( 'Material Icons', '//fonts.googleapis.com/icon?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp' );

  }

}

$enqueue_assets = new seo_pyramid_add_assets();


/*
 * Save meta box content and update sitemap
*/


function seo_pyramid_save_field_entries( $seo_pyramid_post_id ) {
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	
     // Create Sitemap 

      $seo_pyramid_sitemap_options = get_option( 'seo_pyramid_sitemap_option_name' );
	  

    
      if ( !empty( $seo_pyramid_sitemap_options[ 'change_frequency_0' ] ) ||


        ( !empty( $seo_pyramid_sitemap_options[ 'page_priority_1' ] ) ) ||


        ( !empty( $seo_pyramid_sitemap_options[ 'last_modified_2' ] ) ) ) {


        $opts = [


          "http" => [


            "method" => "GET",


            "header" => "Accept-language: en\r\n"


          ]

        ];


        $my_plugin = plugin_dir_url( __FILE__ ) . '/builders';


        $context = stream_context_create( $opts );


        $content = file_get_contents( $my_plugin . '/sitemap.php', false, $context );


        clearstatcache();


        $fp = fopen( $_SERVER[ 'DOCUMENT_ROOT' ] . "/sitemap.xml", "w+" ) or die( "Unable to open file!" );


        fwrite( $fp, $content );


        fclose( $fp );


  }

	
	
  if ( $seo_pyramid_parent_id = wp_is_post_revision( $seo_pyramid_post_id ) ) {
    $seo_pyramid_post_id = $seo_pyramid_parent_id;
  }

  $seo_pyramid_fields = [

    'seo_pyramid_title',

    'seo_pyramid_description',

    'seo_pyramid_robots',

    'seo_pyramid_redirect',

    'seo_pyramid_redirect_switch',

    'seo_pyramid_redirect_date',

    'seo_pyramid_canonical',

    'seo_pyramid_change_frequency',

    'seo_pyramid_page_priority',

    'seo_pyramid_status'

  ];


  foreach ( $seo_pyramid_fields as $seo_pyramid_field ) {

    if ( array_key_exists( $seo_pyramid_field, $_POST ) ) {

      update_post_meta( $seo_pyramid_post_id, $seo_pyramid_field, sanitize_text_field( $_POST[ $seo_pyramid_field ] ) );
    }

  }
}

add_action( 'save_post', 'seo_pyramid_save_field_entries' );

/*

 * Settings Page Code begins here

*/

include( "pages/general-page.php" );

include( "pages/sitemap-page.php" );

include( "pages/share-page.php" );

include( "pages/schema-page.php" );

include( "pages/reports-page.php" );