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

        }
    });

	$('.collection').collection({
        position_field_selector: '.my-position',
        allow_duplicate: false,
        after_init: function(collection) {
            $('.collection input[type=hidden]:not(.is-image)').each(function(i) {
                if ($('.is-image').eq(i).val()) {
                    $(this).after('<img class="preview-image" src="/uploads/'+ $(this).val() +'"/>');
                } else {
                    $(this).after('<div class="preview-noimage">Нет превью</div>');
                }
            });
        }
    });
});
