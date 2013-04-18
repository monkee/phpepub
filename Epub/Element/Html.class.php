<?php
/**
 *
 * 
 * @author zomboo1(@126.com)
 */
class Epub_Element_Html extends Epub_Element
{
	private $srcFile = '';
	public function __construct($id = ''){
		$this->file = $file;
		$this->type = 'html';
		$this->mimedata = '';
		if(empty($id)){
			$this->genId();
		}else{
			$this->id = $id;
		}
	}

	public function setSrc($file){
		$this->srcFile = $file;
	}

	public function setFile($file){
		$this->file = $file;
	}

	public function setContent($content){
		$this->string = $content;
		$this->srcFile = '';
	}

	public function getString(){
		if(empty($this->srcFile)){
			return $this->string;
		}
		return file_get_contents($this->srcFile);
	}
}


/* vim: set ts=4 sw=4 sts=4 tw=2000: */
