<?php

class haxe_io_StringInput extends haxe_io_BytesInput {
	public function __construct($s) { if(!php_Boot::$skip_constructor) {
		parent::__construct(haxe_io_Bytes::ofString($s),null,null);
	}}
	function __toString() { return 'haxe.io.StringInput'; }
}
