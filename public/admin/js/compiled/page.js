$(document).ready(function(){
    if ($("#is-preview").val() == 1) {
        url = new URL(window.location.protocol + $("#preview-url").val() + '/' + $("#slug").val()+'?preview=true');
        window.open(url);
    }

    $('input[type="file"][data-type="image"]').each(function(){
        $(this).preview();
    });

    tinymce.init({
        selector: "textarea.tinymce",
        theme: "modern",
        height: 300,
        relative_urls : false,
        remove_script_host : false,
        convert_urls : true,
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
    // setTimeout(function(){
    //     document.getElementById('mceu_22').style.borderWidth = '0px';
    // }, 200);

    $('.datetime').inputmask('m/d/y h:s', { placeholder: '__/__/____ __:__', alias: "datetime", hourFormat: '24' });

    $('form').submit(function(){
        var id = $("button[type=submit][clicked=true]").attr('id');
        if(id == "draft"){
            $('#published').val(0);
        }
        else if (id == "btn-preview") {
            $('#published').val(0);
            $('#preview').val(1);
        }
        else{
            $('#published').val(1);
        }
    });
    $("form button[type=submit]").click(function() {
        $("input[type=submit]", $(this).parents("form")).removeAttr("clicked");
        $(this).attr("clicked", "true");
    });

    $('#category').change(function(){
        var category = $(this);
        var subcategory = $('#subcategory');
        if(category.val() == ""){
            $('.subcategory-inline').addClass('hidden');
            subcategory.html('');
            return;
        }
        $.ajax({
            type: 'GET',
            url: baseUrl + 'subcategories/' + $(this).val(),
            dataType: 'json',
            success: function(response) {
                if(response.status){
                    if(response.data.length > 0){
                        $('.subcategory-inline').removeClass('hidden');
                        var html = '';
                        $(response.data).each(function(i, subcategory){
                            html += '<option value="'+subcategory.slug+'">' + subcategory.name + '</option>';
                        });
                        subcategory.html(html);
                        subcategory.selectpicker('refresh');
                    }else{
                        $('.subcategory-inline').addClass('hidden');
                    }
                }
            },
            error: function(xhr, textStatus, errorThrown) {
                if(xhr.status == 500){
                    swal({
                        title: 'Oops!',
                        text: 'Something is wrong with the server right now. Please try again later',
                        type: 'error'
                    }, function() {
                        location.reload();
                    });
                }
            }
        });
    });
});
