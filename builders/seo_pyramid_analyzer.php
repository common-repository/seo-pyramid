<?php
// Load necessary file
$parse_uri = explode( 'wp-content', $_SERVER[ 'SCRIPT_FILENAME' ] );

require_once( $parse_uri[ 0 ] . 'wp-load.php' );

?>
<h2 class="meta-analysis">
  <?php _e( 'Content Analysis', 'seo-pyramid' ); ?>
</h2>
<?php

// Start analyze function and Classes

class seo_pyramid_analyze_function {

  public function __construct() {

    $this->seo_pyramid_analyze();
  }

  private function seo_pyramid_analyze() {

    $imgWalt;

    if ( isset( $_GET[ "analyzer" ] ) ) {

      $newTitle = $_GET[ "title" ];

      $newdesc = $_GET[ "desc" ];

      $pageContent = $_GET[ "pageContent" ];

      if(isset($_GET[ "robots" ])) {
      
		$robots = $_GET[ "robots" ];
	  }

      $image_total = $_GET[ "contentImagesTotal" ];

      $image_without_alt = $_GET[ "imagesWithoutAltTag" ];

      $currPageSlug = $_GET[ "currPageSlug" ];
		
	  $langFilter = $_GET["langFilter"];
		
	  $allContent = $newTitle . " " . $newdesc . " " . $pageContent;
		


      // Do something with it only if it is not empty
      if ( !empty( $_GET[ "imgWalt" ] ) ):
        $imgWalt = $_GET[ "imgWalt" ];
        endif;


      // Define all variables

      $descContent = $descReporrtDesc = $descReport = $titleReport = $titleReporrtDesc = $index_or_not = $index_or_not_desc = $titleReport = $titleReportDesc = $titleCharLength = $wordDiff = $alignmentReport = $alignmentReportDesc = $img_check_report_des = $image_alt_report_desc = $imageAltClass = $status = $robotsStatus = $tdStatus = $urlWords = $urlWord = $urlWordsFoundInTitle = $urlWordFoundInTitleLenght = $urlWordDiff = $urlAlignmentReport = $urlAlignmentReportDesc = $urlWordDiffClass = $titlecChar = $wordsFoundInProfaneList = $profaneReport = $profaneWords = $profanity_list = $profaneReportDesc = $profaneClass = $profaneReport = $profaneCheck = $robots = $imageAlt = "";


      // Define title meta tag content

      $titleContent = $newTitle;

      $titleCharLength = strlen( $titleContent );

      $titleWords = explode( ' ', $titleContent );

      $wordsFoundInTitle = []; // Create words an array

      //Find title in title;

      foreach ( $titleWords as $tword ) {

        if ( stripos( $titleContent, $tword ) !== false ) {

          $wordsFoundInTitle[ $tword ] = true;

        }

      }


      // Define description meta tag content

      $descContent = $newdesc;

      $descCharLength = strlen( $descContent );

      $wordsFoundInDesc = []; // Create words an array

      $indexOrNot = $robots;


      //Find title in description ;

      foreach ( $titleWords as $word ) {

        if ( stripos( $descContent, $word ) !== false ) {

          $wordsFoundInDesc[ $word ] = true;

        }

      }


      // Define main page content

      $page_content = $pageContent;

      $wordsFoundInPC = []; // Create words an array
        

      //Find title in page content

      foreach ( $titleWords as $word ) {

        if ( stripos( $page_content, $word ) !== false ) {

          $wordsFoundInPC[ $word ] = true;

        }

      }


      // Define URL words composition

      $urlWords = $currPageSlug;
      $urlWords = explode( ' ', $currPageSlug );
      $urlWordsFoundInTitle = []; // Create words an array


      //Find URL words in title;

      foreach ( $urlWords as $urlWord ) {

        if ( stripos( $titleContent, $urlWord ) !== false ) {

          $urlWordsFoundInTitle[ $urlWord ] = true;

        }

      }
		
		
	// Profanity check	

	$profanity_list = file_get_contents(plugin_dir_url( __FILE__ ) . "/forbidden-languages.php");
		
	 $allContent  = preg_replace('/[^\w]+/', ' ', $allContent);
		

     $profaneWords = explode( ' ', strtolower($profanity_list));
		
	 $allContent = explode( ' ', strtolower($allContent));

      //Find title in title;
      $profaneCheck = array_intersect($allContent, $profaneWords);
		
	// echo implode(' ', $allContent);

      // Count title meta tag word length

      $foundInTitleWordLenght = str_word_count( implode( ", ", array_keys( $wordsFoundInDesc ) ) );

      // Count description meta tag word length

      $titleContentWordLenght = str_word_count( implode( ", ", array_keys( $wordsFoundInTitle ) ) );

      // Count description meta tag word length

      $foundInContentWordLenght = str_word_count( implode( ", ", array_keys( $wordsFoundInPC ) ) );


      // Count URL word length

      $urlWordFoundInTitleLenght = str_word_count( implode( ", ", array_keys( $urlWordsFoundInTitle ) ) );


      // Calculate alignment percentage of title and description only if wordlength doesn't equal zero

      if ( $titleContentWordLenght !== 0 ) {

        $wordDiff = round( ( $foundInTitleWordLenght / $titleContentWordLenght * 100 ) );

      } else {

        $wordDiff = 0;

      }


      // Calculate alignment percentage of title and page content only if wordlength doesn't equal zero

      if ( $foundInContentWordLenght !== 0 ) {

        $pcWordDiff = round( ( $foundInContentWordLenght / $titleContentWordLenght * 100 ) );

      } else {

        $pcWordDiff = 0;

      }


      // Calculate alignment percentage of URL and title  only if wordlength doesn't equal zero

      if ( $urlWordFoundInTitleLenght !== 0 ) {

        $urlWordDiff = round( ( $urlWordFoundInTitleLenght / $titleContentWordLenght * 100 ) );

      } else {

        $urlWordDiff = 0;

      }
		
		
	  // Calculate how many bad words found in content

     if (!empty($profaneCheck)) {
        $profaneReport = __("Warning: There are " . "<strong>" . count($profaneCheck) . "</strong>" . " possible profanity word(s) in your content");
		$profaneReportDesc = __("Your content contains profanity words such as " . "<strong>" . implode( ", ", array_unique($profaneCheck)) . "</strong>. Please check your content.");
		$profaneClass = "bad";
        
      } else {

       $profaneReport = __("Great: Your content contains no profanity!");
	   $profaneReportDesc = __("Good: No profanity was found in your content");
	   $profaneClass = "good";

      }

      // Conditional statements for URL and title alignment percentatge 
      if ( $urlWordDiff < 1 ) {

        $urlAlignmentReport = __( "The page URL and title alignment is at " . "<strong>" . $urlWordDiff . "%</strong>", "seo-pyramid" );

        $urlAlignmentReportDesc = __( "The page URL and page title are not aligned, which is not good. This issue may be as a result of your permalink structure setting. Important words in your page title should always be included in the URL. <br>
Example: If your post's name/title is <em>My Post,</em>
your URL should be <em>www.your-site.com/my-post</em>", "seo-pyramid" );

        $urlWordDiffClass = "bad";

      } else {

        $urlAlignmentReport = __( "Perfect: Your page URL and title alignment is at " . "<strong>" . $urlWordDiff . "%</strong>", "seo-pyramid" );

        $urlAlignmentReportDesc = __( "The page URL and title are well aligned, which is great. Important words in your page title should always be included in the URL.", "seo-pyramid" );

        $urlWordDiffClass = "good";

      }


      // Conditional statements for title and main content alignment percentatge   

      if ( $pcWordDiff < 1 ) {

        $contentAlignmentReport = __( "Your title tag and page content alignment is at " . "<strong>" . $pcWordDiff . "%</strong>", "seo-pyramid" );

        $contentAlignmentReportDesc = __( "Your title and page content are not aligned, which is not good. Important words in your title should be included in the main content.", "seo-pyramid" );

        $pcWordDiffClass = "bad";


      } elseif ( $pcWordDiff < 75 && $pcWordDiff > 70 ) {

        $contentAlignmentReport = __( "Your title tag and main content alignment is at " . "<strong>" . $pcWordDiff . "%</strong>", "seo-pyramid" );

        $contentAlignmentReportDesc = __( "Your page content contains " . implode( ", ", array_keys( $wordsFoundInDesc ) ) . " which are in your title meta tag content. There may still be room for further optimization. Important words in your title should be included in the main content.", "seo-pyramid" );

        $pcWordDiffClass = "half";

        $status = "half";


      } elseif ( $pcWordDiff >= 75 ) {

        $contentAlignmentReport = __( "Great: Your title tag and page content alignment is at " . "<strong>" . $pcWordDiff . "%</strong>", "seo-pyramid" );

        $contentAlignmentReportDesc = __( "Your page content contains " . implode( ", ", array_keys( $wordsFoundInDesc ) ) . " which are in your title meta tag content. Great Job!", "seo-pyramid" );

        $pcWordDiffClass = "good";

        $status = "good";


      } else {

        $contentAlignmentReport = __( "Your title tag and page content alignment is at " . "<strong>" . $pcWordDiff . "%</strong>", "seo-pyramid" );

        $contentAlignmentReportDesc = __( "Your title meta tag and main content are not aligned. Important words in your title should be included in the main content.", "seo-pyramid" );

        $pcWordDiffClass = "bad";

      }


      // Conditional statements for title and description alignment percentatge

      if ( $wordDiff < 1 ) {

        $alignmentReport = __( "Your title and description meta tags content alignment is at " . "<strong>" . $wordDiff . "%</strong>", "seo-pyramid" );

        $alignmentReportDesc = __( "Your description and title meta tag content are not aligned, which is not good. Important words in your title should be included in the description that you have provided.", "seo-pyramid" );

        $wordDiffClass = "bad";


      } elseif ( $wordDiff < 75 && $wordDiff > 70 ) {

        $alignmentReport = __( "Your title and description meta tags content alignment is at " . "<strong>" . $wordDiff . "%</strong>", "seo-pyramid" );

        $alignmentReportDesc = __( "Your description meta tag content contains " . implode( ", ", array_keys( $wordsFoundInDesc ) ) . " which are in your title meta tag content. There may still be room for further optimization.", "seo-pyramid" );

        $wordDiffClass = "half";
        $tdStatus = "half";


      } elseif ( $wordDiff >= 75 ) {

        $alignmentReport = __( "Your title and description meta tags content alignment is at " . "<strong>" . $wordDiff . "%</strong>", "seo-pyramid" );

        $alignmentReportDesc = __( "Your description meta tag content contains " . implode( ",", array_keys( $wordsFoundInDesc ) ) . " which are in your title meta tag content. Great Job!", "seo-pyramid" );

        $wordDiffClass = "good";
        $tdStatus = "good";

      } else {

        $alignmentReport = __( "Your title and description meta tags content alignment is at " . "<strong>" . $wordDiff . "%</strong>", "seo-pyramid" );

        $alignmentReportDesc = __( "Your description and title meta tag content are not well aligned. There may still be room for further optimization. Important words in your title should be included in the description that you have provided.", "seo-pyramid" );

        $wordDiffClass = "bad";

      }


      // Conditional statements for description character length      

      if ( $descCharLength < 161 && $descCharLength !== 0 ) {

        $descReport = __( "Perfect: your description meta tag content is within the recommended character length", "seo-pyramid" );

        $descReporrtDesc = __( "Your description meta tag content contains " . "<strong>$descCharLength</strong> " . " characters and will not be truncated", "seo-pyramid" );

        $descCharLengthClass = "good";
        $descChar = "good";


      } elseif ( $descCharLength > 160 ) {


        $descReport = __( "Warning: Your description meta tag content exceeds the recommended character length", "seo-pyramid" );

        $descReporrtDesc = __( "Your description meta tag content contains " . "<strong>$descCharLength</strong> " . " characters and will be truncated as shown in the SERP snippet", "seo-pyramid" );

        $descCharLengthClass = "bad";


      } else {

        $descReport = __( "Warning: Your have not provided a description for your page", "seo-pyramid" );

        $descReporrtDesc = __( "Descripption is an essential part search engine optimization. It provides a brief explanation about the content of your website on search engine result page.", "seo-pyramid" );

        $descCharLengthClass = "bad";

      }


      // Conditional statements for title character length

      if ( $titleCharLength < 61 && $titleCharLength !== 0 ) {

        $titleReport = __( "Perfect: Your title meta tag content is within the recommended character length", "seo-pyramid" );

        $titleReporrtDesc = __( "Your title meta tag content contains " . "<strong>$titleCharLength</strong> " . " characters and will not be truncated", "seo-pyramid" );

        $titleCharLengthClass = "good";
        $titlecChar = "good";

      } elseif ( $titleCharLength > 60 ) {

        $titleCharLengthClass = "bad";

        $titleReport = __( "Warning: Your title meta tag content exceeds the recommended character length", "seo-pyramid" );

        $titleReporrtDesc = __( "Your title meta tag content contains " . "<strong>$titleCharLength</strong> " . " characters and will be truncated as shown in the SERP snippet", "seo-pyramid" );

      } else {

        $titleCharLengthClass = "bad";

        $titleReport = __( "Warning: You have not provided a title for your page", "seo-pyramid" );

        $titleReporrtDesc = __( "Web page title is an essential part of search engine optimization. It headlines the description of your page on search engine result pages", "seo-pyramid" );

      }

      // Conditional statements for robots directives 

      if ( $indexOrNot === "noindex, nofollow" ) {

        $index_or_not = __( "Warning: Search engines may not index this page/post", "seo-pyramid" );

        $index_or_not_desc = __( "Search engines may not index this page because the Robots Directives metat tag value is set to <strong>[noindex, nofollow] </strong> And, it will not be inlcuded in your sitemap.", "seo-pyramid" );

        $indexOrNotClass = "bad";


      } else {

        $index_or_not = __( "Great: You are not blocking search engines from this page/post", "seo-pyramid" );

        $index_or_not_desc = __( "Search engines may index this page because the Robots Directives metat tag value is not set to <strong>[noindex, nofollow]</strong>", "seo-pyramid" );

        $indexOrNotClass = "good";
        $robotsStatus = "good";

      }

      // Conditional statements for image analysis

      if ( $image_total > 0 && $image_without_alt > 0 ) {

        $img_check_report = __( "Opse: $image_without_alt of $image_total images on this page do not have alt tags", "seo-pyramid" );

        $img_check_report_desc = __( "All the images in your posts or pages should have alternative text. The alternative text describes the image and show if the image cannot be displayed. Go to the WordPress media gallery, click on each image to add alt text.", "seo-pyramid" );

        $imageAltClass = "bad";

      } elseif ( $image_total > 0 && $image_without_alt === '0' ) {

        $img_check_report = __( "Perfect: $image_total of $image_total images on this page have alt tags", "seo-pyramid" );

        $img_check_report_desc = __( "All the images in your posts have alternative text. This can improve your page ranking", "seo-pyramid" );

        $imageAltClass = "good";
        $imageAlt = "good";


      } else {


        $img_check_report = __( "Okay: Your content does not contain images", "seo-pyramid" );

        $img_check_report_desc = __( "There are no images on this page to analyse", "seo-pyramid" );
        $imageAlt = "good";

      }

      // Set status

      if ( $status === "good" && $tdStatus === "good" && $descChar && $titlecChar === "good" && $robotsStatus === "good" && $imageAlt === "good" ) {

        $seo_pyramid_status = "all-good";

      } else {

        $seo_pyramid_status = "not-good";

      }

      ?>
<ul>
<?php

// DDo not show URL analysis on home page      
if ( $currPageSlug !== "do_not_analyze" ): ?>
<li class="<?php echo $urlWordDiffClass ?> expand"> <?php echo $urlAlignmentReport ?> <span> <?php echo $urlAlignmentReportDesc ?> </span></li>
<?php endif ?>
<li class="<?php echo $wordDiffClass;  if ( $currPageSlug === "do_not_analyze" ): echo " expand"; endif ?>"> <?php echo $alignmentReport ?> <span> <?php echo $alignmentReportDesc ?> </span></li>
<li class="<?php echo $pcWordDiffClass ?>"> <?php echo $contentAlignmentReport ?> <span> <?php echo $contentAlignmentReportDesc ?> </span> </li>
<li class="<?php echo $descCharLengthClass ?>"> <?php echo $descReport ?> <span> <?php echo $descReporrtDesc ?> </span> </li>
<li class="<?php echo $titleCharLengthClass ?>"> <?php echo $titleReport ?> <span> <?php echo $titleReporrtDesc ?> </span> </li>
<?php if(!empty($langFilter)) { ?>
<li class="<?php echo $profaneClass ?>"> <?php echo $profaneReport ?> <span> <?php echo $profaneReportDesc ?> </span> </li>
<?php } ?>	
<li class="<?php echo $indexOrNotClass ?>"> <?php echo $index_or_not ?> <span> <?php echo $index_or_not_desc ?> </span> </li>
<li class="<?php echo $imageAltClass ?>"> <?php echo $img_check_report ?> <span> <?php echo $img_check_report_desc ?>
<?php if($imageAltClass === "bad") { ?>
<div class="seo-pyramid-imgwalt">
<h5>
<?php _e( 'These images do not have alt text:', 'seo-pyramid' ); ?>
</h5>
<?php
foreach ( $imgWalt as $oneImage ) {
echo "<a>" . stripslashes( $oneImage ) . "</a>";
 }
 }
  ?>
  </ol>
  </span> </li>
<li class="seo-pyramid-status" style="display: none"><?php echo $seo_pyramid_status ?></li>
<ul>
<script>
    
    jQuery("#seo_pyramid_status").value(".seo-pyramid-status");
    
    </script>
</div>
<?php

}
}
}

$seo_pyramid_analyze = new seo_pyramid_analyze_function();

// End Page analyis functoin
