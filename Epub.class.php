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

if(!defined("DS")){
	define("DS", DIRECTORY_SEPARATOR); //使用DS作为DIRECTORY_SEPARATOR的缩写，已经成为了一种共识
}

define("PE_ROOT", dirname(__FILE__));

spl_autoload_register("__pepub_autoload"); //注册自动载入函数，使得类的载入规则化

/**
 * autoload
 * 
 * 规则如下：
 * 1. 根目录下，每个类包的拥有单独的命名空间，与该目录的名称一致
 * 2. 类包可拥有与自己命名空间一致的类，称之为默认类或者主类
 * 3. 如包：Sample下，class Sample是主类
 * 4. new Sample_SubClass() 载入的类为：Sample/SubClass
 * 5. 尚未使用PHP5.3的命名空间，未保证代码向前有一定的兼容性
 * 6. 文件名与类名一致，将"/"换成"_"即可；文件使用".class.php"作为文件后缀
 * 
 * @param string $class
 * @throws SDException
 */
function __pepub_autoload($class){
	$classPath = str_replace('_', DS, $class);
	$classPath = PE_ROOT . DS . $classPath . '.class.php';
	if(is_file($classPath)){
		include_once $classPath;
	}
}

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
	 * Add a html object
	 *
	 * attention : param must be Epub_Element_Css object
	 *
	 * @param Epub_Element_Html $html You can instance it with "new Epub_Element_Html"
	 */
	public function addHtml(Epub_Element_Html $html){
		$this->addHtmlElement($html);
	}

	/**
	 * Add a chapter navigation
	 *
	 * We have to know:
	 * 
	 * 1. Default the Epub_Element_Html object will not be add to the Object
	 *    so, you do has to use addHtml to add this object
	 * 2. You can add sub chapter, you can do it with Epub_Chapter::addSubChapter
	 *    Of course, you have to instance with : new Epub_Chapter_Sub
	 *
	 * @param string $chapterSubject subject of chapter, this will display in the catalog
	 * @param Epub_Element_Html $chapter not really mean chapter object, but Html object
	 */
    public function addChapter(Epub_Chapter $chapter){
		$this->elements['ncx']->addChapter($chapter);
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


