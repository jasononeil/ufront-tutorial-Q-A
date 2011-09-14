<?php

class ufront_events_ReverseDispatcher extends hxevents_Dispatcher {
	public function __construct() { if(!php_Boot::$skip_constructor) {
		parent::__construct();
	}}
	public function add($h) {
		$this->handlers->unshift($h);
		return $h;
	}
	function __toString() { return 'ufront.events.ReverseDispatcher'; }
}
