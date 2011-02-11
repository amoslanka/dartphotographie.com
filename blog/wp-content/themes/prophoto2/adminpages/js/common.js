/* Scripts for all the admin page */

if (typeof(jQuery.fn.tTips) != 'function') {
	(function(JQ) {
		JQ.fn.tTips = function() {

			JQ('body').append('<div id="tTips"><p id="tTips_inside"></p></div>');
			var TT = JQ('#tTips');

			this.each(function() {
				var el = JQ(this), txt;
				
				if ( txt = el.attr('title') ) el.attr('tip', txt).removeAttr('title');
				else return;
				el.find('img').removeAttr('alt');

				el.mouseover(function(e) {
					txt = el.attr('tip'), o = el.offset();;

					clearTimeout(TT.sD);
					TT.find('p').html(txt);

					TT.css({'top': o.top - 43, 'left': o.left - 15});
					TT.sD = setTimeout(function(){TT.fadeIn(150);}, 100);
				});

				el.mouseout(function() {
					clearTimeout(TT.sD);
					TT.css({display : 'none'});
				})
			});
		}
	}(jQuery));
}