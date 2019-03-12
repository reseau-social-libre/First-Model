// any CSS you require will output into a single css file (app.css in this case)
require('../css/cookie.css');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
const $ = require('jquery');

const Cookies = require('js-cookie');

$(document).ready(function(){
  $('#eu-cookie-law-accept').on('click', function(){
    var $this;

    $this = $(this);
    var cookieName = $this.data('name');
    var value = $this.data('value');

    $('#eu-cookie-law').remove();

    Cookies.set(cookieName, value, { expires: 10, path: '' });
  });
});
