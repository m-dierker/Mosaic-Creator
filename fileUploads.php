<?php

function includeFileUploadImageGallery()
{
	?>
	<div id="modal-gallery" class="modal modal-gallery hide fade">
	    <div class="modal-header">
	        <a class="close" data-dismiss="modal">&times;</a>
	        <h3 class="modal-title"></h3>
	    </div>
	    <div class="modal-body"><div class="modal-image"></div></div>
	    <div class="modal-footer">
	        <a class="btn modal-download" target="_blank">
	            <i class="icon-download"></i>
	            <span>Download</span>
	        </a>
	        <a class="btn btn-success modal-play modal-slideshow" data-slideshow="5000">
	            <i class="icon-play icon-white"></i>
	            <span>Slideshow</span>
	        </a>
	        <a class="btn btn-info modal-prev">
	            <i class="icon-arrow-left icon-white"></i>
	            <span>Previous</span>
	        </a>
	        <a class="btn btn-primary modal-next">
	            <span>Next</span>
	            <i class="icon-arrow-right icon-white"></i>
	        </a>
	    </div>
	</div>

	<?php
}

function includeFileUploadScripts()
{
	?>

	<!-- The Templates plugin is included to render the upload/download listings -->
	<script src="http://blueimp.github.com/JavaScript-Templates/tmpl.min.js"></script>
	<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
	<script src="http://blueimp.github.com/JavaScript-Load-Image/load-image.min.js"></script>
	<!-- The Canvas to Blob plugin is included for image resizing functionality -->
	<script src="http://blueimp.github.com/JavaScript-Canvas-to-Blob/canvas-to-blob.min.js"></script>
	<!-- Bootstrap JS and Bootstrap Image Gallery are not required, but included for the demo -->
	<script src="http://blueimp.github.com/cdn/js/bootstrap.min.js"></script>
	<script src="http://blueimp.github.com/Bootstrap-Image-Gallery/js/bootstrap-image-gallery.min.js"></script>
	<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
	<script src="upload-plugin/js/jquery.iframe-transport.js"></script>
	<!-- The basic File Upload plugin -->
	<script src="upload-plugin/js/jquery.fileupload.js"></script>
	<!-- The File Upload image processing plugin -->
	<script src="upload-plugin/js/jquery.fileupload-ip.js"></script>
	<!-- The File Upload user interface plugin -->
	<script src="upload-plugin/js/jquery.fileupload-ui.js"></script>
	<!-- The localization script -->
	<script src="upload-plugin/js/locale.js"></script>
	<!-- The main application script -->
	<script src="js/fileUpload.js"></script>
	<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE8+ -->
	<!--[if gte IE 8]><script src="upload-plugin/js/cors/jquery.xdr-transport.js"></script><![endif]-->

	<!-- Bootstrap Image Gallery styles -->
	<link rel="stylesheet" href="http://blueimp.github.com/Bootstrap-Image-Gallery/css/bootstrap-image-gallery.min.css">
	<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
	<link rel="stylesheet" href="upload-plugin/css/jquery.fileupload-ui.css">


	<?php
}


function includeFileUploadTemplates()
{
	?>

	<!-- The template to display files available for upload -->
	<script id="template-upload" type="text/x-tmpl">
	{% for (var i=0, file; file=o.files[i]; i++) { %}
	    <tr class="template-upload fade">
	        <td class="preview"><span class="fade"></span></td>
	        <td class="name"><span>{%=file.name%}</span></td>
	        <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
	        {% if (file.error) { %}
	            <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
	        {% } else if (o.files.valid && !i) { %}
	            <td>
	                <div class="progress progress-success progress-striped active"><div class="bar" style="width:0%;"></div></div>
	            </td>
	            <td class="start">{% if (!o.options.autoUpload) { %}
	                <button class="btn btn-primary">
	                    <i class="icon-upload icon-white"></i>
	                    <span>{%=locale.fileupload.start%}</span>
	                </button>
	            {% } %}</td>
	        {% } else { %}
	            <td colspan="2"></td>
	        {% } %}
	        <td class="cancel">{% if (!i) { %}
	            <button class="btn btn-warning">
	                <i class="icon-ban-circle icon-white"></i>
	                <span>{%=locale.fileupload.cancel%}</span>
	            </button>
	        {% } %}</td>
	    </tr>
	{% } %}
	</script>
	<!-- The template to display files available for download -->
	<script id="template-download" type="text/x-tmpl">
	{% for (var i=0, file; file=o.files[i]; i++) { %}
	    <tr class="template-download fade">
	        {% if (file.error) { %}
	            <td></td>
	            <td class="name"><span>{%=file.name%}</span></td>
	            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
	            <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
	        {% } else { %}
	            <!--<td class="preview">{% if (file.thumbnail_url) { %}
	                <a href="{%=file.url%}" title="{%=file.name%}" rel="gallery" download="{%=file.name%}"><img src="{%=file.thumbnail_url%}"></a>
	            {% } %}</td> -->
	            <td class="name">
	                <a href="{%=file.url%}" title="{%=file.name%}" rel="{%=file.thumbnail_url&&'gallery'%}" download="{%=file.name%}">{%=file.name%}</a>
	            </td>
	            <td class="size"><span>{%=o.formatFileSize(file.size)%}</span></td>
	            <td colspan="2"></td>
	        {% } %}
	        <td class="delete">
	            <button class="btn btn-danger" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}">
	                <i class="icon-trash icon-white"></i>
	                <span>{%=locale.fileupload.destroy%}</span>
	            </button>
	            <input type="checkbox" name="delete" value="1">
	        </td>
	    </tr>
	{% } %}
	</script>


	<?php
}


?>