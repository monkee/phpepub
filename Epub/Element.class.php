<?php
/**
 * Basic class of file object
 *
 * Each file as common methods,such as ncx,opf
 * Each file has priperties such as :
 *
 * id 
 * file file path relate to zip
 * string file content
 * type xml|opf|ncx|html|css|jpg|png
 *
 * @file Epub.class.php
 * @author zomboo1(@126.com)
 * @date 2013/04/15 20:59:16
 */

class Epub_Element
{
	static private $ID_INDEX = 0;
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

	/**
	 * Get id of this object
	 *
	 * @return string
	 */
	final public function getId(){
		return $this->id;
	}

	/**
	 * Get file Type of this object
	 *
	 * @return string
	 */
	final public function getType(){
		return $this->type;
	}

	/**
	 * Get file of this object
	 *
	 * @return string
	 */
	final public function getFile(){
		return $this->file;
	}

	/**
	 * common way to add line to file
	 *
	 * it will add \n at end of string
	 */
	final public function addString($line){
		$this->string .= "{$line}\n";
	}

	/**
	 * clear $this->string for create
	 */
	final public function clearString(){
		$this->string = '';
	}

	/**
	 * need to be override
	 *
	 * @return string
	 */
	public function getString(){
		return $this->string;
	}

	/**
	 * generate id auto
	 *
	 * set $this->id value
	 */
	final protected function genId(){
		$this->id = 'bele' . self::$ID_INDEX++;
	}
}

/* vim: set ts=4 sw=4 sts=4 tw=2000: */
?>
