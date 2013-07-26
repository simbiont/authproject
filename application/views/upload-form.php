<!-- <h4>HTML 5 runtime</h4> -->

<div id="alarm"></div>

<div id="html5_uploader">You browser doesn't support native upload. Try Firefox 3 or Safari 4.</div>

<script type="text/javascript">

    $(function() {
        var base = "<?php echo base_url(); ?>";
        // Setup html5 version
        var uploader = $("#html5_uploader").pluploadQueue({
            runtimes : 'html5',
            url : base+'upload/processing/<?php echo $page; ?>',
            max_file_size : '10mb',
            unique_names : true,
            init: attachCallbacks,
        });

    });
    function attachCallbacks(uploader) {
        uploader.bind('FileUploaded', function(up, file, response){
            // var response = jQuery.parseJSON(response.response);
            if( response.response == "1" ) {
                $('#alarm').append("<div class='alert alert-error'>File size exceeded</div>");
            } else if (response.response == "upload") {
                $('#alarm').append("<div class='alert alert-success'>Your file ("+file.name+") successfully sended to admin</div>");
            } else if (response.response == "reload") {
                $("#tblJQGrid").trigger('reloadGrid');
            } else if (response.response == "failed") {
                $('#alarm').append("<div class='alert alert-error'>Email sending failed. Try again.</div>");
            } else if (response.response == "file_type") {
                $('#alarm').append("<div class='alert alert-error'>Wrong file type</div>");                
            }  
            $('.plupload_buttons').show();
            $('.plupload_upload_status').hide();
        });
    }




</script>