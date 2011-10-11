<?php

class haxe_macro_VarAccess extends Enum {
	public static function AccCall($m) { return new haxe_macro_VarAccess("AccCall", 4, array($m)); }
	public static $AccInline;
	public static $AccNever;
	public static $AccNo;
	public static $AccNormal;
	public static function AccRequire($r) { return new haxe_macro_VarAccess("AccRequire", 6, array($r)); }
	public static $AccResolve;
	public static $__constructors = array(4 => 'AccCall', 5 => 'AccInline', 2 => 'AccNever', 1 => 'AccNo', 0 => 'AccNormal', 6 => 'AccRequire', 3 => 'AccResolve');
	}
haxe_macro_VarAccess::$AccInline = new haxe_macro_VarAccess("AccInline", 5);
haxe_macro_VarAccess::$AccNever = new haxe_macro_VarAccess("AccNever", 2);
haxe_macro_VarAccess::$AccNo = new haxe_macro_VarAccess("AccNo", 1);
haxe_macro_VarAccess::$AccNormal = new haxe_macro_VarAccess("AccNormal", 0);
haxe_macro_VarAccess::$AccResolve = new haxe_macro_VarAccess("AccResolve", 3);
