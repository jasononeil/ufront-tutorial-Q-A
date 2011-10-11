<?php

class haxe_macro_MethodKind extends Enum {
	public static $MethDynamic;
	public static $MethInline;
	public static $MethMacro;
	public static $MethNormal;
	public static $__constructors = array(2 => 'MethDynamic', 1 => 'MethInline', 3 => 'MethMacro', 0 => 'MethNormal');
	}
haxe_macro_MethodKind::$MethDynamic = new haxe_macro_MethodKind("MethDynamic", 2);
haxe_macro_MethodKind::$MethInline = new haxe_macro_MethodKind("MethInline", 1);
haxe_macro_MethodKind::$MethMacro = new haxe_macro_MethodKind("MethMacro", 3);
haxe_macro_MethodKind::$MethNormal = new haxe_macro_MethodKind("MethNormal", 0);
