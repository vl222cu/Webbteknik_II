<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="ico/favicon.png">

    <title>Mezzy Labbage - Logga in</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
		<script src="js/bootstrap.js"></script>
		
    <!-- Custom styles for this template -->
    <style>
	body {
	  padding-top: 40px;
	  padding-bottom: 40px;
	  background-color: #eee;
	}

	.form-signin {
	  max-width: 330px;
	  padding: 15px;
	  margin: 0 auto;
	}
	.form-signin .form-signin-heading,
	.form-signin .checkbox {
	  margin-bottom: 10px;
	}
	.form-signin .checkbox {
	  font-weight: normal;
	}
	.form-signin .form-control {
	  position: relative;
	  font-size: 16px;
	  height: auto;
	  padding: 10px;
	  -webkit-box-sizing: border-box;
	     -moz-box-sizing: border-box;
	          box-sizing: border-box;
	}
	.form-signin .form-control:focus {
	  z-index: 2;
	}
	.form-signin input[type="text"] {
	  margin-bottom: -1px;
	  border-bottom-left-radius: 0;
	  border-bottom-right-radius: 0;
	}
	.form-signin input[type="password"] {
	  margin-bottom: 10px;
	  border-top-left-radius: 0;
	  border-top-right-radius: 0;
	}

	</style>

  </head>

  <body>

    <div class="container">

      <form class="form-signin" action="check.php" method="POST">
        <h2 class="form-signin-heading">Log in</h2>
        <input value="" name="username" type="text" class="form-control" placeholder="Användarnamn" required autofocus>
        <input value="" name="password" type="password" class="form-control" placeholder="Password" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Log in</button>
      </form>
    </div> <!-- /container -->
  </body>
</html>

