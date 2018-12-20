/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require('../scss/app.scss');

const imagesContext = require.context('../images', true, /\.(png|jpg|jpeg|gif|ico|svg|webp)$/);
imagesContext.keys().forEach(imagesContext);

// Use jQuery
var $ = require('jquery');

// Require Bootstrap
require('bootstrap');

$(function () {
  $('.memory-card').click(function(e){
    e.preventDefault();
    $(this).toggleClass('flipped');
  })
});