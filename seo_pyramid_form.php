<?php

$seo_pyramid_options = get_option( 'seo_pyramid_option_name' );

$seo_pyramid_sitemap_options = get_option( 'seo_pyramid_sitemap_option_name' );

if ( is_admin() ) {

  // Get current URL

  $permalink = get_the_permalink();

  $find_h = '#^http(s)?://#';

  $find_w = '/^www\./';

  $replace = '';

  $cleanPermalink = preg_replace( $find_h, $replace, $permalink );

  $cleanPermalink = preg_replace( $find_w, $replace, $cleanPermalink );

  // Get site name 

  if ( !empty( get_bloginfo( "name" ) ) && ( !empty( get_post_meta( get_the_ID(), 'seo_pyramid_title', true ) ) ) && !is_home() && !is_front_page() ) {

    global $titleContent;

    $sitename = " - " . get_bloginfo( "name" );

    // Remove divider if user did not provide title

  } elseif ( empty( get_post_meta( get_the_ID(), 'seo_pyramid_title', true ) ) ) {

    $sitename = get_bloginfo( "name" );

    // Construct title if one doesn't exist

  } elseif ( empty( get_bloginfo( "name" ) ) && ( empty( get_post_meta( get_the_ID(), 'seo_pyramid_title', true ) ) ) ) {

    global $post;

    $sitename = ucwords( str_replace( "-", " ", $post->post_name ) );

  } else {

    $sitename = esc_html( get_the_title() );

  }

}


// Define SERP Favicon

$serpFavicon = plugins_url( "/seo-pyramid/img/yandex-globe.png" );

if ( !empty( get_site_icon_url() ) ) {

  $serpFavicon = get_site_icon_url();

}

