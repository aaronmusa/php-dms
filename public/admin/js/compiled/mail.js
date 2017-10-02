$(document).ready(function(){
    tinymce.init({
        selector: "textarea.tinymce",
        theme: "modern",
        height: 300,
        plugins: [
            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking save table contextmenu directionality',
            'emoticons template paste textcolor colorpicker textpattern imagetools'
        ],
        toolbar1: 'insertfile undo redo | styleselect | fontselect fontsizeselect bold italic | alignleft aligncenter alignright alignjustify',
        toolbar2: 'bullist numlist outdent indent | link image | print preview media | forecolor backcolor',
        image_advtab: true,
        border: 'none'
    });
    tinymce.suffix = ".min";
    // tinyMCE.baseURL = '../../plugins/tinymce';
    setTimeout(function(){
        document.getElementById('mceu_22').style.borderWidth = '0px';
    }, 200);

    $(document).on('focusin', function(e) {
        if ($(e.target).closest(".mce-window").length) {
            e.stopImmediatePropagation();
        }
    });
});
