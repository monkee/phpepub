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
$css = new Epub_Element_CSS("sample");
$epub->addCSS($cssObject);
$epub->addImage($imageObject);
$epub->addChapter($chapterName, $htmlObject);

//create file
$epub->create("sample.epub");

/* vim: set ts=4 sw=4 sts=4 tw=2000: */
