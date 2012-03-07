$(document).ready(function() {
	checkURL();	
	$("a.inline-nav").click(function(){
		checkURL(this);
	});
	
	$("#inline-content").focus(function(){
		if($("#inline-content").val()=='What\'s happening?'){ $("#inline-content").toggleClass('selected'); $("#inline-content").val(''); $("#inline-content").next().show(); }
	});
	$("#inline-content").blur(function(event){
		if($("#inline-content").val()==''){ $("#inline-content").next().hide(); $("#inline-content").toggleClass('selected'); $("#inline-content").val('What\'s happening?'); }
	});
	
	$("#upload-photo").uploadify({
		'method'		 : 'GET',
		'uploader'       : '/js/uploadify/uploadify.swf',
		'script'         : '/interface/dashboard/upload.php',
		'buttonText'	 : 'Select Photos',
		'fileDataName'	 : 'photo',
		'scriptData'	 : { 'cookie-data' : document.cookie, 'photos-publish-option' : $("form#post-photos select[name='photos-publish-option']").val(), 'photos-tags' : $("form#post-photos textarea[name='photos-tags']").val() },
		'cancelImg'      : '/images/cancel.png',
		'queueID'        : 'photosQueue',
		'auto'           : false,
		'multi'          : true,
		'scriptAccess' 	 : 'always',
		'fileDesc'		 : 'Image Files (.jpg, .png, .gif)',
		'fileExt'		 : '*.jpg;*.jpeg;*.JPG;*.JPEG;*.png;*.PNG;*.gif;*.GIF',
		onComplete : function(event, queueID, fileObj, response, data) {
			if (response.errorMsg) {
				$.lightbox(response.errorMsg);
			}
			return true;
		},
		onAllComplete: function(event, data) {
			hideOperation('#post-photos', $('#photos-button').parent());
			$('#post-photos input:text').val('');
			$('#post-photos textarea').val('');
			$('#post-photos option[value="now"]').attr('selected', 'selected');
		}
	});

	$("#upload-video").uploadify({
		'method'		 : 'GET',
		'uploader'       : '/js/uploadify/uploadify.swf',
		'script'         : '/interface/dashboard/upload.php',
		'buttonText'	 : 'Select Videos',
		'fileDataName'	 : 'video',
		'scriptData'	 : { 'cookie-data' : document.cookie, 'videos-publish-option' : $("form#post-videos select[name='videos-publish-option']").val(), 'videos-tags' : $("form#post-videos textarea[name='videos-tags']").val() },
		'cancelImg'      : '/images/cancel.png',
		'queueID'        : 'videosQueue',
		'auto'           : false,
		'multi'          : true,
		'scriptAccess' 	 : 'always',
		'fileDesc'		 : 'Video Files (.avi, .mpeg, .wmv, .3gp, .mp4, .mov, .flv)',
		'fileExt'		 : '*.avi;*.mpeg;*.mpg;*.wmv;*.3gp;*.mp4;*.mov;*.flv',
		onComplete : function(event, queueID, fileObj, response, data) {
			if (response.errorMsg) {
				$.lightbox(response.errorMsg);
			}
			return true;
		},
		onAllComplete: function(event, data) {
			hideOperation('#post-videos', $('#videos-button').parent());
			$('#post-videos input:text').val('');
			$('#post-videos textarea').val('');
			$('#post-videos option[value="now"]').attr('selected', 'selected');
		}
	});
	
	$("#upload-file").uploadify({
		'method'		 : 'GET',
		'uploader'       : '/js/uploadify/uploadify.swf',
		'script'         : '/interface/dashboard/upload.php',
		'buttonText'	 : 'Select Files',
		'fileDataName'	 : 'file',
		'scriptData'	 : { 'cookie-data' : document.cookie },
		'cancelImg'      : '/images/cancel.png',
		'queueID'        : 'filesQueue',
		'auto'           : false,
		'multi'          : true,
		'scriptAccess' 	 : 'always',
		'fileDesc'		 : 'All Files',
		'fileExt'		 : '*.*',
		onComplete : function(event, queueID, fileObj, response, data) {
			$.lightbox(response);
			return true;
		},
		onAllComplete: function(event, data) {
			hideOperation('#post-files', $('#files-button').parent());
			$('#post-files input:text').val('');
			$('#post-files textarea').val('');
			$('#post-files option[value="now"]').attr('selected', 'selected');
		}
	});
	
	var arr = $('textarea.wysiwyg').rte({
		css: ['default.css'],
		width: 520,
		height: 220,
		controls_rte: rte_toolbar
	});
	
	$("#post-text").data("editor", arr['post-content']);
	
	$("#link-url").blur(function(){
		var url = $("#link-url").val();
		if (url) {
			$.loading("Updating the title...");
			$.get("/interface/dashboard/get.php?get=url-title&url="+url, function(title){
				$("#link-title").val(title);
				$.loading.done();
			});
		}
	});
	
	$("#sub-upload-photos").click(function(){
		$("#upload-photo").uploadifySettings('scriptData', {
			'cookie-data' : document.cookie,
			'photos-publish-option' : $("form#post-photos select[name='photos-publish-option']").val(),
			'photos-tags' : $("form#post-photos textarea[name='photos-tags']").val() 
		});
		$('#upload-photo').uploadifyUpload();
		return false;
	});
	
	$("#sub-upload-videos").click(function(){
		$("#upload-video").uploadifySettings('scriptData', {
			'cookie-data' : document.cookie,
			'videos-publish-option' : $("form#post-videos select[name='videos-publish-option']").val(),
			'videos-tags' : $("form#post-videos textarea[name='videos-tags']").val() 
		});
		$('#upload-video').uploadifyUpload();
		return false;
	});
	
	$("#quick-feedback-form .sub-button").click(function(){
		$.ajax({
			type: "POST",
			url: "/interface/dashboard/feedback.php",
			data: "body="+$("#quick-feedback-form textarea").val()+"&subject="+$("#quick-feedback-form .text").val(),
			beforeSend: function(){
				$.loading('Submitting...');
			},
			success: function(response){
				$.loading.done();
			},
			complete: function(){
				$('#quick-feedback-form').toggle();$('#quick-feedback-overlay').toggle();
			}
		});
	});
});

