var width = window.innerWidth - 21,
    height = window.innerHeight,
    boxwidth = $('#header > div').width(),
    boxheight = $('#header > div').height(),
    marginTop = (height - boxheight) / 2;

$('#header').width(width).height(height);
$('#header > div').css('marginTop', marginTop + 'px', 'marginBottom', marginTop);
$('section').each(function() {
    if ($(this).innerHeight() < height) {
        // console.log($(this).height());
        $(this).innerHeight(height);
    };
});

/* -- STICKY NAVIGATION -- */

(function($) {
    var defaults = {
        topSpacing: 0,
        bottomSpacing: 0,
        className: 'is-sticky',
        wrapperClassName: 'sticky-wrapper',
        center: false,
        getWidthFrom: ''
    },
        $window = $(window),
        $document = $(document),
        sticked = [],
        windowHeight = $window.height(),
        scroller = function() {
            var scrollTop = $window.scrollTop(),
                documentHeight = $document.height(),
                dwh = documentHeight - windowHeight,
                extra = (scrollTop > dwh) ? dwh - scrollTop : 0;

            for (var i = 0; i < sticked.length; i++) {
                var s = sticked[i],
                    elementTop = s.stickyWrapper.offset().top,
                    etse = elementTop - s.topSpacing - extra;

                if (scrollTop <= etse) {
                    if (s.currentTop !== null) {
                        s.stickyElement
                            .css('position', '')
                            .css('top', '');
                        s.stickyElement.parent().removeClass(s.className);
                        s.currentTop = null;
                    }
                } else {
                    var newTop = documentHeight - s.stickyElement.outerHeight() - s.topSpacing - s.bottomSpacing - scrollTop - extra;
                    if (newTop < 0) {
                        newTop = newTop + s.topSpacing;
                    } else {
                        newTop = s.topSpacing;
                    }
                    if (s.currentTop != newTop) {
                        s.stickyElement
                            .css('position', 'fixed')
                            .css('top', newTop);

                        if (typeof s.getWidthFrom !== 'undefined') {
                            s.stickyElement.css('width', $(s.getWidthFrom).width());
                        }

                        s.stickyElement.parent().addClass(s.className);
                        s.currentTop = newTop;
                    }
                }
            }
        },
        resizer = function() {
            windowHeight = $window.height();
        },
        methods = {
            init: function(options) {
                var o = $.extend(defaults, options);
                return this.each(function() {
                    var stickyElement = $(this);

                    stickyId = stickyElement.attr('id');
                    wrapper = $('<div></div>')
                        .attr('id', stickyId + '-sticky-wrapper')
                        .addClass(o.wrapperClassName);
                    stickyElement.wrapAll(wrapper);

                    if (o.center) {
                        stickyElement.parent().css({
                            width: stickyElement.outerWidth(),
                            marginLeft: "auto",
                            marginRight: "auto"
                        });
                    }

                    if (stickyElement.css("float") == "right") {
                        stickyElement.css({
                            "float": "none"
                        }).parent().css({
                            "float": "right"
                        });
                    }

                    var stickyWrapper = stickyElement.parent();
                    stickyWrapper.css('height', stickyElement.outerHeight());
                    sticked.push({
                        topSpacing: o.topSpacing,
                        bottomSpacing: o.bottomSpacing,
                        stickyElement: stickyElement,
                        currentTop: null,
                        stickyWrapper: stickyWrapper,
                        className: o.className,
                        getWidthFrom: o.getWidthFrom
                    });
                });
            },
            update: scroller
        };


    if (window.addEventListener) {
        window.addEventListener('scroll', scroller, false);
        window.addEventListener('resize', resizer, false);
    } else if (window.attachEvent) {
        window.attachEvent('onscroll', scroller);
        window.attachEvent('onresize', resizer);
    }

    $.fn.sticky = function(method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Method ' + method + ' does not exist on jQuery.sticky');
        }
    };
    $(function() {
        setTimeout(scroller, 0);
    });
})(jQuery);


// SELECTED CLASS ON SCROLLING 

var header_height = $('#nav').outerHeight();
var sections = [];
$('#nav a').each(function() {
    var section = $(this.hash).offset()
    sections.push({
        'link': $(this).parent(),
        'top': $(this.hash).offset().top - header_height,
        'bottom': $(this.hash).offset().top + $(this.hash).outerHeight() - header_height
    });
});

$('#nav a').click(function(e) {
    e.preventDefault();
    $('html,body').animate({
        scrollTop: $(this.hash).offset().top - header_height
    }, 500);
});


$(window).scroll(function() {
    for (var i = 1; i < sections.length; i++)
        if ($(window).scrollTop() >= sections[i].top && $(window).scrollTop() <= sections[i].bottom) {
            sections[i].link.addClass('selected').siblings().removeClass('selected');
        }
});

/* -- SMOOTH SCROLLING -- */


$('a[href^="#"]').bind('click.smoothscroll', function(e) {
    e.preventDefault();
    var target = this.hash;
    $target = $(target);
    $('html, body').stop().animate({
        'scrollTop': $target.offset().top
    }, 800, 'swing', function() {
        window.location.hash = target;
    });
});

/* -- STICKY NAV -- */

$(document).ready(function() {
    $("nav").sticky({
        topSpacing: 0
    });
});


/* -- ROLES OF HEADER -- */

var current = 1;
var height = $('.roles').height();
var numberDivs = $('.roles').children().length;
var first = $('.roles div:nth-child(1)');
setInterval(function() {
    var number = current * -height;
    first.css('margin-top', number + 'px');
    if (current === numberDivs) {
        first.css('margin-top', '0px');
        current = 1;
    } else current++;
}, 2500);



/* -- WORKS GRID LOADER -- */

$(function() {
    Grid.init();
});

/* -- TWITTER MAKE IT WORK -- */


jQuery(function($) {
    $("#ticker").tweet({
        username: "Supview",
        page: 1,
        avatar_size: 0,
        count: 10,
        template: "{text}{time}",
        filter: function(t) {
            return !/^@\w+/.test(t.tweet_raw_text);
        },
        loading_text: "loading ..."
    }).bind("loaded", function() {
        var ul = $(this).find(".tweet_list");
        var ticker = function() {
            setTimeout(function() {
                ul.find('li:first').animate({
                    marginTop: '-30px'
                }, 500, function() {
                    $(this).detach().appendTo(ul).removeAttr('style');
                });
                ticker();
            }, 5000);
        };
        ticker();
    });
});