<?php echo $title; ?>
<script type="text/javascript">

    document.addEventListener("DOMContentLoaded", function(event) {

        var ta = document.getElementById('output');
        var source = new EventSource('setup?page=composerinstall&debug=<?php echo $debug; ?>');
        source.addEventListener('message', function(e) {
            if (e.data !== '') {
                ta.value += e.data + '\n';
            }
        }, false);
        source.addEventListener('error', function(e) {
            source.close();
        }, false);
        });
</script>
<p>Output:<br/><textarea id="output" style="width: 80%; height: 25em;"></textarea></p>
