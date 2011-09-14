<?php

class haxe_Serializer {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$this->buf = new StringBuf();
		$this->cache = new _hx_array(array());
		$this->useCache = haxe_Serializer::$USE_CACHE;
		$this->useEnumIndex = haxe_Serializer::$USE_ENUM_INDEX;
		$this->shash = new Hash();
		$this->scount = 0;
	}}
	public $buf;
	public $cache;
	public $shash;
	public $scount;
	public $useCache;
	public $useEnumIndex;
	public function toString() {
		return $this->buf->b;
	}
	public function serializeString($s) {
		$x = $this->shash->get($s);
		if($x !== null) {
			$this->buf->b .= "R";
			$this->buf->b .= $x;
			return;
		}
		$this->shash->set($s, $this->scount++);
		$this->buf->b .= "y";
		$s = rawurlencode($s);
		$this->buf->b .= strlen($s);
		$this->buf->b .= ":";
		$this->buf->b .= $s;
	}
	public function serializeRef($v) {
		{
			$_g1 = 0; $_g = $this->cache->length;
			while($_g1 < $_g) {
				$i = $_g1++;
				if(_hx_equal($this->cache[$i], $v)) {
					$this->buf->b .= "r";
					$this->buf->b .= $i;
					return true;
				}
				unset($i);
			}
		}
		$this->cache->push($v);
		return false;
	}
	public function serializeFields($v) {
		{
			$_g = 0; $_g1 = Reflect::fields($v);
			while($_g < $_g1->length) {
				$f = $_g1[$_g];
				++$_g;
				$this->serializeString($f);
				$this->serialize(Reflect::field($v, $f));
				unset($f);
			}
		}
		$this->buf->b .= "g";
	}
	public function serialize($v) {
		$»t = (Type::typeof($v));
		switch($»t->index) {
		case 0:
		{
			$this->buf->b .= "n";
		}break;
		case 1:
		{
			if(_hx_equal($v, 0)) {
				$this->buf->b .= "z";
				return;
			}
			$this->buf->b .= "i";
			$this->buf->b .= $v;
		}break;
		case 2:
		{
			if(Math::isNaN($v)) {
				$this->buf->b .= "k";
			} else {
				if(!Math::isFinite($v)) {
					$this->buf->b .= (($v < 0) ? "m" : "p");
				} else {
					$this->buf->b .= "d";
					$this->buf->b .= $v;
				}
			}
		}break;
		case 3:
		{
			$this->buf->b .= (($v) ? "t" : "f");
		}break;
		case 6:
		$c = $»t->params[0];
		{
			if($c === _hx_qtype("String")) {
				$this->serializeString($v);
				return;
			}
			if($this->useCache && $this->serializeRef($v)) {
				return;
			}
			switch($c) {
			case _hx_qtype("Array"):{
				$ucount = 0;
				$this->buf->b .= "a";
				$l = _hx_len($v);
				{
					$_g = 0;
					while($_g < $l) {
						$i = $_g++;
						if($v[$i] === null) {
							$ucount++;
						} else {
							if($ucount > 0) {
								if($ucount === 1) {
									$this->buf->b .= "n";
								} else {
									$this->buf->b .= "u";
									$this->buf->b .= $ucount;
								}
								$ucount = 0;
							}
							$this->serialize($v[$i]);
						}
						unset($i);
					}
				}
				if($ucount > 0) {
					if($ucount === 1) {
						$this->buf->b .= "n";
					} else {
						$this->buf->b .= "u";
						$this->buf->b .= $ucount;
					}
				}
				$this->buf->b .= "h";
			}break;
			case _hx_qtype("List"):{
				$this->buf->b .= "l";
				$v1 = $v;
				if(null == $v1) throw new HException('null iterable');
				$»it = $v1->iterator();
				while($»it->hasNext()) {
					$i = $»it->next();
					$this->serialize($i);
				}
				$this->buf->b .= "h";
			}break;
			case _hx_qtype("Date"):{
				$d = $v;
				$this->buf->b .= "v";
				$this->buf->b .= $d->toString();
			}break;
			case _hx_qtype("Hash"):{
				$this->buf->b .= "b";
				$v1 = $v;
				if(null == $v1) throw new HException('null iterable');
				$»it = $v1->keys();
				while($»it->hasNext()) {
					$k = $»it->next();
					$this->serializeString($k);
					$this->serialize($v1->get($k));
				}
				$this->buf->b .= "h";
			}break;
			case _hx_qtype("IntHash"):{
				$this->buf->b .= "q";
				$v1 = $v;
				if(null == $v1) throw new HException('null iterable');
				$»it = $v1->keys();
				while($»it->hasNext()) {
					$k = $»it->next();
					$this->buf->b .= ":";
					$this->buf->b .= $k;
					$this->serialize($v1->get($k));
				}
				$this->buf->b .= "h";
			}break;
			case _hx_qtype("haxe.io.Bytes"):{
				$v1 = $v;
				$i = 0;
				$max = $v1->length - 2;
				$chars = "";
				$b64 = haxe_Serializer::$BASE64;
				while($i < $max) {
					$b1 = ord($v1->b[$i++]);
					$b2 = ord($v1->b[$i++]);
					$b3 = ord($v1->b[$i++]);
					$chars .= _hx_char_at($b64, $b1 >> 2) . _hx_char_at($b64, ($b1 << 4 | $b2 >> 4) & 63) . _hx_char_at($b64, ($b2 << 2 | $b3 >> 6) & 63) . _hx_char_at($b64, $b3 & 63);
					unset($b3,$b2,$b1);
				}
				if($i === $max) {
					$b1 = ord($v1->b[$i++]);
					$b2 = ord($v1->b[$i++]);
					$chars .= _hx_char_at($b64, $b1 >> 2) . _hx_char_at($b64, ($b1 << 4 | $b2 >> 4) & 63) . _hx_char_at($b64, $b2 << 2 & 63);
				} else {
					if($i === $max + 1) {
						$b1 = ord($v1->b[$i++]);
						$chars .= _hx_char_at($b64, $b1 >> 2) . _hx_char_at($b64, $b1 << 4 & 63);
					}
				}
				$this->buf->b .= "s";
				$this->buf->b .= strlen($chars);
				$this->buf->b .= ":";
				$this->buf->b .= $chars;
			}break;
			default:{
				$this->cache->pop();
				if(_hx_field($v, "hxSerialize") !== null) {
					$this->buf->b .= "C";
					$this->serializeString(Type::getClassName($c));
					$this->cache->push($v);
					$v->hxSerialize($this);
					$this->buf->b .= "g";
				} else {
					$this->buf->b .= "c";
					$this->serializeString(Type::getClassName($c));
					$this->cache->push($v);
					$this->serializeFields($v);
				}
			}break;
			}
		}break;
		case 4:
		{
			if($this->useCache && $this->serializeRef($v)) {
				return;
			}
			$this->buf->b .= "o";
			$this->serializeFields($v);
		}break;
		case 7:
		$e = $»t->params[0];
		{
			if($this->useCache && $this->serializeRef($v)) {
				return;
			}
			$this->cache->pop();
			$this->buf->b .= (($this->useEnumIndex) ? "j" : "w");
			$this->serializeString(Type::getEnumName($e));
			if($this->useEnumIndex) {
				$this->buf->b .= ":";
				$this->buf->b .= $v->index;
			} else {
				$this->serializeString($v->tag);
			}
			$this->buf->b .= ":";
			$l = count($v->params);
			if($l === 0 || _hx_field($v, "params") === null) {
				$this->buf->b .= 0;
			} else {
				$this->buf->b .= $l;
				{
					$_g = 0;
					while($_g < $l) {
						$i = $_g++;
						$this->serialize($v->params[$i]);
						unset($i);
					}
				}
			}
			$this->cache->push($v);
		}break;
		case 5:
		{
			throw new HException("Cannot serialize function");
		}break;
		default:{
			throw new HException("Cannot serialize " . Std::string($v));
		}break;
		}
	}
	public function serializeException($e) {
		$this->buf->b .= "x";
		$this->serialize($e);
	}
	public function __call($m, $a) {
		if(isset($this->$m) && is_callable($this->$m))
			return call_user_func_array($this->$m, $a);
		else if(isset($this->»dynamics[$m]) && is_callable($this->»dynamics[$m]))
			return call_user_func_array($this->»dynamics[$m], $a);
		else if('toString' == $m)
			return $this->__toString();
		else
			throw new HException('Unable to call «'.$m.'»');
	}
	static $USE_CACHE = false;
	static $USE_ENUM_INDEX = false;
	static $BASE64 = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789%:";
	static function run($v) {
		$s = new haxe_Serializer();
		$s->serialize($v);
		return $s->toString();
	}
	function __toString() { return $this->toString(); }
}
