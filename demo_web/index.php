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
    <?php
    session_start();
    ?>
    <nav>
        <div class="nav-wrapper">
          <a href="#" class="brand-logo center">Facial Recognition</a>
          <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li class="active"><a href="#">Train</a></li>
            <li><a href="test.php">Test</a></li>
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
                                <a class="btn-floating btn-large waves-effect waves-light red" onclick="snapshot();"><i class="material-icons">add_a_photo</i></a>
                                <form action="action.php" method="POST" enctype="multipart/form-data">
                                  <input type="file" name="image" />
                                  <input type="submit" />
                                  <a class="btn-floating btn-large waves-effect waves-light red" onclick="upload();"><i class="material-icons">add_photo_alternate</i></a>
                                </form>

                            </div>
                            <div class="input-field col s6">
                                    <input placeholder="Enter Name" type="text" class="validate" id="ip">
                            </div>
                            <p>
                                <video onclick="snapshot(this);" width=300 height=300 id="video" controls autoplay></video>
                                <img onclick="upload(this);" id="img" width="300" height="300" src="../web/<?php echo $_SESSION["img_name"] ?>" alt="<?php echo $_SESSION["img_name"] ?>">
                                <br><br><br><br><br>
                                <canvas  id="myCanvas" width="300" height="220"></canvas>
                            </p>
                            
                    </div>

                  </div>
      </div>
      <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>
  </body>
  <script type="text/javascript">
 
    // GET USER MEDIA CODE
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
      <?php $_SESSION["img_name"]="" ?>
    }

    function snapshot() {
      
      ctx.drawImage(video, 0,0, canvas.width, canvas.height);
      var img1 = new Image();
      //img1.src="../tet/images/IMG20180414004330.jpg";
      img1.src=canvas.toDataURL();
      var ip = document.getElementById('ip').value;
      datad = "{\r\n    \"image\":\"" + img1.src+ "\",\r\n    \"subject_id\":\"" + ip + "\",\r\n    \"gallery_name\":\"Ominext\"\r\n}";
      var settings = {
          "async": true,
          "crossDomain": true,
          "url": "https://api.kairos.com/enroll",
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
        //
        if((response.images[0].transaction.status) == "success"){
            Materialize.toast("Image Trained succesfully by name " +response.images[0].transaction.subject_id+ " in gallery name " +response.images[0].transaction.gallery_name, 4000);
        }
        else{
            Materialize.toast("Unable to Train Image", 4000);
        }
      });
      //console.log(img1.src);
    }


    function upload() {
      ctx.drawImage(img, 0,0, canvas.width, canvas.height);

      var img1 = new Image();
      img1.src = canvas.toDataURL();
      var ip = document.getElementById('ip').value;
      datad = "{\r\n    \"image\":\"" + img1.src+ "\",\r\n    \"subject_id\":\"" + ip + "\",\r\n    \"gallery_name\":\"Ominext\"\r\n}";
      var settings = {
          "async": true,
          "crossDomain": true,
          "url": "https://api.kairos.com/enroll",
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
      //console.log(settings);
      $.ajax(settings).done(function (response) {
        //
        if((response.images[0].transaction.status) == "success"){
            Materialize.toast("Image Trained succesfully by name " +response.images[0].transaction.subject_id+ " in gallery name " +response.images[0].transaction.gallery_name, 4000);
        }
        else{
            Materialize.toast("Unable to Train Image", 4000);
        }
      });
      //console.log(img1.src);
    }

</script>
</html>