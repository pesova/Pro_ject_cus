<script>
    var edit_input = document.querySelector("#editphone");

    $("#editphone").keyup(() => {
        if ($("#editphone").val().charAt(0) == 0) {
            $("#editphone").val($("#editphone").val().substring(1));
        }
    });

    var edit_test = window.intlTelInput(edit_input, {
                separateDialCode: true,
                // autoHideDialCode:true,
               


             });

    // $(".open_edit_store").click(function(event){
        function open_edit_store(element){
        
             edit_test.setNumber("+" + (element.dataset.store_phone_full));
            let store_name = element.dataset.store_name;
            let store_tagline = element.dataset.store_tagline;
            let store_email = element.dataset.store_email;
            let store_address = element.dataset.store_address;
            // let store_phone = element.dataset.store_phone;
            let store_id = element.dataset.store_id;

            $("#edit_store_name").val(store_name);
            $("#edit_tagline").val(store_tagline);
            // $("#editphone").val(store_phone);
            // $("#edit_phone_number").val(store_phone);
            $("#edit_email").val(store_email);
            $("#edit_shop_address").val(store_address);


            let form_url = "{{route('store.update','1')}}";
            let formatted_url = form_url.replace('1',store_id);
            $("#editStore_form").attr('action',formatted_url);

            // console.log(formatted_url);
        }
       
    // })


    $("#editStore_form").submit((e) => {
        e.preventDefault();
        const dialCode = edit_test.getSelectedCountryData().dialCode;
        if ($("#editphone").val().charAt(0) == 0) {
            $("#editphone").val($("#editphone").val().substring(1));
        }
        console.log(dialCode);
        $("#edit_phone_number").val(dialCode + $("#editphone").val());
        $("#editStore_form").off('submit').submit();
    });
</script>