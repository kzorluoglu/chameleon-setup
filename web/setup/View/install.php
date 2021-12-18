<?php include "layout/header.php"; ?>
<div class="card border-0">
    <div class="card-body p-0">
        <div class="row no-gutters">
            <div class="col-lg-12">
                <div class="p-5">
                    <div class="mb-5">
                        <span class="badge bg-secondary">Step 3</span>
                        <h3 class="h4 font-weight-bold text-theme">Installation</h3>
                    </div>
                    <h6 class="h5 mb-0">Please wait...</h6>
                    <div class="terminal">
                        <textarea id="output" class="body form-control"></textarea>
                    </div>

                    <div class="mt-5">

                    <a class="btn btn-outline-info" href="<?php echo $full_url; ?>?page=requirement">
                        <i class="bi bi-arrow-left-square"></i>
                        System Requirements
                    </a>
                    <a class="btn btn-primary invisible" id="nextStep" href="<?php echo $full_url; ?>?page=databasevalidation">
                        <i class="bi bi-arrow-right-square"></i>
                        Database Validation
                    </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- end card-body -->
</div>
<!-- end card -->

<?php include "layout/footer.php"; ?>



<script type="text/javascript">

    document.addEventListener("DOMContentLoaded", function(event) {

        var ta = document.getElementById('output');

        var scrollToBottomInterval = setInterval(function(){
            ta.scrollTop = ta.scrollHeight;
        }, 10);

        var source = new EventSource('<?php echo $full_url; ?>?page=composerinstall<?php echo ($debug === '') ? '&debug=true' : '&debug=false'; ?>');
        source.addEventListener('message', function(e) {
            if (e.data !== '') {
                ta.value += e.data + '\n';

                if (e.data === 'Done!') {

                    var nextStepContainer = document.getElementById('nextStep');
                    nextStepContainer.classList.remove('invisible');
                    nextStepContainer.classList.add('visible');

                    clearInterval(scrollToBottomInterval);
                }
            }
        }, false);
        source.addEventListener('error', function(e) {
            source.close();
        }, false);

        });
</script>