(function($) {
	$.loading = function(msg){
		if(!msg)
			msg = "Loading..."	
		$('#loading').html(msg);
		$('#loading').removeClass("done");
		$('#loading').show();
	}
	
	$.extend($.loading, {
		done: function(flag){
			if (flag) {
				$('#loading').fadeOut("slow", function(){
					$('#loading').removeClass("done");
				});
			}
			else {
				$('#loading').hide();
				$('#loading').removeClass("done");
			}
		},
		fadingMsg: function(msg, time){
			$('#loading').html(msg);
			$('#loading').addClass("done");			
			$('#loading').show();
			if(!time)
				time = 2000;
			setTimeout("$.loading.done(true);", time)
		}
	});
})(jQuery);

function checkURL(elem){
	if(!elem){
		hash=window.location.hash;
		if(!hash) hash='#home';
		loadContent(hash.substr(1), null, window.location.search.substr(1));
	} else
		loadContent(elem.hash.substr(1), elem, elem.search.substr(1));
}

function loadContent(content, elem, params){
	$.ajax({
		type: "GET",
		url: "/interface/admin/controller.php",
		data: "content="+content+"&"+params,
		beforeSend: function(){
			$.loading();
			$('#main-nav .selected').removeClass('selected');
		},
		success: function(content){
			$('#main-contents').html(content);
		},
		complete: function(XMLHttpRequest, textStatus){
			if(elem){
				$(elem).parent().addClass('selected');
				$(elem).parents('#main-nav li').addClass('selected');
			} else {
				$('a[href=#'+content+']').parent().addClass('selected');
				$('a[href=#'+content+']').parents('#main-nav li').addClass('selected');
			}
			$.loading.done();
			
			if(content == 'manage/blog'){
				var arr = $('textarea.wysiwyg').rte({
					css: ['default.css'],
					width: 520,
					height: 220,
					controls_rte: rte_toolbar
				});				
				$("#blog-posts").data("editors", arr);
			}
		}
	});
}

function toggleOperation(className, elem){
	if (!$(className).is('.selected')) {
		$('#main-options .selected').removeClass('selected');
		$('#main-operations .selected').hide();
		$('#main-operations .selected').removeClass('selected');
	}
	$(elem).toggleClass('selected');
	$(className).slideToggle('fast');
	$(className).toggleClass('selected');	
}

function hideOperation(className, elem){
	if(className && elem){
		$(elem).removeClass('selected');
		$(className).slideUp('fast');
		$(className).removeClass('selected');
	} else {
		$('#main-options .selected').removeClass('selected');
		$('#main-operations .selected').hide();
		$('#main-operations .selected').removeClass('selected');
	}	
}

