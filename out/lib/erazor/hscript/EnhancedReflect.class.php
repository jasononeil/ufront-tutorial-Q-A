<?php

class erazor_hscript_EnhancedReflect {
	public function __construct(){}
	static function getProperty($o, $field) {
		try {
			$meta = haxe_rtti_Meta::getFields(Type::getClass($o));
			$infos = Reflect::field($meta, $field);
			if($infos !== null) {
				$getter = $infos->get;
				if($getter !== null) {
					return Reflect::callMethod($o, Reflect::field($o, $getter[0]), new _hx_array(array()));
				}
			}
		}catch(Exception $»e) {
			$_ex_ = ($»e instanceof HException) ? $»e->e : $»e;
			$e = $_ex_;
			{
			}
		}
		return Reflect::field($o, $field);
	}
	function __toString() { return 'erazor.hscript.EnhancedReflect'; }
}
