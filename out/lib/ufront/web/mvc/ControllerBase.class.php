<?php

class ufront_web_mvc_ControllerBase implements haxe_rtti_Infos, ufront_web_mvc_IController{
	public function __construct() {
		;
	}
	public $controllerContext;
	public $_valueProvider;
	public $valueProvider;
	public function getValueProvider() {
		if($this->_valueProvider === null) {
			$this->_valueProvider = ufront_web_mvc_ValueProviderFactories::$factories->getValueProvider($this->controllerContext);
		}
		return $this->_valueProvider;
	}
	public function setValueProvider($valueProvider) {
		$this->_valueProvider = $valueProvider;
		return $this->_valueProvider;
	}
	public function executeCore($async) {
		throw new HException("executeCore() must be overridden in subclass.");
	}
	public function execute($requestContext, $async) {
		if(null === $requestContext) {
			throw new HException(new thx_error_NullArgument("requestContext", _hx_anonymous(array("fileName" => "ControllerBase.hx", "lineNumber" => 44, "className" => "ufront.web.mvc.ControllerBase", "methodName" => "execute"))));
		}
		if($this->controllerContext === null) {
			$this->controllerContext = new ufront_web_mvc_ControllerContext($this, $requestContext);
		}
		$this->executeCore($async);
	}
	public function getViewHelpers() {
		return new _hx_array(array());
	}
	public function __call($m, $a) {
		if(isset($this->$m) && is_callable($this->$m))
			return call_user_func_array($this->$m, $a);
		else if(isset($this->�dynamics[$m]) && is_callable($this->�dynamics[$m]))
			return call_user_func_array($this->�dynamics[$m], $a);
		else if('toString' == $m)
			return $this->__toString();
		else
			throw new HException('Unable to call �'.$m.'�');
	}
	static function __meta__() { $�args = func_get_args(); return call_user_func_array(self::$__meta__, $�args); }
	static $__meta__;
	static $__rtti = "<class path=\"ufront.web.mvc.ControllerBase\" params=\"\">\x0A\x09<implements path=\"haxe.rtti.Infos\"/>\x0A\x09<implements path=\"ufront.web.mvc.IController\"/>\x0A\x09<controllerContext public=\"1\">\x0A\x09\x09<c path=\"ufront.web.mvc.ControllerContext\"/>\x0A\x09\x09<haxe_doc>\x0A\x09 * If null, this value is automatically created in execute().\x0A\x09 </haxe_doc>\x0A\x09</controllerContext>\x0A\x09<_valueProvider><c path=\"ufront.web.mvc.IValueProvider\"/></_valueProvider>\x0A\x09<valueProvider public=\"1\" get=\"getValueProvider\" set=\"setValueProvider\"><c path=\"ufront.web.mvc.IValueProvider\"/></valueProvider>\x0A\x09<getValueProvider set=\"method\" line=\"24\"><f a=\"\"><c path=\"ufront.web.mvc.IValueProvider\"/></f></getValueProvider>\x0A\x09<setValueProvider set=\"method\" line=\"31\"><f a=\"valueProvider\">\x0A\x09<c path=\"ufront.web.mvc.IValueProvider\"/>\x0A\x09<c path=\"ufront.web.mvc.IValueProvider\"/>\x0A</f></setValueProvider>\x0A\x09<executeCore set=\"method\" line=\"39\"><f a=\"async\">\x0A\x09<c path=\"hxevents.Async\"/>\x0A\x09<e path=\"Void\"/>\x0A</f></executeCore>\x0A\x09<execute public=\"1\" set=\"method\" line=\"41\"><f a=\"requestContext:async\">\x0A\x09<c path=\"ufront.web.routing.RequestContext\"/>\x0A\x09<c path=\"hxevents.Async\"/>\x0A\x09<e path=\"Void\"/>\x0A</f></execute>\x0A\x09<getViewHelpers public=\"1\" set=\"method\" line=\"50\"><f a=\"\"><c path=\"Array\"><c path=\"ufront.web.mvc.IViewHelper\"/></c></f></getViewHelpers>\x0A\x09<new public=\"1\" set=\"method\" line=\"37\"><f a=\"\"><e path=\"Void\"/></f></new>\x0A\x09<haxe_doc>\x0A * ...\x0A * @author Andreas Soderlund\x0A </haxe_doc>\x0A</class>";
	function __toString() { return 'ufront.web.mvc.ControllerBase'; }
}
ufront_web_mvc_ControllerBase::$__meta__ = _hx_anonymous(array("fields" => _hx_anonymous(array("valueProvider" => _hx_anonymous(array("set" => new _hx_array(array("setValueProvider")), "get" => new _hx_array(array("getValueProvider"))))))));
