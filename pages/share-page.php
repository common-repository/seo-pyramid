<?php
class SEOPyramidOGAndTC {

  private $seo_pyramid_og_and_tc_options;

  public function __construct() {

    add_action( 'admin_menu', array( $this, 'seo_pyramid_og_and_tc_add_plugin_page' ) );

    add_action( 'admin_init', array( $this, 'seo_pyramid_og_and_tc_page_init' ) );

  }

  public function seo_pyramid_og_and_tc_add_plugin_page() {

    add_options_page(

      'SEO Pyramid OG and TC', // page_title

      'SEO Pyramid OG and TC', // menu_title

      'manage_options', // capability

      'seo-pyramid-og-and-tc', // menu_slug

      array( $this, 'seo_pyramid_og_and_tc_create_admin_page' ) // function

    );

  }

  public function seo_pyramid_og_and_tc_create_admin_page() {
    $this->seo_pyramid_og_and_tc_options = get_option( 'seo_pyramid_og_and_tc_option_name' );
    $seo_pyramid_path = plugin_dir_path( __DIR__ ) . '/parts';

    ?>
<div id="seo_pyramid_settings_form" class="share">
  <h2 class="seo_pyramid_settings_title">SEO Pyramid</h2>
 <?php include($seo_pyramid_path . "/settings-navigation.php"); ?>
  <?php // settings_errors(); ?>
  <form method="post" action="options.php">
    <?php
    settings_fields( 'seo_pyramid_og_and_tc_option_group' );
    do_settings_sections( 'seo-pyramid-og-and-tc-admin' );
    submit_button();
    ?>
  </form>
  <style type="text/css">

		.seo_pyramid_enabler {
			display: none!important;
		}

.seo_pyramid_notice a {

    display: inline-block;
    margin-right: 10px;

}

	</style>
  <div class="seo_pyramid_notice">
    <?php _e( 'The Facebook Open Graph image will only be used if the shared content on your website does not have a featured image. Use the tools below to validate your Open Graph and Twitter Card.', 'seo-pyramid' ); ?>
    <hr style="margin-top: 15px; opacity: .5;">
    <a href="https://developers.facebook.com/tools/debug/" target="_blank"><span class="dashicons dashicons-external"></span>
    <?php _e( 'Facebook Validator', 'seo-pyramid' ); ?>
    </a> <a href="https://cards-dev.twitter.com/validator" target="_blank"><span class="dashicons dashicons-external"></span>
    <?php _e( 'Twitter Card Validator', 'seo-pyramid' ); ?>
    </a></div>
</div>
<?php

}


public function seo_pyramid_og_and_tc_page_init() {

  register_setting(

    'seo_pyramid_og_and_tc_option_group',

    'seo_pyramid_og_and_tc_option_name',

    array( $this, 'seo_pyramid_og_and_tc_sanitize' )

  );


  add_settings_section(

    'seo_pyramid_og_and_tc_setting_section',

    __('Open Graph', 'seo-pyramid'),

    array( $this, 'seo_pyramid_og_and_tc_section_info' ),

    'seo-pyramid-og-and-tc-admin'

  );


  add_settings_section(

    'seo_pyramid_og_and_tc_setting_section1',

    __('Twitter Card', 'seo-pyramid'),

    array( $this, 'seo_pyramid_og_and_tc_section_info' ),

    'seo-pyramid-og-and-tc-admin'

  );


  add_settings_field(

    'open_graph_0',

    __('Enable Open Graph', 'seo-pyramid'),

    array( $this, 'open_graph_0_callback' ),

    'seo-pyramid-og-and-tc-admin',

    'seo_pyramid_og_and_tc_setting_section'


  );


  add_settings_field(

    'open_graph_image_1',

    __('FB Preview Image', 'seo-pyramid'),

    array( $this, 'open_graph_image_1_callback' ),

    'seo-pyramid-og-and-tc-admin',

    'seo_pyramid_og_and_tc_setting_section'

  );


  add_settings_field(

    'open_graph_admin_5',

    __('FB Admin ID', 'seo-pyramid'),

    array( $this, 'open_graph_admin_5_callback' ),

    'seo-pyramid-og-and-tc-admin',

    'seo_pyramid_og_and_tc_setting_section'

  );


  add_settings_field(

    'open_graph_app_6',

    __('FB App ID', 'seo-pyramid'),

    array( $this, 'open_graph_app_6_callback' ),

    'seo-pyramid-og-and-tc-admin',

    'seo_pyramid_og_and_tc_setting_section'

  );


  add_settings_field(

    'twitter_card_2',

    __('Enable Twitter Card', 'seo-pyramid'),

    array( $this, 'twitter_card_2_callback' ),

    'seo-pyramid-og-and-tc-admin',

    'seo_pyramid_og_and_tc_setting_section1'

  );


  add_settings_field(

    'twitter_card_image_3',

    __('Twitter Preview Image', 'seo-pyramid'),

    array( $this, 'twitter_card_image_3_callback' ),

    'seo-pyramid-og-and-tc-admin',

    'seo_pyramid_og_and_tc_setting_section1'

  );


  add_settings_field(

    'twitter_card_handle_4',

    __('Twitter Handle', 'seo-pyramid'),

    array( $this, 'twitter_card_handle_4_callback' ),

    'seo-pyramid-og-and-tc-admin',

    'seo_pyramid_og_and_tc_setting_section1'

  );


}


public function seo_pyramid_og_and_tc_sanitize( $input ) {

  $sanitary_values = array();

  if ( isset( $input[ 'open_graph_0' ] ) ) {

    $sanitary_values[ 'open_graph_0' ] = $input[ 'open_graph_0' ];

  }


  if ( isset( $input[ 'open_graph_image_1' ] ) ) {

    $sanitary_values[ 'open_graph_image_1' ] = sanitize_text_field( $input[ 'open_graph_image_1' ] );

  }


  if ( isset( $input[ 'twitter_card_2' ] ) ) {

    $sanitary_values[ 'twitter_card_2' ] = $input[ 'twitter_card_2' ];

  }


  if ( isset( $input[ 'twitter_card_image_3' ] ) ) {

    $sanitary_values[ 'twitter_card_image_3' ] = sanitize_text_field( $input[ 'twitter_card_image_3' ] );

  }


  if ( isset( $input[ 'twitter_card_handle_4' ] ) ) {

    $sanitary_values[ 'twitter_card_handle_4' ] = sanitize_text_field( $input[ 'twitter_card_handle_4' ] );

  }


  if ( isset( $input[ 'open_graph_admin_5' ] ) ) {

    $sanitary_values[ 'open_graph_admin_5' ] = sanitize_text_field( $input[ 'open_graph_admin_5' ] );

  }


  if ( isset( $input[ 'open_graph_app_6' ] ) ) {

    $sanitary_values[ 'open_graph_app_6' ] = sanitize_text_field( $input[ 'open_graph_app_6' ] );

  }

  return $sanitary_values;

}

public function seo_pyramid_og_and_tc_section_info() {

}


public function open_graph_0_callback() {

  printf(

    '<label class="switch"><input type="checkbox" name="seo_pyramid_og_and_tc_option_name[open_graph_0]" id="open_graph_0" value="open_graph_0" %s><span class="slider round"></span></label>',

    ( isset( $this->seo_pyramid_og_and_tc_options[ 'open_graph_0' ] ) && $this->seo_pyramid_og_and_tc_options[ 'open_graph_0' ] === 'open_graph_0' ) ? 'checked' : ''

  );

}


public function open_graph_admin_5_callback() {

  // Save attachment ID

  if ( isset( $_POST[ 'submit_image_selector' ] ) && isset( $_POST[ 'image_attachment_id' ] ) ):

    update_option( 'media_selector_attachment_id', absint( $_POST[ 'image_attachment_id' ] ) );

  endif;

  wp_enqueue_media();

  printf(

    '<input class="regular-text" type="text" name="seo_pyramid_og_and_tc_option_name[open_graph_admin_5]" id="open_graph_admin_5" value="%s" placeholder="Facebook User ID"><p class="help-text"><a href="http://findmyfbid.com/" target="_blank">Get Facebook Page ID with this tool</a></p>',

    isset( $this->seo_pyramid_og_and_tc_options[ 'open_graph_admin_5' ] ) ? esc_attr( $this->seo_pyramid_og_and_tc_options[ 'open_graph_admin_5' ] ) : ''

  );

}


public function open_graph_app_6_callback() {

  printf(

    '<input class="regular-text" type="text" name="seo_pyramid_og_and_tc_option_name[open_graph_app_6]" id="open_graph_app_6" value="%s" placeholder="Facebook App ID"><p class="help-text"><a href="https://developers.facebook.com/apps" target="_blank">Get Facebook App ID here</a></p>',

    isset( $this->seo_pyramid_og_and_tc_options[ 'open_graph_app_6' ] ) ? esc_attr( $this->seo_pyramid_og_and_tc_options[ 'open_graph_app_6' ] ) : ''

  );

}

public function open_graph_image_1_callback() {

  printf(

    '<div style="width: 360px; display: inline-block; position: relative;"><input class="regular-text ogi" trigger="ogi" type="text" name="seo_pyramid_og_and_tc_option_name[open_graph_image_1]" id="open_graph_image_1" value="%s" placeholder="Facebook Preview Image">       

            <div class="image-preview-wrapper">

			<img id="image-preview" src="' . esc_attr( $this->seo_pyramid_og_and_tc_options[ "open_graph_image_1" ] ) . '"' . 'height="100">

		</div> <a class="call-to-action"><i class="material-icons">add</i> Add image</a></div>',

    isset( $this->seo_pyramid_og_and_tc_options[ 'open_graph_image_1' ] ) ? esc_attr( $this->seo_pyramid_og_and_tc_options[ 'open_graph_image_1' ] ) : ''

  );

}


public function twitter_card_2_callback() {

  printf(

    '<label class="switch"><input type="checkbox" name="seo_pyramid_og_and_tc_option_name[twitter_card_2]" id="twitter_card_2" value="twitter_card_2" %s><span class="slider round"></span></label>',

    ( isset( $this->seo_pyramid_og_and_tc_options[ 'twitter_card_2' ] ) && $this->seo_pyramid_og_and_tc_options[ 'twitter_card_2' ] === 'twitter_card_2' ) ? 'checked' : ''

  );


}


public function twitter_card_image_3_callback() {


  printf(

    '<div style="width: 360px; display: inline-block; position: relative;"><input class="regular-text tci" type="text" trigger="tci" name="seo_pyramid_og_and_tc_option_name[twitter_card_image_3]" id="twitter_card_image_3" value="%s" placeholder="Twitter Preview Image">

            <div class="image-preview-wrapper">

			<img id="image-preview" src="' . esc_attr( $this->seo_pyramid_og_and_tc_options[ "twitter_card_image_3" ] ) . '"' . 'height="100">

		</div><a class="call-to-action"><i class="material-icons">add</i> Add image</a></div>',

    isset( $this->seo_pyramid_og_and_tc_options[ 'twitter_card_image_3' ] ) ? esc_attr( $this->seo_pyramid_og_and_tc_options[ 'twitter_card_image_3' ] ) : ''

  );


}


public function twitter_card_handle_4_callback() {

  printf(
    '<input class="regular-text" type="text" name="seo_pyramid_og_and_tc_option_name[twitter_card_handle_4]" id="twitter_card_handle_3" value="%s" placeholder="Twitter Handle">',

    isset( $this->seo_pyramid_og_and_tc_options[ 'twitter_card_handle_4' ] ) ? esc_attr( $this->seo_pyramid_og_and_tc_options[ 'twitter_card_handle_4' ] ) : ''
  );


}


}


