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
class Line
{
	public $lineNumber;
	public $originalLine;
	public $translatedLine;
	public $previousLines;
	
	public function Line($lineNumber,$originalLine,$translatedLine,$previousLines)
	{
		$this->lineNumber=$lineNumber;
		$this->originalLine=$originalLine;
		$this->translatedLine=$translatedLine;		
		$this->previousLines=$previousLines;
	}
}
?>