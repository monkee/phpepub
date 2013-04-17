<?php
/**
 *
 * 
 * @author zomboo1(@126.com)
 */

class Epub_Zip extends Epub_Zip_Zip
{
	private $index = array();

	public function __construct(){
	}

	public function addFile($fileContent, $file){
		if(isset($this->index[$file])){
			return;	//如果重复提交文件，则直接退出
		}
		$dirs = explode('/', $file);
		array_pop($dirs);

		$pDir = '';
		foreach($dirs as $dir){
			empty($pDir) || $pDir .= '/';
			$pDir .= $dir;
			//$this->addDirectory($pDir);
		}
		$this->index[$file] = 1;
		parent::addFile($fileContent, $file);
	}

	public function addDirectory($dir, $timestamp = 0, $fileComment = NULL){
		if(isset($this->index[$dir])){
			return;
		}
		$this->index[$dir] = 1;
		parent::addDirectory($dir, $timestamp, $fileComment);
	}
}





/* vim: set ts=4 sw=4 sts=4 tw=2000: */
