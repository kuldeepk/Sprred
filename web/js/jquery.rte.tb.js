/*
 * Lightweight RTE - jQuery Plugin, v1.2
 * Basic Toolbars
 * Copyright (c) 2009 Andrey Gayvoronsky - http://www.gayvoronsky.com
 */
var rte_tag		= '-rte-tmp-tag-';

var	rte_toolbar = {
	s1				: {separator: true},
	bold			: {command: 'bold', tags:['b', 'strong']},
	italic			: {command: 'italic', tags:['i', 'em']},
	strikeThrough	: {command: 'strikethrough', tags: ['s', 'strike'] },
	underline		: {command: 'underline', tags: ['u']},
	s2				: {separator: true },
	size			: {command: 'fontsize', select: '\
	<select>\
		<option value="">-</option>\
		<option value="1">1 (8pt)</option>\
		<option value="2">2 (10pt)</option>\
		<option value="3">3 (12pt)</options>\
		<option value="4">4 (14pt)</option>\
		<option value="5">5 (16pt)</options>\
		<option value="6">6 (18pt)</option>\
		<option value="7">7 (20pt)</options>\
	</select>\
		', tags: ['font']},
		color			: {exec: lwrte_color},
	s3				: {separator : true },
	justifyLeft   	: {command: 'justifyleft'},
	justifyCenter	: {command: 'justifycenter'},
	justifyRight	: {command: 'justifyright'},
	s4				: {separator : true},
	indent			: {command: 'indent'},
	outdent			: {command: 'outdent'},
	s5				: {separator : true},
	orderedList		: {command: 'insertorderedlist', tags: ['ol'] },
	unorderedList	: {command: 'insertunorderedlist', tags: ['ul'] },
	s6				: {separator : true },
	image			: {exec: lwrte_image, tags: ['img'] },
	link			: {exec: lwrte_link, tags: ['a'] },
	unlink			: {command: 'unlink'},
	s7				: {separator : true },
	removeFormat:{exec:lwrte_unformat}
};

var html_toolbar = {
	s1				: {separator: true},
};

/*** tag compare callbacks ***/
function lwrte_block_compare(node, tag) {
	tag = tag.replace(/<([^>]*)>/, '$1');
	return (tag.toLowerCase() == node.nodeName.toLowerCase());
}

/*** init callbacks ***/
function lwrte_style_init(rte) {
	var self = this;
	self.select = '<select><option value="">- no css -</option></select>';

	// load CSS info. javascript only issue is not working correctly, that's why ajax-php :(
	if(rte.css.length) {	
		$.ajax({
			url: "styles.php", 
			type: "POST",
			data: { css: rte.css[rte.css.length - 1] }, 
			async: false,
			success: function(data) {
				var list = data.split(',');
				var select = "";

				for(var name in list)
					select += '<option value="' + list[name] + '">' + list[name] + '</option>';
	
				self.select = '<select><option value="">- css -</option>' + select + '</select>';
			}});
	}
}

/*** exec callbacks ***/
function lwrte_style(args) {
	if(args) {
		try {
			var css = args.options[args.selectedIndex].value
			var self = this;
			var html = self.get_selected_text();
			html = '<span class="' + css + '">' + html + '</span>';
			self.selection_replace_with(html);
			args.selectedIndex = 0;
		} catch(e) {
		}
	}
}

