<?php

class controller_InstallationController extends ufront_web_mvc_Controller {
	public function __construct() { if(!php_Boot::$skip_constructor) {
		parent::__construct();
	}}
	public function information() {
		return "<h1>Do you want to install?</h1><pre>" . "\x0A Server: " . AppConfig::$dbServer . "\x0A Port: " . AppConfig::$dbPort . "\x0A Database: " . AppConfig::$dbDatabase . "\x0A Username: " . AppConfig::$dbUser . "\x0A Password: " . AppConfig::$dbPass . "</pre><p>" . "If so, click here: <a href='/install/createtables/'>Install</a>" . "</p>";
	}
	public function createtables() {
		sys_db_TableCreate::create(model_User::$manager, null);
		sys_db_TableCreate::create(model_Question::$manager, null);
		sys_db_TableCreate::create(model_Answer::$manager, null);
		sys_db_TableCreate::create(model_Vote::$manager, null);
		return "<h1>Installed the tables.</h1>" . "<p>You can also <a href='/install/sampledata/'>Install Sample Data</a></p>" . "<p><a href='/'>Or go to the app!</a></p>";
	}
	public function sampledata() {
		if(model_User::$manager->unsafeCount("SELECT COUNT(*) FROM User WHERE 1") === 0) {
			{
				$_g = 0; $_g1 = new _hx_array(array("jason", "billy", "jill"));
				while($_g < $_g1->length) {
					$name = $_g1[$_g];
					++$_g;
					$u = new model_User();
					$u->username = $name;
					$u->password = "password";
					$u->email = $name . "@example.com";
					$u->registrationDate = Date::now();
					$u->insert();
					unset($u,$name);
				}
			}
			$q1 = new model_Question();
			$q1->answered = false;
			$q1->date = Date::now();
			$q1->title = "Why am I hungry?";
			$q1->text = "I'm not usually this hungry.  It's 3:30pm and I haven't had lunch, but still!";
			$q1->set_user(model_User::$manager->unsafeObjects("SELECT * FROM User WHERE username = 'jason'", null)->first());
			$q1->insert();
			$q2 = new model_Question();
			$q2->answered = false;
			$q2->date = Date::now();
			$q2->title = "Has anyone seen my keys?";
			$q2->text = "I could have sworn I left them in the kitchen, but they're not there!  Please help.";
			$q2->set_user(model_User::$manager->unsafeObjects("SELECT * FROM User WHERE username = 'jill'", null)->first());
			$q2->insert();
			$a1 = new model_Answer();
			$a1->text = "Please RTFM: http://en.wikipedia.org/wiki/Hunger";
			$a1->date = Date::now();
			$a1->set_question($q1);
			$a1->set_user(model_User::$manager->unsafeObjects("SELECT * FROM User WHERE username = 'jill'", null)->first());
			$a1->insert();
			$a2 = new model_Answer();
			$a2->text = "Good question!  \x0A\x0AI personally advocate keeping the fridge next to my desk, so that I can always be close to the food I need.  That way I don't get hungry even if I don't have time to take a lunch break.\x0A\x0AHope that helps!\x0ABilly";
			$a2->date = Date::now();
			$a2->set_question($q1);
			$a2->set_user(model_User::$manager->unsafeObjects("SELECT * FROM User WHERE username = 'billy'", null)->first());
			$a2->insert();
			$v1 = new model_Vote();
			$v1->set_answer($a2);
			$v1->set_user(model_User::$manager->unsafeObjects("SELECT * FROM User WHERE username = 'jason'", null)->first());
			$v1->voteUp();
			$v1->insert();
			$v2 = new model_Vote();
			$v2->set_answer($a2);
			$v2->set_user(model_User::$manager->unsafeObjects("SELECT * FROM User WHERE username = 'jill'", null)->first());
			$v2->voteUp();
			$v2->insert();
			$v3 = new model_Vote();
			$v3->set_answer($a1);
			$v3->set_user(model_User::$manager->unsafeObjects("SELECT * FROM User WHERE username = 'billy'", null)->first());
			$v3->voteDown();
			$v3->insert();
			return "<h1>Sample data installed.</h1>" . "<p><a href='/'>Go to the app!</a></p>";
		} else {
			return "<h1>No sample data installed - data already existed!</h1>" . "<p><a href='/'>Go to the app!</a></p>";
		}
	}
	static $__rtti = "<class path=\"controller.InstallationController\" params=\"\">\x0A\x09<extends path=\"ufront.web.mvc.Controller\"/>\x0A\x09<information public=\"1\" set=\"method\" line=\"8\"><f a=\"\"><c path=\"String\"/></f></information>\x0A\x09<createtables public=\"1\" set=\"method\" line=\"21\"><f a=\"\"><c path=\"String\"/></f></createtables>\x0A\x09<sampledata public=\"1\" set=\"method\" line=\"37\"><f a=\"\"><c path=\"String\"/></f></sampledata>\x0A\x09<new public=\"1\" set=\"method\" line=\"6\"><f a=\"\"><e path=\"Void\"/></f></new>\x0A</class>";
	function __toString() { return 'controller.InstallationController'; }
}
