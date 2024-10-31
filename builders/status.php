<?php
// Start analyze function
    
$imgWalt = $_GET["imgWalt"] = $_GET["contentImagesTotal"] = $_GET["imagesWithoutAltTag"] = "";

    $newTitle = get_post_meta( get_the_ID(), 'seo_pyramid_title', true ) .  " - " . get_bloginfo( "name" );

    $newdesc = get_post_meta( get_the_ID(), 'seo_pyramid_description', true );

    $pageContent = get_the_content();

    $robots = get_post_meta( get_the_ID(), 'seo_pyramid_robots', true );

    $image_total = $_GET["contentImagesTotal"]; 

    $image_without_alt = $_GET["imagesWithoutAltTag"]; 
        
    $imgWalt = $_GET["imgWalt"];

// Define all variables

$descContent = $descReporrtDesc = $descReport = $titleReport = $titleReporrtDesc = $index_or_not = $index_or_not_desc = $titleReport = $titleReportDesc = $titleCharLength = $wordDiff = $alignmentReport = $alignmentReportDesc = $img_check_report_des = $image_alt_report_desc = $imageAltClass = "";

// Define title meta tag content

$titleContent = $newTitle;

$titleCharLength = strlen( $titleContent );

$searchWords = explode( ' ', $titleContent );
    
$wordsFoundInTitle = []; // Create words an array

    //Find title in title;

