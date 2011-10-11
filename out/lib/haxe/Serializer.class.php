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
			{
				$x1 = "R";
				if(is_null($x1)) {
					$x1 = "null";
				} else {
					if(is_bool($x1)) {
						$x1 = (($x1) ? "true" : "false");
					}
				}
				$this->buf->b .= $x1;
			}
			{
				$x1 = $x;
				if(is_null($x1)) {
					$x1 = "null";
				} else {
					if(is_bool($x1)) {
						$x1 = (($x1) ? "true" : "false");
					}
				}
				$this->buf->b .= $x1;
			}
			return;
		}
		$this->shash->set($s, $this->scount++);
		{
			$x1 = "y";
			if(is_null($x1)) {
				$x1 = "null";
			} else {
				if(is_bool($x1)) {
					$x1 = (($x1) ? "true" : "false");
				}
			}
			$this->buf->b .= $x1;
		}
		$s = rawurlencode($s);
		{
			$x1 = strlen($s);
			if(is_null($x1)) {
				$x1 = "null";
			} else {
				if(is_bool($x1)) {
					$x1 = (($x1) ? "true" : "false");
				}
			}
			$this->buf->b .= $x1;
		}
		{
			$x1 = ":";
			if(is_null($x1)) {
				$x1 = "null";
			} else {
				if(is_bool($x1)) {
					$x1 = (($x1) ? "true" : "false");
				}
			}
			$this->buf->b .= $x1;
		}
		{
			$x1 = $s;
			if(is_null($x1)) {
				$x1 = "null";
			} else {
				if(is_bool($x1)) {
					$x1 = (($x1) ? "true" : "false");
				}
			}
			$this->buf->b .= $x1;
		}
	}
	public function serializeRef($v) {
		{
			$_g1 = 0; $_g = $this->cache->length;
			while($_g1 < $_g) {
				$i = $_g1++;
				if(_hx_equal($this->cache[$i], $v)) {
					{
						$x = "r";
						if(is_null($x)) {
							$x = "null";
						} else {
							if(is_bool($x)) {
								$x = (($x) ? "true" : "false");
							}
						}
						$this->buf->b .= $x;
						unset($x);
					}
					{
						$x = $i;
						if(is_null($x)) {
							$x = "null";
						} else {
							if(is_bool($x)) {
								$x = (($x) ? "true" : "false");
							}
						}
						$this->buf->b .= $x;
						unset($x);
					}
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
		{
			$x = "g";
			if(is_null($x)) {
				$x = "null";
			} else {
				if(is_bool($x)) {
					$x = (($x) ? "true" : "false");
				}
			}
			$this->buf->b .= $x;
		}
	}
	public function serialize($v) {
		$»t = (Type::typeof($v));
		switch($»t->index) {
		case 0:
		{
			$x = "n";
			if(is_null($x)) {
				$x = "null";
			} else {
				if(is_bool($x)) {
					$x = (($x) ? "true" : "false");
				}
			}
			$this->buf->b .= $x;
		}break;
		case 1:
		{
			if(_hx_equal($v, 0)) {
				{
					$x = "z";
					if(is_null($x)) {
						$x = "null";
					} else {
						if(is_bool($x)) {
							$x = (($x) ? "true" : "false");
						}
					}
					$this->buf->b .= $x;
				}
				return;
			}
			{
				$x = "i";
				if(is_null($x)) {
					$x = "null";
				} else {
					if(is_bool($x)) {
						$x = (($x) ? "true" : "false");
					}
				}
				$this->buf->b .= $x;
			}
			{
				$x = $v;
				if(is_null($x)) {
					$x = "null";
				} else {
					if(is_bool($x)) {
						$x = (($x) ? "true" : "false");
					}
				}
				$this->buf->b .= $x;
			}
		}break;
		case 2:
		{
			if(Math::isNaN($v)) {
				$x = "k";
				if(is_null($x)) {
					$x = "null";
				} else {
					if(is_bool($x)) {
						$x = (($x) ? "true" : "false");
					}
				}
				$this->buf->b .= $x;
			} else {
				if(!Math::isFinite($v)) {
					$x = (($v < 0) ? "m" : "p");
					if(is_null($x)) {
						$x = "null";
					} else {
						if(is_bool($x)) {
							$x = (($x) ? "true" : "false");
						}
					}
					$this->buf->b .= $x;
				} else {
					{
						$x = "d";
						if(is_null($x)) {
							$x = "null";
						} else {
							if(is_bool($x)) {
								$x = (($x) ? "true" : "false");
							}
						}
						$this->buf->b .= $x;
					}
					{
						$x = $v;
						if(is_null($x)) {
							$x = "null";
						} else {
							if(is_bool($x)) {
								$x = (($x) ? "true" : "false");
							}
						}
						$this->buf->b .= $x;
					}
				}
			}
		}break;
		case 3:
		{
			$x = (($v) ? "t" : "f");
			if(is_null($x)) {
				$x = "null";
			} else {
				if(is_bool($x)) {
					$x = (($x) ? "true" : "false");
				}
			}
			$this->buf->b .= $x;
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
				{
					$x = "a";
					if(is_null($x)) {
						$x = "null";
					} else {
						if(is_bool($x)) {
							$x = (($x) ? "true" : "false");
						}
					}
					$this->buf->b .= $x;
				}
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
									$x = "n";
									if(is_null($x)) {
										$x = "null";
									} else {
										if(is_bool($x)) {
											$x = (($x) ? "true" : "false");
										}
									}
									$this->buf->b .= $x;
									unset($x);
								} else {
									{
										$x = "u";
										if(is_null($x)) {
											$x = "null";
										} else {
											if(is_bool($x)) {
												$x = (($x) ? "true" : "false");
											}
										}
										$this->buf->b .= $x;
										unset($x);
									}
									{
										$x = $ucount;
										if(is_null($x)) {
											$x = "null";
										} else {
											if(is_bool($x)) {
												$x = (($x) ? "true" : "false");
											}
										}
										$this->buf->b .= $x;
										unset($x);
									}
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
						$x = "n";
						if(is_null($x)) {
							$x = "null";
						} else {
							if(is_bool($x)) {
								$x = (($x) ? "true" : "false");
							}
						}
						$this->buf->b .= $x;
					} else {
						{
							$x = "u";
							if(is_null($x)) {
								$x = "null";
							} else {
								if(is_bool($x)) {
									$x = (($x) ? "true" : "false");
								}
							}
							$this->buf->b .= $x;
						}
						{
							$x = $ucount;
							if(is_null($x)) {
								$x = "null";
							} else {
								if(is_bool($x)) {
									$x = (($x) ? "true" : "false");
								}
							}
							$this->buf->b .= $x;
						}
					}
				}
				{
					$x = "h";
					if(is_null($x)) {
						$x = "null";
					} else {
						if(is_bool($x)) {
							$x = (($x) ? "true" : "false");
						}
					}
					$this->buf->b .= $x;
				}
			}break;
			case _hx_qtype("List"):{
				{
					$x = "l";
					if(is_null($x)) {
						$x = "null";
					} else {
						if(is_bool($x)) {
							$x = (($x) ? "true" : "false");
						}
					}
					$this->buf->b .= $x;
				}
				$v1 = $v;
				if(null == $v1) throw new HException('null iterable');
				$»it = $v1->iterator();
				while($»it->hasNext()) {
					$i = $»it->next();
					$this->serialize($i);
				}
				{
					$x = "h";
					if(is_null($x)) {
						$x = "null";
					} else {
						if(is_bool($x)) {
							$x = (($x) ? "true" : "false");
						}
					}
					$this->buf->b .= $x;
				}
			}break;
			case _hx_qtype("Date"):{
				$d = $v;
				{
					$x = "v";
					if(is_null($x)) {
						$x = "null";
					} else {
						if(is_bool($x)) {
							$x = (($x) ? "true" : "false");
						}
					}
					$this->buf->b .= $x;
				}
				{
					$x = $d->toString();
					if(is_null($x)) {
						$x = "null";
					} else {
						if(is_bool($x)) {
							$x = (($x) ? "true" : "false");
						}
					}
					$this->buf->b .= $x;
				}
			}break;
			case _hx_qtype("Hash"):{
				{
					$x = "b";
					if(is_null($x)) {
						$x = "null";
					} else {
						if(is_bool($x)) {
							$x = (($x) ? "true" : "false");
						}
					}
					$this->buf->b .= $x;
				}
				$v1 = $v;
				if(null == $v1) throw new HException('null iterable');
				$»it = $v1->keys();
				while($»it->hasNext()) {
					$k = $»it->next();
					$this->serializeString($k);
					$this->serialize($v1->get($k));
				}
				{
					$x = "h";
					if(is_null($x)) {
						$x = "null";
					} else {
						if(is_bool($x)) {
							$x = (($x) ? "true" : "false");
						}
					}
					$this->buf->b .= $x;
				}
			}break;
			case _hx_qtype("IntHash"):{
				{
					$x = "q";
					if(is_null($x)) {
						$x = "null";
					} else {
						if(is_bool($x)) {
							$x = (($x) ? "true" : "false");
						}
					}
					$this->buf->b .= $x;
				}
				$v1 = $v;
				if(null == $v1) throw new HException('null iterable');
				$»it = $v1->keys();
				while($»it->hasNext()) {
					$k = $»it->next();
					{
						$x = ":";
						if(is_null($x)) {
							$x = "null";
						} else {
							if(is_bool($x)) {
								$x = (($x) ? "true" : "false");
							}
						}
						$this->buf->b .= $x;
						unset($x);
					}
					{
						$x = $k;
						if(is_null($x)) {
							$x = "null";
						} else {
							if(is_bool($x)) {
								$x = (($x) ? "true" : "false");
							}
						}
						$this->buf->b .= $x;
						unset($x);
					}
					$this->serialize($v1->get($k));
				}
				{
					$x = "h";
					if(is_null($x)) {
						$x = "null";
					} else {
						if(is_bool($x)) {
							$x = (($x) ? "true" : "false");
						}
					}
					$this->buf->b .= $x;
				}
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
				{
					$x = "s";
					if(is_null($x)) {
						$x = "null";
					} else {
						if(is_bool($x)) {
							$x = (($x) ? "true" : "false");
						}
					}
					$this->buf->b .= $x;
				}
				{
					$x = strlen($chars);
					if(is_null($x)) {
						$x = "null";
					} else {
						if(is_bool($x)) {
							$x = (($x) ? "true" : "false");
						}
					}
					$this->buf->b .= $x;
				}
				{
					$x = ":";
					if(is_null($x)) {
						$x = "null";
					} else {
						if(is_bool($x)) {
							$x = (($x) ? "true" : "false");
						}
					}
					$this->buf->b .= $x;
				}
				{
					$x = $chars;
					if(is_null($x)) {
						$x = "null";
					} else {
						if(is_bool($x)) {
							$x = (($x) ? "true" : "false");
						}
					}
					$this->buf->b .= $x;
				}
			}break;
			default:{
				$this->cache->pop();
				if(_hx_field($v, "hxSerialize") !== null) {
					{
						$x = "C";
						if(is_null($x)) {
							$x = "null";
						} else {
							if(is_bool($x)) {
								$x = (($x) ? "true" : "false");
							}
						}
						$this->buf->b .= $x;
					}
					$this->serializeString(Type::getClassName($c));
					$this->cache->push($v);
					$v->hxSerialize($this);
					{
						$x = "g";
						if(is_null($x)) {
							$x = "null";
						} else {
							if(is_bool($x)) {
								$x = (($x) ? "true" : "false");
							}
						}
						$this->buf->b .= $x;
					}
				} else {
					{
						$x = "c";
						if(is_null($x)) {
							$x = "null";
						} else {
							if(is_bool($x)) {
								$x = (($x) ? "true" : "false");
							}
						}
						$this->buf->b .= $x;
					}
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
			{
				$x = "o";
				if(is_null($x)) {
					$x = "null";
				} else {
					if(is_bool($x)) {
						$x = (($x) ? "true" : "false");
					}
				}
				$this->buf->b .= $x;
			}
			$this->serializeFields($v);
		}break;
		case 7:
		$e = $»t->params[0];
		{
			if($this->useCache && $this->serializeRef($v)) {
				return;
			}
			$this->cache->pop();
			{
				$x = (($this->useEnumIndex) ? "j" : "w");
				if(is_null($x)) {
					$x = "null";
				} else {
					if(is_bool($x)) {
						$x = (($x) ? "true" : "false");
					}
				}
				$this->buf->b .= $x;
			}
			$this->serializeString(Type::getEnumName($e));
			if($this->useEnumIndex) {
				{
					$x = ":";
					if(is_null($x)) {
						$x = "null";
					} else {
						if(is_bool($x)) {
							$x = (($x) ? "true" : "false");
						}
					}
					$this->buf->b .= $x;
				}
				{
					$x = $v->index;
					if(is_null($x)) {
						$x = "null";
					} else {
						if(is_bool($x)) {
							$x = (($x) ? "true" : "false");
						}
					}
					$this->buf->b .= $x;
				}
			} else {
				$this->serializeString($v->tag);
			}
			{
				$x = ":";
				if(is_null($x)) {
					$x = "null";
				} else {
					if(is_bool($x)) {
						$x = (($x) ? "true" : "false");
					}
				}
				$this->buf->b .= $x;
			}
			$l = count($v->params);
			if($l === 0 || _hx_field($v, "params") === null) {
				$x = 0;
				if(is_null($x)) {
					$x = "null";
				} else {
					if(is_bool($x)) {
						$x = (($x) ? "true" : "false");
					}
				}
				$this->buf->b .= $x;
			} else {
				{
					$x = $l;
					if(is_null($x)) {
						$x = "null";
					} else {
						if(is_bool($x)) {
							$x = (($x) ? "true" : "false");
						}
					}
					$this->buf->b .= $x;
				}
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
		{
			$x = "x";
			if(is_null($x)) {
				$x = "null";
			} else {
				if(is_bool($x)) {
					$x = (($x) ? "true" : "false");
				}
			}
			$this->buf->b .= $x;
		}
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
