<?php

class Types {
	public function __construct(){}
	static function className($o) {
		return _hx_explode(".", Type::getClassName(Type::getClass($o)))->pop();
	}
	static function fullName($o) {
		return Type::getClassName(Type::getClass($o));
	}
	static function typeName($o) {
		return Types_0($o);
	}
	static function hasSuperClass($type, $sup) {
		while(null !== $type) {
			if($type === $sup) {
				return true;
			}
			$type = Type::getSuperClass($type);
		}
		return false;
	}
	static function isAnonymous($v) {
		return Reflect::isObject($v) && null === Type::getClass($v);
	}
	static function has($value, $type) {
		return ((Std::is($value, $type)) ? $value : null);
	}
	static function ifIs($value, $type, $handler) {
		if(Std::is($value, $type)) {
			call_user_func_array($handler, array($value));
		}
		return $value;
	}
	static function of($type, $value) {
		return ((Std::is($value, $type)) ? $value : null);
	}
	static function sameAs($a, $b) {
		if(null === $a && $b === null) {
			return true;
		}
		if(null === $a || $b === null) {
			return false;
		}
		$tb = Type::typeof($b);
		$퍁 = ($tb);
		switch($퍁->index) {
		case 6:
		$c = $퍁->params[0];
		{
			return Std::is($a, $c);
		}break;
		case 7:
		$e = $퍁->params[0];
		{
			return Std::is($a, $e);
		}break;
		default:{
			return Type::typeof($a) === $tb;
		}break;
		}
	}
	function __toString() { return 'Types'; }
}
function Types_0(&$o) {
	$퍁 = (Type::typeof($o));
	switch($퍁->index) {
	case 0:
	{
		return "null";
	}break;
	case 1:
	{
		return "Int";
	}break;
	case 2:
	{
		return "Float";
	}break;
	case 3:
	{
		return "Bool";
	}break;
	case 5:
	{
		return "function";
	}break;
	case 6:
	$c = $퍁->params[0];
	{
		return Type::getClassName($c);
	}break;
	case 7:
	$e = $퍁->params[0];
	{
		return Type::getEnumName($e);
	}break;
	case 4:
	{
		return "Object";
	}break;
	case 8:
	{
		return "Unknown";
	}break;
	}
}
