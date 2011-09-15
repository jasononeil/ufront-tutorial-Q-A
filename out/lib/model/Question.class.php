<?php

class model_Question extends sys_db_Object {
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
	public $title;
	public $text;
	public $date;
	public $answered;
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
	function __toString() { return 'model.Question'; }
}
model_Question::$__meta__ = _hx_anonymous(array("obj" => _hx_anonymous(array("rtti" => new _hx_array(array("oy9:relationsaoy3:keyy6:userIDy4:lockfy4:propy4:usery4:typey10:model.Usery6:isNullfy7:cascadefghR1ay2:idhy4:namey8:Questiony6:fieldsaoy1:tjy15:sys.db.SpodType:2:0R11R10R8fgoR14jR15:9:1i255R11y5:titleR8fgoR14jR15:13:0R11y4:textR8tgoR14jR15:11:0R11y4:dateR8fgoR14jR15:8:0R11y8:answeredR8fgoR14jR15:1:0R11R2R8fghy7:hfieldsbR10r5R19r13R16r7R17r9R18r11R2r15hy7:indexesaoy4:keysaR2hy6:uniquefgoR22aR18hR23fgoR22aR19hR23fghg"))))));
model_Question::$manager = new sys_db_Manager(_hx_qtype("model.Question"));
