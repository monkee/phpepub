phpepub
=======

# 简介

使用PHP创建epub电子书

# 目标

我们的目的是希望更多的资源可以在移动端体验良好地访问。这个开源项目，方便更多的网站实现这个目标。


# 备注

epub介绍：http://idpf.org/epub  
zip class : http://www.phpclasses.org/package/6110

# example

1. sample/sample.php

# fix bugs

1. html file DOCTYPE should be absolutely 
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">  
	if not district, when using epub2pdf it will throw Exception and convert fail.
