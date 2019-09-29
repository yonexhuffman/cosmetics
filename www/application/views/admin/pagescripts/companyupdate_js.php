<script type="text/javascript">
	var handleSubmit = function() {
		$('.new_company_form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                com_name: {
                    required: true
                },
                // com_image: {
                //     required: true , 
                // },
                com_searchkey: {
                    required: true , 
                },
                com_searchkey_alias: {
                    required: true , 
                },
            },

            messages: {
                com_name: {
                    required: "这是必填栏。"
                },
                // com_image: {
                //     required: "这是必填栏。"
                // },
                com_searchkey: {
                    required: "这是必填栏。" , 
                },
                com_searchkey_alias: {
                    required: "这是必填栏。" , 
                },
            },

            invalidHandler: function (event, validator) { //display error alert on form submit   
                $('.alert-danger', $('.new_company_form')).show();
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

        $('.new_company_form input').keypress(function (e) {
            if (e.which == 13) {
                if ($('.new_company_form').validate().form()) {
                    $('.new_company_form').submit();
                }
                return false;
            }
        });
	}

    handleSubmit();

    $(document).on('change' , 'input[name=com_image]' , function(){
        var input = $(this)[0];
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#preview_image').show();
                $('#preview_image').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    })
</script>