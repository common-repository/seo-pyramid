
<ul id="seo_pyramid_nav">
  <li class="<?php if($_GET["page"] === "seo-pyramid") { echo "active"; } ?>"><a href="<?php echo get_site_url(); ?>/wp-admin/options-general.php?page=seo-pyramid">
    <?php _e( 'General', 'seo-pyramid' ); ?>
    </a></li>
  <li class="<?php if($_GET["page"] === "seo-pyramid-sitemap") { echo "active"; } ?>"><a href="<?php echo get_site_url(); ?>/wp-admin/options-general.php?page=seo-pyramid-sitemap">
    <?php _e( 'Sitemap', 'seo-pyramid' ); ?>
    </a></li>
  <li class="<?php if($_GET["page"] === "seo-pyramid-schema-settings") { echo "active"; } ?>"><a href="<?php echo get_site_url(); ?>/wp-admin/options-general.php?page=seo-pyramid-schema-settings">
    <?php _e( 'Schema', 'seo-pyramid' ); ?>
    </a></li>
  <li class="<?php if($_GET["page"] === "seo-pyramid-og-and-tc") { echo "active"; } ?>"><a href="<?php echo get_site_url(); ?>/wp-admin/options-general.php?page=seo-pyramid-og-and-tc">
    <?php _e( 'Sharing', 'seo-pyramid' ); ?>
    </a></li>
  <li class="<?php if($_GET["page"] === "seo-pyramid-report-page") { echo "active"; } ?>"><a href="<?php echo get_site_url(); ?>/wp-admin/options-general.php?page=seo-pyramid-report-page">
    <?php _e( 'Reports', 'seo-pyramid' ); ?>
    </a></li>
  <style>	 
		 body {
		 background: #fff!important;	
		 }
		 
		 div#setting-error-settings_updated {
         margin-top: 20px;
         }
	 
	 </style>
</ul>
