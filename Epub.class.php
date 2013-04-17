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

class Epub
{
	/**
	 * 包含的基础元素，核心数据，也是必须的
	 *
	 * @var array
	 */
	private $elements = array(
		'mimetype' => null,
		'opf' => null,
		'container' => null,
		'ncx' => null,
	);

	/**
	 * html relates files
	 *
	 * @var array
	 */
	private $htmls = array();

	/**
	 * construct method
	 */
    public function __construct(){
		foreach($this->elements as $k => $v){
			$class = 'Epub_Element_' . ucfirst($k);
			$this->elements[$k] = new $class();
		}
		$this->elements['opf']->addElement($this->elements['ncx']);
    }

	/**
	 * Add a image object
	 *
	 * attention : param must be Epub_Element_Image object
	 *
	 * @param Epub_Element_Image $image You can instance it with "new Epub_Element_Image"
	 */
	public function addImage(Epub_Element_Image $image){
		$this->addHtmlElement($image);
	}

	/**
	 * Add a css object
	 *
	 * attention : param must be Epub_Element_Css object
	 *
	 * @param Epub_Element_Css $css You can instance it with "new Epub_Element_Css"
	 */
	public function addCss(Epub_Element_Css $css){
		$this->addHtmlElement($css);
	}

	/**
	 * Add a chapter navigation
	 *
	 * This method has a little problem:
	 * 1. One html must add with a chapter
	 * 2. One chapter must point to a html, and, badly can not use "a.html#link"
	 *
	 * @todo seperate html & chapter to two methods
	 *
	 * @param string $chapterSubject subject of chapter, this will display in the catalog
	 * @param Epub_Element_Html $chapter not really mean chapter object, but Html object
	 */
    public function addChapter($chapterSubject, Epub_Element_Html $chapter){
		$this->addHtmlElement($chapter);
		$this->elements['ncx']->addNav(new Epub_Element_Ncx_Nav($chapter->getId(), Epub_Element_Ncx_Nav::genPlayOrder(), $chapter->getFile(), $chapterSubject));
    }

	/**
	 * SET cover of this ebook
	 *
	 * Must be a html object,
	 * Why?
	 * I can not tell you right now,sorry
	 *
	 * @param Epub_Element_Html $cover
	 */
	public function setCover(Epub_Element_Html $cover){
		$this->elements['opf']->setCover($cover);
		$this->elements['ncx']->setCover($cover);
		$this->htmls[] = $cover;
	}

	/**
	 * Final create epub file
	 *
	 * This method will create a *.epub file in your path,
	 * make sure we have the write access
	 *
	 * !!!!! if the file is exist, we will overwrite
	 *
	 * @param string $epubfile output file
	 */
	public function create($epubfile){
		$zip = new Epub_Zip();
		$zip->setZipFile($epubfile);

		//add elements
		foreach($this->elements as $ele){
			$zip->addFile($ele->asString(), $ele->getFile());
		}

		//add HTMLs
		foreach($this->htmls as $ele){
			$zip->addFile($ele->asString(), $ele->getFile());
		}

		$zip->finalize();
		unset($zip);
	}

	/**
	 * Accept method like "set***"
	 *
	 * if the method we do not support, nothing will happen
	 *
	 */
	public function __call($method, $argv){
		if('setAuthor' == $method || 'setTitle' == $method){
			$this->elements['ncx']->$method($argv[0]);
		}
		$this->elements['opf']->__call($method, $argv);
	}

	/**
	 * Add html type element
	 *
	 * This will add to the element, and build the relations of elements
	 *
	 * @param Epub_Element $ele Epub_Element & sub_class of Epub_Element
	 */
	private function addHtmlElement(Epub_Element $ele){
		$this->elements['opf']->addElement($ele);
		$this->htmls[] = $ele;
	}
}

?>
