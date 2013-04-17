<?php
/**
 *
 * 
 * @author zomboo1(@126.com)
 */
class Epub_Element_Ncx_Nav
{
	static private $PLAY_ORDER_ID = 1;
	public $id = '';
	public $playOrder = '';
	public $src = '';
	public $text = '';

	public function __construct($id = '', $playOrder = 0, $src = '', $text = ''){
		$this->id = $id;
		$this->playOrder = $playOrder;
		$this->src = $src;
		$this->text = $text;
	}

	static public function genPlayOrder(){
		return self::$PLAY_ORDER_ID++;
	}
}


/* vim: set ts=4 sw=4 sts=4 tw=2000: */
