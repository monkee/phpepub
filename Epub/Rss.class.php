<?php
/**
 * Create Epub from rss
 * 
 * @author zomboo1(@126.com)
 */

class Epub_Rss
{
	private $content = '';
	private $xml = null;
	private $htmlName = 1;

	/**
	 * init from a rss url or well formatted xml string
	 *
	 * @param string $rss
	 */
	public function __construct($rss){
		$this->initXml($rss);
	}

	/**
	 * Exec parse and put out a epub file
	 *
	 * @param string $epub a epub file where you want to store
	 */
	public function create($output){
		$channel = $this->xml->channel;
		$channel = (array)$channel;

		$this->epub = new Epub();

		//meta info
		$this->epub->setTitle($channel['title']);
		$this->epub->setDescription($channel['description']);
		$this->epub->setLanguage($channel['language']);
		$this->epub->setPublisher($channel['generator']);
		$this->epub->setDate($channel['pubDate']);
		$this->epub->setRights($channel['copyright']);

		foreach($channel['item'] as $item){
			$item = (array)$item;
			$this->createItem($item);
		}

		$this->epub->create($output);
	}

	private function createItem($item){
		$html = new Epub_Element_Html();
		$html->setFile($this->getHtml());
		$html->setContent($this->getHtmlContent($item));
		$this->epub->addChapter($item['title'], $html);
	}

	private function getHtml(){
		return $this->htmlName++ . '.html';
	}

	private function getHtmlContent($item){
		$str = <<<EOF
<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
EOF;
		$str .= sprintf("<title>%s</title>\n", htmlspecialchars($item['title']));
		$str .= "</head>\n";
		$str .= "<body>\n";
		$str .= sprintf("<h1>%s</h1>\n", (string)$item['title']);
		$str .= $this->clearTag((string)$item['description']);
		$str .= "</body></html>\n";
		return $str;
	}

	private function clearTag($html){
		$html = mb_strtolower($html, 'utf-8');
		//$html = preg_replace('/<(div|span|p|ul|li|ol)[^>]+>/i', '<$1>', $html);
		//echo $html;exit;
		return $html;
	}

	private function initXml($rss){
		if(preg_match('/^http:\/\//', $rss)){
			$ch = curl_init($rss);
			$headers = array(
				'User-Agent:Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.97 Safari/537.22'
			);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$r = curl_exec($ch);

			if(curl_errno($ch) > 0){
				throw new Epub_Exception("Get rss from {$rss} failed, error : " . curl_error(), curl_errno($ch));
			}
			$rss = $r;
		}
		libxml_use_internal_errors();
		$this->xml = simplexml_load_string($rss);
		if($this->xml === false){
			throw new Epub_Exception("Rss string is not well formatted");
		}
	}
}

/* vim: set ts=4 sw=4 sts=4 tw=2000: */
