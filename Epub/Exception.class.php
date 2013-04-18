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

/**
 * 该类库下的通用异常
 * 
 * 默认情况下，使用这个异常类来承载信息
 * 这意味着，我们可以更加专注于正常的逻辑流程，而不必考虑如何使用错误码来
 * 各个子包可以有自己的异常处理机制，可以有考虑
 * 1. 继承该异常类
 * 2. 继承PHP自己的Exception
 * 
 * 如果只是在本类包下使用这个子包，那么使用SDException更方便
 * 如果期望更加通用地使用这个子包，那么使用Exception有更好的可移植性
 * 
 * @author monkee
 */
class Epub_Exception extends Exception{
	/**
	 * 构造函数
	 * 
	 * @param string $message
	 * @param int $code
	 */
	public function __construct($message, $code = 0){
		parent::__construct($message, $code);
	}
	
	/**
	 * 当做string时的输出格式话
	 * 
	 * @return string
	 */
	public function __toString(){
		return sprintf("[%d] %s (%s-%d)",
			$this->code, $this->message, $this->file, $this->line);
	}
}
