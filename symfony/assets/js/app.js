/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.css');

import '../css/animate.css';
import '../css/bootstrap.min.css';
import '../css/line-awesome.css';
import '../css/line-awesome-font-awesome.min.css';
import '../css/font-awesome.min.css';
import '../lib/slick/slick.css';
import '../lib/slick/slick-theme.css';
import '../css/style.css';
import '../css/responsive.css';


// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
const $ = require('jquery');

$(document).ready(function(){
  var RSL = {};

  RSL.likeProcess = false;
  RSL.commentProcess = false;

  RSL.init = function() {
    RSL.bindCommentEvent();
    RSL.bindLikeEvent();

    $('a.com').on('click', function(e){
      e.preventDefault();
      var $this;

      $this = $(this);
      var post = $this.data('post');

      $('#comment-section-'+post).toggleClass('hidden');
    });
  };

  RSL.bindLikeEvent = function() {
    $(document).on('click', 'a.liker-btn', function(e){
      e.preventDefault();

      if (RSL.likeProcess === false) {
        RSL.likeProcess = true;
        var $this;

        $this = $(this);
        var user = $this.data('user');
        var post = $this.data('post');
        var liked = $this.data('liked');
        var locale = $this.data('locale');

        RSL.postLike(user, post, liked, locale);
      }

    });
  };

  RSL.bindCommentEvent = function() {
    $('form.comment-form').on('submit', function(e){
      e.preventDefault();

      if (RSL.commentProcess === false) {
        RSL.commentProcess = true;
        var $this;

        $this = $(this);
        var comment = $this.find('textarea.comment-text').val();
        var user = $this.data('user');
        var post = $this.data('post');
        var locale = $this.data('locale');

        RSL.postComment(user, comment, post, locale);
      }

    });
  };

  RSL.postComment = function(user, comment, post, locale) {
    $.ajax({
      url: '/'+locale+'/api/comments',
      type: "POST",
      data: {'user': user, 'comment': comment, 'post': post},
      success: function(response){
        RSL.appendComment(post, response);
        RSL.commentProcess = false;
      },
      error: function() {
        RSL.commentProcess = false;
      }
    });
  };

  RSL.appendComment = function(post, response) {
    $('ul#comment-list-'+post).append(response);
    $('textarea.comment-text').val('');
  };

  RSL.postLike = function(user, post, liked, locale) {
    $.ajax({
      url: '/'+locale+'/api/likes',
      type: "POST",
      data: {'user': user, 'post': post, 'liked': liked},
      success: function(response){
        $('#like-btn-'+post).html(response);
        RSL.likeProcess = false;
      },
      error: function() {
        RSL.likeProcess = false;
      }
    });
  };

  RSL.init();

});
