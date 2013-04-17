<?php
/**
 *
 * 
 * @author zomboo1(@126.com)
 */


include "../autoload.php";


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

for($i = 1; $i < 2; $i++){
	$html = new Epub_Element_Html();
	$html->setSrc('1.html');
	$html->setFile($i . '.html');
	$epub->addChapter('section ' . $i, $html);
}


//create file
$epub->create("sample.epub");

/* vim: set ts=4 sw=4 sts=4 tw=2000: */
