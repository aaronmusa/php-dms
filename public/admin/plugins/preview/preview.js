/**
 * PREVIEW.JS
 * Previews an image file
 * Author: Kiel Lago - HTECH CORP 2016
 */
$.fn.preview = function() {
    var input = this;
    $(input).change(function(){
        if($(input).val() !== null && $(input).val() != ""){
            generatePreview($(input)[0], $(input).data('target'), 0, input);
        }
    });
    if($('#remove-preview').length > 0 && $($(input).data('target')).attr('src') != ""){
        $('#remove-preview').show().click(function(){
            $($(input).data('target')).attr('src', '');
            $($(input)[0]).val('');
            $(this).hide();
            $('#with-preview').remove();
        });
    }
};

/**
 * Generates a preview of the uploaded image
 * @param  {[type]} input     must be document.getElementById()
 * @param  {[type]} className class name of the image tag
 * @param  {[type]} index     if file upload is set to multiple, pass the index number here. Default is 0
 * @return {[type]}           do not do anything here. It will just do the magic.
 */
function generatePreview(input, target, index, origin) {
    if(index === undefined){
        index = 0;
    }
    if (input.files && input.files[index]) {
        var _URL = window.URL || window.webkitURL;
        var control = $(origin);
        displayPreview(input,target,index);
    }
}

function displayPreview(input,target,index){
    var reader = new FileReader();
    reader.onload = function (e) {
        $(target).attr('src', e.target.result);
        if($('#with-preview').length == 0){
            $(target).after('<input type="hidden" name="withPreview" id="with-preview" value="1"/>');
        }
    }
    reader.readAsDataURL(input.files[index]);

    if($('#remove-preview').length > 0){
        $('#remove-preview').show().click(function(){
            $(target).attr('src', '');
            $(input).val('');
            $(this).hide();
            $('#with-preview').remove();
        });
    }

}