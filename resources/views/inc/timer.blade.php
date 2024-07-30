<script>
    var timerDuration = "<?php echo option('timeout') ?>";

    var timerElement = document.getElementById("timer");

    var countdown = setInterval(function() {
        var minutes = Math.floor(timerDuration / 60);
        var seconds = timerDuration % 60;

        var formattedMinutes = minutes.toString().padStart(2, '0');
        var formattedSeconds = seconds.toString().padStart(2, '0');

        timerElement.textContent = formattedMinutes + ":" + formattedSeconds;

        timerDuration--;

        if (timerDuration < 0) {
            clearInterval(countdown);

            window.location.href = "<?php echo route('index') ?>";
        }
    }, 1000);
</script>