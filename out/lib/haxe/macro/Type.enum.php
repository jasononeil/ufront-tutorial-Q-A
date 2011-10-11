<?php

class haxe_macro_Type extends Enum {
	public static function TAnonymous($a) { return new haxe_macro_Type("TAnonymous", 5, array($a)); }
	public static function TDynamic($t) { return new haxe_macro_Type("TDynamic", 6, array($t)); }
	public static function TEnum($t, $params) { return new haxe_macro_Type("TEnum", 1, array($t, $params)); }
	public static function TFun($args, $ret) { return new haxe_macro_Type("TFun", 4, array($args, $ret)); }
	public static function TInst($t, $params) { return new haxe_macro_Type("TInst", 2, array($t, $params)); }
	public static function TLazy($f) { return new haxe_macro_Type("TLazy", 7, array($f)); }
	public static function TMono($t) { return new haxe_macro_Type("TMono", 0, array($t)); }
	public static function TType($t, $params) { return new haxe_macro_Type("TType", 3, array($t, $params)); }
	public static $__constructors = array(5 => 'TAnonymous', 6 => 'TDynamic', 1 => 'TEnum', 4 => 'TFun', 2 => 'TInst', 7 => 'TLazy', 0 => 'TMono', 3 => 'TType');
	}
