/*
 * jQuery File Upload Plugin JS Example 6.5.1
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */
/*jslint nomen: true, unparam: true, regexp: true */
/*global $, window, document */
$(function ()
{
	'use strict';

	// Initialize the jQuery File Upload widget:
	$$('#fileupload').fileupload('option', {
			maxFileSize: 20000000, //20 MB
			acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
			resizeMaxWidth: 1920,
			resizeMaxHeight: 1200
		});

	// Enable iframe cross-domain access via redirect option:
	$('#fileupload').fileupload('option', 'redirect', window.location.href.replace(/\/[^\/]*$/, '/cors/result.html?%s'));

    // Load existing files:
    $('#fileupload').each(function ()
    {
        var that = this;
        $.getJSON(this.action, function (result)
        {
            if (result && result.length)
            {
                $(that).fileupload('option', 'done').call(that, null, {
                result: result
                });
            }
        });
    });

});