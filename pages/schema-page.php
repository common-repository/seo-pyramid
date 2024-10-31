<?php
class SEOPyramidSchemaSettings {
	private $seo_pyramid_schema_settings_options;
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'seo_pyramid_schema_settings_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'seo_pyramid_schema_settings_page_init' ) );
	}

	public function seo_pyramid_schema_settings_add_plugin_page() {
		add_options_page(
			'SEO Pyramid Schema settings', // page_title
			'SEO Pyramid Schema settings', // menu_title
			'manage_options', // capability
			'seo-pyramid-schema-settings', // menu_slug
			array( $this, 'seo_pyramid_schema_settings_create_admin_page' ) // function
		);
	}

	public function seo_pyramid_schema_settings_create_admin_page() {
		$this->seo_pyramid_schema_settings_options = get_option( 'seo_pyramid_schema_settings_option_name' );
        $seo_pyramid_path = plugin_dir_path( __DIR__ ) . '/parts';
?>

<div id="seo_pyramid_settings_form" class="jld">
	
<script type='text/javascript'>
        /* Start conditional display of address section */
		jQuery(document).ready(function() {	
		var bTypeOption = jQuery("#business_type_1").val();
		if(bTypeOption === "LocalBusiness") {	
		jQuery("#seo_pyramid_settings_form.jld table:nth-of-type(2), #seo_pyramid_settings_form.jld h2:last-of-type:not(.seo_pyramid_settings_title)").show(200);
		} else {
		jQuery("#seo_pyramid_settings_form.jld table:nth-of-type(2), #seo_pyramid_settings_form.jld h2:last-of-type:not(.seo_pyramid_settings_title)").hide(200);	
		}
			
		jQuery("#business_type_1").on("change", function() {
		var bTypeOption = jQuery("#business_type_1").val();
		if(bTypeOption === "LocalBusiness") {
		jQuery("#seo_pyramid_settings_form.jld table:nth-of-type(2), #seo_pyramid_settings_form.jld h2:last-of-type:not(.seo_pyramid_settings_title)").show(200);
		} else {
		jQuery("#seo_pyramid_settings_form.jld table:nth-of-type(2), #seo_pyramid_settings_form.jld h2:last-of-type:not(.seo_pyramid_settings_title)").hide(200);	
		}
		});
		});
	
</script>		
	
<h2 class="seo_pyramid_settings_title" style="display: !important">SEO Pyramid</h2>
<?php include($seo_pyramid_path . "/settings-navigation.php"); ?>
  <?php // settings_errors(); ?>
  <form method="post" action="options.php">
				<?php
					settings_fields( 'seo_pyramid_schema_settings_option_group' );
					do_settings_sections( 'seo-pyramid-schema-settings-admin' );
					submit_button();
				?>
			</form>
            
             <div class="seo_pyramid_notice">
    <?php _e( 'Use the tool below to validate the structured data on your web pages.', 'seo-pyramid' ); ?>
    <hr style="margin-top: 15px; opacity: .5;">
    <a href="https://search.google.com/test/rich-results" target="_blank"><span class="dashicons dashicons-external"></span> 
    <?php _e( 'Google structured data (Schema) testing tool', 'seo-pyramid' ); ?>
    </a></div>
            
            
		</div>
	<?php }

	public function seo_pyramid_schema_settings_page_init() {
		register_setting(
			'seo_pyramid_schema_settings_option_group', // option_group
			'seo_pyramid_schema_settings_option_name', // option_name
			array( $this, 'seo_pyramid_schema_settings_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'seo_pyramid_schema_settings_setting_section', // id
			__('Structured Data Settings (Schema)', 'seo-pyramid'), // title
			array( $this, 'seo_pyramid_schema_settings_section_info' ), // callback
			'seo-pyramid-schema-settings-admin' // page
		);
        
        
        add_settings_section(
			'seo_pyramid_schema_settings_setting_section_1', // id
			__('Local Business Contact Information', 'seo-pyramid'), // title
			array( $this, 'seo_pyramid_schema_settings_section_info' ), // callback
			'seo-pyramid-schema-settings-admin' // page
		);

		add_settings_field(
			'enable_schema_0', // id
			__('Enable Schema', 'seo-pyramid'), // title
			array( $this, 'enable_schema_0_callback' ), // callback
			'seo-pyramid-schema-settings-admin', // page
			'seo_pyramid_schema_settings_setting_section' // section
		);

		add_settings_field(
			'business_type_1', // id
			__('Business Type', 'seo-pyramid'), // title
			array( $this, 'business_type_1_callback' ), // callback
			'seo-pyramid-schema-settings-admin', // page
			'seo_pyramid_schema_settings_setting_section' // section
		);
        
        
        add_settings_field(
			'business_logo_2', // id
			__('Entity Logo', 'seo-pyramid'), // title
			array( $this, 'business_logo_2_callback' ), // callback
			'seo-pyramid-schema-settings-admin', // page
			'seo_pyramid_schema_settings_setting_section' // section
		);
        
        
         add_settings_field(
			'social_media_presence', // id
			__('Social Media Pages', 'seo-pyramid'), // title
			array( $this, 'social_media_presence_callback' ), // callback
			'seo-pyramid-schema-settings-admin', // page
			'seo_pyramid_schema_settings_setting_section' // section
		);
        
         add_settings_field(
			'city', // id
			__('City', 'seo-pyramid'), // title
			array( $this, 'city_callback' ), // callback
			'seo-pyramid-schema-settings-admin', // page
			'seo_pyramid_schema_settings_setting_section_1' // section
		);
        
        add_settings_field(
			'state', // id
			__('State', 'seo-pyramid'), // title
			array( $this, 'state_callback' ), // callback
			'seo-pyramid-schema-settings-admin', // page
			'seo_pyramid_schema_settings_setting_section_1' // section
		);
        
         add_settings_field(
			'pcode', // id
			__('Postal Code', 'seo-pyramid'), // title
			array( $this, 'pcode_callback' ), // callback
			'seo-pyramid-schema-settings-admin', // page
			'seo_pyramid_schema_settings_setting_section_1' // section
		);
        
        
        add_settings_field(
			'saddress', // id
			__('Street Address', 'seo-pyramid'), // title
			array( $this, 'saddress_callback' ), // callback
			'seo-pyramid-schema-settings-admin', // page
			'seo_pyramid_schema_settings_setting_section_1' // section
		);
        
         add_settings_field(
			'phone', // id
			__('Phone Number', 'seo-pyramid'), // title
			array( $this, 'Phone_callback' ), // callback
			'seo-pyramid-schema-settings-admin', // page
			'seo_pyramid_schema_settings_setting_section_1' // section
		);
        
        
         add_settings_field(
			'price', // id
			__('Price Range', 'seo-pyramid'), // title
			array( $this, 'price_callback' ), // callback
			'seo-pyramid-schema-settings-admin', // page
			'seo_pyramid_schema_settings_setting_section_1' // section
		);
        
	}

	public function seo_pyramid_schema_settings_sanitize($input) {
		$sanitary_values = array();
		if ( isset( $input['enable_schema_0'] ) ) {
			$sanitary_values['enable_schema_0'] = $input['enable_schema_0'];
		}

		if ( isset( $input['business_type_1'] ) ) {
			$sanitary_values['business_type_1'] = $input['business_type_1'];
		}
        
        if ( isset( $input['business_logo_2'] ) ) {
			$sanitary_values['business_logo_2'] = $input['business_logo_2'];
		}
        
        
        if ( isset( $input['social_media_presence'] ) ) {
			$sanitary_values['social_media_presence'] = $input['social_media_presence'];
		}
        
       
        if ( isset( $input['city'] ) ) {
			$sanitary_values['city'] = sanitize_text_field( $input['city']);
		}
        
        if ( isset( $input['state'] ) ) {
			$sanitary_values['state'] = sanitize_text_field( $input['state']);
		}
        
        
        if ( isset( $input['pcode'] ) ) {
			$sanitary_values['pcode'] = sanitize_text_field( $input['pcode']);
		}
        
         if ( isset( $input['saddress'] ) ) {
			$sanitary_values['saddress'] = sanitize_text_field( $input['saddress']);
		}
        
        if ( isset( $input['phone'] ) ) {
			$sanitary_values['phone'] = sanitize_text_field( $input['phone']);
		}
        
         if ( isset( $input['price'] ) ) {
			$sanitary_values['price'] = sanitize_text_field( $input['price']);
		}

		return $sanitary_values;
	}

	public function seo_pyramid_schema_settings_section_info() {
		
	}

	public function enable_schema_0_callback() {
        
            
// Save attachment ID
  if ( isset( $_POST[ 'submit_image_selector' ] ) && isset( $_POST[ 'image_attachment_id' ] ) ):

    update_option( 'media_selector_attachment_id', absint( $_POST[ 'image_attachment_id' ] ) );

  endif;

  wp_enqueue_media();
        
        
		printf(
			'<label class="switch"><input type="checkbox" name="seo_pyramid_schema_settings_option_name[enable_schema_0]" id="enable_schema_0" value="enable_schema_0" %s><span class="slider round"></span></label>',
			( isset( $this->seo_pyramid_schema_settings_options['enable_schema_0'] ) && $this->seo_pyramid_schema_settings_options['enable_schema_0'] === 'enable_schema_0' ) ? 'checked' : ''
		);
	}

	public function business_type_1_callback() {
		?> <select name="seo_pyramid_schema_settings_option_name[business_type_1]" id="business_type_1">
			<?php $option1 = (isset( $this->seo_pyramid_schema_settings_options['business_type_1'] ) && $this->seo_pyramid_schema_settings_options['business_type_1'] === 'Organization') ? 'selected' : '' ; ?>
        
            <?php $option3 = (isset( $this->seo_pyramid_schema_settings_options['business_type_1'] ) && $this->seo_pyramid_schema_settings_options['business_type_1'] === 'LocalBusiness') ? 'selected' : '' ; ?>
        
			<option value="Organization" <?php echo $option1; ?>><?php _e( 'Organization', 'seo-pyramid' ) ?></option>  
            <option value="LocalBusiness" <?php echo $option3; ?>><?php _e( 'Local Business', 'seo-pyramid' ) ?></option>
            
		</select> <?php
	}
    
    
    public function business_logo_2_callback() {


  printf(

    '<div style="width: 360px; display: inline-block; position: relative;"><input class="regular-text" type="text" name="seo_pyramid_schema_settings_option_name[business_logo_2]" id="business_logo_2" value="%s" placeholder="' . __( 'Add your logo', 'seo-pyramid' ) . '">       
            <div class="image-preview-wrapper">

			<img id="image-preview" src="' . esc_attr( $this->seo_pyramid_schema_settings_options[ "business_logo_2" ] ) . '"' . 'height="100">

		</div> <a class="call-to-action"><i class="material-icons">add</i> Add Logo</a></div>',
    isset( $this->seo_pyramid_schema_settings_options[ 'business_logo_2' ] ) ? esc_attr( $this->seo_pyramid_schema_settings_options[ 'business_logo_2' ] ) : ''
  );
}
    
    
  public function social_media_presence_callback() {
		
  printf(

    '<textarea  class="regular-text" rows="5" name="seo_pyramid_schema_settings_option_name[social_media_presence]" id="social_media_presence" placeholder="' . __( 'Social Media Pages', 'seo-pyramid' ) . '">%s</textarea><p class="help-text">Format: One social media page link per line</p>',
    isset( $this->seo_pyramid_schema_settings_options[ 'social_media_presence' ] ) ? esc_attr( $this->seo_pyramid_schema_settings_options[ 'social_media_presence' ] ) : ''

  );


} 
     
 public function city_callback() {
  printf(

    '<input class="regular-text" type="text" name="seo_pyramid_schema_settings_option_name[city]" id="city" value="%s" placeholder="' . __( 'City', 'seo-pyramid' ) . '">',
    isset( $this->seo_pyramid_schema_settings_options[ 'city' ] ) ? esc_attr( $this->seo_pyramid_schema_settings_options[ 'city' ] ) : ''

  );

} 
    
 public function state_callback() {

  printf(

    '<input class="regular-text" type="text" name="seo_pyramid_schema_settings_option_name[state]" id="state" value="%s" placeholder="' . __( 'State', 'seo-pyramid' ) . '">',
    isset( $this->seo_pyramid_schema_settings_options[ 'state' ] ) ? esc_attr( $this->seo_pyramid_schema_settings_options[ 'state' ] ) : ''

  );

} 
      
 public function pcode_callback() {

  printf(

    '<input class="regular-text" type="text" name="seo_pyramid_schema_settings_option_name[pcode]" id="state" value="%s" placeholder="' . __( 'PostalCode', 'seo-pyramid' ) . '">',
    isset( $this->seo_pyramid_schema_settings_options[ 'pcode' ] ) ? esc_attr( $this->seo_pyramid_schema_settings_options[ 'pcode' ] ) : ''

  );

} 
       
 public function saddress_callback() {

  printf(

    '<input class="regular-text" type="text" name="seo_pyramid_schema_settings_option_name[saddress]" id="state" value="%s" placeholder="' . __( 'Street Address', 'seo-pyramid' ) . '">',
    isset( $this->seo_pyramid_schema_settings_options[ 'saddress' ] ) ? esc_attr( $this->seo_pyramid_schema_settings_options[ 'saddress' ] ) : ''

  );

} 
    
 public function phone_callback() {

  printf(

    '<input class="regular-text" type="text" name="seo_pyramid_schema_settings_option_name[phone]" id="state" value="%s" placeholder="' . __( 'Phone Number', 'seo-pyramid' ) . '">',
    isset( $this->seo_pyramid_schema_settings_options[ 'phone' ] ) ? esc_attr( $this->seo_pyramid_schema_settings_options[ 'phone' ] ) : ''

  );

} 
      
 public function price_callback() {

  printf(

    '<input class="regular-text" type="text" name="seo_pyramid_schema_settings_option_name[price]" id="price" value="%s" placeholder="' . __( '$00 - $00', 'seo-pyramid' ) . '">',
    isset( $this->seo_pyramid_schema_settings_options[ 'price' ] ) ? esc_attr( $this->seo_pyramid_schema_settings_options[ 'price' ] ) : ''

  );

} 
    
}
if ( is_admin() )
    
	$seo_pyramid_schema_settings = new SEOPyramidSchemaSettings();

// Remove the link

function remove_schema_link() {

  remove_submenu_page( 'options-general.php', 'seo-pyramid-schema-settings' );

}

add_action( 'admin_menu', 'remove_schema_link', 9999 );



if ( isset( $_GET[ "page" ] ) && ( $_GET[ "page" ] ) === "seo-pyramid-schema-settings" ) {


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

          $(this).html($(this).html().replace('Add Logo','Change Logo')); 

         }

         });


			// Uploading files only when on schema settings page

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