function lwrte_color(){
	var self = this;
	var panel = self.create_panel('Set color for text', 385);
	var mouse_down = false;
	var mouse_over = false;
	panel.append('\
<div class="colorpicker1"><div class="rgb" id="rgb"></div></div>\
<div class="colorpicker1"><div class="gray" id="gray"></div></div>\
<div class="colorpicker2">\
	<div class="palette" id="palette"></div>\
	<div class="preview" id="preview"></div>\
	<div class="color" id="color"></div>\
</div>\
<div class="clear"></div>\
<p class="submit"><button id="ok">Ok</button><button id="cancel">Cancel</button></p>'
).show();

	var preview = $('#preview', panel);
	var color = $("#color", panel);
	var palette = $("#palette", panel);
	var colors = [
		'#660000', '#990000', '#cc0000', '#ff0000', '#333333',
		'#006600', '#009900', '#00cc00', '#00ff00', '#666666',
		'#000066', '#000099', '#0000cc', '#0000ff', '#999999',
		'#909000', '#900090', '#009090', '#ffffff', '#cccccc',
		'#ffff00', '#ff00ff', '#00ffff', '#000000', '#eeeeee'
	];
			
	for(var i = 0; i < colors.length; i++)
		$("<div></div>").addClass("item").css('background', colors[i]).appendTo(palette);
			
	var height = $('#rgb').height();
	var part_width = $('#rgb').width() / 6;

	$('#rgb,#gray,#palette', panel)
		.mousedown( function(e) {mouse_down = true; return false; } )
		.mouseup( function(e) {mouse_down = false; return false; } )
		.mouseout( function(e) {mouse_over = false; return false; } )
		.mouseover( function(e) {mouse_over = true; return false; } );

	$('#rgb').mousemove( function(e) { if(mouse_down && mouse_over) compute_color(this, true, false, false, e); return false;} );
	$('#gray').mousemove( function(e) { if(mouse_down && mouse_over) compute_color(this, false, true, false, e); return false;} );
	$('#palette').mousemove( function(e) { if(mouse_down && mouse_over) compute_color(this, false, false, true, e); return false;} );
	$('#rgb').click( function(e) { compute_color(this, true, false, false, e); return false;} );
	$('#gray').click( function(e) { compute_color(this, false, true, false, e); return false;} );
	$('#palette').click( function(e) { compute_color(this, false, false, true, e); return false;} );

	$('#cancel', panel).click( function() { panel.remove(); return false; } );
	$('#ok', panel).click( 
		function() {
			var value = color.html();

			if(value.length > 0 && value.charAt(0) =='#') {
				if(self.iframe_doc.selection) //IE fix for lost focus
					self.range.select();

				self.editor_cmd('foreColor', value);
			}
					
			panel.remove(); 
			return false;
		}
	);

	function to_hex(n) {
		var s = "0123456789abcdef";
		return s.charAt(Math.floor(n / 16)) + s.charAt(n % 16);
	}			

	function get_abs_pos(element) {
		var r = { x: element.offsetLeft, y: element.offsetTop };

		if (element.offsetParent) {
			var tmp = get_abs_pos(element.offsetParent);
			r.x += tmp.x;
			r.y += tmp.y;
		}

		return r;
	};
			
	function get_xy(obj, event) {
		var x, y;
		event = event || window.event;
		var el = event.target || event.srcElement;

		// use absolute coordinates
		var pos = get_abs_pos(obj);

		// subtract distance to middle
		x = event.pageX  - pos.x;
		y = event.pageY - pos.y;

		return { x: x, y: y };
	}
			
	function compute_color(obj, is_rgb, is_gray, is_palette, e) {
		var r, g, b, c;

		var mouse = get_xy(obj, e);
		var x = mouse.x;
		var y = mouse.y;

		if(is_rgb) {
			r = (x >= 0)*(x < part_width)*255 + (x >= part_width)*(x < 2*part_width)*(2*255 - x * 255 / part_width) + (x >= 4*part_width)*(x < 5*part_width)*(-4*255 + x * 255 / part_width) + (x >= 5*part_width)*(x < 6*part_width)*255;
			g = (x >= 0)*(x < part_width)*(x * 255 / part_width) + (x >= part_width)*(x < 3*part_width)*255	+ (x >= 3*part_width)*(x < 4*part_width)*(4*255 - x * 255 / part_width);
			b = (x >= 2*part_width)*(x < 3*part_width)*(-2*255 + x * 255 / part_width) + (x >= 3*part_width)*(x < 5*part_width)*255 + (x >= 5*part_width)*(x < 6*part_width)*(6*255 - x * 255 / part_width);

			var k = (height - y) / height;

			r = 128 + (r - 128) * k;
			g = 128 + (g - 128) * k;
			b = 128 + (b - 128) * k;
		} else if (is_gray) {
			r = g = b = (height - y) * 1.7;
		} else if(is_palette) {
			x = Math.floor(x / 10);
			y = Math.floor(y / 10);
			c = colors[x + y * 5];
		}

		if(!is_palette)
			c = '#' + to_hex(r) + to_hex(g) + to_hex(b);

		preview.css('background', c);
		color.html(c);
	}
}

function lwrte_image() {
	var self = this;
	var panel = self.create_panel('Insert image', 385);
	panel.append('\
<p><label>URL</label><input type="text" id="url" size="30" value=""><button id="view">View</button></p>\
<div class="clear"></div>\
<p class="submit"><button id="ok">Ok</button><button id="cancel">Cancel</button></p>'
).show();

	var url = $('#url', panel);

	$('#view', panel).click( function() {
			(url.val().length >0 ) ? window.open(url.val()) : alert("Enter URL of image to view");
			return false;
		}
	);
			
	$('#cancel', panel).click( function() { panel.remove(); return false;} );
	$('#ok', panel).click( 
		function() {
			var file = url.val();
			self.editor_cmd('insertImage', file);
			panel.remove(); 
			return false;
		}
	)
}

function lwrte_unformat() {
	this.editor_cmd('removeFormat');
	this.editor_cmd('unlink');
}

function lwrte_clear() {
	if(confirm('Clear Document?')) 
		this.set_content('');
}

function lwrte_link() {
	var self = this;
	var panel = self.create_panel("Create link", 385);

	panel.append('\
<p><label>URL</label><input type="text" id="url" size="30" value=""><button id="view">View</button></p>\
<div class="clear"></div>\
<p><label>Title</label><input type="text" id="title" size="30" value=""><label>Target</label><select id="target"><option value="">default</option><option value="_blank">new</option></select></p>\
<div class="clear"></div>\
<p class="submit"><button id="ok">Ok</button><button id="cancel">Cancel</button></p>'
).show();

	$('#cancel', panel).click( function() { panel.remove(); return false; } );

	var url = $('#url', panel);

	$('#view', panel).click( function() {
		(url.val().length >0 ) ? window.open(url.val()) : alert("Enter URL to view");
		return false;
	});

	$('#ok', panel).click( function() {
			var url = $('#url', panel).val();
			var target = $('#target', panel).val();
			var title = $('#title', panel).val();

			if(self.get_selected_text().length <= 0) {
				alert('Select the text you wish to link!');
				return false;
			}

			panel.remove(); 

			if(url.length <= 0)
				return false;

			self.editor_cmd('unlink');

			// we wanna well-formed linkage (<p>,<h1> and other block types can't be inside of link due to WC3)
			self.editor_cmd('createLink', url);
			
			var tmp = $('<span></span>').html('<a href="' + url + '">'+self.get_selected_html()+'</a>');
			
			if(target.length > 0)
				$('a[href*="' + url + '"]', tmp).attr('target', target);

			if(title.length > 0)
				$('a[href*="' + url + '"]', tmp).attr('title', title);
				
				

			$('a[href*="' + url + '"]', tmp).attr('href', url);
				
			self.selection_replace_with(tmp.html());
			return false;
	});
}
