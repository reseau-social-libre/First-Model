//require('!style-loader!css-loader!video.js/dist/video-js.css');

require('../../node_modules/video.js/dist/video-js.css');
require('../css/video-js.css');

import videojs from 'video.js';
import '../lib/webrtc/fetch.js';
import '../lib/webrtc/promise.min.js';
import '../lib/webrtc/fetch.stream.js';

const $ = require('jquery');

$(document).ready(function(){
  var RSL = {};

  RSL.initializePlayer = function(name, extension, token, elem, app) {
    var type;
    var liveStream = false;
    var preview = name;

    if (extension === "mp4") {
      type = "video/mp4";
      liveStream = false;
    } else if (extension === "m3u8") {
      type = "application/x-mpegurl";
      liveStream = true;
    } else {
      console.log("Unknown extension: " + extension);
      return;
    }

    if (name.endsWith("_adaptive")) {
      preview = name.substring(0, name.indexOf("_adaptive"));
    }

    var player = videojs(elem, {
      poster : "previews/" + preview + ".png",
      controls: true,
      autoplay: false,
      preload: 'auto',
      fluid: true,
      liveui: true,
    });

    player.src([
      { type: type, src: "//live.rslibre.com:5443/" + app + "/streams/" + name + "." + extension + "?token=" + token }
    ]);

    var containerId = '#'+name+'-container';
    var videoInfo = '#'+name+'-info';
    $(containerId).css({'display': 'block'});
    $(videoInfo).remove();

  };

  RSL.tryToPlay = function(name, token, app, elem) {
    fetch("//live.rslibre.com:5443/"+app+"/streams/"+ name +"_adaptive.m3u8", {method:'HEAD'})
        .then(function(response) {
          if (response.status === 200) {
            // adaptive m3u8 exists,play it
            RSL.initializePlayer(name+"_adaptive", "m3u8", token, elem, app);
          }
          else
          {
            //adaptive m3u8 not exists, try m3u8 exists.
            fetch("//live.rslibre.com:5443/"+ app +"/streams/"+ name +".m3u8", {method:'HEAD'})
                .then(function(response) {
                  if (response.status === 200) {
                    //m3u8 exists, play it
                    RSL.initializePlayer(name, "m3u8", token, elem, app);
                  }
                  else {
                    //no m3u8 exists, try vod file
                    fetch("//live.rslibre.com:5443/"+ app +"/streams/"+ name +".mp4", {method:'HEAD'})
                        .then(function(response) {
                          if (response.status === 200) {
                            //mp4 exists, play it
                            RSL.initializePlayer(name, "mp4", token, elem, app);
                          }
                          else {
                            console.log("No stream found");
                            setTimeout(function() {
                              RSL.tryToPlay(name, token, elem);
                            }, 5000);
                            var videoInfo = '#'+name+'-info';
                            $(videoInfo).html('Stream will start playing automatically<br/>when it is live');
                          }
                        }).catch(function(err) {
                      console.log("Error: " + err);
                    });
                  }
                }).catch(function(err) {
              console.log("Error: " + err);
            });
          }
        }).catch(function(err) {
      console.log("Error: " + err);
    });
  };


  $('video').each(function(){
    var $this;

    $this = $(this);
    var name = $this.data('name');
    var token = $this.data('token');
    var app = $this.data('app');

    RSL.tryToPlay(name, token, app, this);

  });

});