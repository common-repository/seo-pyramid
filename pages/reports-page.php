<?php

class SEOPyramidReportPage {
  private $seo_pyramid_report_page_options;

  public function __construct() {
    add_action( 'admin_menu', array( $this, 'seo_pyramid_report_page_add_plugin_page' ) );
    add_action( 'admin_init', array( $this, 'seo_pyramid_report_page_page_init' ) );
  }

  public function seo_pyramid_report_page_add_plugin_page() {
    add_options_page(
      'SEO Pyramid Report Page', // page_title
      'SEO Pyramid Report Page', // menu_title
      'manage_options', // capability
      'seo-pyramid-report-page', // menu_slug
      array( $this, 'seo_pyramid_report_page_create_admin_page' ) // function
    );
  }

  public function seo_pyramid_report_page_create_admin_page() {
    $this->seo_pyramid_report_page_options = get_option( 'seo_pyramid_report_page_option_name' );
    $seo_pyramid_path = plugin_dir_path( __DIR__ ) . '/parts';
    ?>
<div id="seo_pyramid_settings_form" class="rp">
  <h2 class="seo_pyramid_settings_title">SEO Pyramid</h2>
 <?php include($seo_pyramid_path . "/settings-navigation.php"); ?>
  <form method="post" action="options.php">
    <?php
    settings_fields( 'seo_pyramid_report_page_option_group' );
    do_settings_sections( 'seo-pyramid-report-page-admin' );
    ?>
  </form>
</div>
<?php
}

public function seo_pyramid_report_page_page_init() {
  add_settings_section(
    'seo_pyramid_report_page_setting_section', // id
    __('Page Reports', 'seo-pyramid'), // title
    array( $this, 'seo_pyramid_report_page_section_info' ), // callback
    'seo-pyramid-report-page-admin' // page
  );

  add_settings_field(
    'reports_0', // id
    'reports', // title
    array( $this, 'reports_0_callback' ), // callback
    'seo-pyramid-report-page-admin', // page
    'seo_pyramid_report_page_setting_section' // section
  );
}


public function seo_pyramid_report_page_section_info() {
// If you remove this plugin, the plugin will break
}

public function reports_0_callback() {

  $args = array( 'post_type' => array( 'page', 'post' ), 'post_status' => 'publish', 'posts_per_page' => -1, 'update_post_meta_cache' => 'false' );

  $wpb_all_query = new\ WP_Query( $args );

  echo '<table width="100%" border="1" class="seo-pyramid-table">
  <tbody><tr><th scope="col">';
  _e('Page Name', 'seo-pyramid');
  echo '</th><th scope="col">';
  _e('URL Format', 'seo-pyramid');
  echo '</th><th scope="col">';
  _e('Title Alignment', 'seo-pyramid');
  echo '</th><th scope="col">';
  _e('Content Alignment', 'seo-pyramid');
  echo '</th><th scope="col">';
  _e('Title Length', 'seo-pyramid');
  echo '</th><th scope="col">';
  _e('Description Lenth', 'seo-pyramid');
  echo '</th><th scope="col">';
  _e('Robots Directive', 'seo-pyramid');
  echo '</th><th scope="col">';
  _e('SEO Score', 'seo-pyramid');
  echo '</th></tr>';
  if ( $wpb_all_query->have_posts() ):


    while ( $wpb_all_query->have_posts() ): $wpb_all_query->the_post();

  global $post;
    

 // Start analyze function
    
  $seo_pyramid_path = plugin_dir_path( __DIR__ ) . '/builders';

  include($seo_pyramid_path . "/shared-analyzer.php");

  echo '<tr>
      <th scope="row">' . get_the_title() . '</th>
      <td class="' . $urlWordDiffClass . '">'. $urlAlignmentReportDesc . '</td>
      <td class="' . $wordDiffClass . '">' . $alignmentReportDesc . '</td>
      <td class="' . $pcWordDiffClass . '">'. $contentAlignmentReportDesc . '</td>
      <td class="' . $titleCharLengthClass . '">' . $titleReporrtDesc . '</td>
      <td class="' . $descCharLengthClass . '">' . $descReporrtDesc . '</td>
      <td class="' . $indexOrNotClass . '">' . $index_or_not_desc . '</td>';
    
     // Check the occurrence of good classes
     $totalClasses = substr_count("$urlWordDiffClass .  '' . $wordDiffClass . ' ' . $pcWordDiffClass . ' ' . $titleCharLengthClass . ' ' . $descCharLengthClass . ' ' . $indexOrNotClass", "good");

     echo  '<td class="' . $totalClasses . '">';
   
    ?>

<div class="circleChart" id="0"></div>

<script>
    
    jQuery("[id$=0]").each(function () {

        jQuery(this).circleChart({
            size: 100,
            value: jQuery(this).parent("td").attr("class")/6 * 100,
            text: 79,
            onDraw: function(el, circle) {
                circle.text(Math.round(circle.value) + "%");
            }
        });
        setInterval(function() {
            jQuery(this).circleChart({
                value: Math.random() * 100
            });
        }, 4000);
        
        });
    </script>

<?php
    
   echo  '</td>
    </tr>';
  
  endwhile;
  wp_reset_query();

  else :

    _e( 'Sorry, no posts matched your criteria.' );

  endif;

  echo "</tbody></table>";

}

}

if ( is_admin() )
  $seo_pyramid_report_page = new SEOPyramidReportPage();
  function remove_report_link() {
  remove_submenu_page( 'options-general.php', 'seo-pyramid-report-page' );
}
add_action( 'admin_menu', 'remove_report_link', 9999 );