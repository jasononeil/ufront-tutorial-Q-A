<?php

class Main {
	public function __construct(){}
	static function main() {
		$config = new ufront_web_AppConfiguration("controller", true, "/");
		$routes = _hx_deref(new ufront_web_routing_RouteCollection(null))->addRoute("/", _hx_anonymous(array("controller" => "question", "action" => "list")), null)->addRoute("/q/{name}/", _hx_anonymous(array("controller" => "question", "action" => "view")), null)->addRoute("/q/{name}/answer/", _hx_anonymous(array("controller" => "question", "action" => "answer")), null)->addRoute("/q/{questionname}/{answernumber}/", _hx_anonymous(array("controller" => "question", "action" => "viewanswer")), null)->addRoute("/q/{questionname}/{answernumber}/voteup/", _hx_anonymous(array("controller" => "question", "action" => "voteup")), null)->addRoute("/q/{questionname}/{answernumber}/votedown/", _hx_anonymous(array("controller" => "question", "action" => "votedown")), null)->addRoute("/ask/", _hx_anonymous(array("controller" => "question", "action" => "ask")), null);
		_hx_deref(new ufront_web_mvc_MvcApplication($config, $routes, null))->execute();
	}
	function __toString() { return 'Main'; }
}
