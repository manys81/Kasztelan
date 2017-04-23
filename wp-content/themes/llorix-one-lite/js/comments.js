// validate the comment form when it is submitted
/////////////////////////////////////////////////
function resetForm(){
    jQuery('#commentform').reset();
    validator.resetForm();
}

function validateForm(){
    if (validator.form()) {
        jQuery('#commentform').submit();
    }
}

validator = jQuery("#commentform").validate({
    rules: {
        author: "required",
        comment: "required"

    },
    messages: {
        author: "Proszę podać nick",
        comment: "Proszę wpisać komentarz"
    }
});
