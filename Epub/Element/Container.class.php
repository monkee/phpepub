<?php
/**
 *
 * 
 * @author zomboo1(@126.com)
 */
class Epub_Element_Container extends Epub_Element
{
	public function __construct(){
		$this->file = 'META-INF/container.xml';
		$this->type = 'xml';
		$this->string = <<<EOF
<container version="1.0" xmlns="urn:oasis:names:tc:opendocument:xmlns:container">
	<rootfiles>
		<rootfile full-path="bdoc.opf" media-type="application/oebps-package+xml" />
	</rootfiles>
</container>
EOF;
	}
}



/* vim: set ts=4 sw=4 sts=4 tw=2000: */
