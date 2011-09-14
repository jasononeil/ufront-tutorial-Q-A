<?php

class Hashes {
	public function __construct(){}
	static function toDynamic($hash) {
		$o = _hx_anonymous(array());
		if(null == $hash) throw new HException('null iterable');
		$»it = $hash->keys();
		while($»it->hasNext()) {
			$key = $»it->next();
			$o->{$key} = $hash->get($key);
		}
		return $o;
	}
	static function importObject($hash, $ob) {
		return DynamicsT::copyToHash($ob, $hash);
	}
	static function copyTo($from, $to) {
		if(null == $from) throw new HException('null iterable');
		$»it = $from->keys();
		while($»it->hasNext()) {
			$k = $»it->next();
			$to->set($k, $from->get($k));
		}
		return $to;
	}
	static function hclone($src) {
		$h = new Hash();
		Hashes::copyTo($src, $h);
		return $h;
	}
	static function arrayOfKeys($hash) {
		return Iterators::harray($hash->keys());
	}
	static function setOfKeys($hash) {
		$set = new thx_collections_Set();
		if(null == $hash) throw new HException('null iterable');
		$»it = $hash->keys();
		while($»it->hasNext()) {
			$k = $»it->next();
			$set->add($k);
		}
		return $set;
	}
	static function count($hash) {
		return count($hash->h);
	}
	static function clear($hash) {
		$_hash = $hash;
		$_hash->h = array();
	}
	function __toString() { return 'Hashes'; }
}