?>
<div class="seo_pyramid_box"> 
  
  <!-- Navigation starts here -->
  
  <div class="seo_pyramid_preview_nav">
    <?php

    if ( 0 == get_option( 'blog_public' ) ) {

      ?>
    <ul  class="seo-pyramid-notice">
      <li>
        <?php

        _e( "Search engines are discouraged from indexing this site. Click <a href='" . get_home_url() . "/wp-admin/options-reading.php'>here</a> to fix it.", "seo-pyramid" );

        ?>
      </li>
    </ul>
    <?php } ?>
    <div class="seo_pyramid_preview">
      <ul class="seo-pyramid-work-nav">
        <li>
          <?php


          // Show link to settings page only to admin users   

          if ( is_admin() ):

            ?>
          <a href="<?php echo get_home_url()?>/wp-admin/options-general.php?page=seo-pyramid">
          <?php

          _e( 'Enable features', 'seo-pyramid' );

          ?>
          <span class="dashicons dashicons-admin-settings"></span></a>
          <?php endif; ?>
        </li>
        <li class="preview-trigger">
          <?php _e( 'Analyze', 'seo-pyramid' ); ?>
          <span class="dashicons dashicons-chart-bar"></span></li>
      </ul>
    </div>
  </div>
  
  <!-- The preview snippet window starts here -->
  
  <?php

  $close = __( "Close", "seo-pyramid" );

  $update = __( "Update", "seo-pyramid" );

  ?>
  <div id="google" class="seo_pyramid_preview_snippet"> <i class="material-icons close_seo_pyramid_preview" action="<?php echo $close ?>">
    <?php _e( 'close', 'seo-pyramid' ); ?>
    </i> <i class="material-icons update_seo_pyramid_preview" action="<?php echo $update ?>">
    <?php _e( 'update', 'seo-pyramid' ); ?>
    </i>
    <ul class="seo_pyramid_preview_ul">
      <li class="url"> <?php echo $cleanPermalink ?></li>
      <li class="title">
        <div class="serpFavicon"> <img src="<?php echo $serpFavicon ?>" width="50" height="50"/></div>
        <div class="seo-pramid-page-title">
          <?php _e( 'You have\'t provided a title for this page', 'seo-pyramid' ); ?>
        </div>
      </li>
      <li>
        <?php _e( 'You haven\'t provide the description for this content and I can\'t give you an idea of how your page will appear on search engine result pages.', 'seo-pyramid' ); ?>
      </li>
    </ul>
    <div class="explainer robots"> <strong>
      <?php _e( 'What is Robots Directives?', 'seo-pyramid' ); ?>
      </strong>
      <?php _e( 'Robots meta directives (sometimes called "meta tags") are designed to help inform search engines how to crawl or index web page content. Example, You can choose not to allow search engines index or archive a specific web page, or just the images on the page.', 'seo-pyramid' ); ?>
      <a href="https://developers.google.com/search/reference/robots_meta_tag" target="_blanc">
      <?php _e( 'More about Robots Directives', 'seo-pyramid' ); ?>
      </a> </div>
    <div class="explainer canonical"> <strong>
      <?php _e( 'What is Canonical URL?', 'seo-pyramid' ); ?>
      </strong>
      <?php _e( 'Sometimes, search engines perceive the content of some of the pages on a website as duplicates, even when they are not. As such, a bot will always select the URL that seem appropriate for the page. However, you do not have to leave that decision in the hands of a search engine bot and risk having your content mixed up. The Canonical meta tag gives you the opportunity to specify the most appropriate URL for each page on your website.', 'seo-pyramid' ); ?>
      <a href="https://moz.com/learn/seo/canonicalization" target="_blanc">
      <?php _e( 'More about Canonical URL', 'seo-pyramid' ); ?>
      </a> </div>
    <div class="explainer charLength"> <strong>
      <?php

      $sitenameCharLength = strlen( $sitename );

      $whyLength = 60 - strlen( $sitename );

      _e( "Why $whyLength characters?", 'seo-pyramid' );

      ?>
      </strong>
      <?php

      _e( "SEO Pyramid builds the meta title content with your site name and the title you have provided, as shown below: <br>
             <strong> page_title - site_name </strong>
              60 is the recommended character length for meta title content, and your site name is $sitenameCharLength characters long. So, to account for the character length of your site name, we did a little math to help you stay within the recommendation.
             <strong> 60 - $sitenameCharLength = $whyLength </strong>  
              ", 'seo-pyramid' );
      ?>
    </div>
    <div class="serp-switch"> <img class="currSerp" src="<?php echo plugins_url( '/seo-pyramid/img/google-icon.png' )?>" width="50" height="50"  alt="google"/> <img src="<?php echo plugins_url( '/seo-pyramid/img/bing-icon.png' )?>" width="50" height="50"  alt="bing"/> <img src="<?php echo plugins_url( '/seo-pyramid/img/yandex-icon.png' ) ?>" width="50" height="50" alt="yandex"/> </div>
  </div>
  <?php if ( is_admin() ) { ?>
  <div class="loader-container loader-alternate">
    <div class="block">0</div>
    <div class="block">1</div>
    <div class="block">0</div>
    <div class="block">1</div>
    <div class="block">0</div>
    <div class="block">1</div>
    <div class="block">0</div>
    <div class="block">1</div>
    <div class="block">0</div>
    <div class="block">1</div>
    <div class="block">0</div>
    <div class="block">1</div>
    <div class="block">0</div>
    <div class="block">1</div>
    <div class="block">0</div>
    <div class="block">1</div>
  </div>
  <div class="analysis">
    <div class="loader-container">
      <div class="block">0</div>
      <div class="block">1</div>
      <div class="block">0</div>
      <div class="block">1</div>
      <div class="block">0</div>
      <div class="block">1</div>
      <div class="block">0</div>
      <div class="block">1</div>
      <div class="block">0</div>
      <div class="block">1</div>
      <div class="block">0</div>
      <div class="block">1</div>
      <div class="block">0</div>
      <div class="block">1</div>
      <div class="block">0</div>
      <div class="block">1</div>
    </div>
    <?php function seo_pyramid_enqueue_inline_scripts() { ?>
    <script type="text/javascript">



  // wait for document to be ready

  jQuery(function(){



    jQuery(".preview-trigger").click(function () { 

        var langFilter =  jQuery("#seo_pyramid_enable_profane").val();

        var currPageSlug = jQuery("#slug").val();

        var title = jQuery("#seo_pyramid_title").val();

		var desc = jQuery("#seo_pyramid_description").val();

        var robots = jQuery("#seo_pyramid_robots").val();

        var featuredImage = jQuery(".editor-post-featured-image").find("img").attr("alt");

        var pageContent = jQuery('[class$="editor-writing-flow"], .edit-post-text-editor').text();

        var contentImagesTotal = jQuery('[class$="editor-writing-flow"]').find("img").length;

        var imagesWithoutAltTag1 = jQuery("[class$='editor-writing-flow']").find("img[alt='']").length;

        var prefilledImgAlt = jQuery("[class$='editor-writing-flow']").find("img[alt*='This image has an empty alt attribute; its file name is']").length;

        var imagesWithoutAltTag = (prefilledImgAlt + imagesWithoutAltTag1); 

        var imgWalt = jQuery("[class$='editor-writing-flow'] img[alt=''], [class$='editor-writing-flow'] img[alt*='This image has an empty alt attribute; its file name is']").get().map(function(el) {

        return "<img src='" + el.src + "' />";

       });

       var analyzer = "analyze";

         jQuery.ajax({        

		         type: "GET",   

                 url: "<?php echo plugin_dir_url( __FILE__ ) . "/builders/seo_pyramid_analyzer.php" ?>",  

                 async: false,

				 dataType: "html",

				 data: ({

				 title: title, 

                     desc: desc, 

                     robots: robots,

                     pageContent: pageContent, 

                     analyzer: analyzer,

                     contentImagesTotal: contentImagesTotal,

                     imagesWithoutAltTag: imagesWithoutAltTag, 

                     imgWalt: imgWalt,

                     currPageSlug: currPageSlug,
					 
					 langFilter: langFilter,

                 }),	 

                 success : function(text) {

                            var previewTitle = jQuery("#seo_pyramid_title").val() + jQuery("#sitename").val();

                            var previewTitleLength = jQuery("#seo_pyramid_title").val().replace(/\s+/g, " ").length + jQuery("#sitename").val().replace(/\s+/g, " ").length;

                            var titleCharRem = previewTitleLength - 60;

                            if(previewTitleLength > 60 ) {

                            jQuery(".seo_pyramid_preview_ul .title .seo-pramid-page-title").text(previewTitle.slice(0, - titleCharRem) + ("..."));

                            } else {
                                
                             jQuery(".seo_pyramid_preview_ul .title .seo-pramid-page-title").text(previewTitle);

                                
                            }                  

                             setTimeout(function(){

                            jQuery('.analysis').html(text);

                                 },2000); 
                     }
           });	  
});


// Toggle view of report

jQuery(function () {

 // Expand report on lick  

  jQuery(document).on('click', '.analysis ul li', function () {

    jQuery(this).toggleClass("expand");

  });

    });

  });
    
    // Save analysis status

    jQuery(".close_seo_pyramid_preview").click(function () {

     jQuery("#seo_pyramid_status").val(jQuery(".seo-pyramid-status").text()); 

        });

</script>
    <?php } add_action('wp_print_scripts', 'seo_pyramid_enqueue_inline_scripts'); ?>
  </div>
  
  <!-- Form starts here -->
  
  <?php
				
$titleEnabled = "";

 if( is_array($seo_pyramid_options) ) {

	 $titleEnabled = $seo_pyramid_options[ 'page_title_0' ];
	 
 }

  if ( $titleEnabled !== "disabled" ) {

    // Recommended Character length after deduction of sitename length (With the exemption of the home page);

    if ( rtrim( get_home_url(), "/" ) !== rtrim( get_page_link(), "/" ) ) {

      $recCharLen = 60 - strlen( $sitename );

    } else {

      $recCharLen = 60;

      $whyLength = 60;

    }

    ?>
  <p class="meta-options seo_pyramid_field">
    <label for="seo_pyramid_title" style="float: left; width: auto!important"><i class="material-icons">title</i>
      <?php _e( 'Page Title', 'seo-pyramid' ); ?>
      <em>
      <?php _e( "$recCharLen Characters recommended", 'seo-pyramid' ); ?>
      </em> </label>
    <?php if(rtrim(get_home_url(), "/") !== rtrim(get_page_link(), "/")) { ?>
    <span class="answer" text="charLength" style="margin-left: 5px;"><i class="material-icons"> arrow_left </i>
    <?php _e( 'Why?', 'seo-pyramid' ); ?>
    </span>
    <?php } ?>
    <input id="seo_pyramid_title"

            type="text"

            name="seo_pyramid_title"

		    id="input"

		    limit="<?php echo $whyLength ?>"

            value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'seo_pyramid_title', true ) ); ?>">
    <input type="hidden" value="<?php if(rtrim(get_home_url(), "/") !== rtrim(get_page_link(), "/")) { echo $sitename; } ?>" id="sitename">
    <input type="hidden" value="<?php $analyze_or_not = new seo_pyramd_check_currPages(); echo $analyze_or_not->checkCurrUrl(); ?>" id="slug">
    <span class="seo-pyramid-check"><span class="dashicons dashicons-no"></span><span class="count" id="seo_pyramid_title">0 </span>
    <input type="hidden" value="<?php if(!empty($seo_pyramid_options[ 'language_filter' ])) { echo "yes"; } else { echo ""; } ?>" id="seo_pyramid_enable_profane">
    <?php _e( 'Characters', 'seo-pyramid' ); ?>
    <span class="warning">:
    <?php _e( 'You have exceeded the recommended character length', 'seo-pyramid' ); ?>
    </span></span> </p>
  <? } 
 if( is_array($seo_pyramid_options) ) {
 $descEnabled = $seo_pyramid_options['page_description_1'];
 }

 if ($descEnabled !== "disabled") { ?>
  <p class="meta-options seo_pyramid_field">
    <label for="seo_pyramid_description"><i class="material-icons">description</i>
      <?php _e( 'Page Description', 'seo-pyramid' ); ?>
      <em>
      <?php _e( '160 Characters recommended', 'seo-pyramid' ); ?>
      </em></label>
    <input id="seo_pyramid_description"

            type="text"

            name="seo_pyramid_description" 

		    limit="160"

           value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'seo_pyramid_description', true ) ); ?>">
    <span class="seo-pyramid-check"><span class="dashicons dashicons-no"></span><span class="count" id="seo_pyramid_description">0</span>
    <?php _e( 'Characters', 'seo-pyramid' ); ?>
    <span class="warning">:
    <?php _e( 'You have exceeded the recommended character length', 'seo-pyramid' ); ?>
    </span></span> </p>
  <?php

  }

  if ( !empty( $seo_pyramid_options[ 'redirect_4' ] ) ) {

    $seo_pyramid_redirect = esc_attr( get_post_meta( get_the_ID(), 'seo_pyramid_redirect', true ) );

    $seo_pyramid_redirect_switch = esc_attr( get_post_meta( get_the_ID(), 'seo_pyramid_redirect_switch', true ) );

    ?>
  <p class="meta-options seo_pyramid_field">
    <label for="seo_pyramid_redirect"><span class="dashicons dashicons-redo"></span>
      <?php _e( 'Temporary Redirect', 'seo-pyramid' ); ?>
      <em>
      <?php _e( 'Redirect current page to another location', 'seo-pyramid' ); ?>
      </em> </label>
    <input id="seo_pyramid_redirect"

            type="text"

            name="seo_pyramid_redirect" 

		    limit="60"

           value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'seo_pyramid_redirect', true ) ); ?>">
	  <input type="text" value="<?php _e( 'End Date', 'seo-pyramid' ); ?>" id="date-label" disabled>
    <input id="seo_pyramid_redirect_date"

            type="date"

            name="seo_pyramid_redirect_date" 

            value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'seo_pyramid_redirect_date', true ) ); ?>">
    <select name="seo_pyramid_redirect_switch" id="seo_pyramid_redirect_switch">
      <option value="Inactive" <?php if($seo_pyramid_redirect_switch === 'Inactive') { echo 'selected'; }?>>
      <?php _e( 'Inactive', 'seo-pyramid' ); ?>
      </option>
      <option value="Active"  <?php if($seo_pyramid_redirect_switch === 'Active') { echo 'selected'; }?>>
      <?php _e( 'Active', 'seo-pyramid' ); ?>
      </option>
    </select>
    <span class="dir-parent seo-pyramid-check"><span class="dashicons dashicons-no"></span><span style="float: left!; width: auto;">
    <?php _e( 'Destination URL', 'seo-pyramid' ); ?>
    </span><span class="warning dir">:
    <?php _e( 'You have provided an invalid URL', 'seo-pyramid' ); ?>
    </span></span> </p>
  <?php } ?>
  <?php if(!empty($seo_pyramid_options['canonical_tag_3'])) { ?>
  <p class="meta-options seo_pyramid_field cano">
    <label for="seo_pyramid_canonical"><span class="dashicons dashicons dashicons-admin-links"></span>
      <?php _e( 'Canonical URL', 'seo-pyramid' ); ?>
    </label>
    <input id="seo_pyramid_canonical"

            type="text"

            name="seo_pyramid_canonical" 

           value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'seo_pyramid_canonical', true ) ); ?>">
    <span class="answer" text="canonical"><i class="material-icons"> arrow_left </i>
    <?php _e( 'What is Canonical URL?', 'seo-pyramid' ); ?>
    </span> <span class="can-parent seo-pyramid-check"><span class="dashicons dashicons-no"></span><span style="display: inline-block; width: auto;">
    <?php _e( 'Provide content URL', 'seo-pyramid' ); ?>
    </span><span class="warning can">:
    <?php _e( 'You have provided an invalid URL', 'seo-pyramid' ); ?>
    </span></span> </p>
  <?php } ?>
  
  <!-- Robots' Directives -->
  
  <?php if(!empty($seo_pyramid_options['robots_directive_2']) ){ ?>
  <p class="meta-options seo_pyramid_field">
    <label for="seo_pyramid_robots"><i class="material-icons">visibility</i>
      <?php _e( 'Robots Directive', 'seo-pyramid' ); ?>
    </label>
    <?php


    $robot_directive = esc_attr( get_post_meta( get_the_ID(), 'seo_pyramid_robots', true ) );

    ?>
    <select name="seo_pyramid_robots" id="seo_pyramid_robots">
      <option value="">
      <?php _e( 'Index this page', 'seo-pyramid' ); ?>
      </option>
      <option value="noindex, nofollow" <?php if($robot_directive === 'noindex, nofollow') { echo 'selected'; }?>>
      <?php _e( 'No Index, No Follow', 'seo-pyramid' ); ?>
      </option>
      <option value="noimageindex" <?php if($robot_directive === 'noimageindex') { echo 'selected'; }?>>
      <?php _e( 'No Image Index', 'seo-pyramid' ); ?>
      </option>
    </select>
    <span class="answer" text="robots"><i class="material-icons"> arrow_left </i>
    <?php _e( 'What is Robots Directives?', 'seo-pyramid' ); ?>
    </span> </p>
  <?php } ?>
  
  <!-- Sitemap Settings -->
  
  <?php if((!empty($seo_pyramid_sitemap_options['change_frequency_0'])) || (!empty($seo_pyramid_sitemap_options['page_priority_1']))) { ?>
  <p class="meta-options seo_pyramid_field"> 
    
    <!-- Change Frequency -->
    
    <label for="seo_pyramid_change_frequency"><i class="material-icons">account_tree</i>
      <?php _e( 'Sitemap Attributes', 'seo-pyramid' ); ?>
    </label>
    <?php


    if ( ( !empty( $seo_pyramid_sitemap_options[ 'change_frequency_0' ] ) ) ) {

      $seo_pyramid_change_frequency = esc_attr( get_post_meta( get_the_ID(), 'seo_pyramid_change_frequency', true ) );
      ?>
    <select name="seo_pyramid_change_frequency" id="seo_pyramid_change_frequency">
      <option value="">Change Frequency</option>
      <option value="Always"  <?php if($seo_pyramid_change_frequency === 'Always') { echo 'selected'; }?>>Always</option>
      <option value="Hourly"  <?php if($seo_pyramid_change_frequency === 'Hourly') { echo 'selected'; }?>>Hourly</option>
      <option value="Daily"   <?php if($seo_pyramid_change_frequency === 'Daily') { echo 'selected'; }?>>Daily</option>
      <option value="Weekly"  <?php if($seo_pyramid_change_frequency === 'Weekly') { echo 'selected'; }?>>Weekly</option>
      <option value="Monthly" <?php if($seo_pyramid_change_frequency === 'Monthly') { echo 'selected'; }?>>Monthly</option>
      <option value="Yearly"  <?php if($seo_pyramid_change_frequency === 'Yearly') { echo 'selected'; }?>>Yearly</option>
      <option value="Never"   <?php if($seo_pyramid_change_frequency === 'Never') { echo 'selected'; }?>>Never</option>
    </select>
    <?php } ?>
    
    <!-- Page Priority -->
    
    <?php

    if ( !empty( $seo_pyramid_sitemap_options[ 'page_priority_1' ] ) ) {

      $seo_pyramid_page_priority = esc_attr( get_post_meta( get_the_ID(), 'seo_pyramid_page_priority', true ) );
      ?>
    <select name="seo_pyramid_page_priority" id="seo_pyramid_page_priority">
      <option value="">
      <?php _e( 'URL Priority', 'seo-pyramid' ); ?>
      </option>
      <option value="0.0" <?php if($seo_pyramid_page_priority === '0.0') { echo 'selected'; }?>>0.0</option>
      <option value="0.1" <?php if($seo_pyramid_page_priority === '0.1') { echo 'selected'; }?>>0.1</option>
      <option value="0.2" <?php if($seo_pyramid_page_priority === '0.2') { echo 'selected'; }?>>0.2</option>
      <option value="0.3" <?php if($seo_pyramid_page_priority === '0.3') { echo 'selected'; }?>>0.3</option>
      <option value="0.4" <?php if($seo_pyramid_page_priority === '0.4') { echo 'selected'; }?>>0.4</option>
      <option value="0.5" <?php if($seo_pyramid_page_priority === '0.5') { echo 'selected'; }?>>0.5</option>
      <option value="0.6" <?php if($seo_pyramid_page_priority === '0.6') { echo 'selected'; }?>>0.6</option>
      <option value="0.7" <?php if($seo_pyramid_page_priority === '0.7') { echo 'selected'; }?>>0.7</option>
      <option value="0.8" <?php if($seo_pyramid_page_priority === '0.8') { echo 'selected'; }?>>0.8</option>
      <option value="0.9" <?php if($seo_pyramid_page_priority === '0.9') { echo 'selected'; }?>>0.9</option>
      <option value="1.0" <?php if($seo_pyramid_page_priority === '1.0') { echo 'selected'; }?>>1.0</option>
    </select>
    <?php } ?>
  </p>
  <?php } } ?>
  <input id="seo_pyramid_status"

            type="hidden"

            name="seo_pyramid_status" 

		    limit="60"

           value="<?php echo esc_attr( get_post_meta( get_the_ID(), 'seo_pyramid_status', true ) ); ?>">
</div>