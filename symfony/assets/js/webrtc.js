require('../css/live.css');

const $ = require('jquery');

import adapter from 'webrtc-adapter';
import WebRTCAdaptor from '../lib/webrtc/webrtc_adaptor.js';

$(document).ready(function(){
  var RSL = {};

  RSL.token = '';
  RSL.start_publish_button = $('#start_publish_button');
  RSL.stop_publish_button = $('#stop_publish_button');
  RSL.stream = $('#post-stream');
  RSL.stream_app = $('#post-stream-app');
  RSL.post_title = $('#post-title');
  RSL.post_description = $('#post-description');
  RSL.pc_config = null;
  RSL.sdpConstraints = {
    OfferToReceiveAudio : false,
    OfferToReceiveVideo : false
  };

  if( navigator.userAgent.match(/Android/i)
      || navigator.userAgent.match(/webOS/i)
      || navigator.userAgent.match(/iPhone/i)
      || navigator.userAgent.match(/iPad/i)
      || navigator.userAgent.match(/iPod/i)
      || navigator.userAgent.match(/BlackBerry/i)
      || navigator.userAgent.match(/Windows Phone/i)
  )
  {
    RSL.mediaConstraints = {
      video : {width: 480, height: 640},
      audio : true
    };
  }
  else {
    RSL.mediaConstraints = {
      video : {width: 640, height: 480},
      audio : true
    };
  }

  RSL.websocketURL = "ws://live.rslibre.com:5080/WebRTCApp/websocket";

  if (location.protocol.startsWith("https")) {
    RSL.websocketURL = "wss://live.rslibre.com:5443/WebRTCApp/websocket";
  }

  RSL.init = function() {
    RSL.bindStartPublishingEvent();
    RSL.bindStopPublishingEvent();
  };

  RSL.bindStartPublishingEvent = function() {
    RSL.start_publish_button.on('click', function() {
      var $this;

      $this = $(this);
      var user = $this.data('user');

      if (RSL.post_title.val() !== '' || RSL.post_description.val() !== '') {
        var stream = RSL.stream.val();
        var streamApp = RSL.stream_app.val();
        var title = RSL.post_title.val();
        var description = RSL.post_description.val();
        RSL.createPostLive(user, stream, streamApp, title, description);
      }
      else {
        alert('Le titre et la description sont obligatoire');
      }
    });
  };

  RSL.bindStopPublishingEvent = function() {
    RSL.stop_publish_button.on('click', function () {
      RSL.stopPublishing();
    });
  };

  RSL.startPublishing = function () {
    RSL.webRTCAdaptor.publish(RSL.stream.val(), RSL.token);
  };

  RSL.stopPublishing = function () {
    RSL.webRTCAdaptor.stop(RSL.stream.val());
    location.reload();
  };

  RSL.startAnimation = function () {
    $("#broadcastingInfo").fadeIn(800, function () {
      $("#broadcastingInfo").fadeOut(800, function () {
        var state = RSL.webRTCAdaptor.signallingState(RSL.stream.val());

        if (state !== null && state !== "closed") {
          var iceState = RSL.webRTCAdaptor.iceConnectionState(RSL.stream.val());

          if (iceState !== null && iceState !== "failed" && iceState !== "disconnected") {
            RSL.startAnimation();
          }
        }
      });
    });
  };

  RSL.webRTCAdaptor = new WebRTCAdaptor({
    websocket_url : RSL.websocketURL,
    mediaConstraints : RSL.mediaConstraints,
    peerconnection_config : RSL.pc_config,
    sdp_constraints : RSL.sdpConstraints,
    localVideoId : "localVideo",
    debug:true,
    callback : function(info, description) {
      if (info === "initialized") {
        console.log("initialized");
        RSL.start_publish_button.prop("disabled", false);
        RSL.stop_publish_button.prop("disabled", true);
      }
      else if (info === "publish_started") {
        //stream is being published
        console.log("publish started");
        RSL.start_publish_button.prop("disabled", true);
        RSL.stop_publish_button.prop("disabled", false);
        RSL.startAnimation();
      }
      else if (info === "publish_finished") {
        //stream is being finished
        console.log("publish finished");
        RSL.start_publish_button.prop("disabled", false);
        RSL.stop_publish_button.prop("disabled", true);
      }
      else if (info === "closed") {
        //console.log("Connection closed");
        if (typeof description !== "undefined") {
          console.log("Connecton closed: " + JSON.stringify(description));
        }
      }
    },
    callbackError : function(error, message) {
      //some of the possible errors, NotFoundError, SecurityError,PermissionDeniedError
      console.log("error callback: " +  JSON.stringify(error));
      var errorMessage = JSON.stringify(error);

      if (typeof message !== "undefined") {
        errorMessage = message;
      }
      else if (error.indexOf("NotFoundError") !== -1) {
        errorMessage = "Camera or Mic are not found or not allowed in your device";
      }
      else if (error.indexOf("NotReadableError") !== -1 || error.indexOf("TrackStartError") !== -1) {
        errorMessage = "Camera or Mic is being used by some other process that does not let read the devices";
      }
      else if(error.indexOf("OverconstrainedError") !== -1 || error.indexOf("ConstraintNotSatisfiedError") !== -1) {
        errorMessage = "There is no device found that fits your video and audio constraints. You may change video and audio constraints"
      }
      else if (error.indexOf("NotAllowedError") !== -1 || error.indexOf("PermissionDeniedError") !== -1) {
        errorMessage = "You are not allowed to access camera and mic.";
      }
      else if (error.indexOf("TypeError") !== -1) {
        errorMessage = "Video/Audio is required";
      }

      alert(errorMessage);
    }
  });

  RSL.createPostLive = function (user, stream, streamApp, title, description) {
    $.ajax({
      url: '/fr/api/post/lives',
      type: "POST",
      data: {'user': user, 'stream': stream, 'streamApp': streamApp, 'title': title, 'content': description},
      success: function(response){
        if (response === '201') {
          RSL.startPublishing();
        } else {
          alert('error');
        }
      },
      error: function() {
        alert('error');
      }
    });
  };

  RSL.init();
});