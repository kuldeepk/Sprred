(function($) {
  $.lightbox = function(data, klass) {
    $.lightbox.loading()

    if (data.ajax) filllightboxFromAjax(data.ajax)
    else if (data.image) filllightboxFromImage(data.image)
    else if (data.div) filllightboxFromHref(data.div)
    else if ($.isFunction(data)) data.call($)
    else $.lightbox.reveal(data, klass)
  }

  /*
   * Public, $.lightbox methods
   */

  $.extend($.lightbox, {
    settings: {
      opacity      : 0.6,
      overlay      : true,
      loadingImage : '/images/loading.gif',
      closeImage   : '/images/closelabel.gif',
      imageTypes   : [ 'png', 'jpg', 'jpeg', 'gif' ],
	  closeButtonActive: true,
      lightboxHtml  : '\
    <div id="lightbox" style="display:none;"> \
      <div class="popup"> \
        <table> \
          <tbody> \
            <tr> \
              <td class="tl"/><td class="top"/><td class="tr"/> \
            </tr> \
            <tr> \
              <td class="left_side"/> \
              <td class="body"> \
                <div class="content"> \
                </div> \
                <div class="footer"> \
                  <a href="#" class="close"> \
                    <img src="../images/closelabel.gif" title="close" class="close_image" /> \
                  </a> \
                </div> \
              </td> \
              <td class="right_side"/> \
            </tr> \
            <tr> \
              <td class="bl"/><td class="bottom"/><td class="br"/> \
            </tr> \
          </tbody> \
        </table> \
      </div> \
    </div>'
    },

    loading: function() {
      init()
      if ($('#lightbox .loading').length == 1) return true
      showOverlay()

      $('#lightbox .content').empty()
      $('#lightbox .body').children().hide().end().
        append('<div class="loading"><img src="'+$.lightbox.settings.loadingImage+'"/></div>')

      $('#lightbox').css({
        top:	getPageScroll()[1] + (getPageHeight() / 3),
        left:	385.5
      }).show()

      $(document).bind('keydown.lightbox', function(e) {
        if (e.keyCode == 27) $.lightbox.close()
        return true
      })
      $(document).trigger('loading.lightbox')
    },

    reveal: function(data, klass) {
      $(document).trigger('beforeReveal.lightbox')
      if (klass) $('#lightbox .content').addClass(klass)
      $('#lightbox .content').append(data)
	  if(!$.lightbox.settings.closeButtonActive) $('#lightbox .close').hide();
      $('#lightbox .loading').remove()
	  $('#lightbox .body').children().show()
	  $('#lightbox').css('left', $(window).width() / 2 - ($('#lightbox table').width() / 2))
      $('#lightbox').css('top', (getPageScroll()[1] + (getPageHeight() / 2)) - ($('#lightbox table').height() / 2))
      $(document).trigger('reveal.lightbox').trigger('afterReveal.lightbox')
    },

    close: function() {
      $(document).trigger('close.lightbox')
      return false
    }
  })

  /*
   * Public, $.fn methods
   */

  $.fn.lightbox = function(settings) {
    init(settings)

    function clickHandler() {
      $.lightbox.loading(true)

      // support for rel="lightbox.inline_popup" syntax, to add a class
      // also supports deprecated "lightbox[.inline_popup]" syntax
      var klass = this.rel.match(/lightbox\[?\.(\w+)\]?/)
      if (klass) klass = klass[1]

      filllightboxFromHref(this.href, klass)
      return false
    }

    return this.click(clickHandler)
  }

  /*
   * Private methods
   */

  // called one time to setup lightbox on this page
  function init(settings) {
    if ($.lightbox.settings.inited) return true
    else $.lightbox.settings.inited = true

    $(document).trigger('init.lightbox')
    makeCompatible()

    var imageTypes = $.lightbox.settings.imageTypes.join('|')
    $.lightbox.settings.imageTypesRegexp = new RegExp('\.' + imageTypes + '$', 'i')

    if (settings) $.extend($.lightbox.settings, settings)
    $('body').append($.lightbox.settings.lightboxHtml)

    var preload = [ new Image(), new Image() ]
    preload[0].src = $.lightbox.settings.closeImage
    preload[1].src = $.lightbox.settings.loadingImage

    $('#lightbox').find('.b:first, .bl, .br, .tl, .tr').each(function() {
      preload.push(new Image())
      preload.slice(-1).src = $(this).css('background-image').replace(/url\((.+)\)/, '$1')
    })

    $('#lightbox .close').click($.lightbox.close)
    $('#lightbox .close_image').attr('src', $.lightbox.settings.closeImage)
  }
  
  // getPageScroll() by quirksmode.com
  function getPageScroll() {
    var xScroll, yScroll;
    if (self.pageYOffset) {
      yScroll = self.pageYOffset;
      xScroll = self.pageXOffset;
    } else if (document.documentElement && document.documentElement.scrollTop) {	 // Explorer 6 Strict
      yScroll = document.documentElement.scrollTop;
      xScroll = document.documentElement.scrollLeft;
    } else if (document.body) {// all other Explorers
      yScroll = document.body.scrollTop;
      xScroll = document.body.scrollLeft;	
    }
    return new Array(xScroll,yScroll) 
  }

  // Adapted from getPageSize() by quirksmode.com
  function getPageHeight() {
    var windowHeight
    if (self.innerHeight) {	// all except Explorer
      windowHeight = self.innerHeight;
    } else if (document.documentElement && document.documentElement.clientHeight) { // Explorer 6 Strict Mode
      windowHeight = document.documentElement.clientHeight;
    } else if (document.body) { // other Explorers
      windowHeight = document.body.clientHeight;
    }	
    return windowHeight
  }

  // Backwards compatibility
  function makeCompatible() {
    var $s = $.lightbox.settings

    $s.loadingImage = $s.loading_image || $s.loadingImage
    $s.closeImage = $s.close_image || $s.closeImage
    $s.imageTypes = $s.image_types || $s.imageTypes
    $s.lightboxHtml = $s.lightbox_html || $s.lightboxHtml
  }

  // Figures out what you want to display and displays it
  // formats are:
  //     div: #id
  //   image: blah.extension
  //    ajax: anything else
  function filllightboxFromHref(href, klass) {
    // div
    if (href.match(/#/)) {
      var url    = window.location.href.split('#')[0]
      var target = href.replace(url,'')
      $.lightbox.reveal($(target).clone().show(), klass)

    // image
    } else if (href.match($.lightbox.settings.imageTypesRegexp)) {
      filllightboxFromImage(href, klass)
    // ajax
    } else {
      filllightboxFromAjax(href, klass)
    }
  }

  function filllightboxFromImage(href, klass) {
    var image = new Image()
    image.onload = function() {
      $.lightbox.reveal('<div class="image"><img src="' + image.src + '" /></div>', klass)
    }
    image.src = href
  }

  function filllightboxFromAjax(href, klass) {
    $.get(href, function(data) { $.lightbox.reveal(data, klass) })
  }

  function skipOverlay() {
    return $.lightbox.settings.overlay == false || $.lightbox.settings.opacity === null 
  }

  function showOverlay() {
    if (skipOverlay()) return

    if ($('lightbox_overlay').length == 0) 
      $("body").append('<div id="lightbox_overlay" class="lightbox_hide"></div>')

    $('#lightbox_overlay').hide().addClass("lightbox_overlayBG")
      .css('opacity', $.lightbox.settings.opacity)
      .click(function() { $(document).trigger('close.lightbox') })
      .fadeIn(200)
    return false
  }

  function hideOverlay() {
    if (skipOverlay()) return

    $('#lightbox_overlay').fadeOut(200, function(){
      $("#lightbox_overlay").removeClass("lightbox_overlayBG")
      $("#lightbox_overlay").addClass("lightbox_hide") 
      $("#lightbox_overlay").remove()
    })
    
    return false
  }

  /*
   * Bindings
   */

  $(document).bind('close.lightbox', function() {
    $(document).unbind('keydown.lightbox')
    $('#lightbox').fadeOut(function() {
      $('#lightbox .content').empty();
      $('#lightbox .content').removeClass().addClass('content')
      hideOverlay()
      $('#lightbox .loading').remove()
    })
  })

})(jQuery);
