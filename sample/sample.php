<?php
/**
 *
 * 
 * @author zomboo1(@126.com)
 */


include "../Epub.class.php";


$epub = new Epub();

//meta set
$epub->setTitle("百度文库生成的文档");
$epub->setAuthor("百度文库");
//$epub->setTitle("baidu wenku ");
//$epub->setAuthor("wenku");
$epub->setLanguage("zh-CN");

//file object add
//$css = new Epub_Element_Css("sample");
//$epub->addCss($css);
//
$css = new Epub_Element_Css();
$css->setSrc('style.css');
$css->setFile('image/style.css');
$epub->addCss($css);

$html = new Epub_Element_Html();
$html->setSrc('0.html');
$html->setFile('0.html');
$epub->setCover($html);

$image = new Epub_Element_Image();
$image->setSrc('1.jpg');
$image->setFile('image/1.jpg');
$epub->addImage($image);

for($i = 1; $i < 9; $i++){
	$html = new Epub_Element_Html();
	$html->setContent(str_replace('%%%%%%%%', $i, file_get_contents('1.html')));
	$html->setFile($i . '.html');
	$epub->addHtml($html);
	$chapter = new Epub_Chapter();
	$chapter->setTitle('section ' . $i);
	$chapter->setLink($html);

	if($i < 4){
		$sub = new Epub_Chapter_Sub();
		$sub->setTitle('link' . $i);
		$sub->setLink($html, 'link' . $i);
		$chapter->addSubChapter($sub);
	}
	$epub->addChapter($chapter);
}


//create file
$epub->create("sample.epub");

/* vim: set ts=4 sw=4 sts=4 tw=2000: */
