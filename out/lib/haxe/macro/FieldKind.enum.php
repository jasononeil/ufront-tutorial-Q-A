<?php

class haxe_macro_FieldKind extends Enum {
	public static function FMethod($k) { return new haxe_macro_FieldKind("FMethod", 1, array($k)); }
	public static function FVar($read, $write) { return new haxe_macro_FieldKind("FVar", 0, array($read, $write)); }
	public static $__constructors = array(1 => 'FMethod', 0 => 'FVar');
	}
