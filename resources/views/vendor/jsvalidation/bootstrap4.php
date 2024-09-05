<script>
    jQuery(document).ready(function(){

        $("<?= $validator['selector']; ?>").each(function() {
            $(this).validate({
                errorElement: 'span',
                errorClass: 'invalid-feedback',

                errorPlacement: function (error, element) {
                    if (element.parent('.input-group').length ||
                        element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
                        error.insertAfter(element.parent());
                        // else just place the validation message immediately after the input
                    } else if(element.attr('data-select2-id') !== typeof undefined && element.next('.select2-container').length) {
                        element.next('.select2-container').find('.select2-selection').css({"border":"1px solid #F64E60"})
                        element.next('.select2-container').append(error);
                    } else {
                        error.insertAfter(element);
                        if(element.parent().hasClass('row'))
                        {
                         error.css("margin-left","20%")
                        }
                    }
                },
                highlight: function (element) {
                    $(element).closest('.form.control').removeClass('is-valid').addClass('is-invalid'); // add the Bootstrap error class to the control group
                },

                <?php if (isset($validator['ignore']) && is_string($validator['ignore'])): ?>

                ignore: "<?= $validator['ignore']; ?>",
                <?php endif; ?>

                
                 // Uncomment this to mark as validated non required fields
                unhighlight: function(element) {
                    $el = $(element);
                    
                    if($el.attr('data-select2-id') !== typeof undefined && $el.next('.select2-container').length) {
                        $el.next('.select2-container').find('.select2-selection').css({"border":"1px solid #2f374b"})
                    } else {
                        $(element).closest('.form-control').removeClass('is-invalid').addClass('is-valid');
                    }
                },
                
                success: function (element) {
                    $(element).closest('.form.control').removeClass('is-invalid').addClass('is-valid'); // remove the Boostrap error class from the control group
                },

                focusInvalid: false, // do not focus the last invalid input
                <?php if (Config::get('jsvalidation.focus_on_error')): ?>
                invalidHandler: function (form, validator) {

                    if (!validator.numberOfInvalids())
                        return;

                    $('html, body').animate({
                        scrollTop: $(validator.errorList[0].element).offset().top
                    }, <?= Config::get('jsvalidation.duration_animate') ?>);
                    $(validator.errorList[0].element).focus();

                },
                <?php endif; ?>

                rules: <?= json_encode($validator['rules']); ?>
            });
        });
    });
</script>
