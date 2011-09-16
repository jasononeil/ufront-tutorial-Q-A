<?php

class AppConfig {
	public function __construct(){}
	static $dbServer = "localhost";
	static $dbPort = null;
	static $dbUser = "qanda";
	static $dbPass = "";
	static $dbDatabase = "qanda";
	static $dbSocket = null;
	function __toString() { return 'AppConfig'; }
}
