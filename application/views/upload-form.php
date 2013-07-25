<h4>HTML 5 runtime</h4>
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
            preinit: attachCallbacks,
        });
    });
    function attachCallbacks(uploader) {
        uploader.bind('FileUploaded', function(up, file, response){
            // var response = jQuery.parseJSON(response.response);
            if( response == "1" ) {
                alert('Huge Filesize');
            }

        });
    }


</script>