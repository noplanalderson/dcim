/**
 * Resize function without multiple trigger
 * 
 * Usage:
 * $(window).smartresize(function(){  
 *     // code here
 * });
 */
(function($,sr){
    // debouncing function from John Hann
    // http://unscriptable.com/index.php/2009/03/20/debouncing-javascript-methods/
    var debounce = function (func, threshold, execAsap) {
      var timeout;

        return function debounced () {
            var obj = this, args = arguments;
            function delayed () {
                if (!execAsap)
                    func.apply(obj, args); 
                timeout = null; 
            }

            if (timeout)
                clearTimeout(timeout);
            else if (execAsap)
                func.apply(obj, args);

            timeout = setTimeout(delayed, threshold || 100); 
        };
    };

    // smartresize 
    jQuery.fn[sr] = function(fn){  return fn ? this.bind('resize', debounce(fn)) : this.trigger(sr); };

})(jQuery,'smartresize');
/**
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var CURRENT_URL = window.location.href.split('#')[0].split('?')[0],
    $BODY = $('body'),
    $MENU_TOGGLE = $('#menu_toggle'),
    $SIDEBAR_MENU = $('#sidebar-menu'),
    $SIDEBAR_FOOTER = $('.sidebar-footer'),
    $LEFT_COL = $('.left_col'),
    $RIGHT_COL = $('.right_col'),
    $NAV_MENU = $('.nav_menu'),
    $FOOTER = $('footer');

	
	
// Sidebar
function init_sidebar() {
// TODO: This is some kind of easy fix, maybe we can improve this
var setContentHeight = function () {
	// reset height
	$RIGHT_COL.css('min-height', $(window).height());

	var bodyHeight = $BODY.outerHeight(),
		footerHeight = $BODY.hasClass('footer_fixed') ? -10 : $FOOTER.height(),
		leftColHeight = $LEFT_COL.eq(1).height() + $SIDEBAR_FOOTER.height(),
		contentHeight = bodyHeight < leftColHeight ? leftColHeight : bodyHeight;

	// normalize content
	contentHeight -= $NAV_MENU.height() + footerHeight;

	$RIGHT_COL.css('min-height', contentHeight);
};

  $SIDEBAR_MENU.find('a').on('click', function(ev) {
	  console.log('clicked - sidebar_menu');
        var $li = $(this).parent();

        if ($li.is('.active')) {
            $li.removeClass('active active-sm');
            $('ul:first', $li).slideUp(function() {
                setContentHeight();
            });
        } else {
            // prevent closing menu if we are on child menu
            if (!$li.parent().is('.child_menu')) {
                $SIDEBAR_MENU.find('li').removeClass('active active-sm');
                $SIDEBAR_MENU.find('li ul').slideUp();
            }else
            {
				if ( $BODY.is( ".nav-sm" ) )
				{
					$li.parent().find( "li" ).removeClass( "active active-sm" );
					$li.parent().find( "li ul" ).slideUp();
				}
			}
            $li.addClass('active');

            $('ul:first', $li).slideDown(function() {
                setContentHeight();
            });
        }
    });

// toggle small or large menu 
$MENU_TOGGLE.on('click', function() {
		console.log('clicked - menu toggle');
		
		if ($BODY.hasClass('nav-md')) {
			$SIDEBAR_MENU.find('li.active ul').hide();
			$SIDEBAR_MENU.find('li.active').addClass('active-sm').removeClass('active');
		} else {
			$SIDEBAR_MENU.find('li.active-sm ul').show();
			$SIDEBAR_MENU.find('li.active-sm').addClass('active').removeClass('active-sm');
		}

	$BODY.toggleClass('nav-md nav-sm');

	setContentHeight();

	$('.dataTable').each ( function () { $(this).dataTable().fnDraw(); });
});

	// check active menu
	$SIDEBAR_MENU.find('a[href="' + CURRENT_URL + '"]').parent('li').addClass('current-page');

	$SIDEBAR_MENU.find('a').filter(function () {
		return this.href == CURRENT_URL;
	}).parent('li').addClass('current-page').parents('ul').slideDown(function() {
		setContentHeight();
	}).parent().addClass('active');

	// recompute content when resizing
	$(window).smartresize(function(){  
		setContentHeight();
	});

	setContentHeight();

	// fixed sidebar
	if ($.fn.mCustomScrollbar) {
		$('.menu_fixed').mCustomScrollbar({
			autoHideScrollbar: true,
			theme: 'minimal',
			mouseWheel:{ preventDefault: true }
		});
	}
};
// /Sidebar

	var randNum = function() {
	  return (Math.floor(Math.random() * (1 + 40 - 20))) + 20;
	};


// Panel toolbox
$(document).ready(function() {
    $('.collapse-link').on('click', function() {
        var $BOX_PANEL = $(this).closest('.x_panel'),
            $ICON = $(this).find('i'),
            $BOX_CONTENT = $BOX_PANEL.find('.x_content');
        
        // fix for some div with hardcoded fix class
        if ($BOX_PANEL.attr('style')) {
            $BOX_CONTENT.slideToggle(200, function(){
                $BOX_PANEL.removeAttr('style');
            });
        } else {
            $BOX_CONTENT.slideToggle(200); 
            $BOX_PANEL.css('height', 'auto');  
        }

        $ICON.toggleClass('fa-chevron-up fa-chevron-down');
    });

    $('.close-link').click(function () {
        var $BOX_PANEL = $(this).closest('.x_panel');

        $BOX_PANEL.remove();
    });
});
// /Panel toolbox

// Progressbar
if ($(".progress .progress-bar")[0]) {
    $('.progress .progress-bar').progressbar();
}
// /Progressbar

// NProgress
if (typeof NProgress != 'undefined') {
    $(document).ready(function () {
        NProgress.start();
    });

    $(window).load(function () {
        NProgress.done();
    });
}

    /* Automate testing of module somewhat */

    var nav = Highcharts.win.navigator,
        isMSBrowser = /Edge\/|Trident\/|MSIE /.test(nav.userAgent),
        isEdgeBrowser = /Edge\/\d+/.test(nav.userAgent),
        containerEl = document.getElementsByClassName('graph'),
        parentEl = containerEl.parentNode,
        oldDownloadURL = Highcharts.downloadURL;

    function addText(text) {
        var heading = document.createElement('h2');
        heading.innerHTML = text;
        parentEl.appendChild(heading);
    }

    function addURLView(title, url) {
        var iframe = document.createElement('iframe');
        if (isMSBrowser && Highcharts.isObject(url)) {
            addText(title +
            ': Microsoft browsers do not support Blob iframe.src, test manually'
            );
            return;
        }
        iframe.src = url;
        iframe.width = 400;
        iframe.height = 300;
        iframe.title = title;
        iframe.style.display = 'none';
        //parentEl.appendChild(iframe);
    }

    function fallbackHandler(options) {
        if (options.type !== 'image/svg+xml' && isEdgeBrowser ||
            options.type === 'application/pdf' && isMSBrowser) {
            addText(options.type + ' fell back on purpose');
        } else {
            throw 'Should not have to fall back for this combination. ' +
                options.type;
        }
    }

    Highcharts.downloadURL = function (dataURL, filename) {
        // Emulate toBlob behavior for long URLs
        if (dataURL.length > 2000000) {
            dataURL = Highcharts.dataURLtoBlob(dataURL);
            if (!dataURL) {
                throw 'Data URL length limit reached';
            }
        }
        // Show result in an iframe instead of downloading
        addURLView(filename, dataURL);
    };

    Highcharts.Chart.prototype.exportTest = function (type) {
        this.exportChartLocal({
            type: type
        }, {
            title: {
                text: type
            },
            subtitle: {
                text: false
            }
        });
    };

    Highcharts.Chart.prototype.callbacks.push(function (chart) {
        if (!chart.options.chart.forExport) {
            var menu = chart.exportSVGElements && chart.exportSVGElements[0],
                oldHandler;
            chart.exportTest('image/png');
            chart.exportTest('image/jpeg');
            chart.exportTest('image/svg+xml');
            chart.exportTest('application/pdf');

            // Allow manual testing by resetting downloadURL handler when trying
            // to export manually
            if (menu) {
                oldHandler = menu.element.onclick;
                menu.element.onclick = function () {
                    Highcharts.downloadURL = oldDownloadURL;
                    oldHandler.call(this);
                };
            }
        }
    });


    $(document).ready(function(){
    // updating the view with notifications using ajax
      function load_unseen_notification(see = '')
      {
        $.ajax({
          url:window.location.origin + '/notification/fetch',
          method:"POST",
          data:{see:see},
          dataType: 'json',
          success: function(data) {
            if(data.result == 1)
            {
               $('.count-notif span[id=count-notif]').html(data.count);
            }
          }
        });
      }
      $(document).on('click', '.notif', function(){
        load_unseen_notification();
      });
    });

    //original canvas
    var canvas = document.querySelector('#slaSummary');
    var context = canvas.getContext('2d');

    //add event listener to button
    document.getElementById('download-pdf').addEventListener("click", downloadPDF);

    //donwload pdf from original canvas
    function downloadPDF() {
      var canvas = document.querySelector('#slaSummary');
      //creates image
      var canvasImg = canvas.toDataURL("image/jpeg", 1.0);
      //creates PDF from img
      var doc = new jsPDF('landscape');
      doc.setFontSize(5);
      doc.text(2, 2, "SLA Summary Last Year");
      doc.addImage(canvasImg, 'JPEG', 10, 10, 180, 85 );
      doc.save('sla_summary.pdf');
      margins = {
        top: 10,
        bottom: 10,
        left: 20,
      };
    }
    
    $(document).ready(function() {

        init_sidebar();
                
    });
