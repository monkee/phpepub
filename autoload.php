<?php
/**
 * 基本的shadow载入文件
 * 
 * 包含：
 * 1. class autoload规则
 * 2. 定义基本环境常量
 * 3. 定义异常类
 * 
 * @author monkee<zomboo1@126.com>
 * @copyright 2013-2014
 * @package shadow
 * @version 0.1.0
 */

if(!defined("DS")){
	define("DS", DIRECTORY_SEPARATOR); //使用DS作为DIRECTORY_SEPARATOR的缩写，已经成为了一种共识
}

define("PE_ROOT", dirname(__FILE__));

spl_autoload_register("__pepub_autoload"); //注册自动载入函数，使得类的载入规则化

/**
 * autoload
 * 
 * 规则如下：
 * 1. 根目录下，每个类包的拥有单独的命名空间，与该目录的名称一致
 * 2. 类包可拥有与自己命名空间一致的类，称之为默认类或者主类
 * 3. 如包：Sample下，class Sample是主类
 * 4. new Sample_SubClass() 载入的类为：Sample/SubClass
 * 5. 尚未使用PHP5.3的命名空间，未保证代码向前有一定的兼容性
 * 6. 文件名与类名一致，将"/"换成"_"即可；文件使用".class.php"作为文件后缀
 * 
 * @param string $class
 * @throws SDException
 */
function __pepub_autoload($class){
	$classPath = str_replace('_', DS, $class);
	$classPath = PE_ROOT . DS . $classPath . '.class.php';
	if(!is_file($classPath)){
		throw new SDException("Class {$class} is not defined,should be {$classPath}."); //或者有别的方案也行，比如：不作为
	}
	include_once $classPath;
}

