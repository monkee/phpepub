<?php
/**
 * mimetype file
 *
 * a file contain basic zip type info
 * string "application/epub+zip" in it
 * 
 * @author zomboo1(@126.com)
 */

class Epub_Element_Mimetype extends Epub_Element
{
	public function __construct(){
		$this->file = 'mimetype';
		$this->string = 'application/epub+zip';
		$this->type = 'text';
	}

	public function asString(){
		return $this->string;
	}
}


/* vim: set ts=4 sw=4 sts=4 tw=2000: */