if ( is_admin() )

  $seo_pyramid_og_and_tc = new SEOPyramidOGAndTC();

// Remove menu from menu

function remove_sharing_items() {

  remove_submenu_page( 'options-general.php', 'seo-pyramid-og-and-tc' );

}


add_action( 'admin_menu', 'remove_sharing_items', 9999 );


if ( isset( $_GET[ "page" ] ) && ( $_GET[ "page" ] ) === "seo-pyramid-og-and-tc" ) {

  // End Menu item removal

  add_action( 'admin_footer', 'media_selector_print_scripts' );

  function media_selector_print_scripts() {

    $my_saved_attachment_post_id = get_option( 'media_selector_attachment_id', 0 );


    ?>
<script type='text/javascript'>

		jQuery( document ).ready( function( $ ) {

            // Show none empty image preview

            jQuery("img#image-preview").each(function () {

            if(jQuery(this).attr('src') != '') {

             jQuery(this).parents(".image-preview-wrapper").addClass("notEmpty");

            }

           });


        // Handle call to action for empty input 

         jQuery(".call-to-action").each(function () {

          if( $(this).siblings("input").val().trim() == '' ) {

          $(this).children('i').text('add');   

         } else {

          $(this).children('i').text('swap_horiz');

          $(this).html($(this).html().replace('Add image','Change image'));

         }

         });


			// Uploading files only when on OG/TC settings page

			var file_frame;

			var wp_media_post_id = wp.media.model.settings.post.id; // Store the old id

			var set_to_post_id = <?php echo $my_saved_attachment_post_id; ?>; // Set this

			jQuery('.call-to-action').on('click', function( event ){

                jQuery('.call-to-action').not(this).removeClass("pullMe");

                jQuery(this).addClass("pullMe");

				event.preventDefault();


				// If the media frame already exists, reopen it.

				if ( file_frame ) {

					// Set the post ID to what we want

					file_frame.uploader.uploader.param( 'post_id', set_to_post_id );

					// Open frame

					file_frame.open();

					return;

				} else {

					// Set the wp.media post id so the uploader grabs the ID we want when initialised

					wp.media.model.settings.post.id = set_to_post_id;

				}



				// Create the media frame.

				file_frame = wp.media.frames.file_frame = wp.media({

					title: 'Select an image to upload',

					button: {

						text: 'Use this image',

					},

					multiple: false	// Set to true to allow multiple files to be selected

				});


				// When an image is selected, run a callback.

				file_frame.on( 'select', function() {

					// We set multiple to false so only get one image from the uploader

					attachment = file_frame.state().get('selection').first().toJSON();

					// Do something with attachment.id and/or attachment.url here

					jQuery(".pullMe").siblings(".image-preview-wrapper").children("img").attr( 'src', attachment.url );

					jQuery(".pullMe").siblings("input").val( attachment.url );

                    // image preview whe src ins't empty

                    jQuery("img#image-preview").each(function () {

                     if(jQuery(this).attr('src') != '') {

                     jQuery(this).parents(".image-preview-wrapper").addClass("notEmpty");

                    }

                  });

					// Restore the main post ID

					wp.media.model.settings.post.id = wp_media_post_id;

				});

					// Finally, open the modal

					file_frame.open();
			});



			// Restore the main ID when the add media button is pressed

			jQuery( 'a.add_media' ).on( 'click', function() {

				wp.media.model.settings.post.id = wp_media_post_id;

			});

		});

	</script>
<?php

}

}