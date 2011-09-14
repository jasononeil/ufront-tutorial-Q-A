<?php

class ufront_web_mvc_FormValueProviderFactory extends ufront_web_mvc_ValueProviderFactory {
	public function __construct() { if(!php_Boot::$skip_constructor) {
		parent::__construct();
	}}
	public function getValueProvider($controllerContext) {
		if(null === $controllerContext) {
			throw new HException(new thx_error_NullArgument("controllerContext", _hx_anonymous(array("fileName" => "FormValueProviderFactory.hx", "lineNumber" => 22, "className" => "ufront.web.mvc.FormValueProviderFactory", "methodName" => "getValueProvider"))));
		}
		return new ufront_web_mvc_FormValueProvider($controllerContext);
	}
	function __toString() { return 'ufront.web.mvc.FormValueProviderFactory'; }
}
