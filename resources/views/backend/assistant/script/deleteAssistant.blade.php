<script>
    function deleteAssistant(element){
        let assistant_id = element.dataset.assistant_id;
        $('.assistant-name').text(element.dataset.assistant_name);
        let form_url = "{{route('assistants.destroy','1')}}";
          let formatted_url = form_url.replace('1',assistant_id);
          $("#deleteForm").attr('action',formatted_url);
    }
</script>