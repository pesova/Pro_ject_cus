<script>
    
    var edit_input = document.querySelector("#edit_phone");
  
  $("#edit_phone").keyup(() => {
      if ($("#edit_phone").val().charAt(0) == 0) {
          $("#edit_phone").val($("#edit_phone").val().substring(1));
      }
  });
  
  var edit_test = window.intlTelInput(edit_input, {
      separateDialCode: true,
      placeholder: true,
   });
  
   $("#editForm").submit((e) => {
          e.preventDefault();
          const dialCode = edit_test.getSelectedCountryData().dialCode;
          if ($("#edit_phone").val().charAt(0) == 0) {
              $("#edit_phone").val($("#edit_phone").val().substring(1));
          }
          $("#edit_phone_number").val(dialCode + $("#edit_phone").val());
          $("#editForm").off('submit').submit();
      });
  
  
      function open_edit_assistant(element){
  
          edit_test.setNumber("+" + (element.dataset.assistant_phone));
          let store_id = element.dataset.store_id;
          let assistant_id = element.dataset.assistant_id;
  
          $("#edit_name").val(element.dataset.assistant_name);
          $("#edit_email").val('');
          $("#edit_email").val(element.dataset.assistant_email);
  
  
          $('#edit_store_id > option').each(function() {
           if($(this).val() == store_id){
               $(this).attr('selected','selected');
           };
          });
  
  
          
          let form_url = "{{route('assistants.update','1')}}";
          let formatted_url = form_url.replace('1',assistant_id);
          $("#editForm").attr('action',formatted_url);
          // console.log(formatted_url);
          
      }
  </script>