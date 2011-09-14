<?php

class Arrays {
	public function __construct(){}
	static function addIf($arr, $condition, $value) {
		if(null !== $condition) {
			if($condition) {
				$arr->push($value);
			}
		} else {
			if(null !== $value) {
				$arr->push($value);
			}
		}
		return $arr;
	}
	static function add($arr, $value) {
		$arr->push($value);
		return $arr;
	}
	static function delete($arr, $value) {
		$arr->remove($value);
		return $arr;
	}
	static function filter($arr, $f) {
		$result = new _hx_array(array());
		{
			$_g = 0;
			while($_g < $arr->length) {
				$i = $arr[$_g];
				++$_g;
				if(call_user_func_array($f, array($i))) {
					$result->push($i);
				}
				unset($i);
			}
		}
		return $result;
	}
	static function min($arr, $f) {
		if($arr->length === 0) {
			return null;
		}
		if(null === $f) {
			$a = $arr[0]; $p = 0;
			{
				$_g1 = 1; $_g = $arr->length;
				while($_g1 < $_g) {
					$i = $_g1++;
					if(Reflect::compare($a, $arr[$i]) > 0) {
						$a = $arr[$p = $i];
					}
					unset($i);
				}
			}
			return $arr[$p];
		} else {
			$a = call_user_func_array($f, array($arr[0])); $p = 0; $b = null;
			{
				$_g1 = 1; $_g = $arr->length;
				while($_g1 < $_g) {
					$i = $_g1++;
					if($a > ($b = call_user_func_array($f, array($arr[$i])))) {
						$a = $b;
						$p = $i;
					}
					unset($i);
				}
			}
			return $arr[$p];
		}
	}
	static function floatMin($arr, $f) {
		if($arr->length === 0) {
			return Math::$NaN;
		}
		$a = call_user_func_array($f, array($arr[0])); $b = null;
		{
			$_g1 = 1; $_g = $arr->length;
			while($_g1 < $_g) {
				$i = $_g1++;
				if($a > ($b = call_user_func_array($f, array($arr[$i])))) {
					$a = $b;
				}
				unset($i);
			}
		}
		return $a;
	}
	static function max($arr, $f) {
		if($arr->length === 0) {
			return null;
		}
		if(null === $f) {
			$a = $arr[0]; $p = 0;
			{
				$_g1 = 1; $_g = $arr->length;
				while($_g1 < $_g) {
					$i = $_g1++;
					if(Reflect::compare($a, $arr[$i]) < 0) {
						$a = $arr[$p = $i];
					}
					unset($i);
				}
			}
			return $arr[$p];
		} else {
			$a = call_user_func_array($f, array($arr[0])); $p = 0; $b = null;
			{
				$_g1 = 1; $_g = $arr->length;
				while($_g1 < $_g) {
					$i = $_g1++;
					if($a < ($b = call_user_func_array($f, array($arr[$i])))) {
						$a = $b;
						$p = $i;
					}
					unset($i);
				}
			}
			return $arr[$p];
		}
	}
	static function floatMax($arr, $f) {
		if($arr->length === 0) {
			return Math::$NaN;
		}
		$a = call_user_func_array($f, array($arr[0])); $b = null;
		{
			$_g1 = 1; $_g = $arr->length;
			while($_g1 < $_g) {
				$i = $_g1++;
				if($a < ($b = call_user_func_array($f, array($arr[$i])))) {
					$a = $b;
				}
				unset($i);
			}
		}
		return $a;
	}
	static function flatten($arr) {
		$r = new _hx_array(array());
		{
			$_g = 0;
			while($_g < $arr->length) {
				$v = $arr[$_g];
				++$_g;
				$r = $r->concat($v);
				unset($v);
			}
		}
		return $r;
	}
	static function map($arr, $f) {
		return Iterators::map($arr->iterator(), $f);
	}
	static function reduce($arr, $f, $initialValue) {
		return Iterators::reduce($arr->iterator(), $f, $initialValue);
	}
	static function order($arr, $f) {
		$arr->sort(Arrays_0($arr, $f));
		return $arr;
	}
	static function split($arr, $f) {
		if(null === $f) {
			$f = array(new _hx_lambda(array(&$arr, &$f), "Arrays_1"), 'execute');
		}
		$arrays = new _hx_array(array()); $i = -1; $values = new _hx_array(array()); $value = null;
		{
			$_g1 = 0; $_g = $arr->length;
			while($_g1 < $_g) {
				$i1 = $_g1++;
				if(call_user_func_array($f, array($value = $arr[$i1], $i1))) {
					$values = new _hx_array(array());
				} else {
					if($values->length === 0) {
						$arrays->push($values);
					}
					$values->push($value);
				}
				unset($i1);
			}
		}
		return $arrays;
	}
	static function exists($arr, $value, $f) {
		if(null !== $f) {
			$_g = 0;
			while($_g < $arr->length) {
				$v = $arr[$_g];
				++$_g;
				if(call_user_func_array($f, array($v))) {
					return true;
				}
				unset($v);
			}
		} else {
			$_g = 0;
			while($_g < $arr->length) {
				$v = $arr[$_g];
				++$_g;
				if($v === $value) {
					return true;
				}
				unset($v);
			}
		}
		return false;
	}
	static function format($v, $param, $params, $culture) {
		$params = thx_culture_FormatParams::params($param, $params, "J");
		$format = $params->shift();
		switch($format) {
		case "J":{
			if($v->length === 0) {
				$empty = Arrays_2($culture, $format, $param, $params, $v);
				return $empty;
			}
			$sep = Arrays_3($culture, $format, $param, $params, $v);
			$max = (($params[3] === null) ? null : (("" === $params[3]) ? null : Std::parseInt($params[3])));
			if(null !== $max && $max < $v->length) {
				$elipsis = Arrays_4($culture, $format, $max, $param, $params, $sep, $v);
				return Iterators::map($v->copy()->splice(0, $max)->iterator(), array(new _hx_lambda(array(&$culture, &$elipsis, &$format, &$max, &$param, &$params, &$sep, &$v), "Arrays_5"), 'execute'))->join($sep) . $elipsis;
			} else {
				return Iterators::map($v->iterator(), array(new _hx_lambda(array(&$culture, &$format, &$max, &$param, &$params, &$sep, &$v), "Arrays_6"), 'execute'))->join($sep);
			}
		}break;
		case "C":{
			return Ints::format($v->length, "I", new _hx_array(array()), $culture);
		}break;
		default:{
			throw new HException("Unsupported array format: " . $format);
		}break;
		}
	}
	static function formatf($param, $params, $culture) {
		$params = thx_culture_FormatParams::params($param, $params, "J");
		$format = $params->shift();
		switch($format) {
		case "J":{
			return array(new _hx_lambda(array(&$culture, &$format, &$param, &$params), "Arrays_7"), 'execute');
		}break;
		case "C":{
			$f = Ints::formatf("I", new _hx_array(array()), $culture);
			return array(new _hx_lambda(array(&$culture, &$f, &$format, &$param, &$params), "Arrays_8"), 'execute');
		}break;
		default:{
			throw new HException("Unsupported array format: " . $format);
		}break;
		}
	}
	static function interpolate($v, $a, $b, $equation) {
		return call_user_func_array(Arrays::interpolatef($a, $b, $equation), array($v));
	}
	static function interpolatef($a, $b, $equation) {
		$functions = new _hx_array(array()); $i = 0; $min = Arrays_9($a, $b, $equation, $functions, $i);
		while($i < $min) {
			if($a[$i] === $b[$i]) {
				$v = $b[$i];
				$functions->push(array(new _hx_lambda(array(&$a, &$b, &$equation, &$functions, &$i, &$min, &$v), "Arrays_10"), 'execute'));
				unset($v);
			} else {
				$functions->push(Floats::interpolatef($a[$i], $b[$i], $equation));
			}
			$i++;
		}
		while($i < $b->length) {
			$v = $b[$i];
			$functions->push(array(new _hx_lambda(array(&$a, &$b, &$equation, &$functions, &$i, &$min, &$v), "Arrays_11"), 'execute'));
			$i++;
			unset($v);
		}
		return array(new _hx_lambda(array(&$a, &$b, &$equation, &$functions, &$i, &$min), "Arrays_12"), 'execute');
	}
	static function interpolateStrings($v, $a, $b, $equation) {
		return call_user_func_array(Arrays::interpolateStringsf($a, $b, $equation), array($v));
	}
	static function interpolateStringsf($a, $b, $equation) {
		$functions = new _hx_array(array()); $i = 0; $min = Arrays_13($a, $b, $equation, $functions, $i);
		while($i < $min) {
			if($a[$i] === $b[$i]) {
				$v = $b[$i];
				$functions->push(array(new _hx_lambda(array(&$a, &$b, &$equation, &$functions, &$i, &$min, &$v), "Arrays_14"), 'execute'));
				unset($v);
			} else {
				$functions->push(Strings::interpolatef($a[$i], $b[$i], $equation));
			}
			$i++;
		}
		while($i < $b->length) {
			$v = $b[$i];
			$functions->push(array(new _hx_lambda(array(&$a, &$b, &$equation, &$functions, &$i, &$min, &$v), "Arrays_15"), 'execute'));
			$i++;
			unset($v);
		}
		return array(new _hx_lambda(array(&$a, &$b, &$equation, &$functions, &$i, &$min), "Arrays_16"), 'execute');
	}
	static function interpolateInts($v, $a, $b, $equation) {
		return call_user_func_array(Arrays::interpolateIntsf($a, $b, $equation), array($v));
	}
	static function interpolateIntsf($a, $b, $equation) {
		$functions = new _hx_array(array()); $i = 0; $min = Arrays_17($a, $b, $equation, $functions, $i);
		while($i < $min) {
			if($a[$i] === $b[$i]) {
				$v = $b[$i];
				$functions->push(array(new _hx_lambda(array(&$a, &$b, &$equation, &$functions, &$i, &$min, &$v), "Arrays_18"), 'execute'));
				unset($v);
			} else {
				$functions->push(Ints::interpolatef($a[$i], $b[$i], $equation));
			}
			$i++;
		}
		while($i < $b->length) {
			$v = $b[$i];
			$functions->push(array(new _hx_lambda(array(&$a, &$b, &$equation, &$functions, &$i, &$min, &$v), "Arrays_19"), 'execute'));
			$i++;
			unset($v);
		}
		return array(new _hx_lambda(array(&$a, &$b, &$equation, &$functions, &$i, &$min), "Arrays_20"), 'execute');
	}
	static function indexOf($arr, $el) {
		$len = $arr->length;
		{
			$_g = 0;
			while($_g < $len) {
				$i = $_g++;
				if($arr[$i] === $el) {
					return $i;
				}
				unset($i);
			}
		}
		return -1;
	}
	static function every($arr, $f) {
		{
			$_g1 = 0; $_g = $arr->length;
			while($_g1 < $_g) {
				$i = $_g1++;
				if(!call_user_func_array($f, array($arr[$i], $i))) {
					return false;
				}
				unset($i);
			}
		}
		return true;
	}
	static function each($arr, $f) {
		$_g1 = 0; $_g = $arr->length;
		while($_g1 < $_g) {
			$i = $_g1++;
			call_user_func_array($f, array($arr[$i], $i));
			unset($i);
		}
	}
	static function any($arr, $f) {
		return Iterators::any($arr->iterator(), $f);
	}
	static function all($arr, $f) {
		return Iterators::all($arr->iterator(), $f);
	}
	static function random($arr) {
		return $arr[Std::random($arr->length)];
	}
	static function string($arr) {
		return "[" . Iterators::map($arr->iterator(), array(new _hx_lambda(array(&$arr), "Arrays_21"), 'execute'))->join(", ") . "]";
	}
	static function last($arr) {
		return $arr[$arr->length - 1];
	}
	static function lastf($arr, $f) {
		$t = $arr->copy();
		$t->reverse();
		return Arrays::firstf($arr, $f);
	}
	static function first($arr) {
		return $arr[0];
	}
	static function firstf($arr, $f) {
		{
			$_g = 0;
			while($_g < $arr->length) {
				$v = $arr[$_g];
				++$_g;
				if(call_user_func_array($f, array($v))) {
					return $v;
				}
				unset($v);
			}
		}
		return null;
	}
	function __toString() { return 'Arrays'; }
}
function Arrays_0(&$arr, &$f) {
	if(null === $f) {
		return (isset(Reflect::$compare) ? Reflect::$compare: array("Reflect", "compare"));
	} else {
		return $f;
	}
}
function Arrays_1(&$arr, &$f, $v, $_) {
	{
		return $v === null;
	}
}
function Arrays_2(&$culture, &$format, &$param, &$params, &$v) {
	if(null === $params[1]) {
		return "[]";
	} else {
		return $params[1];
	}
}
function Arrays_3(&$culture, &$format, &$param, &$params, &$v) {
	if(null === $params[2]) {
		return ", ";
	} else {
		return $params[2];
	}
}
function Arrays_4(&$culture, &$format, &$max, &$param, &$params, &$sep, &$v) {
	if(null === $params[4]) {
		return " ...";
	} else {
		return $params[4];
	}
}
function Arrays_5(&$culture, &$elipsis, &$format, &$max, &$param, &$params, &$sep, &$v, $d, $i) {
	{
		return Dynamics::format($d, $params[0], null, null, $culture);
	}
}
function Arrays_6(&$culture, &$format, &$max, &$param, &$params, &$sep, &$v, $d, $i) {
	{
		return Dynamics::format($d, $params[0], null, null, $culture);
	}
}
function Arrays_7(&$culture, &$format, &$param, &$params, $v) {
	{
		if($v->length === 0) {
			$empty = Arrays_22($culture, $format, $param, $params, $v);
			return $empty;
		}
		$sep = Arrays_23($culture, $format, $param, $params, $v);
		$max = (($params[3] === null) ? null : (("" === $params[3]) ? null : Std::parseInt($params[3])));
		if(null !== $max && $max < $v->length) {
			$elipsis = Arrays_24($culture, $format, $max, $param, $params, $sep, $v);
			return Iterators::map($v->copy()->splice(0, $max)->iterator(), array(new _hx_lambda(array(&$culture, &$elipsis, &$format, &$max, &$param, &$params, &$sep, &$v), "Arrays_25"), 'execute'))->join($sep) . $elipsis;
		} else {
			return Iterators::map($v->iterator(), array(new _hx_lambda(array(&$culture, &$format, &$max, &$param, &$params, &$sep, &$v), "Arrays_26"), 'execute'))->join($sep);
		}
	}
}
function Arrays_8(&$culture, &$f, &$format, &$param, &$params, $v) {
	{
		return call_user_func_array($f, array(_hx_len($v)));
	}
}
function Arrays_9(&$a, &$b, &$equation, &$functions, &$i) {
	{
		$a1 = $a->length; $b1 = $b->length;
		if($a1 < $b1) {
			return $a1;
		} else {
			return $b1;
		}
		unset($b1,$a1);
	}
}
function Arrays_10(&$a, &$b, &$equation, &$functions, &$i, &$min, &$v, $_) {
	{
		return $v;
	}
}
function Arrays_11(&$a, &$b, &$equation, &$functions, &$i, &$min, &$v, $_) {
	{
		return $v;
	}
}
function Arrays_12(&$a, &$b, &$equation, &$functions, &$i, &$min, $t) {
	{
		return Iterators::map($functions->iterator(), array(new _hx_lambda(array(&$a, &$b, &$equation, &$functions, &$i, &$min, &$t), "Arrays_27"), 'execute'));
	}
}
function Arrays_13(&$a, &$b, &$equation, &$functions, &$i) {
	{
		$a1 = $a->length; $b1 = $b->length;
		if($a1 < $b1) {
			return $a1;
		} else {
			return $b1;
		}
		unset($b1,$a1);
	}
}
function Arrays_14(&$a, &$b, &$equation, &$functions, &$i, &$min, &$v, $_) {
	{
		return $v;
	}
}
function Arrays_15(&$a, &$b, &$equation, &$functions, &$i, &$min, &$v, $_) {
	{
		return $v;
	}
}
function Arrays_16(&$a, &$b, &$equation, &$functions, &$i, &$min, $t) {
	{
		return Iterators::map($functions->iterator(), array(new _hx_lambda(array(&$a, &$b, &$equation, &$functions, &$i, &$min, &$t), "Arrays_28"), 'execute'));
	}
}
function Arrays_17(&$a, &$b, &$equation, &$functions, &$i) {
	{
		$a1 = $a->length; $b1 = $b->length;
		if($a1 < $b1) {
			return $a1;
		} else {
			return $b1;
		}
		unset($b1,$a1);
	}
}
function Arrays_18(&$a, &$b, &$equation, &$functions, &$i, &$min, &$v, $_) {
	{
		return $v;
	}
}
function Arrays_19(&$a, &$b, &$equation, &$functions, &$i, &$min, &$v, $_) {
	{
		return $v;
	}
}
function Arrays_20(&$a, &$b, &$equation, &$functions, &$i, &$min, $t) {
	{
		return Iterators::map($functions->iterator(), array(new _hx_lambda(array(&$a, &$b, &$equation, &$functions, &$i, &$min, &$t), "Arrays_29"), 'execute'));
	}
}
function Arrays_21(&$arr, $v, $_) {
	{
		return Dynamics::string($v);
	}
}
function Arrays_22(&$culture, &$format, &$param, &$params, &$v) {
	if(null === $params[1]) {
		return "[]";
	} else {
		return $params[1];
	}
}
function Arrays_23(&$culture, &$format, &$param, &$params, &$v) {
	if(null === $params[2]) {
		return ", ";
	} else {
		return $params[2];
	}
}
function Arrays_24(&$culture, &$format, &$max, &$param, &$params, &$sep, &$v) {
	if(null === $params[4]) {
		return " ...";
	} else {
		return $params[4];
	}
}
function Arrays_25(&$culture, &$elipsis, &$format, &$max, &$param, &$params, &$sep, &$v, $d, $i) {
	{
		return Dynamics::format($d, $params[0], null, null, $culture);
	}
}
function Arrays_26(&$culture, &$format, &$max, &$param, &$params, &$sep, &$v, $d, $i) {
	{
		return Dynamics::format($d, $params[0], null, null, $culture);
	}
}
function Arrays_27(&$a, &$b, &$equation, &$functions, &$i, &$min, &$t, $f, $_) {
	{
		return call_user_func_array($f, array($t));
	}
}
function Arrays_28(&$a, &$b, &$equation, &$functions, &$i, &$min, &$t, $f, $_) {
	{
		return call_user_func_array($f, array($t));
	}
}
function Arrays_29(&$a, &$b, &$equation, &$functions, &$i, &$min, &$t, $f, $_) {
	{
		return call_user_func_array($f, array($t));
	}
}
