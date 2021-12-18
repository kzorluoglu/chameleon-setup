<?php include "layout/header.php"; ?>
<div class="card border-0">
    <div class="card-body p-0">
        <div class="row no-gutters">
            <div class="col-lg-12">
                <div class="p-5">
                    <div class="mb-5">
                        <span class="badge bg-secondary">Step 5</span>
                        <h3 class="h4 font-weight-bold text-theme">Database Installation</h3>
                    </div>
                    <h6 class="h5 mb-0" id="please_wait_text_container">Please wait...</h6>
                    <div class="terminal">
                        <textarea id="output" class="body form-control"></textarea>
                    </div>

                    <div class="mt-5">

                        <p class="text-success mt-2 mb-5 invisible" id="success_message">Database imported completed.</p>


                        <a class="btn btn-outline-info" href="<?php echo $full_url; ?>?page=databasevalidation">
                            <i class="bi bi-arrow-left-square"></i>
                            Database Validation
                        </a>
                        <a class="btn btn-primary invisible" id="nextStep" href="<?php echo $full_url; ?>?page=checkconfig">
                            <i class="bi bi-arrow-right-square"></i>
                            Modify/Check Config
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

    function scrollTOutputBottom(output) {
        output.scrollTop = output.scrollHeight;
    }

    document.addEventListener("DOMContentLoaded", function(event) {

        var output = document.getElementById('output');

        var scrollToBottomInterval = setInterval(function(){
            scrollTOutputBottom(output)
        }, 10);

        var source = new EventSource('index.php?page=databaseimport');
        source.addEventListener('message', function(e) {
            if (e.data !== '') {
                output.value += e.data + '\n';

                if (e.data === 'Done!') {

                    var nextStepContainer = document.getElementById('nextStep');
                    nextStepContainer.classList.remove('invisible');
                    nextStepContainer.classList.add('visible');

                    var successMessageContainer = document.getElementById('success_message');
                    successMessageContainer.classList.remove('invisible');
                    successMessageContainer.classList.add('visible');

                    document.getElementById('please_wait_text_container').innerText = '';

                    scrollTOutputBottom(output);

                    clearInterval(scrollToBottomInterval);
                }
            }
        }, false);
        source.addEventListener('error', function(e) {
            source.close();
        }, false);

    });
</script>
