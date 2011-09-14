<?php

class ufront_web_mvc_DefaultDependencyResolver implements ufront_web_mvc_IDependencyResolver{
	public function __construct() { 
	}
	public function getService($type) {
		try {
			return Type::createInstance($type, new _hx_array(array()));
		}catch(Exception $»e) {
			$_ex_ = ($»e instanceof HException) ? $»e->e : $»e;
			$e = $_ex_;
			{
				return null;
			}
		}
	}
	function __toString() { return 'ufront.web.mvc.DefaultDependencyResolver'; }
}
