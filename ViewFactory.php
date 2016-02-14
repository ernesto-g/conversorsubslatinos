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
include_once("Line.php");

class ViewFactory
{
	public function ViewFactory()
	{
		
	}

	public function buildUploadForm($action)
	{
		echo("
			<form id='uploadForm' name='uploadForm' action='".$action."' method='POST' enctype='multipart/form-data' >
				<input id='uploadFile' placeholder='Elige el archivo de subtítulo' disabled='disabled' />
				<div class='upload'>
					<input id='uploadBtn' type='file' name='file'/>
				</div>
				<div id='divCaptcha'>
					<img id='captchaImg' src='imagecaptcha.php' alt='captcha'/>
					<input id='captchaTxt' type='text' placeholder='Ingresa el código' name='captchaUser'/>				
				</div>
				<div class='translate'>
					<input id='translateButton' type='submit' value='Traducir' title='Traducir'>
				</div>
			</form>	
			<div id='facebook-div'>
				<div class='fb-like' data-href='https://www.facebook.com/subslatinos' data-width='400px' data-layout='standard' data-action='like' data-show-faces='true' data-share='true'></div>			
			</div>
			<br/><br/><br/><br/><br/><br/><br/><br/><br/>
			");	
	}
	
	public function buildEditForm($action,$fileName,$translatedLines,$url,$img)
	{
		
		// Table
		if(count($translatedLines)>0)
		{
			// Form
			echo("<form id='editForm' name='editForm' action='".$action."' method='POST'>");
			echo("<table id='editTable' ><tr><th id='thLine' >Línea</th><th id='thTxtOr'>Original</th><th id='thTxtTr'>Traducción</th></tr>");
			foreach($translatedLines as $lObj) 
			{
				echo("<tr>");
				echo("<td><mark>$lObj->lineNumber</mark></td>");
				echo("<td id='tdTxtOr'>$lObj->originalLine</td>");
				
				$prevLines="";
				foreach($lObj->previousLines as $l)
					$prevLines.=$l."</br>";
				$prevLines.="<div style='color:red;'>".$lObj->originalLine."</div>";
				
				echo("<td class='tooltip'><input type='text' class='classInputEditTxt' name='$lObj->lineNumber' value='$lObj->translatedLine' /> <span><img class='callout' src='images/callout.gif' />$prevLines</span> </td>");
				echo("</tr>");
			}
			echo("</table>");
			echo("<input type='hidden' name='file_name' value='$fileName'>");
			
			echo("<div class='download'>
					<input id='downloadButton' type='submit' value='Descargar' title='Descargar subtitulo'>
				  </div>
				  <a href='$url' title='Volver al inicio'><img src='$img' alt='Volver al inicio'/></a>			  
				");
			echo("</form><br/>");			
			return true;
		}
		return false;
	}
	
	public function buildBackButton($url,$img)
	{
		echo("<a href='$url' title='Volver al inicio'><img src='$img' alt='Volver al inicio'/></a>");
	}
	
	public function showError($error,$url,$img)
	{
		echo("<div id='error'><p>ERROR: $error</p><a href='$url' title='Volver al inicio'><img src='$img' alt='Volver al inicio'/></a></div><br/><br/><br/><br/><br/><br/><br/><br/>");
	}
	
	public function showEditTitles()
	{
		echo("<div id='editHeader'>");
		echo("<h2>Edita el subtítulo y descárgalo</h2>");
		echo("<p>Chequea las traducciones manualmente para lograr un subtítulo sin errores</p>");
		echo("</div>");
	}
}	
?>