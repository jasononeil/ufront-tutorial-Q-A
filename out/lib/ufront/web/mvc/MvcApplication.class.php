<?php

class ufront_web_mvc_MvcApplication extends ufront_web_HttpApplication {
	public function __construct($configuration, $routes, $httpContext) {
		if(!php_Boot::$skip_constructor) {
		if($configuration === null) {
			$configuration = new ufront_web_AppConfiguration(null, null, null);
		}
		if($httpContext === null) {
			$httpContext = ufront_web_HttpContext::createWebContext(null, null, null);
			$path = trim($configuration->basePath, "/");
			if(strlen($path) > 0) {
				$httpContext->addUrlFilter(new ufront_web_DirectoryUrlFilter($path));
			}
			if($configuration->modRewrite !== true) {
				$httpContext->addUrlFilter(new ufront_web_PathInfoUrlFilter(null, null));
			}
		}
		parent::__construct($httpContext);
		$this->modules->add($this->routeModule = new ufront_web_routing_UrlRoutingModule((($routes === null) ? new ufront_web_routing_RouteCollection(ufront_web_mvc_MvcApplication::$defaultRoutes) : $routes)));
		{
			$_g = 0; $_g1 = $configuration->controllerPackages;
			while($_g < $_g1->length) {
				$pack = $_g1[$_g];
				++$_g;
				ufront_web_mvc_ControllerBuilder::$current->packages->add($pack);
				unset($pack);
			}
		}
		{
			$_g = 0; $_g1 = $configuration->attributePackages;
			while($_g < $_g1->length) {
				$pack = $_g1[$_g];
				++$_g;
				ufront_web_mvc_ControllerBuilder::$current->packages->add($pack);
				unset($pack);
			}
		}
		$this->modules->add(new ufront_web_module_ErrorModule());
		$this->modules->add(new ufront_web_module_TraceModule());
	}}
	public $routeModule;
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
	static $defaultRoutes;
	function __toString() { return 'ufront.web.mvc.MvcApplication'; }
}
ufront_web_mvc_MvcApplication::$defaultRoutes = new _hx_array(array(new ufront_web_routing_Route("/", new ufront_web_mvc_MvcRouteHandler(), DynamicsT::toHash(_hx_anonymous(array("controller" => "home", "action" => "index"))), null), new ufront_web_routing_Route("/{controller}/{action}/{?id}", new ufront_web_mvc_MvcRouteHandler(), null, null)));
