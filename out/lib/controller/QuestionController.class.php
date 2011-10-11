<?php

class controller_QuestionController extends ufront_web_mvc_Controller {
	public function __construct() { if(!php_Boot::$skip_constructor) {
		parent::__construct();
	}}
	public function hlist() {
		$questionList = model_Question::$manager->all(null);
		return new ufront_web_mvc_ViewResult(null, _hx_anonymous(array("questions" => $questionList)));
	}
	public function view($name) {
		$question = model_Question::$manager->unsafeObjects("SELECT * FROM Question WHERE slug = " . sys_db_Manager::quoteAny($name), null)->first();
		return new ufront_web_mvc_ViewResult(null, _hx_anonymous(array("question" => $question)));
	}
	public function answer($name) {
		return "Answer a specific question: " . $name;
	}
	public function viewanswer($questionname, $answerid) {
		$answer = model_Answer::$manager->unsafeGet($answerid, null);
		return new ufront_web_mvc_ViewResult(null, _hx_anonymous(array("answer" => $answer, "question" => $answer->get_question())));
	}
	public function voteup($questionname, $answerid) {
		return "Vote up answer " . $answerid . " on question " . $questionname;
	}
	public function votedown($questionname, $answerid) {
		return "Vote down answer " . $answerid . " on question " . $questionname;
	}
	public function ask() {
		return "Allow the user to ask a question";
	}
	static $__rtti = "<class path=\"controller.QuestionController\" params=\"\">\x0A\x09<extends path=\"ufront.web.mvc.Controller\"/>\x0A\x09<list public=\"1\" set=\"method\" line=\"7\"><f a=\"\"><c path=\"ufront.web.mvc.ViewResult\"/></f></list>\x0A\x09<view public=\"1\" set=\"method\" line=\"15\"><f a=\"name\">\x0A\x09<c path=\"String\"/>\x0A\x09<c path=\"ufront.web.mvc.ViewResult\"/>\x0A</f></view>\x0A\x09<answer public=\"1\" set=\"method\" line=\"23\"><f a=\"name\">\x0A\x09<c path=\"String\"/>\x0A\x09<c path=\"String\"/>\x0A</f></answer>\x0A\x09<viewanswer public=\"1\" set=\"method\" line=\"28\"><f a=\"questionname:answerid\">\x0A\x09<c path=\"String\"/>\x0A\x09<c path=\"Int\"/>\x0A\x09<c path=\"ufront.web.mvc.ViewResult\"/>\x0A</f></viewanswer>\x0A\x09<voteup public=\"1\" set=\"method\" line=\"37\"><f a=\"questionname:answerid\">\x0A\x09<c path=\"String\"/>\x0A\x09<c path=\"Int\"/>\x0A\x09<c path=\"String\"/>\x0A</f></voteup>\x0A\x09<votedown public=\"1\" set=\"method\" line=\"42\"><f a=\"questionname:answerid\">\x0A\x09<c path=\"String\"/>\x0A\x09<c path=\"Int\"/>\x0A\x09<c path=\"String\"/>\x0A</f></votedown>\x0A\x09<ask public=\"1\" set=\"method\" line=\"47\"><f a=\"\"><c path=\"String\"/></f></ask>\x0A\x09<new public=\"1\" set=\"method\" line=\"5\"><f a=\"\"><e path=\"Void\"/></f></new>\x0A</class>";
	function __toString() { return 'controller.QuestionController'; }
}
