<h4>HTML 5 runtime</h4>
<div id="html5_uploader">You browser doesn't support native upload. Try Firefox 3 or Safari 4.</div>

<?php
    // dummy $project_id
    $project_id = 1;
?>

<script type="text/javascript">

    $(function() {

        // Setup html5 version
        $("#html5_uploader").pluploadQueue({
            runtimes : 'html5',
            url : 'processing/<?php echo $project_id; ?>',
            max_file_size : '10mb',
            unique_names : true,
            filters : [
                {title : "Image files", extensions : "jpg,gif,png"},
                {title : "Zip files", extensions : "zip"}
            ]
        });

    });

</script>
