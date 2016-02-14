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

class Translator
{
	private $error;
	private $previousLines;
	private $previousLinesIndex;
	
	public function Translator()
	{
		$this->error="";
		$this->previousLines = array();
		$this->previousLinesIndex=0;
	}
	
	/*
		Translate: Lee el archivo que esta en $_FILES con el nombre "file" y lo traduce. Devuelve un array de objetos "Line". Deja en la sesion el contenido del archivo original
	*/
	public function Translate()
	{
		$translatedLines=null;
		if (!empty($_FILES)) 
		{
			$tempFile = $_FILES['file']['tmp_name'];
			if($tempFile==null)
			{
				$this->error="El archivo no existe";
				return null;
			}
			$fileSize = $_FILES['file']['size'];
			if($fileSize > 200000) // 200Kbytes
			{
				$this->error="El archivo es demasiado grande";
				return null;
			}	
			
			$handle = fopen($tempFile, "r");
			if ($handle) 
			{
				$lineNumber=1;
				$fileContent="";
				$translatedLines = array();
				
				while (($line = fgets($handle)) !== false) 
				{
					$lineOriginal = utf8_encode ($line);
					$fileContent=$fileContent.$lineOriginal;
					$line2 = $lineOriginal;

					// Expresiones regulares
					$fin="(\r\n|[^a-zA-Z0-9]+)/mi"; // si termina con fin de linea o cualquier cosa que no sean caracteres (espacio, comas puntos,etc)
					// ********************
					
					// Expresiones
					$line2 = preg_replace ("/me gusta un follón/i",'me gusta mucho',$line2);
					$line2 = preg_replace ("/me gusta un mogollón/i",'me gusta mucho',$line2);
					$line2 = preg_replace ("/me mola/i",'me gusta',$line2);
					$line2 = preg_replace ('/la pasta/i','el dinero',$line2);
					$line2 = preg_replace ('/de pasta/i','de dinero',$line2);	
					$line2 = preg_replace ('/el tío/i','el tipo',$line2);
					$line2 = preg_replace ('/este tío/i','este tipo',$line2);
					$line2 = preg_replace ('/ese tío/i','ese tipo',$line2);
					$line2 = preg_replace ('/aquel tío/i','aquel tipo',$line2);
					$line2 = preg_replace ('/un tío/i','un tipo',$line2);					
					$line2 = preg_replace ('/los tíos/i','los tipos',$line2);
					$line2 = preg_replace ('/estos tíos/i','estos tipos',$line2);
					$line2 = preg_replace ('/esos tíos/i','esos tipos',$line2);
					$line2 = preg_replace ('/aquellos tíos/i','aquellos tipos',$line2);
					$line2 = preg_replace ('/unos tíos/i','unos tipos',$line2);
					$line2 = preg_replace ('/venga,/i','vamos,',$line2);
					
					// os
					$line2 = preg_replace ('/(^os) habéis /i','se han ',$line2);
					$line2 = preg_replace ('/( os) habéis /i',' se han ',$line2);
					$line2 = preg_replace ('/(¿os) habéis /i','¿se han ',$line2);
					
					$line2 = preg_replace ('/(^os) han /i','los han ',$line2);
					$line2 = preg_replace ('/( os) han /i',' los han ',$line2);
					$line2 = preg_replace ('/(¿os) han /i','¿los han ',$line2);
					
					$line2 = preg_replace ('/(^os) ha /i','les ha ',$line2);
					$line2 = preg_replace ('/( os) ha /i',' les ha ',$line2);
					$line2 = preg_replace ('/(¿os) ha /i','¿les ha ',$line2);
					
					$line2 = preg_replace ('/(^os)( |\r\n)/mi','les ',$line2);
					$line2 = preg_replace ('/( os)( |\r\n)/mi',' les ',$line2);
					$line2 = preg_replace ('/(¿os)( |\r\n)/mi','¿les ',$line2);
					//****
					
					// lo/el vuestro					
					$line2 = preg_replace ('/lo vuestro/mi','lo de ustedes',$line2);
					$line2 = preg_replace ('/el vuestro/mi','el de ustedes',$line2);
					// ***********
					
					// Reemplazo de palabras
					$dicPalabras = array(
					// expresiones
					"vale" =>"OK","joder"=>"carajo","coño"=>"mierda",
					//verbos		
					"iros"=>"váyanse",
					"mantened"=>"mantengan",
					"oísteis"=>"escuchaste",
					"habéis"=>"has","habíais"=>"habías",
					"sois"=>"eres","fuisteis"=>"fuiste","ser(é|á)is"=>"serás",					
					"coge"=>"agarra","cógela"=>"agárrala","cógelo"=>"agárralo","cogimos"=>"agarramos",
					"follar"=>"coger","follaste"=>"cogiste","fóllatelo"=>"cogételo","fóllatela"=>"cogétela",
					"pillan"=>"descubren","pillé"=>"descubrí","pillaron"=>"descubrieron","pillo"=>"descubro","pillaré"=>"descubriré","pillar"=>"descubrir","pillas"=>"entiendes",
					"liado"=>"ocupado","liada"=>"ocupada","ligar"=>"conquistar",
					// sustantivos
					"curro"=>"trabajo","follón"=>"problemón","chaval"=>"amigo","tío"=>"amigo","hostia"=>"puta madre","cojones"=>"huevos","coj(ó|o)n"=>"huevo","bocata"=>"bocadillo",
					"un duro"=>"un peso",
					// adjetivos
					"cabrón"=>"maldito","gilipollas"=>"estúpido","pringao"=>"estúpido","niñat(o|a)"=>"infantil","paleto"=>"campesino","morro"=>"sin vergüenza","chivato"=>"soplón",
					"cojonudo"=>"bueno","cojonuda"=>"buena","maja"=>"linda","majo"=>"lindo","majadero"=>"necio","majadera"=>"necia",
					// pronombres
					"vuestr(a|o)s"=>"sus","vuestr(a|o)"=>"tu","vosotros"=>"ustedes"
					);
					foreach($dicPalabras as $palabra => $traduccion)
					{
						if(preg_match("/(((([^a-zA-Z0-9ñÑáéíóú¡]+)$palabra)|^$palabra|¡$palabra)([^a-zA-Z0-9ñÑáéíóú!]+|\r\n|!))/mi",$line2,$matches)==1)
						{
							$line2 = preg_replace ("/$palabra/mi","$traduccion",$line2);							
						}
					}
					//***************************************************************************
					
					// Correcciones "vale"
					$line2 = preg_replace ("/más te OK/mi","más te vale",$line2);	
					//********************

					// Terminaciones
					$line2 = preg_replace ("/áis$fin",'as ',$line2);
					$line2 = preg_replace ("/ais$fin",'as ',$line2);					
					$line2 = preg_replace ("/éis$fin",'es ',$line2);					
					$line2 = preg_replace ("/áoslo$fin",'alo ',$line2);
					$line2 = preg_replace ("/ándoos$fin",'ándote ',$line2);	
					//***************
					
					if($lineOriginal!=$line2)
					{
						$translatedLines[] = new Line($lineNumber,$lineOriginal,$line2,$this->getPreviousLines());
					}
					
					if($lineOriginal!="\r\n")
						$this->pushLine($lineOriginal);
					
					$lineNumber=$lineNumber+1;
					
				}
				fclose($handle);
				
				$_SESSION['fileContent']=$fileContent;
			} 
			else 
			{
				$this->error="Leyendo el archivo";
			}
		}
		else
		{
			$this->error="No Existe el archivo";
		}
		
		return $translatedLines;
	}
	
	public function getError()
	{
		return $this->error;
	}
	
	public function isOk()
	{
		return ($this->error=="");
	}
	
	private function pushLine($line)
	{
		if($this->previousLinesIndex<8)
		{
			$this->previousLines[$this->previousLinesIndex] = $line;
			$this->previousLinesIndex++;
		}
		else
		{
			for($i=1;$i<8;$i++)
			{
				$this->previousLines[$i-1] = $this->previousLines[$i];
			}
			$this->previousLines[$i-1] = $line;
		}
	}
	
	private function getPreviousLines()
	{		
		return array_slice ($this->previousLines , 0, $this->previousLinesIndex );
	}

}

?>