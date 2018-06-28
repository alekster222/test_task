$(function(){
	$('.upload-dropzone').dropzone({
        url: Routing.generate('document_file_upload'),
        addRemoveLinks: true,
        dictRemoveFile: 'Удалить',
        removedfile: function (file) {
            var name = file.name;
            $.ajax({
                type: 'POST',
                url: Routing.generate('document_file_remove'),
                data: {name: name},
                success: function (data) {
                    console.log('success: ' + data);
                }
            });
            var _ref;
            return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
        },
        init: function() {
            var imgDropzone = this;
            files = JSON.parse($('.uploads').val());

            $.each(files, function(i) {
                previewThumbailFromUrl({
                    selector: '.upload-dropzone',
                    fileName: this.orig_name,
                    imageURL: '/uploads/' + this.name,
					size: this.filesize
                });
            });

            function previewThumbailFromUrl(opts) {
                var mockFile = {
                    name: opts.fileName,
                    size: opts.size,
                    accepted: true,
                    kind: 'image'
                };
                imgDropzone.emit("addedfile", mockFile);
                imgDropzone.files.push(mockFile);
                imgDropzone.createThumbnailFromUrl(mockFile, opts.imageURL, function() {
                    imgDropzone.emit("complete", mockFile);
                });
            }
        }
    });
	
	$('.collection').collection({
            position_field_selector: '.my-position',
            allow_duplicate: false
        });
});