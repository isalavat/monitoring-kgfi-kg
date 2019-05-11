<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>monitoring.kgfi</title>

    <!-- Bootstrap -->
    <link href="/template/css/bootstrap.css" rel="stylesheet">
    <link href="/template/css/font-awesome.css" rel="stylesheet">
    <link href="/template/css/mystyle.css" rel="stylesheet">
     
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
	<div class="navbar navbar-inverse navbar-static-top">
		<div class="container">

			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#responsive">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>	

			<div class = "collapse navbar-collapse" id ="responsive">
				<ul class="nav navbar-nav">
					<li><a href="/">Start Seite</a></li>
					<li ><a href="/progress/" >Leistung</a></li>
					<li><a href="/attendance/" >Besucherzahl</a></li>
				</ul>
                                <?php if (!User::isGuest()):?>
                                    <a href="/user/logout" id ="logout" class="btn btn-primary "><i class="fa fa-sign-in"> Ausloggen</i></a>
                                <?php endif;?>
				<?php if (User::isGuest()):?>
                                    <form action="/user/login" method="post" class="navbar-form navbar-lg navbar-right sm-hidden">
					<div class="form-group">
						<input type="text" name="login" class="form-control" placeholder="login">
					</div>
					<div class="form-group">
						<input type="password" name="password" class="form-control" placeholder="password">
					</div>
                                        <button class="btn btn-primary" type="submit" name="submit"><i class="fa fa-sign-in"> Einloggen</i></button>
				</form>
                                <?php endif;?>
			</div>	
		</div>
	</div>