function post(action, params){
	$.ajax({
		type: "POST",
		dataType: "json",
		url: "/interface/dashboard/upload.php",
		data: "action="+action+"&"+params,
		beforeSend: function(){
			$.loading("Uploading...");
		},
		success: function(response){
			if (response.errorMsg) {
				$.lightbox(response.errorMsg);
				$.loading.done();
			}
			else {
				if(action == 'post-blog' || action=='post-link'){
					if(action == 'post-blog'){
						hideOperation('#post-text', $('#text-button').parent());
						$('#post-text').data('editor').set_content('');
						$('#post-text input:text').val('');
						$('#post-text textarea').val('');
						$('#post-text option[value="now"]').attr('selected', 'selected');
					} else {
						hideOperation('#post-link', $('#link-button').parent());
						$('#post-link input:text').val('');
						$('#post-link textarea').val('');
						$('#post-link option[value="now"]').attr('selected', 'selected');
					}
					$.loading.fadingMsg("Uploaded!");	
				}				
			}	
		}
	});
}

function editPost(action, params){
	$.ajax({
		type: "GET",
		dataType: "json",
		url: "/interface/dashboard/actions.php",
		data: "action="+action+"&"+params,
		beforeSend: function(){
			$.loading("Updating...");
		},
		success: function(response){
			if (response.errorMsg) {
				$.lightbox(response.errorMsg);
				$.loading.done();
			}
			else 
				$.loading.fadingMsg("Updated!");
		}
	});
}

function updateData(action, params, reload){
	$.ajax({
		type: "POST",
		dataType: "json",
		url: "/interface/dashboard/actions.php",
		data: "action="+action+"&"+params,
		beforeSend: function(){
			$.loading("Updating...");
		},
		success: function(response){
			if (response.errorMsg) {
				$.lightbox(response.errorMsg);
				$.loading.done();
			}
			else {
				$.loading.fadingMsg("Updated!");
				if(reload && reload != undefined)
					checkURL();
			}
		},
		complete: function(XMLHttpRequest, textStatus){

		}
	});
}

function delPost(postID, pointer){
	$.ajax({
		type: "GET",
		dataType: "json",
		url: "/interface/dashboard/actions.php",
		data: "action=del-post&postID="+postID,
		beforeSend: function(){
			$.loading("Deleting...");
		},
		success: function(response){
			if (response.errorMsg) {
				$.lightbox(response.errorMsg);
				$.loading.done();
			}
			else {
				$(pointer).fadeOut('slow', function() {
				    $(pointer).remove();
				});
			}
		},
		complete: function(XMLHttpRequest, textStatus){
			$.loading.fadingMsg("Deleted!");
		}
	});
}

function unlinkService(service){
	$.ajax({
		type: "GET",
		dataType: "json",
		url: "/interface/dashboard/actions.php",
		data: "action=unlink-service&service="+service,
		beforeSend: function(){
			$.loading("Unlinking...");
		},
		success: function(response){
			if (response.errorMsg) {
				$.lightbox(response.errorMsg);
				$.loading.done();
			}
			else {
				checkURL();
			}
		},
		complete: function(XMLHttpRequest, textStatus){
			$.loading.fadingMsg("Unlinked!");
		}
	});
}

function showPostEditor(s3name, pointer, num){
	if ($(pointer).children('.loading').is(':hidden') && $(pointer).children('.post-box').is(':hidden')) {
		if (!$(pointer).data("loaded")) {
			$.ajax({
				type: "GET",
				dataType: "json",
				url: "/interface/dashboard/get.php",
				data: "get=blog-content&s3name=" + s3name,
				beforeSend: function(){
				},
				success: function(response){
					if (response.errorMsg) 
						$.lightbox(response.errorMsg);
					else {
						var editors = $("#blog-posts").data("editors");
						editors['post-content-' + num].set_content(response.content)
						$(pointer).children('.loading').hide();
						$(pointer).children('.post-box').fadeIn('fast');
						$(pointer).data("loaded", true);
					}
				}
			});
			$(pointer).children('.loading').slideDown('fast');
			$(pointer).toggleClass('selected');
			$(pointer).find('.edit').html('&uarr;');
		} else {
			$(pointer).toggleClass('selected');
			$(pointer).find('.edit').html('&uarr;');
			$(pointer).children('.post-box').slideDown('fast');
		}
	} else if($(pointer).children('.loading').is(':hidden')) {
		$(pointer).children('.post-box').slideUp('fast');
		$(pointer).children('.loading').slideUp('fast');
		$(pointer).toggleClass('selected');	
		$(pointer).find('.edit').html('&darr;');
	}
}
