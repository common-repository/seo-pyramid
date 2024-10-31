// JavaScript Document
jQuery(function () {

  "use strict";

  setTimeout(function () {
    // Prefil fields with default content if they are empty
    if (!jQuery('#seo_pyramid_title').val()) {
      jQuery("#seo_pyramid_title").val(jQuery("#post-title-0").val());
    }

    // Highlight over limit fields
    jQuery(".overLimit .dashicons-yes").removeClass("dashicons-yes").addClass("dashicons-no");

  }, 5);


  // Check user entry character lenght when document is ready, whenever neccessary 
  jQuery("input").each(function () {

    var currId = "#" + jQuery(this).attr("id") + ".count";

    var contentLimit = jQuery(this).attr("limit");

    var entryLenght = jQuery(this).val().length;

    var WordLenght = jQuery(this).val().split(' ').length;

    jQuery(currId).text(this.value.length + "/" + contentLimit);

    if (entryLenght > contentLimit) {

      jQuery(currId).parent("span").addClass("overLimit");


    } else {

      jQuery(currId).parent("span").removeClass("overLimit");

    }


    if (WordLenght > 1) {
      jQuery(currId).parent("span").addClass("notEmpty");
      jQuery(currId).siblings(".dashicons-no").removeClass("dashicons-no").addClass("dashicons-yes");
    } else {

      jQuery(currId).siblings(".dashicons-yes").removeClass("dashicons-yes").addClass("dashicons-no");
      jQuery(currId).parent("span").removeClass("notEmpty");

    }


  });


  // Check user entry character lenght whenever neccessary
  jQuery("input").bind("change keyup input", function () {

    var currId = "#" + jQuery(this).attr("id") + ".count";

    var contentLimit = jQuery(this).attr("limit");

    var entryLenght = jQuery(this).val().length;

    var WordLenght = jQuery(this).val().split(' ').length;

    jQuery(currId).text(this.value.length + "/" + contentLimit);


    if (WordLenght > 1) {
      jQuery(currId).parent("span").addClass("notEmpty");
      jQuery(currId).siblings(".dashicons-no").removeClass("dashicons-no").addClass("dashicons-yes");
    } else {

      jQuery(currId).siblings(".dashicons-yes").removeClass("dashicons-yes").addClass("dashicons-no");
      jQuery(currId).parent("span").removeClass("notEmpty");

    }


    if (entryLenght > contentLimit) {

      jQuery(currId).parent("span").addClass("overLimit");

      jQuery(currId).siblings(".dashicons-yes").removeClass("dashicons-yes").addClass("dashicons-no");


    } else {

      jQuery(currId).parent("span").removeClass("overLimit");

      jQuery(currId).siblings(".dashicons-no").removeClass("dashicons-no").addClass("dashicons-yes");

    }


  });


  // Preview snippet js	
  jQuery(".seo_pyramid_preview_nav .preview-trigger").on("click", function () {

    jQuery(".edit-post-visual-editor").delay(1500).hide();

    jQuery(".analysis").show();

    jQuery(".seo_pyramid_preview_snippet").addClass("show-serp-header");


    // Count description character entry
    var pageDescText = jQuery("#seo_pyramid_description").val();

    var pageDesCharCount = pageDescText.length;

    // Truncate if description entry is more than 160 characters

    if (pageDesCharCount > 160) {

      var descCharRem = pageDesCharCount - 160;

      jQuery(".seo_pyramid_preview_ul li:nth-of-type(3)").text(pageDescText.slice(0, -descCharRem) + ("..."));

    } else {


      if (pageDesCharCount > 1) {

        jQuery(".seo_pyramid_preview_ul li:nth-of-type(3)").text(pageDescText);

      }

    }

    // Close preview when close button is clicked
    jQuery(".seo_pyramid_preview_snippet, #seo_pyramid").addClass("show_seo_ps");

    setTimeout(function () {

      jQuery("#analyze").trigger("click");

    }, 1000);


  });


  jQuery(".close_seo_pyramid_preview").click(function () {

    jQuery(".meta-analysis").remove();

    jQuery(".analysis ul").replaceWith(jQuery(".loader-alternate").clone().removeClass("loader-alternate"));

    jQuery(".edit-post-visual-editor").delay(1500).show();

    jQuery(".seo_pyramid_preview_snippet").removeClass("show-serp-header");

    jQuery(".seo_pyramid_preview_snippet, #seo_pyramid").removeClass("show_seo_ps answerOn");

    jQuery(".explainer, .analysis, .loader-container").hide();

    jQuery("body").removeClass("loading");

  });

  // Explainer controls
  jQuery(".answer").on("click", function () {

    var answer = jQuery(this).attr("text");

    var answerText = "." + answer;

    jQuery(".explainer:not(answerText)").hide();

    jQuery(answerText).show();

    jQuery(".seo_pyramid_preview_snippet, #seo_pyramid").addClass("show_seo_ps answerOn");

  });

  // Toggle Google ID and Bing ID help 
  jQuery(".material-icons.what_is_this").on("click", function () {

    var target = jQuery(this).children(".seo_pyramid_learn");

    jQuery(".seo_pyramid_learn").not(target).hide();

    jQuery(this).children(".seo_pyramid_learn").toggle();

  });


  // Validate URL field

  jQuery("#seo_pyramid_canonical").bind("blur change keyup input", function () {

    var url = jQuery(this).val();

    var url_validate = /^(http(s)?:\/\/)?(www\.)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/;

    if (url !== "") {

      if (!url_validate.test(url)) {

        jQuery(".cano .dashicons-yes").removeClass("dashicons-yes").addClass("dashicons-no");

        jQuery(".can-parent").addClass("overLimit");

      } else if (url_validate.test(url)) {

        jQuery(".cano .dashicons-no").removeClass("dashicons-no").addClass("dashicons-yes");

        jQuery(".can-parent").removeClass("overLimit").addClass("notEmpty");


      }


    } else {

      jQuery(".can-parent").removeClass("overLimit");

      jQuery(".cano .dashicons-no").removeClass("dashicons-no").addClass("dashicons-yes");

    }

  });
    
    
  // Validate URL field for redirect

  jQuery("#seo_pyramid_redirect").bind("blur change keyup input", function () {

    var url = jQuery(this).val();

    var url_validate = /^(http(s)?:\/\/)?(www\.)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/;

    if (url !== "") {

      if (!url_validate.test(url)) {

        jQuery(".dir .dashicons-yes").removeClass("dashicons-yes").addClass("dashicons-no");

        jQuery(".dir-parent").addClass("overLimit");

      } else if (url_validate.test(url)) {

        jQuery(".dir .dashicons-no").removeClass("dashicons-no").addClass("dashicons-yes");

        jQuery(".dir-parent").removeClass("overLimit").addClass("notEmpty");


      }


    } else {

      jQuery(".dir-parent").removeClass("overLimit");

      jQuery(".dir-parent .dashicons-no").removeClass("dashicons-no").addClass("dashicons-yes");

    }

  });


  /* Trigger loader */
  jQuery(".seo_pyramid_preview_nav .preview-trigger").click(function () {

    jQuery("body").addClass("loading");

    jQuery(".loader-container").show();

  });

  // SERP switch starts here 
  jQuery(".serp-switch img").click(function () {
    var currSerp = jQuery(this).attr("alt");
    jQuery(".serp-switch img").removeClass("currSerp");
    jQuery(this).addClass("currSerp");
    jQuery(".seo_pyramid_preview_snippet").attr("id", currSerp);

    if (currSerp === "yandex" || currSerp === "bing") {
      jQuery(".url").insertAfter(".title");
      jQuery(".seo_pyramid_preview_snippet")
    } else {
      jQuery(".title").insertAfter(".url");
    }

  });


  // Check user entry character lenght when document is ready, whenever neccessary
    
 var urls = jQuery("#seo_pyramid_redirect").val();

    var url_validater = /^(http(s)?:\/\/)?(www\.)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/;

    if (urls !== "") {

      if (!url_validater.test(urls)) {

        jQuery(".dir .dashicons-yes").removeClass("dashicons-yes").addClass("dashicons-no");

        jQuery(".dir-parent").addClass("overLimit");

      } else if (url_validater.test(urls)) {

        jQuery(".dir-parent .dashicons-no").removeClass("dashicons-no").addClass("dashicons-yes");

        jQuery(".dir-parent").removeClass("overLimit").addClass("notEmpty");


      }


    } else {

      jQuery(".dir-parent").removeClass("overLimit");

      jQuery(".dir .dashicons-no").removeClass("dashicons-no").addClass("dashicons-yes");

    }

    
// For Canonical URL

  var url = jQuery("#seo_pyramid_canonical").val();

  var url_validate = /^(http(s)?:\/\/)?(www\.)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/;

  if (url !== "") {

    if (!url_validate.test(url)) {

      jQuery(".cano .dashicons-yes").removeClass("dashicons-yes").addClass("dashicons-no");

      jQuery(".can-parent").addClass("overLimit");

    } else if (url_validate.test(url)) {

      jQuery(".cano .dashicons-no").removeClass("dashicons-no").addClass("dashicons-yes");

      jQuery(".can-parent").removeClass("overLimit, seo-pyramid-check").addClass("notEmpty");


    }


  } else {

    jQuery(".can-parent").removeClass("overLimit");

    jQuery(".cano .dashicons-no").removeClass("dashicons-no").addClass("dashicons-yes");

  }


});


