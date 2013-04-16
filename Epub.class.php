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
    }
	public function addImage(Epub_Element_Image $image){
	}

	public function addCss(Epub_Element_Css $css){
	}

    public function addChapter($chapterSubject, Epub_Element_Html $chapter){
    }

	public function create($epubfile){
		$zip = new Epub_Zip();
		$zip->setZipFile($epubfile);
		$zip->setComment("Create by PHPEpub.\nCreate On " . date('Y-m-d H:i:s'));

		//add elements
		foreach($this->elements as $ele){
			$zip->addFile($ele->asString(), $ele->getFile());
		}

		//add HTMLs
		foreach($this->htmls as $ele){
			$zip->addFile($ele->asString(), $ele->getFile());
		}

		//$zip->sendZip($epubfile);
		$zip->finalize();
	}

	public function __call($method, $argv){
		$this->elements['opf']->__call($method, $argv);
	}
}

?>
