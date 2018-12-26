// Use jQuery
var $ = require('jquery');

$(function () {

    // Only for game page
    if ($('body').hasClass('game')) {
        // Define needed vars
        let $firstCard, $secondCard;

        // Define transition handler, this is here the decision is made
        let transitionHandler = function () {
            // If both cards are defined, we have to make a decision
            if ($firstCard && $secondCard) {

                // Remove transition handling to avoid concurrent triggers
                $secondCard.off('transitionend webkitTransitionEnd oTransitionEnd otransitionend MSTransitionEnd', transitionHandler);

                // If .back classes are equals, both cards are the same. They are found and will stay flipped.
                if ($firstCard.find('.back').attr('class') === $secondCard.find('.back').attr('class')) {
                    $firstCard
                        .removeClass('iteration')
                        .addClass('found')
                    ;

                    $secondCard
                        .removeClass('iteration')
                        .addClass('found')
                    ;

                    // TODO send insight to server for history
                }

                // Cards are different. Flip them back, this iteration is lost
                else {
                    $firstCard.removeClass(['flipped', 'iteration']);
                    $secondCard.removeClass(['flipped', 'iteration']);
                }

                // Reset cards for next game iteration
                $firstCard = $secondCard = null;

                // Check game end
                if ($('.memory-card:not(.flipped)').length === 0) {

                    // Finish game
                    $( document ).trigger( "gameFinished", ['won']);
                }
            }
        };

        // Define click handler (for click on any card) externally to make it unbindable
        let clickHandler = function (e) {
            e.preventDefault();

            // If no game iteration in progress, this is the first card of the iteration
            if (!$firstCard && !($(this).hasClass('flipped') || $(this).hasClass('iteration'))) {
                $(this).addClass(['flipped', 'iteration']);
                $firstCard = $(this);
                console.log('first card chosen.')
            }

            // One card has already been flipped, this is the second shot (only if different unflipped card is clicked)
            else if (!$secondCard && !($(this).hasClass('flipped') || $(this).hasClass('iteration'))) {

                $secondCard = $(this);

                // Bind choice logic for decision on transition end fot this card
                $secondCard.on('transitionend webkitTransitionEnd oTransitionEnd otransitionend MSTransitionEnd', transitionHandler);

                $(this).addClass(['flipped', 'iteration']);

                console.log('second card chosen.')
            }
            // TODO send insight to server for history
        };
        // On every memory card click.
        $('.memory-card').bind('click', clickHandler);
    }
});