(function( $ ) {

    $.fn.imageUploadResizer = function(options) {
        var settings = $.extend({
            max_size: 1000,
            max_height: 1000,
            do_not_resize: [],
            preview: "",
        }, options );

        this.filter('input[type="file"]').each(function () {
            this.onchange = function() {
            
                const that = this; // input node
                const originalFile = this.files[0];

                if (!originalFile || !originalFile.type.startsWith('image')) {
                    return;
                }

                // Don't resize if doNotResize is set
                if (settings.do_not_resize.includes('*') || settings.do_not_resize.includes( originalFile.type.split('/')[1])) {
                    return;
                }

                var reader = new FileReader();

                reader.onload = function (e) {
                    var img = document.createElement('img');

                    img.src = e.target.result
                    img.onload = function () {
                        var canvas = document.createElement('canvas');
                        if (img.width < settings.max_size || img.height < settings.max_size) {
                            var max_size = img.width < img.height?img.width:img.height;
                            // Resize not required
                            canvas = crop(img,max_size);
                        }
                        else {
                            canvas = crop(img,settings.max_size);
                        }
                        if(settings.preview != "") {
                            $('#'+settings.preview).attr('src',canvas.toDataURL("image/jpeg"));
                        }
                    }
                }
                reader.readAsDataURL(originalFile);
                
                function crop(image, size = 500) {
                    var max_width = size;
                    var max_height = size;
    
                    var canvas = document.createElement('canvas');
                    canvas.width = size;
                    canvas.height = size;
                    var ctx = canvas.getContext('2d');
                    var sWidth = 0;
                    var sHeight = 0;
                    var startX = 0;
                    var startY = 0;
    
                    if (image.width < image.height) {
                        sWidth = image.width;
                        sHeight = image.width;
                    } else {
                        sWidth = image.height;
                        sHeight = image.height;
                    }
    
                    var width_new = image.height * max_width / max_height;
                    var height_new = image.width * max_height / max_width;
    
                    if (width_new > image.width) {
                        startY = ((image.height - height_new) / 2);
                    } else {
                        startX = ((image.width - width_new) / 2);
                    }                
                    ctx.drawImage(image, startX, startY, sWidth, sHeight, 0, 0, max_width, max_height);
                    return canvas;
                }
            }
        });

        return this;
    };

}(jQuery));