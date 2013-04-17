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
$epub->setLanguage("zh_CN");

//file object add
//$css = new Epub_Element_Css("sample");
//$epub->addCss($css);
//
$css = new Epub_Element_Css();
$css->setSrc('style.css');
$css->setFile('image/style.css');
$epub->addCss($css);

$image = new Epub_Element_Image();
$image->setSrc('1.jpg');
$image->setFile('image/1.jpg');
$epub->addImage($image);

$html = new Epub_Element_Html();
$html->setSrc('1.html');
$html->setFile('1.html');
$epub->addChapter('section 1', $html);

$html = new Epub_Element_Html();
$html->setSrc('2.html');
$html->setFile('2.html');
$epub->addChapter('section 2', $html);

$html = new Epub_Element_Html();
$html->setSrc('3.html');
$html->setFile('3.html');
$epub->setCover($html);

//create file
$epub->create("sample.epub");

/* vim: set ts=4 sw=4 sts=4 tw=2000: */
