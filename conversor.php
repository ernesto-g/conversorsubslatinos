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
		
	$fileContent = $_SESSION['fileContent'];
	
	if($fileContent!=null)
	{
		$lines = explode(PHP_EOL, $fileContent);
		
		$lineNumber=1;
		$fileContent="";
		foreach($lines as $line)
		{	
			if(isset($_POST["$lineNumber"]))
				$fileContent=$fileContent.$_POST["$lineNumber"]."\r\n";
				//$fileContent=$fileContent.$_POST["$lineNumber"];
			else
				$fileContent=$fileContent.$line."\r\n";
				//$fileContent=$fileContent.$line;
				
			$lineNumber=$lineNumber+1;
		}
			
	   header("Content-type: text/plain");
	   $fileName = "latino_".$_POST['file_name'];
	   header("Content-Disposition: attachment; filename=$fileName");
	   
	   echo(utf8_decode($fileContent));
 
   }
   else
   {
		echo("Error, sesion vencida");
   }
   //session_destroy();
?> 

