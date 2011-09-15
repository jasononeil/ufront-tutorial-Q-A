<?php

class model_User extends sys_db_Object {
	public function __construct() {
		if(!php_Boot::$skip_constructor) {
		parent::__construct();
	}}
	public $id;
	public $username;
	public $password;
	public $email;
	public $registrationDate;
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
	function __toString() { return 'model.User'; }
}
model_User::$__meta__ = _hx_anonymous(array("obj" => _hx_anonymous(array("rtti" => new _hx_array(array("oy9:relationsahy3:keyay2:idhy4:namey4:Usery6:fieldsaoy1:tjy15:sys.db.SpodType:2:0R3R2y6:isNullfgoR6jR7:9:1i40R3y8:usernameR8fgoR6jR7:9:1i255R3y8:passwordR8fgoR6jR7:9:1i255R3y5:emailR8fgoR6jR7:11:0R3y16:registrationDateR8fghy7:hfieldsbR12r12R2r4R11r10R9r6R10r8hy7:indexesahg"))))));
model_User::$manager = new sys_db_Manager(_hx_qtype("model.User"));
