<?php
/**
 *
 * 
 * @author zomboo1(@126.com)
 */
class Epub_Element_Opf extends Epub_Element
{
	public function __construct(){
		$this->file = 'bdoc.opf';
	}

	public function __call($method, $argv){
	}
}


/* vim: set ts=4 sw=4 sts=4 tw=2000: */
