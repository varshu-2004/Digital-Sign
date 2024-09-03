<?php
require 'config.php';

if(!isset($_SESSION["login"])){
  header("Location: user_login.php");
  exit();
}

if(isset($_POST['signaturesubmit'])){ 
    $signature = $_POST['signature'];
    $userId = $_SESSION["id"];
    $signatureFileName = uniqid().'.png';
    $signature = str_replace('data:image/png;base64,', '', $signature);
    $signature = str_replace(' ', '+', $signature);
    $data = base64_decode($signature);
    $file = 'signatures/'.$signatureFileName;
    file_put_contents($file, $data);

    // Save the signature file path in the database
    $signatureFilePath = 'http://localhost/Digital%20Sign/'.$file;
    $stmt = $conn->prepare("INSERT INTO signatures (user_id, signature) VALUES (?, ?)");
    $stmt->bind_param("is", $userId, $signatureFilePath);
    $stmt->execute();
    $stmt->close();

    $msg = "<div class='alert alert-success'>Signature Uploaded</div>";
} 
?>
<!DOCTYPE html>
<html>
<head>
    <title>Signature Pad</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        #sidePanel {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            background-color: #333;
            padding: 20px;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }
        #sidePanel a {
            color: white;
            text-decoration: none;
            padding: 10px;
            margin-bottom: 10px;
            font-size: 18px;
        }
        #sidePanel a:hover {
            background-color: #555;
        }
        #content {
            margin-left: 200px; /* Width of the side panel */
            padding: 20px;
        }
        #canvasDiv{
            position: relative;
            border: 2px dashed grey;
            height:300px;
        }
    </style>
</head>
<body>
<div id="sidePanel">
        <a href="signature_pad.php">Signature Pad</a>
        <a href="my_signature.php">My Signature</a>
        <a href="profile.php">Profile</a>
        <a href="logout.php">Logout</a>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <br>
                <?php echo isset($msg)?$msg:''; ?>
                <hr>
                <div id="canvasDiv"></div>
                <br>
                <button type="button" class="btn btn-danger" id="reset-btn">Clear</button>
                <button type="button" class="btn btn-success" id="btn-save">Save</button>
            </div>
            <form id="signatureform" action="" style="display:none" method="post">
                <input type="hidden" id="signature" name="signature">
                <input type="hidden" name="signaturesubmit" value="1">
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>
    <script>
        $(document).ready(() => {
            var canvasDiv = document.getElementById('canvasDiv');
            var canvas = document.createElement('canvas');
            canvas.setAttribute('id', 'canvas');
            canvasDiv.appendChild(canvas);
            $("#canvas").attr('height', $("#canvasDiv").outerHeight());
            $("#canvas").attr('width', $("#canvasDiv").width());
            if (typeof G_vmlCanvasManager != 'undefined') {
                canvas = G_vmlCanvasManager.initElement(canvas);
            }
            
            context = canvas.getContext("2d");
            $('#canvas').mousedown(function(e) {
                var offset = $(this).offset()
                var mouseX = e.pageX - this.offsetLeft;
                var mouseY = e.pageY - this.offsetTop;

                paint = true;
                addClick(e.pageX - offset.left, e.pageY - offset.top);
                redraw();
            });

            $('#canvas').mousemove(function(e) {
                if (paint) {
                    var offset = $(this).offset()
                    addClick(e.pageX - offset.left, e.pageY - offset.top, true);
                    redraw();
                }
            });

            $('#canvas').mouseup(function(e) {
                paint = false;
            });

            $('#canvas').mouseleave(function(e) {
                paint = false;
            });

            var clickX = new Array();
            var clickY = new Array();
            var clickDrag = new Array();
            var paint;

            function addClick(x, y, dragging) {
                clickX.push(x);
                clickY.push(y);
                clickDrag.push(dragging);
            }

            $("#reset-btn").click(function() {
                context.clearRect(0, 0, window.innerWidth, window.innerWidth);
                clickX = [];
                clickY = [];
                clickDrag = [];
            });

            $(document).on('click', '#btn-save', function() {
                var mycanvas = document.getElementById('canvas');
                var img = mycanvas.toDataURL("image/png");
                anchor = $("#signature");
                anchor.val(img);
                $("#signatureform").submit();
            });

            function redraw() {
                context.clearRect(0, 0, context.canvas.width, context.canvas.height);
                context.strokeStyle = "#000";
                context.lineJoin = "round";
                context.lineWidth = 2;

                for (var i = 0; i < clickX.length; i++) {
                    context.beginPath();
                    if (clickDrag[i] && i) {
                        context.moveTo(clickX[i - 1], clickY[i - 1]);
                    } else {
                        context.moveTo(clickX[i] - 1, clickY[i]);
                    }
                    context.lineTo(clickX[i], clickY[i]);
                    context.closePath();
                    context.stroke();
                }
            }
        })
    </script>
</body>
</html>
