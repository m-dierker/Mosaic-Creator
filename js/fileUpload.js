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

var filesLoaded = false;

function setupFileUpload() {
    'use strict';

	$('#fileupload').fileupload();

    // Initialize the jQuery File Upload widget:
    $('#fileupload').fileupload('option', {
            maxFileSize: 20000000,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
            resizeMaxWidth: 1920,
            resizeMaxHeight: 1200
        });


    if(!filesLoaded)
    {
        filesLoaded = true;
        // Load existing files:
        $('#fileupload').each(function () {
            var that = this;
            $.getJSON(this.action, function (result) {
                if (result && result.length) {
                    $(that).fileupload('option', 'done')
                        .call(that, null, {result: result});
                    }
            });
        });
    }

}
