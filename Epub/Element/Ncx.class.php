<?php
/**
 * ncx文件，电子书的目录
 * 
 * @author zomboo1(@126.com)
 */
class Epub_Element_Ncx extends Epub_Element
{
	private $navMap = array();

	private $docTitle = 'Default';
	private $docAuthor = 'Default';

	private $chapterID = 1;
	private $playOrder = 1;

	public function __construct(){
		$this->file = 'bdoc.ncx';
		$this->type = 'ncx';
		$this->id = 'ncx';
	}

	public function setTitle($title){
		$this->docTitle = $title;
	}

	public function setAuthor($author){
		$this->docAuthor = $author;
	}

	/**
	 * 增加导航内容
	 *
	 * 必须为：Epub_Element_Ncx_Nav对象
	 *
	 * @param Epub_Element_Ncx_Nav $nav
	 */
	public function addChapter(Epub_Chapter $chapter){
		$this->navMap[] = $chapter;
	}

	public function setCover(Epub_Element_Html $html){
		$chapter = new Epub_Chapter();
		$chapter->setTitle('封面');
		$chapter->setLink($html);
		array_unshift($this->navMap, $chapter);
	}

	public function getString(){
		$this->clearString();
		//doctype section
		$this->addString('<!DOCTYPE ncx PUBLIC "-//NISO//DTD ncx 2005-1//EN" "http://www.daisy.org/z3986/2005/ncx-2005-1.dtd">');
		$this->addString('<ncx xmlns="http://www.daisy.org/z3986/2005/ncx/" version="2005-1">');
		//meta section
		$this->addString('<head>');
		$this->addString('<meta name="dtb:uid" content="" />');
		$this->addString('<meta name="dtb:depth" content="2" />');
		$this->addString('<meta name="dtb:totalPageCount" content="0" />');
		$this->addString('<meta name="dtb:maxPageNumber" content="0" />');
		$this->addString('<meta name="dtb:generator" content="PHPEpub (v0.1) alpha, https://github.com/monkee/phpepub" />');
		$this->addString('</head>');
		//docTitle & docAuthor
		$this->addString(sprintf('<docTitle><text>%s</text></docTitle>', $this->docTitle));
		$this->addString(sprintf('<docAuthor><text>%s</text></docAuthor>', $this->docAuthor));
		//navmap section
		$this->addString('<navMap>');
		foreach($this->navMap as $chapter){
			$string = sprintf('<navPoint id="%s" playOrder="%d"><navLabel><text>%s</text></navLabel><content src="%s" />',
				$this->genChapterId(), $this->genPlayOrder(), $chapter->getTitle(), $chapter->getLink());
			$this->addString($string);
			foreach($chapter->getSubChapters() as $subChapter){
				$string = sprintf('<navPoint id="%s" playOrder="%d"><navLabel><text>%s</text></navLabel><content src="%s" /></navPoint>',
					$this->genChapterId(), $this->genPlayOrder(), $subChapter->getTitle(), $subChapter->getLink());
				$this->addString($string);
			}
			$this->addString('</navPoint>');
		}
		$this->addString('</navMap>');

		//end
		$this->addString('</ncx>');

		return $this->string;
	}

	public function genChapterId(){
		return 'chapter_' . $this->chapterID++;
	}

	public function genPlayOrder(){
		return $this->playOrder++;
	}
}


/* vim: set ts=4 sw=4 sts=4 tw=2000: */
