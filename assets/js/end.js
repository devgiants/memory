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
            let modalText;
            switch (status) {
                case 'win':
                    modalText = "Vous avez gagné ! Bravo !";
                    break;
                case 'loose':
                    modalText = "Vous avez perdu... Pourquoi ne pas réessayer?"
                    break;
            }

            $('#end-game-modal')
                .modal('show')
                .find('.modal-body p').text(modalText)
            ;
        });
    }
});