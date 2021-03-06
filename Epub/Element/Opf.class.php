<?php
/**
 *
 * 
 * @author zomboo1(@126.com)
 */
class Epub_Element_Opf extends Epub_Element
{
	static private $TYPE_TO_META = array(
		'xml' => 'text/xml',
		'html' => 'application/xhtml+xml',
		'css' => 'text/css',
		'jpg' => 'image/jpeg',
		'jpeg' => 'image/jpeg',
		'png' => 'image/png',
		'ncx' => 'application/x-dtbncx+xml',
	);
	private $metadata = array(
		'dc:title' => 'epub title',	//标题
		'dc:language' => 'cn',	//语言，en英文
		'dc:identifier' => 'http://somehost.com/id.html',	//标识，唯一
		'dc:description' => 'epub description',	//描述，书的简介
		'dc:publisher' => 'who',	//发布者
		'dc:relation' => 'relation',	//关联方，可以是网址
		'dc:creator' => 'monkee',
		'dc:date' => '2013-03-24',
		'dc:rights' => 'Open access',
		'dc:source' => 'source',
	);

	private $manifest = array();

	private $cover = null; //封面，image对象
	public function __construct(){
		$this->file = 'bdoc.opf';
		$this->id = 'bdoc-' . substr(md5(time() . rand(0, 1000)), 0, 12);
	}

	public function setCover(Epub_Element_Html $cover){
		$this->cover = $cover;
	}

	public function addElement(Epub_Element $ele){
		$this->manifest[] = $ele;
	}

	public function __call($method, $argv){
		if(strpos($method, 'set') === 0){
			$key = 'dc:' . strtolower(substr($method, 3));
			if(isset($this->metadata[$key])){
				$this->metadata[$key] = htmlspecialchars($argv[0]);
			}
		}
	}

	public function getString(){
		//四大块，分别为：metadata、manifest、spine、guide
		$this->clearString();
		$this->addString('<package xmlns="http://www.idpf.org/2007/opf" unique-identifier="' . $this->id . '" version="2.0">');

		$this->addMetadata();
		$this->addManifest();
		$this->addSpine();
		//$this->addGuide();  //暂时还没搞清楚这是干嘛的，注释掉

		$this->addString('</package>');
		return $this->string;
	}

	private function addMetadata(){
		$this->addString('<metadata xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:opf="http://www.idpf.org/2007/opf" xmlns:dcterms="http://purl.org/dc/terms/">');
		foreach($this->metadata as $key => $value){
			if('dc:identifier' == $key){
				$this->addString(sprintf('<dc:identifier id="%s" opf:scheme="URI">%s</dc:identifier>', $this->id, $value));
			}elseif('dc:creator' == $key){
				$this->addString(sprintf('<dc:creator opf:file-as="%s" opf:role="aut">%s</dc:creator>', $value, $value));
			}else{
				$this->addString(sprintf('<%s>%s</%s>', $key, $value, $key));
			}
		}
		//add cover page
		if(!empty($this->cover)){
			$this->addString(sprintf('<meta name="%s" content="coverImage" />', $this->cover->getId()));
		}
		$this->addString('</metadata>');
	}

	private function addManifest(){
		$this->addString('<manifest>');
		if(!empty($this->cover)){
			$ele = $this->cover;
			$this->addString(sprintf(
				'<item id="%s" href="%s" media-type="%s" />',
				$ele->getId(), $ele->getFile(), self::$TYPE_TO_META[$ele->getType()]
			));
		}
		foreach($this->manifest as $ele){
			$this->addString(sprintf(
				'<item id="%s" href="%s" media-type="%s" />',
				$ele->getId(), $ele->getFile(), self::$TYPE_TO_META[$ele->getType()]
			));
		}
		$this->addString('</manifest>');
	}

	private function addSpine(){
		$this->addString('<spine toc="ncx">');

		if(!empty($this->cover)){
			$ele = $this->cover;
			$this->addString(sprintf(
				'<itemref idref="%s" linear="no"/>',
				$ele->getId()
			));
		}
		foreach($this->manifest as $ele){
			if('html' != $ele->getType()){
				continue;
			}
			$this->addString(sprintf(
				'<itemref idref="%s" linear="no"/>',
				$ele->getId()
			));
		}
		$this->addString('</spine>');
	}
	private function addGuide(){
		$this->addString('<guide>');
		if(!empty($this->cover)){
			$this->addString(sprintf('<reference href="%s" type="cover" title="%s"/>', $this->cover->getFile(), $this->cover->getId()));
		}
		$this->addString('</guide>');
	}
}


/* vim: set ts=4 sw=4 sts=4 tw=2000: */
