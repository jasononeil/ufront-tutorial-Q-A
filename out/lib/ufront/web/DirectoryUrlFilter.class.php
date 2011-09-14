<?php

class ufront_web_DirectoryUrlFilter implements ufront_web_IUrlFilter{
	public function __construct($directory) {
		if(!php_Boot::$skip_constructor) {
		if(null === $directory) {
			throw new HException(new thx_error_NullArgument("directory", _hx_anonymous(array("fileName" => "DirectoryUrlFilter.hx", "lineNumber" => 14, "className" => "ufront.web.DirectoryUrlFilter", "methodName" => "new"))));
		}
		if(StringTools::endsWith($directory, "/")) {
			$directory = _hx_substr($directory, 0, strlen($directory) - 1);
		}
		$this->directory = $directory;
	}}
	public $directory;
	public function filterIn($url, $request) {
		if($url->segments[0] === $this->directory) {
			$url->segments->shift();
		}
	}
	public function filterOut($url, $request) {
		$url->segments->unshift($this->directory);
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
	function __toString() { return 'ufront.web.DirectoryUrlFilter'; }
}
