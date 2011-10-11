<?php

class model_Question extends sys_db_Object {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		parent::__construct();
	}}
	public $id;
	public $user;
	public $title;
	public $slug;
	public $text;
	public $date;
	public $answered;
	public function answers() {
		return model_Answer::$manager->unsafeObjects("SELECT * FROM Answer WHERE questionID = " . sys_db_Manager::quoteAny($this->id), null);
	}
	public function numberOfAnswers() {
		return model_Answer::$manager->unsafeCount("SELECT COUNT(*) FROM Answer WHERE questionID = " . sys_db_Manager::quoteAny($this->id));
	}
	public function insert() {
		$urlslug = str_replace(" ", "-", strtolower($this->title));
		$urlslug = _hx_deref(new EReg("[^A-Za-z0-9-]", "g"))->replace($urlslug, "");
		$this->slug = $urlslug;
		parent::insert();
	}
	public function get_user() {
		return model_User::$manager->h__get($this, "user", "userID", false);
	}
	public function set_user($_v) {
		return model_User::$manager->h__set($this, "user", "userID", $_v);
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
	function __toString() { return 'model.Question'; }
}
model_Question::$__meta__ = _hx_anonymous(array("obj" => _hx_anonymous(array("rtti" => new _hx_array(array("oy9:relationsaoy3:keyy6:userIDy4:lockfy4:propy4:usery4:typey10:model.Usery6:isNullfy7:cascadefghR1ay2:idhy4:namey8:Questiony6:fieldsaoy1:tjy15:sys.db.SpodType:2:0R11R10R8fgoR14jR15:9:1i255R11y5:titleR8fgoR14jR15:9:1i255R11y4:slugR8fgoR14jR15:13:0R11y4:textR8tgoR14jR15:11:0R11y4:dateR8fgoR14jR15:8:0R11y8:answeredR8fgoR14jR15:1:0R11R2R8fghy7:hfieldsbR17r9R16r7R18r11R19r13R20r15R2r17R10r5hy7:indexesaoy4:keysaR2hy6:uniquefgoR23aR19hR24fgoR23aR17hR24fgoR23aR20hR24fghg")))), "fields" => _hx_anonymous(array("user" => _hx_anonymous(array("set" => new _hx_array(array("set_user")), "get" => new _hx_array(array("get_user"))))))));
model_Question::$manager = new sys_db_Manager(_hx_qtype("model.Question"));
