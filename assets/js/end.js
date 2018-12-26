// Use jQuery
var $ = require('jquery');

$(function () {

    // Only for game page
    if ($('body').hasClass('game')) {
        /**
         * Register a callback to detect game finished
         */
        $( document ).on( "gameFinished", function(event, status) {
            console.log('callback for modal called : ' + status);
            let modalText = "";
            switch (status) {
                case 'win':
                    modalText = "Vous avez gagné ! Bravo !";
                    break;
                case 'loose':
                    modalText = "Vous avez perdu... Pourquoi ne pas réessayer?"
                    break;
            }

            let endPoint = '/api/game/{game_id}';
            endPoint = endPoint.replace('{game_id}', $('body').attr('data-game-id'));

            let data = {'status': status};

            // Mark game as finished
            $.ajax({
                url: endPoint,
                type: 'PUT',
                contentType: 'application/json',
                data: JSON.stringify(data),
                success: function(data) {
                    // TODO add error handling
                }
            });

            $('#end-game-modal')
                .modal('show')
                .find('.modal-body p').text(modalText)
            ;
        });
    }
});