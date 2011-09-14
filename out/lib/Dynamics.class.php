<?php

class Dynamics {
	public function __construct(){}
	static function format($v, $param, $params, $nullstring, $culture) {
		return call_user_func_array(Dynamics::formatf($param, $params, $nullstring, $culture), array($v));
	}
	static function formatf($param, $params, $nullstring, $culture) {
		if($nullstring === null) {
			$nullstring = "null";
		}
		return array(new _hx_lambda(array(&$culture, &$nullstring, &$param, &$params), "Dynamics_0"), 'execute');
	}
	static function interpolate($v, $a, $b, $equation) {
		return call_user_func_array(Dynamics::interpolatef($a, $b, $equation), array($v));
	}
	static function interpolatef($a, $b, $equation) {
		$ta = Type::typeof($a);
		$tb = Type::typeof($b);
		if(!((Std::is($a, _hx_qtype("Float")) || Std::is($a, _hx_qtype("Int"))) && (Std::is($b, _hx_qtype("Float")) || Std::is($b, _hx_qtype("Int")))) && !Type::enumEq($ta, $tb)) {
			throw new HException(new thx_error_Error("arguments a ({0}) and b ({0}) have different types", new _hx_array(array($a, $b)), null, _hx_anonymous(array("fileName" => "Dynamics.hx", "lineNumber" => 55, "className" => "Dynamics", "methodName" => "interpolatef"))));
		}
		$퍁 = ($ta);
		switch($퍁->index) {
		case 0:
		{
			return array(new _hx_lambda(array(&$a, &$b, &$equation, &$ta, &$tb), "Dynamics_1"), 'execute');
		}break;
		case 1:
		{
			if(Std::is($b, _hx_qtype("Int"))) {
				return Ints::interpolatef($a, $b, $equation);
			} else {
				return Floats::interpolatef($a, $b, $equation);
			}
		}break;
		case 2:
		{
			return Floats::interpolatef($a, $b, $equation);
		}break;
		case 3:
		{
			return Bools::interpolatef($a, $b, $equation);
		}break;
		case 4:
		{
			return Objects::interpolatef($a, $b, $equation);
		}break;
		case 6:
		$c = $퍁->params[0];
		{
			$name = Type::getClassName($c);
			switch($name) {
			case "String":{
				return Strings::interpolatef($a, $b, $equation);
			}break;
			case "Date":{
				return Dates::interpolatef($a, $b, $equation);
			}break;
			default:{
				throw new HException(new thx_error_Error("cannot interpolate on instances of {0}", null, $name, _hx_anonymous(array("fileName" => "Dynamics.hx", "lineNumber" => 73, "className" => "Dynamics", "methodName" => "interpolatef"))));
			}break;
			}
		}break;
		default:{
			throw new HException(new thx_error_Error("cannot interpolate on functions/enums/unknown", null, null, _hx_anonymous(array("fileName" => "Dynamics.hx", "lineNumber" => 75, "className" => "Dynamics", "methodName" => "interpolatef"))));
		}break;
		}
	}
	static function string($v) {
		$퍁 = (Type::typeof($v));
		switch($퍁->index) {
		case 0:
		{
			return "null";
		}break;
		case 1:
		{
			return Ints::format($v, null, null, null);
		}break;
		case 2:
		{
			return Floats::format($v, null, null, null);
		}break;
		case 3:
		{
			return Bools::format($v, null, null, null);
		}break;
		case 4:
		{
			$keys = Reflect::fields($v);
			$result = new _hx_array(array());
			{
				$_g = 0;
				while($_g < $keys->length) {
					$key = $keys[$_g];
					++$_g;
					$result->push($key . " : " . Dynamics::string(Reflect::field($v, $key)));
					unset($key);
				}
			}
			return "{" . $result->join(", ") . "}";
		}break;
		case 6:
		$c = $퍁->params[0];
		{
			$name = Type::getClassName($c);
			switch($name) {
			case "Array":{
				return Arrays::string($v);
			}break;
			case "String":{
				$s = $v;
				if(_hx_index_of($s, "\"", null) < 0) {
					return "\"" . $s . "\"";
				} else {
					if(_hx_index_of($s, "'", null) < 0) {
						return "'" . $s . "'";
					} else {
						return "\"" . str_replace("\"", "\\\"", $s) . "\"";
					}
				}
			}break;
			case "Date":{
				return Dates::format($v, null, null, null);
			}break;
			default:{
				return Std::string($v);
			}break;
			}
		}break;
		case 7:
		$e = $퍁->params[0];
		{
			return Enums::string($v);
		}break;
		case 8:
		{
			return "<unknown>";
		}break;
		case 5:
		{
			return "<function>";
		}break;
		}
	}
	static function hclone($v) {
		$퍁 = (Type::typeof($v));
		switch($퍁->index) {
		case 0:
		{
			return null;
		}break;
		case 1:
		case 2:
		case 3:
		case 7:
		case 8:
		case 5:
		{
			return $v;
		}break;
		case 4:
		{
			$o = _hx_anonymous(array());
			Objects::copyTo($v, $o);
			return $o;
		}break;
		case 6:
		$c = $퍁->params[0];
		{
			$name = Type::getClassName($c);
			switch($name) {
			case "Array":{
				$src = $v; $a = new _hx_array(array());
				{
					$_g = 0;
					while($_g < $src->length) {
						$i = $src[$_g];
						++$_g;
						$a->push(Dynamics::hclone($i));
						unset($i);
					}
				}
				return $a;
			}break;
			case "String":case "Date":{
				return $v;
			}break;
			default:{
				$o = Type::createEmptyInstance($c);
				{
					$_g = 0; $_g1 = Reflect::fields($v);
					while($_g < $_g1->length) {
						$field = $_g1[$_g];
						++$_g;
						$o->{$field} = Dynamics::hclone(Reflect::field($v, $field));
						unset($field);
					}
				}
				return $o;
			}break;
			}
		}break;
		}
	}
	static function number($v) {
		if(Std::is($v, _hx_qtype("Bool"))) {
			return ((_hx_equal($v, true)) ? 1 : 0);
		} else {
			if(Std::is($v, _hx_qtype("Date"))) {
				return $v->getTime();
			} else {
				if(Std::is($v, _hx_qtype("String"))) {
					return Std::parseFloat($v);
				} else {
					return Math::$NaN;
				}
			}
		}
	}
	function __toString() { return 'Dynamics'; }
}
function Dynamics_0(&$culture, &$nullstring, &$param, &$params, $v) {
	{
		$퍁 = (Type::typeof($v));
		switch($퍁->index) {
		case 0:
		{
			return $nullstring;
		}break;
		case 1:
		{
			return Ints::format($v, $param, $params, $culture);
		}break;
		case 2:
		{
			return Floats::format($v, $param, $params, $culture);
		}break;
		case 3:
		{
			return Bools::format($v, $param, $params, $culture);
		}break;
		case 6:
		$c = $퍁->params[0];
		{
			if($c === _hx_qtype("String")) {
				return Strings::formatOne($v, $param, $params, $culture);
			} else {
				if($c === _hx_qtype("Array")) {
					return Arrays::format($v, $param, $params, $culture);
				} else {
					if($c === _hx_qtype("Date")) {
						return Dates::format($v, $param, $params, $culture);
					} else {
						return Std::string($v);
					}
				}
			}
		}break;
		default:{
			Dynamics_2($culture, $nullstring, $param, $params, $v);
		}break;
		}
	}
}
function Dynamics_1(&$a, &$b, &$equation, &$ta, &$tb, $_) {
	{
		return null;
	}
}
function Dynamics_2(&$culture, &$nullstring, &$param, &$params, &$v) {
	throw new HException(new thx_error_Error("Unsupported type format: {0}", null, Type::typeof($v), _hx_anonymous(array("fileName" => "Dynamics.hx", "lineNumber" => 40, "className" => "Dynamics", "methodName" => "formatf"))));
}
