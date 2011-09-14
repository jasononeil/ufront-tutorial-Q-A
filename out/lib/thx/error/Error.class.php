<?php

class thx_error_Error extends thx_util_Message {
	public function __construct($message, $params, $param, $pos) {
		if(!php_Boot::$skip_constructor) {
		parent::__construct($message,$params,$param);
		$this->pos = $pos;
	}}
	public $pos;
	public $inner;
	public function setInner($inner) {
		$this->inner = $inner;
		return $this;
	}
	public function toString() {
		try {
			return Strings::format($this->message, $this->params, null, null);
		}catch(Exception $»e) {
			$_ex_ = ($»e instanceof HException) ? $»e->e : $»e;
			$e = $_ex_;
			{
				$ps = $this->pos->className . "." . $this->pos->methodName . "(" . $this->pos->lineNumber . ")";
				haxe_Log::trace("wrong parameters passed for pattern '" . $this->message . "' at " . $ps, _hx_anonymous(array("fileName" => "Error.hx", "lineNumber" => 34, "className" => "thx.error.Error", "methodName" => "toString")));
				return "";
			}
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
	function __toString() { return $this->toString(); }
}
