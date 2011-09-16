<?php

class model_Answer extends sys_db_Object {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		parent::__construct();
	}}
	public $id;
	public function get_user() { return call_user_func($this->get_user); }
	public $get_user;
	public function set_user($v) { return call_user_func($this->set_user, $v); }
	public $set_user;
	public $user;
	public function get_question() { return call_user_func($this->get_question); }
	public $get_question;
	public function set_question($v) { return call_user_func($this->set_question, $v); }
	public $set_question;
	public $question;
	public $text;
	public $date;
	public function countUpVotes() {
		return model_Vote::$manager->unsafeCount("SELECT COUNT(*) FROM Vote WHERE answerID = " . sys_db_Manager::quoteAny($this->id) . " AND vote = 1");
	}
	public function countDownVotes() {
		return model_Vote::$manager->unsafeCount("SELECT COUNT(*) FROM Vote WHERE answerID = " . sys_db_Manager::quoteAny($this->id) . " AND vote = 0");
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
model_Answer::$__meta__ = _hx_anonymous(array("obj" => _hx_anonymous(array("rtti" => new _hx_array(array("oy9:relationsaoy3:keyy6:userIDy4:lockfy4:propy4:usery4:typey10:model.Usery6:isNullfy7:cascadefgoR1y10:questionIDR3fR4y8:questionR6y14:model.QuestionR8fR9fghR1ay2:idhy4:namey6:Answery6:fieldsaoy1:tjy15:sys.db.SpodType:2:0R14R13R8fgoR17jR18:13:0R14y4:textR8tgoR17jR18:11:0R14y4:dateR8fgoR17jR18:1:0R14R2R8fgoR17r13R14R10R8fghy7:hfieldsbR10r14R13r6R19r8R20r10R2r12hy7:indexesaoy4:keysaR2hy6:uniquefgoR23aR10hR24fghg"))))));
model_Answer::$manager = new sys_db_Manager(_hx_qtype("model.Answer"));