foreach ( $searchWords as $tword ) {

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

foreach ( $searchWords as $word ) {

  if ( stripos( $descContent, $word ) !== false ) {

    $wordsFoundInDesc[ $word ] = true;

  }

}
 

// Define main page content

$page_content = $pageContent;

$wordsFoundInPC = []; // Create words an array

   //Find title in page content

foreach ( $searchWords as $word  ) {

  if ( stripos( $page_content, $word  ) !== false ) {

    $wordsFoundInPC[ $word ] = true;

  }

}


// Count title meta tag word length

$foundInTitleWordLenght = str_word_count( implode( ", ", array_keys( $wordsFoundInDesc ) ) );

// Count description meta tag word length

$titleContentWordLenght = str_word_count( implode( ", ", array_keys( $wordsFoundInTitle ) ) );

// Count description meta tag word length

$foundInContentWordLenght = str_word_count( implode( ", ", array_keys( $wordsFoundInPC ) ) );

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

 
// Conditional statements for title and main content alignment percentatge   

if ( $pcWordDiff < 1 ) {

 $contentAlignmentReport = __("Your title tag and page content alignment is at " . "<strong>" . $pcWordDiff . "%</strong>", "seo-pyramid"); 

 $contentAlignmentReportDesc = __("Your title and page page content are not aligned, which is not good. Important words in your title should be included in the main content.", "seo-pyramid");  

 $pcWordDiffClass = "bad";
  

} elseif ( $pcWordDiff < 75 && $pcWordDiff > 70 ) {

 $contentAlignmentReport = __("Your title tag and main content alignment is at " . "<strong>" . $pcWordDiff . "%</strong>", "seo-pyramid"); 

 $contentAlignmentReportDesc = __("Your page content contains " . implode( ", ", array_keys( $wordsFoundInDesc ) ) . " which are in your title meta tag content. There may still be room for further optimization. Important words in your title should be included in the main content.", "seo-pyramid"); 

 $pcWordDiffClass = "half";   
    

} elseif ( $pcWordDiff >= 75) {

 $contentAlignmentReport = __("Great: Your title tag and page content alignment is at " . "<strong>" . $pcWordDiff . "%</strong>", "seo-pyramid"); 

 $contentAlignmentReportDesc = __("Your page content contains " . implode( ", ", array_keys( $wordsFoundInDesc ) ) . " which are in your title meta tag content. Great Job!", "seo-pyramid"); 

 $pcWordDiffClass = "good";   
   

} else {

 $contentAlignmentReport = __("Your title tag and page content alignment is at " . "<strong>" . $pcWordDiff . "%</strong>", "seo-pyramid"); 

 $contentAlignmentReportDesc = __("Your title meta tag and main content are not aligned. Important words in your title should be included in the main content.", "seo-pyramid"); 

 $pcWordDiffClass = "bad";  

}


// Conditional statements for title and description alignment percentatge

if ( $wordDiff < 1 ) {

  $alignmentReport = __("Your title and description meta tags content alignment is at " . "<strong>" . $wordDiff . "%</strong>", "seo-pyramid");

  $alignmentReportDesc = __("Your description and title meta tag content are not aligned, which is not good. Important words in your title should be included in the description that you have provided.", "seo-pyramid");

  $wordDiffClass = "bad";



} elseif ( $wordDiff < 75 && $wordDiff > 70 ) {

  $alignmentReport = __("Your title and description meta tags content alignment is at " . "<strong>" . $wordDiff . "%</strong>", "seo-pyramid");

  $alignmentReportDesc = __("Your description meta tag content contains " . implode( ", ", array_keys( $wordsFoundInDesc ) ) . " which are in your title meta tag content. There may still be room for further optimization.", "seo-pyramid");

  $wordDiffClass = "half";


} elseif ( $wordDiff >= 75 ) {

  $alignmentReport = __("Your title and description meta tags content alignment is at " . "<strong>" . $wordDiff . "%</strong>", "seo-pyramid");

  $alignmentReportDesc = __("Your description meta tag content contains " . implode( ",", array_keys( $wordsFoundInDesc ) ) . " which are in your title meta tag content. Great Job!", "seo-pyramid");

  $wordDiffClass = "good";

} else {

  $alignmentReport = __("Your title and description meta tags content alignment is at " . "<strong>" . $wordDiff . "%</strong>", "seo-pyramid");

  $alignmentReportDesc = __("Your description and title meta tag content are not well aligned. There may still be room for further optimization. Important words in your title should be included in the description that you have provided.", "seo-pyramid");

  $wordDiffClass = "bad";

}


// Conditional statements for description character length      

if ( $descCharLength < 161 && $descCharLength !== 0 ) {

  $descReport = __("Perfect: your description meta tag content is within the recommended character length", "seo-pyramid");

  $descReporrtDesc = __("Your description meta tag content contains " . "<strong>$descCharLength</strong> " . " characters and will not be truncated", "seo-pyramid");

  $descCharLengthClass = "good";


} elseif ( $descCharLength > 160 ) {


  $descReport = __("Warning: Your description meta tag content exceeds the recommended character length", "seo-pyramid");

  $descReporrtDesc = __("Your description meta tag content contains " . "<strong>$descCharLength</strong> " . " characters and will be truncated as shown in the SERP snippet", "seo-pyramid");

  $descCharLengthClass = "bad";


} else {

  $descReport = __("Warning: your have not provided a description for your page", "seo-pyramid");

  $descReporrtDesc = __("Descripption is an essential part search engine optimization. It provides a brief explanation about the content of your website on search engine result page.", "seo-pyramid");

  $descCharLengthClass = "bad";

}


// Conditional statements for title character length

if ( $titleCharLength < 61 && $titleCharLength !== 0 ) {

  $titleReport = __("Perfect: your title meta tag content is within the recommended character length", "seo-pyramid");

  $titleReporrtDesc = __("Your title meta tag content contains " . "<strong>$titleCharLength</strong> " . " characters and will not be truncated", "seo-pyramid");

  $titleCharLengthClass = "good";

} elseif ( $titleCharLength > 60 ) {


  $titleCharLengthClass = "bad";

  $titleReport = __("Warning: your title meta tag content exceeds the recommended character length", "seo-pyramid");

  $titleReporrtDesc = __("Your description meta tag content contains " . "<strong>$titleCharLength</strong> " . " characters and will be truncated as shown in the SERP snippet", "seo-pyramid");

} else {

  $titleCharLengthClass = "bad";

  $titleReport = __("Warning: You have not provided a title for your page", "seo-pyramid");

  $titleReporrtDesc = __("Web page title is an essential part of search engine optimization. It headlines the description of your page on search engine result pages", "seo-pyramid");

}

// Conditional statements for robots directives 

if ( $indexOrNot === "noindex, nofollow" ) {

  $index_or_not = __("Warning: Search engines may not index this page/post", "seo-pyramid");

  $index_or_not_desc = __("Search engines may not index this page because the Robots Directives metat tag value is set to <strong>[noindex, nofollow] </strong> And, it will not be inlcuded in your sitemap.", "seo-pyramid");

  $indexOrNotClass = "bad";


} else {

  $index_or_not = __("Great: You are not blocking search engines from this page/post", "seo-pyramid");

  $index_or_not_desc = __("Search engines may index this page because the Robots Directives metat tag value is not set to <strong>[noindex, nofollow]</strong>", "seo-pyramid");

  $indexOrNotClass = "good";

}

    // Conditional statements for image analysis

if ($image_total > 0 && $image_without_alt > 0 ) {

$img_check_report = __("Opse: $image_without_alt of $image_total images on this page do not have alt tags", "seo-pyramid");

$img_check_report_desc = __("All the images in your posts or pages should have alternative text. The alternative text describes the image and show if the image cannot be displayed. Go to the WordPress media gallery, click on each image to add alt text.", "seo-pyramid");

$imageAltClass = "bad";

} elseif ($image_total > 0 && $image_without_alt === '0' ) {

 $img_check_report = __("Perfect: $image_total of $image_total images on this page have alt tags", "seo-pyramid");

$img_check_report_desc = __("All the images in your posts have alternative text. This can improve your page ranking", "seo-pyramid");

$imageAltClass = "good";   
   

} else {
  

$img_check_report = __("Okay: Your content does not contain images", "seo-pyramid");

$img_check_report_desc = __("There are no images on this page to analyse", "seo-pyramid");

}