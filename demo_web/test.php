<!DOCTYPE html>
<html>
  <head>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  </head>

  <body onload="init();">
    <nav>
        <div class="nav-wrapper">
          <a href="#" class="brand-logo center">Facial Recognition</a>
          <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li><a href="index.php">Train</a></li>
            <li class="active"><a href="#">Test</a></li>
            <li><a href="remove.html">RemoveSubject</a></li>
            <li><a href="viewSubject.html">ViewSubject</a></li>
          </ul>
        </div>
      </nav>
      
      <div class="container">
            <div class="card center">
 
                    <div class="card-content">
                            <div class="card-action">
                                <a class="btn-floating btn-large waves-effect waves-light red" onclick="startWebcam();"><i class="material-icons">camera</i></a>
                                <a class="btn-floating btn-large waves-effect waves-light red" onclick="snapshot();"><i class="material-icons">touch_app</i></a><br><br>
                            </div>
                            
                            <p>
                                <video onclick="snapshot(this);" width=300 height=300 id="video" controls autoplay></video>
                                <br>
                                <canvas  id="myCanvas" width="300" height="220"></canvas>
                            </p>
                    </div>
                    <audio id="myAudio">
                            <source src="success.wav" type="audio/wav">
                    </audio>

                  </div>
      </div>
      <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>
  </body>
  <script type="text/javascript">
    //--------------------
    // GET USER MEDIA CODE
    //--------------------
        navigator.getUserMedia = ( navigator.getUserMedia ||
                           navigator.webkitGetUserMedia ||
                           navigator.mozGetUserMedia ||
                           navigator.msGetUserMedia);

    var video;
    var webcamStream;

    function startWebcam() {
      if (navigator.getUserMedia) {
         navigator.getUserMedia (

            // constraints
            {
               video: true,
               audio: false
            },

            // successCallback
            function(localMediaStream) {
                video = document.querySelector('video');
               video.src = window.URL.createObjectURL(localMediaStream);
               webcamStream = localMediaStream;
            },

            // errorCallback
            function(err) {
               console.log("The following error occured: " + err);
            }
         );
      } else {
         console.log("getUserMedia not supported");
      }  
    }

    // TAKE A SNAPSHOT CODE
    var canvas, ctx;

    function init() {
      // Get the canvas and obtain a context for
      // drawing in it
      canvas = document.getElementById("myCanvas");
      ctx = canvas.getContext('2d');
    }

    function snapshot() {
        ctx.drawImage(video, 0,0, canvas.width, canvas.height);
        var img1 = new Image();
        img1.src = canvas.toDataURL();
        
        var x = document.getElementById("myAudio"); 
        x.play(); 
        datad = "{\r\n    \"image\":\"" + img1.src+ "\",\r\n    \"gallery_name\":\"Ominext\"\r\n}"
        var settings = {
            "async": true,
            "crossDomain": true,
            "url": "https://api.kairos.com/recognize",
            "method": "POST",
            "headers": {
                "content-type": "application/json",
                "app_id": "1316c881",
                "app_key": "f72d0ad2fa24a8bbed931ddc3bb48813",
                "cache-control": "no-cache"
            },
            "processData": false,
            "data": datad
        }
        $.ajax(settings).done(function (response) {
            var m = response;
            console.log(JSON.stringify(m).indexOf("success"));
            if(JSON.stringify(m).indexOf("success") > -1) {
                Materialize.toast('User Identfied. Name : ' +JSON.stringify(m.images[0].candidates[0].subject_id), 6000);
                console.log(m.images[0].candidates[0].subject_id);
            }
            else{
                Materialize.toast('User Not identified');
            }
        });
    }
</script>
</html>