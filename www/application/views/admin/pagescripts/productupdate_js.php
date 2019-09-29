<script type="text/javascript">
    var shopping_category = $.parseJSON('<?=json_encode($shopping_category)?>');

    $(document).on('change' , 'input[name=pro_image]' , function(){
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

    $(document).on('click' , '.add_seller_row' , function(){
        if ($('#sellers_table tbody tr').last().find('td').eq(1).find('input').val() != '' && $('#sellers_table tbody tr').last().find('td').eq(3).find('input').val() != '') {
            option_html = '<option></option>';
            for (var i = 0 ; i < shopping_category.length ; i ++) {
                option_html += '<option value = "' + shopping_category[i].shop_cat_id + '">' + shopping_category[i].shoppingcat_name + '</option>';
            }
            html = '<tr><td><select class="form-control" name="shop_cat_id[]">' + option_html + '</select></td><td><input type="text" class="form-control" name="shop_name[]"></td><td><input type="text" class="form-control" name="shop_url[]"></td><td><input type="text" class="form-control" name="price[]"></td><td><button class="btn btn-sm btn-danger del_seller_row"><i class="fa fa-trash"></i></button></td></tr>';
            $('#sellers_table tbody').append(html);
        }
    })

    $(document).on('click' , '.del_seller_row' , function(){
        $(this).parents('tr').remove();
    })

    var handleSubmit = function() {
        $('.new_product_form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                pro_title: {
                    required: true
                },
                // pro_alias: {
                //     required: true
                // },
                // pro_cat_new_id: {
                //     required: true
                // },
                pro_ingredients: {
                    required: true
                },
            },

            messages: {
                pro_title: {
                    required: "这是必填栏。"
                },
                // pro_alias: {
                //     required: "这是必填栏。"
                // },
                // pro_cat_new_id: {
                //     required: "这是必填栏。"
                // },
                pro_ingredients: {
                    required: "这是必填栏。"
                },
            },

            invalidHandler: function (event, validator) { //display error alert on form submit   
                $('.alert-danger', $('.new_product_form')).show();
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

    function movieFormatResult(repo) {
        if (repo.loading) {
            return repo.text;
        }

        var markup = "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__meta' data-id='" + repo.id + "'>" +
              "<div class='select2-result-repository__title'>" + repo.ing_name + "</div>";

        markup += '</div></div>';
        return markup;
    }

    function movieFormatSelection(repo) {
        var option_html = '<option value="' + repo.id + '">' + repo.ing_name + '</option>';
        $('#pro_ingredients').prepend(option_html);
        $('#pro_efficacy_ingredients').prepend(option_html);
        return repo.ing_name || repo.text;
    }

    $("#pro_ingredients_load_remote_data").select2({
        placeholder: "搜索成分",
        minimumInputLength: 1,
        ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
            url: site_url + "admin/product/get_ingredient",
            dataType: 'json',
            data: function (term, page) {
                return {
                    q: term, // search term
                };
            },
            results: function (data, page) { // parse the results into the format expected by Select2.
                // since we are using custom formatting functions we do not need to alter remote JSON data
                return {
                    results: data.results
                };
            }
        },
        formatResult: movieFormatResult, // omitted for brevity, see the source of this page
        formatSelection: movieFormatSelection, // omitted for brevity, see the source of this page
        dropdownCssClass: "bigdrop", // apply css that makes the dropdown taller
        escapeMarkup: function (m) {
            return m;
        } // we do not want to escape markup since we are displaying html in results
    });

    function companyFormatResult(repo) {
        if (repo.loading) {
            return repo.text;
        }

        var markup = "<div class='select2-result-repository clearfix'>" +
            "<div class='select2-result-repository__meta' data-id='" + repo.id + "'>" +
              "<div class='select2-result-repository__title'>" + repo.com_name + "</div>";

        markup += '</div></div>';
        return markup;
    }

    function companyFormatSelection(repo) {
        $('p#company_name').html(repo.com_name);
        $('input#pro_company_id').val(repo.id);
        return repo.com_name || repo.text;
    }

    $("#pro_company_load_remote_data").select2({
        placeholder: "搜索品牌",
        minimumInputLength: 1,
        ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
            url: site_url + "admin/product/get_company",
            dataType: 'json',
            data: function (term, page) {
                return {
                    q: term, // search term
                };
            },
            results: function (data, page) { // parse the results into the format expected by Select2.
                // since we are using custom formatting functions we do not need to alter remote JSON data
                return {
                    results: data.results
                };
            }
        },
        formatResult: companyFormatResult, // omitted for brevity, see the source of this page
        formatSelection: companyFormatSelection, // omitted for brevity, see the source of this page
        dropdownCssClass: "bigdrop", // apply css that makes the dropdown taller
        escapeMarkup: function (m) {
            return m;
        } // we do not want to escape markup since we are displaying html in results
    });
</script>