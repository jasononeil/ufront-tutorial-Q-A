<?php

class hxevents_Dispatcher {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		$this->handlers = new _hx_array(array());
	}}
	public $handlers;
	public function add($h) {
		$this->handlers->push($h);
		return $h;
	}
	public function addOnce($h) {
		$me = $this;
		$_h = null;
		$_h = array(new _hx_lambda(array(&$_h, &$h, &$me), "hxevents_Dispatcher_0"), 'execute');
		$this->add($_h);
		return $_h;
	}
	public function remove($h) {
		{
			$_g1 = 0; $_g = $this->handlers->length;
			while($_g1 < $_g) {
				$i = $_g1++;
				if(Reflect::compareMethods($this->handlers[$i], $h)) {
					return _hx_array_get($this->handlers->splice($i, 1), 0);
				}
				unset($i);
			}
		}
		return null;
	}
	public function clear() {
		$this->handlers = new _hx_array(array());
	}
	public function dispatch($e) {
		try {
			$list = $this->handlers->copy();
			{
				$_g = 0;
				while($_g < $list->length) {
					$l = $list[$_g];
					++$_g;
					call_user_func_array($l, array($e));
					unset($l);
				}
			}
			return true;
		}catch(Exception $»e) {
			$_ex_ = ($»e instanceof HException) ? $»e->e : $»e;
			if(($exc = $_ex_) instanceof hxevents_EventException){
				return false;
			} else throw $»e;;
		}
	}
	public function has($h) {
		if(null === $h) {
			return $this->handlers->length > 0;
		} else {
			{
				$_g = 0; $_g1 = $this->handlers;
				while($_g < $_g1->length) {
					$handler = $_g1[$_g];
					++$_g;
					if($h === $handler) {
						return true;
					}
					unset($handler);
				}
			}
			return false;
		}
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
	static function stop() {
		throw new HException(hxevents_EventException::$StopPropagation);
	}
	function __toString() { return 'hxevents.Dispatcher'; }
}
function hxevents_Dispatcher_0(&$_h, &$h, &$me, $v) {
	{
		$me->remove($_h);
		call_user_func_array($h, array($v));
	}
}
