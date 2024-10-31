// JavaScript Document


jQuery(document).ready(function () {


  "use strict";


  // Check user entry character lenght when document is ready, whenever neccessary


  jQuery("input").each(function () {


    var currId = "#" + jQuery(this).attr("id") + ".count";


    var contentLimit = jQuery(this).attr("limit");


    var entryLenght = jQuery(this).val().length;


    jQuery(currId).text(this.value.length + "/" + contentLimit);


    if (entryLenght > contentLimit) {


      jQuery(currId).parent("span").addClass("overLimit");


    } else {


      jQuery(currId).parent("span").removeClass("overLimit");


    }


  });


  // Check user entry character lenght whenever neccessary


  jQuery("input").on("keyup", function () {


    var currId = "#" + jQuery(this).attr("id") + ".count";


    var contentLimit = jQuery(this).attr("limit");


    var entryLenght = jQuery(this).val().length;


    jQuery(currId).text(this.value.length + "/" + contentLimit);


    if (entryLenght > contentLimit) {


      jQuery(currId).parent("span").addClass("overLimit");


      jQuery(currId).siblings(".dashicons-yes").removeClass("dashicons-yes").addClass("dashicons-no");


    } else {


      jQuery(currId).parent("span").removeClass("overLimit");


      jQuery(currId).siblings(".dashicons-no").removeClass("dashicons-no").addClass("dashicons-yes");


    }


  });


 // Preview snippet js	

  jQuery(".seo_pyramid_preview_nav i, .seo_pyramid_preview_nav .text").on("click", function () {

    // Count description character entry
    var pageDescText = jQuery("#seo_pyramid_description").val();
    var pageDesCharCount = pageDescText.length;

    jQuery(".seo_pyramid_preview_ul li:nth-of-type(1)").text(jQuery("#seo_pyramid_title").val());

    jQuery(".seo_pyramid_preview_ul li:nth-of-type(2)").text(window.location.origin);

    // Truncate if description entry is more than 160 characters
    if (pageDesCharCount > 160) {

      var charRem = pageDesCharCount - 160;
      jQuery(".seo_pyramid_preview_ul li:nth-of-type(3)").text(pageDescText.slice(0, -charRem) + ("..."));
    } else {
      jQuery(".seo_pyramid_preview_ul li:nth-of-type(3)").text(pageDescText);
    }

    // Close preview when close button is clicked
    jQuery(".seo_pyramid_preview_snippet, #seo_pyramid").addClass("show_seo_ps");


  });


  jQuery(".close_seo_pyramid_preview").click(function () {

    jQuery(".seo_pyramid_preview_snippet, #seo_pyramid").removeClass("show_seo_ps");

  });

// [](http://coderisk.com/wp/plugin/seo-pyramid/RIPS-5BJZfUM8v4)

});