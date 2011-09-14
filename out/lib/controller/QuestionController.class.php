<?php

class controller_QuestionController extends ufront_web_mvc_Controller {
	public function __construct() { if(!php_Boot::$skip_constructor) {
		parent::__construct();
	}}
	public function hlist() {
		return "List all questions.";
	}
	public function view($name) {
		return "View a specific question: " . $name;
	}
	public function answer($name) {
		return "Answer a specific question: " . $name;
	}
	public function viewanswer($questionname, $answernumber) {
		return "View a specific question/answer combo. Q: " . $questionname . ", with A: " . $answernumber;
	}
	public function voteup($questionname, $answernumber) {
		return "Vote up answer " . $answernumber . " on question " . $questionname;
	}
	public function votedown($questionname, $answernumber) {
		return "Vote down answer " . $answernumber . " on question " . $questionname;
	}
	public function ask() {
		return "Allow the user to ask a question";
	}
	static $__rtti = "<class path=\"controller.QuestionController\" params=\"\">\x0A\x09<extends path=\"ufront.web.mvc.Controller\"/>\x0A\x09<list public=\"1\" set=\"method\" line=\"7\"><f a=\"\"><c path=\"String\"/></f></list>\x0A\x09<view public=\"1\" set=\"method\" line=\"12\"><f a=\"name\">\x0A\x09<c path=\"String\"/>\x0A\x09<c path=\"String\"/>\x0A</f></view>\x0A\x09<answer public=\"1\" set=\"method\" line=\"17\"><f a=\"name\">\x0A\x09<c path=\"String\"/>\x0A\x09<c path=\"String\"/>\x0A</f></answer>\x0A\x09<viewanswer public=\"1\" set=\"method\" line=\"22\"><f a=\"questionname:answernumber\">\x0A\x09<c path=\"String\"/>\x0A\x09<c path=\"String\"/>\x0A\x09<c path=\"String\"/>\x0A</f></viewanswer>\x0A\x09<voteup public=\"1\" set=\"method\" line=\"27\"><f a=\"questionname:answernumber\">\x0A\x09<c path=\"String\"/>\x0A\x09<c path=\"String\"/>\x0A\x09<c path=\"String\"/>\x0A</f></voteup>\x0A\x09<votedown public=\"1\" set=\"method\" line=\"32\"><f a=\"questionname:answernumber\">\x0A\x09<c path=\"String\"/>\x0A\x09<c path=\"String\"/>\x0A\x09<c path=\"String\"/>\x0A</f></votedown>\x0A\x09<ask public=\"1\" set=\"method\" line=\"37\"><f a=\"\"><c path=\"String\"/></f></ask>\x0A\x09<new public=\"1\" set=\"method\" line=\"5\"><f a=\"\"><e path=\"Void\"/></f></new>\x0A</class>";
	function __toString() { return 'controller.QuestionController'; }
}
