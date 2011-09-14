<?php

class Objects {
	public function __construct(){}
	static function field($o, $fieldname, $alt) {
		return ((_hx_has_field($o, $fieldname)) ? Reflect::field($o, $fieldname) : $alt);
	}
	static function keys($o) {
		return Reflect::fields($o);
	}
	static function values($o) {
		$arr = new _hx_array(array());
		{
			$_g = 0; $_g1 = Reflect::fields($o);
			while($_g < $_g1->length) {
				$key = $_g1[$_g];
				++$_g;
				$arr->push(Reflect::field($o, $key));
				unset($key);
			}
		}
		return $arr;
	}
	static function entries($o) {
		$arr = new _hx_array(array());
		{
			$_g = 0; $_g1 = Reflect::fields($o);
			while($_g < $_g1->length) {
				$key = $_g1[$_g];
				++$_g;
				$arr->push(_hx_anonymous(array("key" => $key, "value" => Reflect::field($o, $key))));
				unset($key);
			}
		}
		return $arr;
	}
	static function with($ob, $f) {
		call_user_func_array($f, array($ob));
		return $ob;
	}
	static function toHash($ob) {
		$hash = new Hash();
		return Objects::copyToHash($ob, $hash);
	}
	static function copyToHash($ob, $hash) {
		{
			$_g = 0; $_g1 = Reflect::fields($ob);
			while($_g < $_g1->length) {
				$field = $_g1[$_g];
				++$_g;
				$hash->set($field, Reflect::field($ob, $field));
				unset($field);
			}
		}
		return $hash;
	}
	static function interpolate($v, $a, $b, $equation) {
		return call_user_func_array(Objects::interpolatef($a, $b, $equation), array($v));
	}
	static function interpolatef($a, $b, $equation) {
		$i = _hx_anonymous(array()); $c = _hx_anonymous(array()); $keys = Reflect::fields($a);
		{
			$_g = 0;
			while($_g < $keys->length) {
				$key = $keys[$_g];
				++$_g;
				if(_hx_has_field($b, $key)) {
					$va = Reflect::field($a, $key);
					$i->{$key} = call_user_func_array(Objects::interpolateByName($key, $va), array($va, Reflect::field($b, $key), null));
					unset($va);
				} else {
					$c->{$key} = Reflect::field($a, $key);
				}
				unset($key);
			}
		}
		$keys = Reflect::fields($b);
		{
			$_g = 0;
			while($_g < $keys->length) {
				$key = $keys[$_g];
				++$_g;
				if(!_hx_has_field($a, $key)) {
					$c->{$key} = Reflect::field($b, $key);
				}
				unset($key);
			}
		}
		return array(new _hx_lambda(array(&$a, &$b, &$c, &$equation, &$i, &$keys), "Objects_0"), 'execute');
	}
	static $_reCheckKeyIsColor;
	static function interpolateByName($k, $v) {
		return Objects_1($k, $v);
	}
	static function copyTo($src, $dst) {
		{
			$_g = 0; $_g1 = Reflect::fields($src);
			while($_g < $_g1->length) {
				$field = $_g1[$_g];
				++$_g;
				$sv = Dynamics::hclone(Reflect::field($src, $field));
				$dv = Reflect::field($dst, $field);
				if(Reflect::isObject($sv) && null === Type::getClass($sv) && (Reflect::isObject($dv) && null === Type::getClass($dv))) {
					Objects::copyTo($sv, $dv);
				} else {
					$dst->{$field} = $sv;
				}
				unset($sv,$field,$dv);
			}
		}
		return $dst;
	}
	static function hclone($src) {
		$dst = _hx_anonymous(array());
		Objects::copyTo($src, $dst);
		return $dst;
	}
	static function _flatten($src, $cum, $arr) {
		$_g = 0; $_g1 = Reflect::fields($src);
		while($_g < $_g1->length) {
			$field = $_g1[$_g];
			++$_g;
			$clone = Objects::hclone($cum);
			$v = Reflect::field($src, $field);
			$clone->fields->push($field);
			if(Reflect::isObject($v) && null === Type::getClass($v)) {
				Objects::_flatten($v, $clone, $arr);
			} else {
				$clone->value = $v;
				$arr->push($clone);
			}
			unset($v,$field,$clone);
		}
	}
	static function flatten($src) {
		$arr = new _hx_array(array());
		{
			$_g = 0; $_g1 = Reflect::fields($src);
			while($_g < $_g1->length) {
				$field = $_g1[$_g];
				++$_g;
				$v = Reflect::field($src, $field);
				if(Reflect::isObject($v) && null === Type::getClass($v)) {
					$item = _hx_anonymous(array("fields" => new _hx_array(array($field)), "value" => null));
					Objects::_flatten($v, $item, $arr);
					unset($item);
				} else {
					$arr->push(_hx_anonymous(array("fields" => new _hx_array(array($field)), "value" => $v)));
				}
				unset($v,$field);
			}
		}
		return $arr;
	}
	function __toString() { return 'Objects'; }
}
Objects::$_reCheckKeyIsColor = new EReg("color\\b|\\bbackground\\b|\\bstroke\\b|\\bfill\\b", "");
function Objects_0(&$a, &$b, &$c, &$equation, &$i, &$keys, $t) {
	{
		{
			$_g = 0; $_g1 = Reflect::fields($i);
			while($_g < $_g1->length) {
				$k = $_g1[$_g];
				++$_g;
				$c->{$k} = Reflect::callMethod($i, Reflect::field($i, $k), new _hx_array(array($t)));
				unset($k);
			}
		}
		return $c;
	}
}
function Objects_1(&$k, &$v) {
	if(Std::is($v, _hx_qtype("String")) && Objects::$_reCheckKeyIsColor->match($k)) {
		return (isset(thx_color_Colors::$interpolatef) ? thx_color_Colors::$interpolatef: array("thx_color_Colors", "interpolatef"));
	} else {
		return (isset(Dynamics::$interpolatef) ? Dynamics::$interpolatef: array("Dynamics", "interpolatef"));
	}
}