/***************************************************************************

MIT License

Copyright (c) 2017 Lukas Bolle

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

******************************************************************************/

(function ($) {
    "use strict";
    $.fn.circleChart = function (options) {
        const defaults = {
            color: "green",
            backgroundColor: "red",
            background: true,
            speed: 2000,
            widthRatio: 0.2,
            value: 66,
            unit: 'percent',
            counterclockwise: false,
            size: 110,
            startAngle: 0,
            animate: true,
            backgroundFix: true,
            lineCap: "",
            animation: "easeInOutCubic",
            text: false,
            redraw: false,
            cAngle: 0,
            textCenter: true,
            textSize: false,
            textWeight: '700',
            textFamily: 'sans-serif',
            relativeTextSize: 1 / 7,
            autoCss: true,
            onDraw: false
        };

        // Animation Math functions
        let math = {};

        math.linearTween = (t, b, c, d) => c * t / d + b;
        math.easeInQuad = (t, b, c, d) => {
            t /= d;
            return c * t * t + b;
        };
        math.easeOutQuad = (t, b, c, d) => {
            t /= d;
            return -c * t * (t - 2) + b;
        };
        math.easeInOutQuad = (t, b, c, d) => {
            t /= d / 2;
            if (t < 1)
                return c / 2 * t * t + b;
            t--;
            return -c / 2 * (t * (t - 2) - 1) + b;
        };
        math.easeInCubic = (t, b, c, d) => {
            t /= d;
            return c * t * t * t + b;
        };
        math.easeOutCubic = (t, b, c, d) => {
            t /= d;
            t--;
            return c * (t * t * t + 1) + b;
        };
        math.easeInOutCubic = (t, b, c, d) => {
            t /= d / 2;
            if (t < 1)
                return c / 2 * t * t * t + b;
            t -= 2;
            return c / 2 * (t * t * t + 2) + b;
        };
        math.easeInQuart = (t, b, c, d) => {
            t /= d;
            return c * t * t * t * t + b;
        };
        math.easeOutQuart = (t, b, c, d) => {
            t /= d;
            t--;
            return -c * (t * t * t * t - 1) + b;
        };
        math.easeInOutQuart = (t, b, c, d) => {
            t /= d / 2;
            if (t < 1)
                return c / 2 * t * t * t * t + b;
            t -= 2;
            return -c / 2 * (t * t * t * t - 2) + b;
        };
        math.easeInQuint = (t, b, c, d) => {
            t /= d;
            return c * t * t * t * t * t + b;
        };
        math.easeOutQuint = (t, b, c, d) => {
            t /= d;
            t--;
            return c * (t * t * t * t * t + 1) + b;
        };
        math.easeInOutQuint = (t, b, c, d) => {
            t /= d / 2;
            if (t < 1)
                return c / 2 * t * t * t * t * t + b;
            t -= 2;
            return c / 2 * (t * t * t * t * t + 2) + b;
        };
        math.easeInSine = (t, b, c, d) => -c * Math.cos(t / d * (Math.PI / 2)) + c + b;
        math.easeOutSine = (t, b, c, d) => c * Math.sin(t / d * (Math.PI / 2)) + b;
        math.easeInOutSine = (t, b, c, d) => -c / 2 * (Math.cos(Math.PI * t / d) - 1) + b;
        math.easeInExpo = (t, b, c, d) => c * Math.pow(2, 10 * (t / d - 1)) + b;
        math.easeOutExpo = (t, b, c, d) => c * (-Math.pow(2, -10 * t / d) + 1) + b;
        math.easeInOutExpo = (t, b, c, d) => {
            t /= d / 2;
            if (t < 1)
                return c / 2 * Math.pow(2, 10 * (t - 1)) + b;
            t--;
            return c / 2 * (-Math.pow(2, -10 * t) + 2) + b;
        };
        math.easeInCirc = (t, b, c, d) => {
            t /= d;
            return -c * (Math.sqrt(1 - t * t) - 1) + b;
        };
        math.easeOutCubic = (t, b, c, d) => {
            t /= d;
            t--;
            return c * (t * t * t + 1) + b;
        };
        math.easeInOutCubic = (t, b, c, d) => {
            t /= d / 2;
            if (t < 1)
                return c / 2 * t * t * t + b;
            t -= 2;
            return c / 2 * (t * t * t + 2) + b;
        };
        math.easeOutCirc = (t, b, c, d) => {
            t /= d;
            t--;
            return c * Math.sqrt(1 - t * t) + b;
        };
        math.easeInOutCirc = (t, b, c, d) => {
            t /= d / 2;
            if (t < 1)
                return -c / 2 * (Math.sqrt(1 - t * t) - 1) + b;
            t -= 2;
            return c / 2 * (Math.sqrt(1 - t * t) + 1) + b;
        };

        let Circle = (pos, bAngle, eAngle, cAngle, radius, lineWidth, sAngle, settings) => {
            let circle = Object.create(Circle.prototype);
            circle.pos = pos;
            circle.bAngle = bAngle;
            circle.eAngle = eAngle;
            circle.cAngle = cAngle;
            circle.radius = radius;
            circle.lineWidth = lineWidth;
            circle.sAngle = sAngle;
            circle.settings = settings;
            return circle;
        };

        Circle.prototype = {
            onDraw(el) {
                if (this.settings.onDraw !== false) {
                    let copy = Object.assign({}, this);

                    let units = {
                        'percent': rToP,
                        'rad': (e) => e,
                        'default': rToD
                    };

                    copy.value = (units[this.settings.unit] || units['default'])(copy.cAngle);

                    copy.text = (text) => setCircleText(el, text);
                    copy.settings.onDraw(el, copy);
                }
            },
            drawBackground(ctx) {
                ctx.beginPath();
                ctx.arc(this.pos, this.pos, this.settings.backgroundFix
                    ? this.radius * 0.9999
                    : this.radius, 0, 2 * Math.PI);
                ctx.lineWidth = this.settings.backgroundFix
                    ? this.lineWidth * 0.95
                    : this.lineWidth;
                ctx.strokeStyle = this.settings.backgroundColor;
                ctx.stroke();
            },
            draw(ctx) {
                ctx.beginPath();
                if (this.settings.counterclockwise) {
                    let k = 2 * Math.PI;
                    ctx.arc(this.pos, this.pos, this.radius, k - this.bAngle, k - (this.bAngle + this.cAngle), this.settings.counterclockwise);
                } else {
                    ctx.arc(this.pos, this.pos, this.radius, this.bAngle, this.bAngle + this.cAngle, this.settings.counterclockwise);
                }
                ctx.lineWidth = this.lineWidth;
                ctx.lineCap = this.settings.lineCap;
                ctx.strokeStyle = this.settings.color;
                ctx.stroke();
            },
            animate(el, ctx, time, startTime, move/*move counterclockwise*/) {
                let mspf = new Date().getTime() - time; //milliseconds per frame
                if (mspf < 1) {
                    mspf = 1;
                }
                if ((time - startTime < this.settings.speed * 1.05)/* time not over */ && (!move && (this.cAngle) * 1000 <= Math.floor((this.eAngle) * 1000)/* move clockwise */ || move && (this.cAngle) * 1000 >= Math.floor((this.eAngle) * 1000)/* move counterclockwise */)) {
                    this.cAngle = math[this.settings.animation]((time - startTime) / mspf, this.sAngle, this.eAngle - this.sAngle, this.settings.speed / mspf);
                    ctx.clearRect(0, 0, this.settings.size, this.settings.size);
                    if (this.settings.background) {
                        this.drawBackground(ctx);
                    }
                    this.draw(ctx);
                    this.onDraw(el);
                    time = new Date().getTime();
                    rAF(() => this.animate(el, ctx, time, startTime, move));
                } else {
                    this.cAngle = this.eAngle;
                    ctx.clearRect(0, 0, this.settings.size, this.settings.size);
                    if (this.settings.background) {
                        this.drawBackground(ctx);
                    }
                    this.draw(ctx);
                    this.setCurrentAnglesData(el);
                }
            },
            setCurrentAnglesData(el) {
                let units = {
                    'percent': rToP,
                    'rad': (e) => e,
                    'default': rToD
                };

                let f = (units[this.settings.unit] || units['default']);

                el.data("current-c-angle", f(this.cAngle));
                el.data("current-start-angle", f(this.bAngle));
            }
        };

        let setCircleText = (el, text) => {
            el.data("text", text);
            $(".circleChart_text", el).html(text);
        };

        let scaleCanvas = (c) => {
            let ctx = c.getContext("2d");
            let dpr = window.devicePixelRatio || 1;
            let bsr = ctx.webkitBackingStorePixelRatio || ctx.mozBackingStorePixelRatio || ctx.msBackingStorePixelRatio || ctx.oBackingStorePixelRatio || ctx.backingStorePixelRatio || 1;

            let ratio = dpr / bsr;

            let oldWidth = c.width;
            let oldHeight = c.height;

            c.width = oldWidth * ratio;
            c.height = oldHeight * ratio;

            c.style.width = oldWidth + 'px';
            c.style.height = oldHeight + 'px';

            ctx.scale(ratio, ratio);
        };

        let rToD = (rad) => rad / Math.PI * 180;
        let dToR = (deg) => deg / 180 * Math.PI;
        let pToR = (percent) => dToR(percent / 100 * 360);
        let rToP = (rad) => rToD(rad) / 360 * 100;

        let rAF = ((c) => window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || window.oRequestAnimationFrame || window.msRequestAnimationFrame || function (c) {
            window.setTimeout(c, 1000 / 60);
        })();

        return this.each((idx, element) => {
            let el = $(element);
            let cache = {};
            let _data = el.data();
            for (let key in _data) {
                if (_data.hasOwnProperty(key) && key.indexOf('_cache_') === 0) {
                    if (defaults.hasOwnProperty(key.substring(7))) {
                        cache[key.substring(7)] = _data[key];
                    }
                }
            }

            let settings = Object.assign({}, defaults, cache, _data, options);
            for (let key in settings) {
                if (settings.hasOwnProperty(key) && key.indexOf('_cache_') !== 0)
                    el.data('_cache_' + key, settings[key]);
            }
            if (!$("canvas.circleChart_canvas", el).length) {
                el.append(function () {
                    return $('<canvas/>', {'class': 'circleChart_canvas'}).prop({
                        width: settings.size,
                        height: settings.size
                    }).css(settings.autoCss
                        ? {
                            "margin-left": "auto",
                            "margin-right": "auto",
                            "display": "block"
                        }
                        : {});
                });
                scaleCanvas($("canvas", el).get(0));
            }
            if (!$("p.circleChart_text", el).length) {
                if (settings.text !== false) {
                    el.append("<p class='circleChart_text'>" + settings.text + "</p>");
                    if (settings.autoCss) {
                        if (settings.textCenter) {
                            $("p.circleChart_text", el).css({
                                "position": "absolute",
                                "line-height": (settings.size + "px"),
                                "top": 0,
                                "width": "100%",
                                "margin": 0,
                                "padding": 0,
                                "text-align": "center",
                                "font-size": settings.textSize !== false
                                    ? settings.textSize
                                    : settings.size * settings.relativeTextSize,
                                "font-weight": settings.textWeight,
                                "font-family": settings.textFamily
                            });
                        } else {
                            $("p.circleChart_text", el).css({
                                "padding-top": "5px",
                                "text-align": "center",
                                "font-weight": settings.textWeight,
                                "font-family": settings.textFamily,
                                "font-size": settings.textSize !== false
                                    ? settings.textSize
                                    : settings.size * settings.relativeTextSize
                            });
                        }
                    }
                }
            }

            if (settings.autoCss) {
                el.css("position", "relative");
            }

            if (!settings.redraw) {
                settings.cAngle = settings.currentCAngle
                    ? settings.currentCAngle
                    : settings.cAngle;
                settings.startAngle = settings.currentStartAngle
                    ? settings.currentStartAngle
                    : settings.startAngle;
            }

            let c = $("canvas", el).get(0);
            let ctx = c.getContext("2d");

            let units = {
                'percent': pToR,
                'rad': (e) => e,
                'default': dToR
            };

            let f = (units[settings.unit] || units['default']);

            let bAngle = f(settings.startAngle);
            let eAngle = f(settings.value);
            let cAngle = f(settings.cAngle);

            let pos = settings.size / 2;
            let radius = pos * (1 - settings.widthRatio / 2);
            let lineWidth = radius * settings.widthRatio;
            let circle = Circle(pos, bAngle, eAngle, cAngle, radius, lineWidth, cAngle, settings);
            el.data("size", settings.size);
            if (!settings.animate) {
                circle.cAngle = circle.eAngle;
                rAF(() => {
                    ctx.clearRect(0, 0, settings.size, settings.size);
                    if (settings.background) {
                        circle.drawBackground(ctx);
                    }
                    if (settings.value !== 0) {
                        circle.draw(ctx);
                        circle.setCurrentAnglesData(el);
                    } else {
                        if (circle.settings.background) {
                            circle.drawBackground(ctx);
                        }
                    }
                    circle.onDraw(el);
                });
            } else {
                if (settings.value !== 0) {
                    circle.animate(el, ctx, new Date().getTime(), new Date().getTime(), cAngle > eAngle);
                } else {
                    rAF(() => {
                        ctx.clearRect(0, 0, settings.size, settings.size);
                        if (circle.settings.background) {
                            circle.drawBackground(ctx);
                        }
                        circle.onDraw(el);
                    });
                }
            }
        });
    };
}(jQuery));