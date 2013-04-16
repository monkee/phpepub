<?php
/**
 * A class for creating Epub file by php;
 *
 * I have seen some of class that cat create Epub,
 * but none of them is well-formatted.
 * So I write this class to help build a good class;
 *
 * @file Epub.class.php
 * @author zomboo1(@126.com)
 * @date 2013/04/15 20:59:16
 */

class Epub_Element
{
	protected $file = '';	//file name & path relate in zip
	protected $type = 'xml';	//file type,default is 'xml', text|html|image is also supported
	protected $string = '';	//file content
	protected $id = '';	//

	/**
	 * get file text
	 *
	 * this string can direct write to the file it point to
	 *
	 * @return string
	 */
	public function asString(){
		if($this->type == 'xml'){
			return '<?xml version="1.0" encoding="UTF-8"?>' . "\n" . $this->getString();
		}
		return $this->getString();
	}

	final public function getId(){
		return $this->id;
	}
	final public function getType(){
		return $this->type;
	}

	final public function getFile(){
		return $this->file;
	}

	final public function addString($line){
		$this->string .= "{$line}\n";
	}

	final public function clearString(){
		$this->string = '';
	}

	public function getString(){
		return $this->string;
	}
}

/* vim: set ts=4 sw=4 sts=4 tw=2000: */
?>
