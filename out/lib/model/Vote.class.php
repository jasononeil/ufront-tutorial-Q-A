<?php

class model_Vote extends sys_db_Object {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		parent::__construct();
	}}
	public $id;
	public $user;
	public $answer;
	public $vote;
	public function voteUp() {
		$this->vote = true;
	}
	public function voteDown() {
		$this->vote = false;
	}
	public function get_user() {
		return model_User::$manager->h__get($this, "user", "userID", false);
	}
	public function set_user($_v) {
		return model_User::$manager->h__set($this, "user", "userID", $_v);
	}
	public function get_answer() {
		return model_Answer::$manager->h__get($this, "answer", "answerID", false);
	}
	public function set_answer($_v) {
		return model_Answer::$manager->h__set($this, "answer", "answerID", $_v);
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
	function __toString() { return 'model.Vote'; }
}
model_Vote::$__meta__ = _hx_anonymous(array("obj" => _hx_anonymous(array("rtti" => new _hx_array(array("oy9:relationsaoy3:keyy6:userIDy4:lockfy4:propy4:usery4:typey10:model.Usery6:isNullfy7:cascadefgoR1y8:answerIDR3fR4y6:answerR6y12:model.AnswerR8fR9fghR1ay2:idhy4:namey4:Votey6:fieldsaoy1:tjy15:sys.db.SpodType:2:0R14R13R8fgoR17jR18:8:0R14y4:voteR8fgoR17jR18:1:0R14R2R8fgoR17r11R14R10R8fghy7:hfieldsbR19r8R13r6R10r12R2r10hy7:indexesaoy4:keysaR2R10hy6:uniquefgoR22aR10hR23fgoR22aR2hR23fgoR22aR19hR23fghg")))), "fields" => _hx_anonymous(array("user" => _hx_anonymous(array("set" => new _hx_array(array("set_user")), "get" => new _hx_array(array("get_user")))), "answer" => _hx_anonymous(array("set" => new _hx_array(array("set_answer")), "get" => new _hx_array(array("get_answer"))))))));
model_Vote::$manager = new sys_db_Manager(_hx_qtype("model.Vote"));
