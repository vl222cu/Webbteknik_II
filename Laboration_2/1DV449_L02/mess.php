<?php
	require_once("get.php");
    require_once("sec.php");
    sec_session_start();
?>
<!DOCTYPE html>
<html lang="sv">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="apple-touch-icon" href="touch-icon-iphone.png">
    <link rel="apple-touch-icon" sizes="76x76" href="touch-icon-ipad.png">
    <link rel="apple-touch-icon" sizes="120x120" href="touch-icon-iphone-retina.png">
    <link rel="apple-touch-icon" sizes="152x152" href="touch-icon-ipad-retina.png">
    <link rel="shortcut icon" href="pic/favicon.png">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="./css/mess.css" />
	<title>Messy Labbage</title>
  </head>

	  	<body>        

        <div id="container">
            
            <div id="messageboard">
            <form action="logout.php" method="POST">
            <input id="logout" class="btn btn-danger logout" name="logout" type="submit" value="Logout"/>

            </form> 
                <div id="messagearea"></div>
                
                <p id="numberOfMess">Antal meddelanden: <span id="nrOfMessages">0</span></p>

                <form method="POST">
                    Name:<br /> <input id="inputName" type="text" name="name" /><br />
                    Message: <br />
                    <textarea name="mess" id="inputText" cols="55" rows="6"></textarea>
                    <input type="hidden" id="csrfToken" name="csrfToken" value="<?php echo($_SESSION['csrfToken']) ?>" />
                    <input class="btn btn-primary" type="button" id="buttonSend" value="Write your message" />
                </form>
                <span class="clear">&nbsp;</span>
            </div>

        </div>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="MessageBoard.js"></script>
        <script src="Message.js"></script>
	</body>
	</html>