Importing database structure... Please wait...

     <script type="text/javascript">

    document.addEventListener("DOMContentLoaded", function(event) {

        var ta = document.getElementById('output');
        var source = new EventSource('setup?page=databaseimport');
        source.addEventListener('message', function(e) {
            if (e.data !== '') {
                ta.value += e.data + '\n';

                if (e.data === 'Finish!') {
                    var nextStepContainer = document.getElementById('nextStep');
                    nextStepContainer.style.display =  'block';
                }
            }
        }, false);
        source.addEventListener('error', function(e) {
            source.close();
        }, false);

        var textarea = document.getElementById('output');
        setInterval(function(){
            textarea.scrollTop = textarea.scrollHeight;
        }, 10);


        });
</script>
<p>Output:<br/><textarea id="output" style="width: 100%; height: 25em;"></textarea></p>

<a href="setup?page=databasevalidation">< Database Validation </a> |
<div style="display: none" id="nextStep">
    <p>
        <a href="setup?page=createadmin">Create Admin</a>
    </p>
</div>