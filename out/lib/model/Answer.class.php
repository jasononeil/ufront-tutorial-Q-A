<?php

class model_Answer extends sys_db_Object {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		parent::__construct();
	}}
	public $id;
	public $user;
	public $question;
	public $text;
	public $date;
	public function countUpVotes() {
		return model_Vote::$manager->unsafeCount("SELECT COUNT(*) FROM Vote WHERE answerID = " . sys_db_Manager::quoteAny($this->id) . " AND vote = 1");
	}
	public function countDownVotes() {
		return model_Vote::$manager->unsafeCount("SELECT COUNT(*) FROM Vote WHERE answerID = " . sys_db_Manager::quoteAny($this->id) . " AND vote = 0");
	}
	public function get_user() {
		return model_User::$manager->h__get($this, "user", "userID", false);
	}
	public function set_user($_v) {
		return model_User::$manager->h__set($this, "user", "userID", $_v);
	}
	public function get_question() {
		return model_Question::$manager->h__get($this, "question", "questionID", false);
	}
	public function set_question($_v) {
		return model_Question::$manager->h__set($this, "question", "questionID", $_v);
	}
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
	static function __meta__() { $»args = func_get_args(); return call_user_func_array(self::$__meta__, $»args); }
	static $__meta__;
	static $manager;
	function __toString() { return 'model.Answer'; }
}
model_Answer::$__meta__ = _hx_anonymous(array("obj" => _hx_anonymous(array("rtti" => new _hx_array(array("oy9:relationsaoy3:keyy6:userIDy4:lockfy4:propy4:usery4:typey10:model.Usery6:isNullfy7:cascadefgoR1y10:questionIDR3fR4y8:questionR6y14:model.QuestionR8fR9fghR1ay2:idhy4:namey6:Answery6:fieldsaoy1:tjy15:sys.db.SpodType:2:0R14R13R8fgoR17jR18:13:0R14y4:textR8tgoR17jR18:11:0R14y4:dateR8fgoR17jR18:1:0R14R2R8fgoR17r13R14R10R8fghy7:hfieldsbR10r14R13r6R19r8R20r10R2r12hy7:indexesaoy4:keysaR2hy6:uniquefgoR23aR10hR24fghg")))), "fields" => _hx_anonymous(array("user" => _hx_anonymous(array("set" => new _hx_array(array("set_user")), "get" => new _hx_array(array("get_user")))), "question" => _hx_anonymous(array("set" => new _hx_array(array("set_question")), "get" => new _hx_array(array("get_question"))))))));
model_Answer::$manager = new sys_db_Manager(_hx_qtype("model.Answer"));
