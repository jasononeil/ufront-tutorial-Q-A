<?php

class model_Vote extends sys_db_Object {
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
	public function get_answer() { return call_user_func($this->get_answer); }
	public $get_answer;
	public function set_answer($v) { return call_user_func($this->set_answer, $v); }
	public $set_answer;
	public $answer;
	public $vote;
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
model_Vote::$__meta__ = _hx_anonymous(array("obj" => _hx_anonymous(array("rtti" => new _hx_array(array("oy9:relationsaoy3:keyy6:userIDy4:lockfy4:propy4:usery4:typey10:model.Usery6:isNullfy7:cascadefgoR1y8:answerIDR3fR4y6:answerR6y12:model.AnswerR8fR9fghR1ay2:idhy4:namey4:Votey6:fieldsaoy1:tjy15:sys.db.SpodType:2:0R14R13R8fgoR17jR18:8:0R14y4:voteR8fgoR17jR18:1:0R14R2R8fgoR17r11R14R10R8fghy7:hfieldsbR19r8R13r6R10r12R2r10hy7:indexesahg"))))));
model_Vote::$manager = new sys_db_Manager(_hx_qtype("model.Vote"));
