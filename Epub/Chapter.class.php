<?php
/**
 *
 * 
 * @author zomboo1(@126.com)
 */


class Epub_Chapter
{
	private $title = '';
	private $link = '';
	private $subChapters = array();

	public function __construct(){
	}

	public function setTitle($title){
		$this->title = $title;
	}

	public function setLink(Epub_Element_Html $html, $href = ''){
		$this->link = $html->getFile();
		if($href){
			$this->link .= '#' . $href;
		}
	}

	public function addSubChapter(Epub_Chapter_Sub $chapter){
		$this->subChapters[] = $chapter;
	}

	public function __call($method, $param){
		if(strpos($method, 'get') === 0){
			$method = substr($method, 3);
			$method[0] = strtolower($method[0]);
			if(property_exists($this, $method)){
				return $this->$method;
			}
		}
		return null;
	}
}





/* vim: set ts=4 sw=4 sts=4 tw=2000: */
