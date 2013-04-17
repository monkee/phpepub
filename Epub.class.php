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

	private $htmls = array();
    public function __construct(){
		foreach($this->elements as $k => $v){
			$class = 'Epub_Element_' . ucfirst($k);
			$this->elements[$k] = new $class();
		}
		$this->elements['opf']->addElement($this->elements['ncx']);
    }
	public function addImage(Epub_Element_Image $image){
		$this->addHtmlElement($image);
	}

	public function addCss(Epub_Element_Css $css){
		$this->addHtmlElement($css);
	}

    public function addChapter($chapterSubject, Epub_Element_Html $chapter){
		$this->addHtmlElement($chapter);
		$this->elements['ncx']->addNav(new Epub_Element_Ncx_Nav($chapter->getId(), Epub_Element_Ncx_Nav::genPlayOrder(), $chapter->getFile(), $chapterSubject));
    }

	public function addHtmlElement(Epub_Element $ele){
		$this->elements['opf']->addElement($ele);
		$this->htmls[] = $ele;
	}

	public function setCover(Epub_Element_Html $cover){
		$this->elements['opf']->setCover($cover);
		$this->elements['ncx']->setCover($cover);
		$this->htmls[] = $cover;
	}

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
	}

	public function __call($method, $argv){
		if('setAuthor' == $method || 'setTitle' == $method){
			$this->elements['ncx']->$method($argv[0]);
		}
		$this->elements['opf']->__call($method, $argv);
	}
}

?>
