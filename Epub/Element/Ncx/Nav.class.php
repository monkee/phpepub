<?php
/**
 *
 * 
 * @author zomboo1(@126.com)
 */
class Epub_Element_Ncx_Nav
{
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
}


/* vim: set ts=4 sw=4 sts=4 tw=2000: */
