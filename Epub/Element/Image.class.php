<?php
/**
 *
 * 
 * @author zomboo1(@126.com)
 */
class Epub_Element_Image extends Epub_Element
{
	private $srcFile = '';
	public function __construct($file = ''){
		$this->file = $file;
		$this->type = 'image';
		$this->genId();
	}

	public function setSrc($file){
		$this->srcFile = $file;
	}

	public function setFile($file){
		$this->file = $file;
	}

	public function getString(){
		return file_get_contents($this->srcFile);
	}
}


/* vim: set ts=4 sw=4 sts=4 tw=2000: */
