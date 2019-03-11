// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.css');

import '../css/flatpickr.min.css';


// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
const $ = require('jquery');

$(document).ready(function(){
  var RSL = {};

  RSL.addFriendProcess = false;
  RSL.cancelFriendRequestProcess = false;
  RSL.acceptFriendRequestProcess = false;
  RSL.removeFriendProcess = false;
  RSL.followFriendProcess = false;
  RSL.unFollowFriendProcess = false;

  RSL.init = function() {
    RSL.bindAddFriendEvent();
    RSL.bindCancelFriendRequestEvent();
    RSL.bindAcceptFriendRequestEvent();
    RSL.bindRemoveFriendEvent();
    RSL.bindFollowEvent();
    RSL.bindUnFollowEvent();
  };

  RSL.updateButtons = function(response) {
    $('div.relationship-button').html(response);
  };

  RSL.bindAddFriendEvent = function() {
    $(document).on('click', 'a#add-friend', function(e){
      e.preventDefault();

      if (RSL.addFriendProcess === false) {
        RSL.addFriendProcess = true;
        var $this;

        $this = $(this);
        var user = $this.data('user');
        var friend = $this.data('friend');
        var locale = $this.data('locale');

        RSL.postAddFriend(user, friend, locale);
      }

    });
  };

  RSL.postAddFriend = function(user, friend, locale) {
    $.ajax({
      url: '/'+locale+'/api/friend/request/add',
      type: "POST",
      data: {'user': user, 'friend': friend},
      success: function(response){
        RSL.updateButtons(response);
        RSL.addFriendProcess = false;
      },
      error: function() {
        RSL.addFriendProcess = false;
      }
    });
  };

  RSL.bindCancelFriendRequestEvent = function() {
    $(document).on('click', 'a#cancel-friend-request', function(e){
      e.preventDefault();

      if (RSL.cancelFriendRequestProcess === false) {
        RSL.cancelFriendRequestProcess = true;
        var $this;

        $this = $(this);
        var user = $this.data('user');
        var friend = $this.data('friend');
        var locale = $this.data('locale');

        RSL.cancelFriendRequest(user, friend, locale);
      }

    });
  };

  RSL.cancelFriendRequest = function(user, friend, locale) {
    $.ajax({
      url: '/'+locale+'/api/friend/request/cancel',
      type: "POST",
      data: {'user': user, 'friend': friend},
      success: function(response){
        RSL.updateButtons(response);
        RSL.cancelFriendRequestProcess = false;
      },
      error: function() {
        RSL.cancelFriendRequestProcess = false;
      }
    });
  };

  RSL.bindAcceptFriendRequestEvent = function() {
    $(document).on('click', 'a#accept-friend-request', function(e){
      e.preventDefault();

      if (RSL.acceptFriendRequestProcess === false) {
        RSL.acceptFriendRequestProcess = true;
        var $this;

        $this = $(this);
        var user = $this.data('user');
        var friend = $this.data('friend');
        var locale = $this.data('locale');

        RSL.acceptFriendRequest(user, friend, locale);
      }

    });
  };

  RSL.acceptFriendRequest = function(user, friend, locale) {
    $.ajax({
      url: '/'+locale+'/api/friend/request/accept',
      type: "POST",
      data: {'user': user, 'friend': friend},
      success: function(response){
        RSL.updateButtons(response);
        RSL.acceptFriendRequestProcess = false;
      },
      error: function() {
        RSL.acceptFriendRequestProcess = false;
      }
    });
  };

  RSL.bindRemoveFriendEvent = function() {
    $(document).on('click', 'a#remove-friend', function(e){
      e.preventDefault();

      if (RSL.removeFriendProcess === false) {
        RSL.removeFriendProcess = true;
        var $this;

        $this = $(this);
        var user = $this.data('user');
        var friend = $this.data('friend');
        var locale = $this.data('locale');

        RSL.removeFriendRequest(user, friend, locale);
      }

    });
  };

  RSL.removeFriendRequest = function(user, friend, locale) {
    $.ajax({
      url: '/'+locale+'/api/friend/remove',
      type: "POST",
      data: {'user': user, 'friend': friend},
      success: function(response){
        RSL.updateButtons(response);
        RSL.removeFriendProcess = false;
      },
      error: function() {
        RSL.removeFriendProcess = false;
      }
    });
  };

  RSL.bindFollowEvent = function() {
    $(document).on('click', 'a#follow', function(e){
      e.preventDefault();

      if (RSL.followFriendProcess === false) {
        RSL.followFriendProcess = true;
        var $this;

        $this = $(this);
        var user = $this.data('user');
        var friend = $this.data('friend');
        var locale = $this.data('locale');

        RSL.followFriendRequest(user, friend, locale);
      }

    });
  };

  RSL.followFriendRequest = function(user, friend, locale) {
    $.ajax({
      url: '/'+locale+'/api/friend/follow',
      type: "POST",
      data: {'user': user, 'friend': friend},
      success: function(response){
        RSL.updateButtons(response);
        RSL.followFriendProcess = false;
      },
      error: function() {
        RSL.followFriendProcess = false;
      }
    });
  };

  RSL.bindUnFollowEvent = function() {
    $(document).on('click', 'a#unfollow', function(e){
      e.preventDefault();

      if (RSL.unFollowFriendProcess === false) {
        RSL.unFollowFriendProcess = true;
        var $this;

        $this = $(this);
        var user = $this.data('user');
        var friend = $this.data('friend');
        var locale = $this.data('locale');

        RSL.unFollowFriendRequest(user, friend, locale);
      }

    });
  };

  RSL.unFollowFriendRequest = function(user, friend, locale) {
    $.ajax({
      url: '/'+locale+'/api/friend/unfollow',
      type: "POST",
      data: {'user': user, 'friend': friend},
      success: function(response){
        RSL.updateButtons(response);
        RSL.unFollowFriendProcess = false;
      },
      error: function() {
        RSL.unFollowFriendProcess = false;
      }
    });
  };

  RSL.init();

});
