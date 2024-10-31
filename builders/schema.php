<?php
class seo_pyramid_build_schema {
    
    public function __construct() {

      $this->sp_build_schema();

    }
      
public function sp_build_schema() {
$open_graph_image = $noOther = $jldFeaturedImage = "";    
global $post;
        
$seo_pyramid_schema_settings_options = get_option( 'seo_pyramid_schema_settings_option_name' );

// Check if page has featured image

if ( has_post_thumbnail() ) {
  $jldFeaturedImage = get_the_post_thumbnail_url();
} else {
  $facebookFeaturedImage = $open_graph_image;
}

// Get featured image dimensions
if ( empty( $jldFeaturedImage ) ) {} else {
  list( $width, $height, $type, $attr ) = getimagesize( $jldFeaturedImage );
}


// Define Business Logo
if(!empty($seo_pyramid_schema_settings_options['business_logo_2'])):

$business_logo = $seo_pyramid_schema_settings_options['business_logo_2'];

endif;


// Get Logo image dimensions
if ( empty($business_logo) ) {
  // Do nothing
} else {
  list( $lwidth, $lheight, $type, $attr ) = getimagesize($business_logo);
}

$permalink = get_permalink();
$homeUrl = home_url();
$contentType = $seo_pyramid_schema_settings_options['business_type_1'];
$social_media_presence =  trim($seo_pyramid_schema_settings_options['social_media_presence']);
$city = $seo_pyramid_schema_settings_options['city'];
$state = $seo_pyramid_schema_settings_options['state'];
$pcode = $seo_pyramid_schema_settings_options['pcode'];
$saddress = $seo_pyramid_schema_settings_options['saddress'];
$phone = $seo_pyramid_schema_settings_options['phone'];
$price = $seo_pyramid_schema_settings_options['price'];    
if($price === "") {
 $price = "$$";   
}
    
// Format social media pages
$social_media_presence = preg_split('/\s+/', $social_media_presence);	
$orgPages = '"' . implode( '", "',  $social_media_presence ) . '"';
    
// Define site name   
$site_name = get_bloginfo( 'name' );
    
// Define page description
if (!is_404()) {
$desc = get_post_meta( $post->ID, 'seo_pyramid_description', true );
}
echo

  '<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [';
       
  echo   '{"@type": "' . $contentType . '",
    "@id": "' . $homeUrl . '#' . $contentType . '",
    "name": "' . $site_name . '",
    "url": "' . $homeUrl . '",'; 
     if($noOther !== TRUE):
     echo '"sameAs": [' . $orgPages . '],'; 
     endif;
 
     echo '"logo": {
      "@type": "ImageObject",
      "@id": "' . $homeUrl . '#logo' . '",
      "inLanguage": "' . get_locale() . '",
      "url": "' . $business_logo . '",
      "width":' . $lwidth . ',
      "height":' . $lheight . ',
      "caption": "' . $site_name . '"
    },
    "image": {
       "@id": "' . $homeUrl . '#logo' . '"
    },'; 
  
 echo '"address": {
    "@type": "PostalAddress",
    "addressLocality":"' . $city . '",
    "addressRegion":"' . $state . '",
    "postalCode":"' . $pcode . '",
    "streetAddress": "' . $saddress . '"
    },';
    
     if($contentType === "LocalBusiness") {
     echo '"priceRange": "' . $price . '",';
     }
    
     echo '"telephone": "' . $phone . '"
   
  },';
     
   
 echo     '{
    "@type": "WebSite",
    "@id": "' . $homeUrl . '#' . 'website' . '",
    "url": "' . $homeUrl . '",
    "name": "' . $site_name . '",
    "inLanguage": "' . get_locale() . '",
    "description": "' . $desc . '",
    "publisher": {
    "@id": "' . $homeUrl . '#organization' . '"
    
   },
   
   "potentialAction": [{
      "@type": "SearchAction",
     "target": "' .  $homeUrl . '/?s={search_term_string}' . '",
      "query-input": "required name=search_term_string"
    }]
   },
   ';

// Echo only if featured image is set
if ( $jldFeaturedImage ) {
  echo
    ' {
    "@type": "ImageObject",
    "@id": "' . $homeUrl . '#primaryimage' . '",
    "inLanguage": "' . get_locale() . '",
    "url": "' . $jldFeaturedImage . '",
    "width":' . $width . ',
    "height":' . $height . '
  },';
}
echo ' {
    "@type": "WebPage", 
    "@id": "' . $permalink . '#webpage",
    "url": "' . $permalink . '",
    "inLanguage": "' . get_locale() . '",
    "name": "' . get_the_title() . '",
    "isPartOf": {
      "@id": "' . $homeUrl . '#' . 'website' . '"
    },';

// Echo only if featured image is set  
if ( $jldFeaturedImage ) {
  echo '  
    "primaryImageOfPage": {
      "@id": "' . $permalink . '#' . '#primaryimage' . '" 
    },';
}

echo '   
    "datePublished": "' . get_the_date() . '",
    "dateModified": "' . get_the_modified_date() . '",
    "description": "' . $desc . '"
    
  }
  
  ]
}
</script>';
              
    }
    
}

 $seo_pyramid_build_schema = new seo_pyramid_build_schema();
?>