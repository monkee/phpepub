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
$epub->setLanguage("zh_CN");

//file object add
//$css = new Epub_Element_Css("sample");
//$epub->addCss($css);
//$epub->addImage($imageObject);
$html = new Epub_Element_Html();
$html->setSrc('1.html');
$html->setFile('1.html');
$epub->addChapter('section 1', $html);

$html = new Epub_Element_Html();
$html->setSrc('2.html');
$html->setFile('2.html');
$epub->addChapter('section 2', $html);

//create file
$epub->create("sample.epub");

/* vim: set ts=4 sw=4 sts=4 tw=2000: */
