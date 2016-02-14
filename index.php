<?php
/*
	Conversor de Subtitulos latino
    Copyright (C) <2014>  Ernesto Gigliotti <ernestogigliotti@gmail.com>

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/	
session_start();
include_once ("ViewFactory.php");
include_once ("Translator.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8" />
	<meta name="description" content="Conversor subtítulos latinos"/>
	<meta name="keywords" content="conversor,subtítulos,latinos,español"/>
	<meta name="robots" content="index, nofollow"/>
	<title>Conversor subtítulos latinos</title>		
	<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
	<link rel="shortcut icon" href="images/favlogo.png">
</head>
<body>

	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/es_LA/sdk.js#xfbml=1&appId=82958216262&version=v2.0";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>

	<div id="topPart">
		<div id="topContent">		
		<section>
			<article>
				<header><h1>Convierte subtítulos en español de España, a español Latino</h1></header>
				<p>Esta heramienta te permitirá reeemplazar las palabras y expresiones españolas que encuentras en los subtítulos, por expresiones y palabras latinas.</p>
			</article>
		</section>
		<img id="logo" src="images/logo.png" alt="Logo Conversor subtítulos latinos" />
		</div>
	</div>	
	<div id="bottomPart" >
		<?php
			$viewFactory = new ViewFactory();
			if(isset($_GET['editar'])==true)
			{
				if($_SESSION['security_code']!=$_POST['captchaUser'])
					$viewFactory->showError("Código verificador inválido","convertir-subtitulo","images/btnBack.png"); 			
				else
				{
					$_SESSION['security_code']="0";
					$viewFactory->showEditTitles();
					
					$translator = new Translator();
					$translatedLines = $translator->translate();
					if($translator->isOK())
					{
						if($viewFactory->buildEditForm("conversor.php",$_FILES['file']['name'],$translatedLines,"convertir-subtitulo","images/btnBack.png")==false)
							$viewFactory->showError("El archivo no necesita traducción","convertir-subtitulo","images/btnBack.png"); 			
					}
					else
						$viewFactory->showError($translator->getError(),"convertir-subtitulo","images/btnBack.png"); 			
				}
			}
			else
				$viewFactory->buildUploadForm("editar-conversion");								
		?>	
	</div>	
	
	<footer>
		<p>Copyright 2013-2014 - Ernesto Gigliotti</p>			
	</footer>
	
	<script type="text/javascript">
	document.getElementById("uploadBtn").onchange = function () {
		document.getElementById("uploadFile").value = this.value;
	};
	</script>
	
	<script type="text/javascript">
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-45784110-1', 'subslatinos.com.ar');
	  ga('send', 'pageview');
	</script>	
	
</body>
</html>

