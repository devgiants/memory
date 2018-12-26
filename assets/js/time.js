// Use jQuery
var $ = require('jquery');

$(function () {

    // Only for game page
    if ($('body').hasClass('game')) {

        const GREEN = 66;
        const ORANGE = 33;

        // Variable that will eventually receive the setIntervalId
        let intervalId;
        let $progressBar = $('.progress-bar');
        let progressBarClass = 'bg-success';

        // Initiates the counter with the given seconds number, taken from HTML5 data-* tag.
        let maximumTime = parseInt($progressBar.attr('data-game-time'));
        console.log('Time given for game : ' + maximumTime + 's');
        let counter = maximumTime;

        /**
         * Callback handling process at each interval due
         */
        let countDownStepHandler = function() {
            counter--;

            console.log('Current time : ' + counter + 's');


            // Find relative length for progress bar
            let length = parseInt(counter * 100 / maximumTime);
            console.log('Calculated length for progress bar : ' + length + '%');

            if(length < ORANGE) {
                progressBarClass = 'bg-danger';
            } else if(length > ORANGE && length < GREEN) {
                progressBarClass = 'bg-warning';
            }
            // Update progress bar
            $progressBar
                .css('width', length + '%')
                .prop('aria-valuenow', length)
                .removeClass('bg-danger')
                .removeClass('bg-warning')
                .removeClass('bg-success')
                .addClass(progressBarClass)
            ;
            $('#time-left').text(counter);

            // If counter is 0, game finished
            if (counter === 0) {
                $( document ).trigger( "gameFinished", ['lost']);
            }
        };

        /**
         * Callback handling what to do when countdown finished
         */
        let countDownEndHandler = function() {
            // Stop countdown
            clearInterval(intervalId);
        };

        // Start interval loop
        intervalId = setInterval(countDownStepHandler, 1000);

        /**
         * Register a callback to detect game finished
         */
        $( document ).on( "gameFinished", function(event, status) {
            console.log('callback for time called');
            countDownEndHandler();
        });
    }
});