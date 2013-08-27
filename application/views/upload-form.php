<!-- <h4>HTML 5 runtime</h4> -->
<div id="files_grid" class="span10 offset1">
    <div id="alarm"></div>
    <button id="pickfiles" class="btn">Select files</button>
    <button id="uploadfiles" class="btn">Upload files</button>
    <button id="csvExample" class="btn">CSV Example</button>
    <div id="filelist">No runtime found.</div>
</div>
<script type="text/javascript">

    $(function() {
        console.log(document.location);
        $('#csvExample').click(function(){
            document.location.href = document.location.protocol+'//'+document.location.host+'/resource/example_csv.csv';
        });

        var base = "<?php echo base_url(); ?>";
        // Setup html5 version
        var uploader = new plupload.Uploader({
            runtimes : 'html5,browserplus',
            url : base+'upload/processing/<?php echo $page; ?>',
            max_file_size : '10mb',
            unique_names : true,
            container : 'files_grid',
            browse_button : 'pickfiles'
        });

        uploader.bind('FileUploaded', function(up, file, response){
            // var response = jQuery.parseJSON(response.response);
            if( response.response == "1" ) {
                $('#alarm').empty().append("<div class='alert alert-error'>File size exceeded</div>");
            } else if (response.response == "upload") {
                $('#alarm').empty().append("<div class='alert alert-success'>Your file ("+file.name+") successfully sended to admin</div>");
            } else if (response.response == "reload") {
                $("#tblJQGrid").trigger('reloadGrid');
            } else if (response.response == "failed") {
                $('#alarm').empty().append("<div class='alert alert-error'>Email sending failed. Try again.</div>");
            } else if (response.response == "file_type") {
                $('#alarm').empty().append("<div class='alert alert-error'>Wrong file type</div>");                
            }  
        });
        uploader.bind('Init', function(up, params) {
            $('#filelist').html("<div></div>");
        });

        $('#uploadfiles').click(function(e) {
            uploader.start();
            e.preventDefault();
        });

        uploader.init();

        uploader.bind('FilesAdded', function(up, files) {
            $.each(files, function(i, file) {
                $('#filelist').append(
                    '<div id="' + file.id + '">' +
                    file.name + ' (' + plupload.formatSize(file.size) + ') <b></b>' +
                '</div>');
            });

            up.refresh(); // Reposition Flash/Silverlight
        });

        uploader.bind('UploadProgress', function(up, file) {
            $('#' + file.id + " b").html(file.percent + "%");
        });

        uploader.bind('Error', function(up, err) {
            $('#filelist').append("<div>Error: " + err.code +
                ", Message: " + err.message +
                (err.file ? ", File: " + err.file.name : "") +
                "</div>"
            );

            up.refresh(); // Reposition Flash/Silverlight
        });

        uploader.bind('FileUploaded', function(up, file) {
            $('#' + file.id + " b").html("100%");
        });
    });




</script>