<?php
/**
 *
 * 
 * @author zomboo1(@126.com)
 */


include "../autoload.php";

//$rss = new Epub_Rss('http://blog.sina.com.cn/rss/1415876030.xml');
$rss = new Epub_Rss('http://blog.sina.com.cn/rss/1463029193.xml');

$rss->create("rss.epub");

/* vim: set ts=4 sw=4 sts=4 tw=2000: */
