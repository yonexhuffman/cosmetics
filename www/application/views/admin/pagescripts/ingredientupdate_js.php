<script type="text/javascript">
    var handleSubmit = function() {
        $('.new_ingredient_form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                ing_name: {
                    required: true
                },
                ing_csano: {
                    required: true
                },
                ing_usage_purpose: {
                    required: true
                },
            },

            messages: {
                ing_name: {
                    required: "这是必填栏。"
                },
                ing_csano: {
                    required: "这是必填栏。"
                },
                ing_usage_purpose: {
                    required: "这是必填栏。"
                },
            },

            invalidHandler: function (event, validator) { //display error alert on form submit   
                $('.alert-danger', $('.new_ingredient_form')).show();
            },

            highlight: function (element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            success: function (label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },

            errorPlacement: function (error, element) {
                error.insertAfter(element.closest('.form-control'));
            },

            submitHandler: function (form) {
                form.submit();
            }
        });
    }

    handleSubmit();
</script>