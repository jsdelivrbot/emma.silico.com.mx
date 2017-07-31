<div class="panel">
        <div class="panel-body">
                <div class="col-sm-6">
                        <div class="badge pull-left">
                                {{ $slot->order }}
                        </div>
                        <span class="badge">
                                {{ $slot->id}}
                        </span>
                        @each('management.exams.slot_vignettes_partial', $slot->vignettes, 'vignette')
                        <div style="overflow: scroll; height: 80vh;">
                                <div class="" >
                                        @include('management.exams.dz_images_partial')
                                </div>
                                <div>
                                        @includeIf('management.exams.carousel_partial', ['images' => $slot->images, 'slot_id' => $slot->id])
                                </div>
                        </div>
                </div>
                <div class="col-sm-6">
                        @each('management.exams.slot_questions_partial', $slot->questions, 'question')
                </div>
        </div>
</div>



<script>
Dropzone.options.myDropzone = {
        autoProcessQueue: true,
        uploadMultiple: true,
        maxFilezise: 50,
        maxFiles: 10,

        init: function() {


                this.on("addedfile", function(file) {

                });

                this.on("complete", function(file) {


                });

                this.on("success", function(file) {
                        // this.removeFile(file);
                        this.processQueue.bind(myDropzone);

                });



                this.on("error", function(file, response) {
                        console.log(response);
                        $( '#dropzone-previews' ).append(response);
                });
        }

};
</script>
