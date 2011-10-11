<?php

class sys_db_Manager {
	public function __construct($classval) {
		if(!php_Boot::$skip_constructor) {
		$m = haxe_rtti_Meta::getType($classval)->rtti;
		if($m === null) {
			throw new HException("Missing @rtti for class " . Type::getClassName($classval));
		}
		$this->table_infos = haxe_Unserializer::run($m[0]);
		$this->table_name = $this->quoteField($this->table_infos->name);
		$this->table_keys = $this->table_infos->key;
		$this->table_fields = new HList();
		{
			$_g = 0; $_g1 = $this->table_infos->fields;
			while($_g < $_g1->length) {
				$f = $_g1[$_g];
				++$_g;
				$this->table_fields->add($f->name);
				unset($f);
			}
		}
		$this->class_proto = $classval;
	}}
	public $table_infos;
	public $table_name;
	public $table_fields;
	public $table_keys;
	public $class_proto;
	public function all($lock) {
		return $this->unsafeObjects("SELECT * FROM " . $this->table_name, $lock);
	}
	public $get;
	public $select;
	public $search;
	public $count;
	public $delete;
	public function dynamicSearch($x, $lock) {
		$s = new StringBuf();
		{
			$x1 = "SELECT * FROM ";
			if(is_null($x1)) {
				$x1 = "null";
			} else {
				if(is_bool($x1)) {
					$x1 = (($x1) ? "true" : "false");
				}
			}
			$s->b .= $x1;
		}
		{
			$x1 = $this->table_name;
			if(is_null($x1)) {
				$x1 = "null";
			} else {
				if(is_bool($x1)) {
					$x1 = (($x1) ? "true" : "false");
				}
			}
			$s->b .= $x1;
		}
		{
			$x1 = " WHERE ";
			if(is_null($x1)) {
				$x1 = "null";
			} else {
				if(is_bool($x1)) {
					$x1 = (($x1) ? "true" : "false");
				}
			}
			$s->b .= $x1;
		}
		$this->addCondition($s, $x);
		return $this->unsafeObjects($s->b, $lock);
	}
	public function quote($s) {
		return $this->getCnx()->quote($s);
	}
	public function doInsert($x) {
		$this->unmake($x);
		$s = new StringBuf();
		$fields = new HList();
		$values = new HList();
		$pos = 0;
		if(null == $this->table_fields) throw new HException('null iterable');
		$»it = $this->table_fields->iterator();
		while($»it->hasNext()) {
			$f = $»it->next();
			$v = Reflect::field($x, $f);
			if($v !== null) {
				$fields->add($this->quoteField($f));
				$values->add($v);
			} else {
				$inf = $this->table_infos->fields[$pos];
				if(!$inf->isNull) {
					$»t = ($inf->t);
					switch($»t->index) {
					case 3:
					case 23:
					case 1:
					case 6:
					case 7:
					case 22:
					case 5:
					{
						$x->{$f} = 0;
					}break;
					case 8:
					{
						$x->{$f} = false;
					}break;
					case 12:
					case 14:
					case 9:
					case 13:
					case 20:
					{
						$x->{$f} = "";
					}break;
					case 15:
					case 21:
					case 16:
					case 18:
					case 17:
					{
						$x->{$f} = haxe_io_Bytes::alloc(0);
					}break;
					case 10:
					case 11:
					{
					}break;
					case 0:
					case 2:
					case 4:
					case 25:
					case 24:
					case 19:
					{
					}break;
					}
				}
				unset($inf);
			}
			$pos++;
			unset($v);
		}
		{
			$x1 = "INSERT INTO ";
			if(is_null($x1)) {
				$x1 = "null";
			} else {
				if(is_bool($x1)) {
					$x1 = (($x1) ? "true" : "false");
				}
			}
			$s->b .= $x1;
		}
		{
			$x1 = $this->table_name;
			if(is_null($x1)) {
				$x1 = "null";
			} else {
				if(is_bool($x1)) {
					$x1 = (($x1) ? "true" : "false");
				}
			}
			$s->b .= $x1;
		}
		{
			$x1 = " (";
			if(is_null($x1)) {
				$x1 = "null";
			} else {
				if(is_bool($x1)) {
					$x1 = (($x1) ? "true" : "false");
				}
			}
			$s->b .= $x1;
		}
		{
			$x1 = $fields->join(",");
			if(is_null($x1)) {
				$x1 = "null";
			} else {
				if(is_bool($x1)) {
					$x1 = (($x1) ? "true" : "false");
				}
			}
			$s->b .= $x1;
		}
		{
			$x1 = ") VALUES (";
			if(is_null($x1)) {
				$x1 = "null";
			} else {
				if(is_bool($x1)) {
					$x1 = (($x1) ? "true" : "false");
				}
			}
			$s->b .= $x1;
		}
		$first = true;
		if(null == $values) throw new HException('null iterable');
		$»it = $values->iterator();
		while($»it->hasNext()) {
			$v = $»it->next();
			if($first) {
				$first = false;
			} else {
				$x1 = ", ";
				if(is_null($x1)) {
					$x1 = "null";
				} else {
					if(is_bool($x1)) {
						$x1 = (($x1) ? "true" : "false");
					}
				}
				$s->b .= $x1;
				unset($x1);
			}
			$this->getCnx()->addValue($s, $v);
		}
		{
			$x1 = ")";
			if(is_null($x1)) {
				$x1 = "null";
			} else {
				if(is_bool($x1)) {
					$x1 = (($x1) ? "true" : "false");
				}
			}
			$s->b .= $x1;
		}
		$this->unsafeExecute($s->b);
		$x->_lock = true;
		if($this->table_keys->length === 1 && Reflect::field($x, $this->table_keys[0]) === null) {
			$x->{$this->table_keys[0]} = $this->getCnx()->lastInsertId();
		}
		$this->addToCache($x);
	}
	public function doUpdate($x) {
		if(!$x->_lock) {
			throw new HException("Cannot update a not locked object");
		}
		$this->unmake($x);
		$s = new StringBuf();
		{
			$x1 = "UPDATE ";
			if(is_null($x1)) {
				$x1 = "null";
			} else {
				if(is_bool($x1)) {
					$x1 = (($x1) ? "true" : "false");
				}
			}
			$s->b .= $x1;
		}
		{
			$x1 = $this->table_name;
			if(is_null($x1)) {
				$x1 = "null";
			} else {
				if(is_bool($x1)) {
					$x1 = (($x1) ? "true" : "false");
				}
			}
			$s->b .= $x1;
		}
		{
			$x1 = " SET ";
			if(is_null($x1)) {
				$x1 = "null";
			} else {
				if(is_bool($x1)) {
					$x1 = (($x1) ? "true" : "false");
				}
			}
			$s->b .= $x1;
		}
		$cache = Reflect::field($x, "__cache__");
		$mod = false;
		if(null == $this->table_fields) throw new HException('null iterable');
		$»it = $this->table_fields->iterator();
		while($»it->hasNext()) {
			$f = $»it->next();
			$v = Reflect::field($x, $f);
			$vc = Reflect::field($cache, $f);
			if(!_hx_equal($v, $vc)) {
				if($mod) {
					$x1 = ", ";
					if(is_null($x1)) {
						$x1 = "null";
					} else {
						if(is_bool($x1)) {
							$x1 = (($x1) ? "true" : "false");
						}
					}
					$s->b .= $x1;
					unset($x1);
				} else {
					$mod = true;
				}
				{
					$x1 = $this->quoteField($f);
					if(is_null($x1)) {
						$x1 = "null";
					} else {
						if(is_bool($x1)) {
							$x1 = (($x1) ? "true" : "false");
						}
					}
					$s->b .= $x1;
					unset($x1);
				}
				{
					$x1 = " = ";
					if(is_null($x1)) {
						$x1 = "null";
					} else {
						if(is_bool($x1)) {
							$x1 = (($x1) ? "true" : "false");
						}
					}
					$s->b .= $x1;
					unset($x1);
				}
				$this->getCnx()->addValue($s, $v);
				$cache->{$f} = $v;
			}
			unset($vc,$v);
		}
		if(!$mod) {
			return;
		}
		{
			$x1 = " WHERE ";
			if(is_null($x1)) {
				$x1 = "null";
			} else {
				if(is_bool($x1)) {
					$x1 = (($x1) ? "true" : "false");
				}
			}
			$s->b .= $x1;
		}
		$this->addKeys($s, $x);
		$this->unsafeExecute($s->b);
	}
	public function doDelete($x) {
		$s = new StringBuf();
		{
			$x1 = "DELETE FROM ";
			if(is_null($x1)) {
				$x1 = "null";
			} else {
				if(is_bool($x1)) {
					$x1 = (($x1) ? "true" : "false");
				}
			}
			$s->b .= $x1;
		}
		{
			$x1 = $this->table_name;
			if(is_null($x1)) {
				$x1 = "null";
			} else {
				if(is_bool($x1)) {
					$x1 = (($x1) ? "true" : "false");
				}
			}
			$s->b .= $x1;
		}
		{
			$x1 = " WHERE ";
			if(is_null($x1)) {
				$x1 = "null";
			} else {
				if(is_bool($x1)) {
					$x1 = (($x1) ? "true" : "false");
				}
			}
			$s->b .= $x1;
		}
		$this->addKeys($s, $x);
		$this->unsafeExecute($s->b);
		$this->removeFromCache($x);
	}
	public function doLock($i) {
		if($i->_lock) {
			return;
		}
		$s = new StringBuf();
		{
			$x = "SELECT * FROM ";
			if(is_null($x)) {
				$x = "null";
			} else {
				if(is_bool($x)) {
					$x = (($x) ? "true" : "false");
				}
			}
			$s->b .= $x;
		}
		{
			$x = $this->table_name;
			if(is_null($x)) {
				$x = "null";
			} else {
				if(is_bool($x)) {
					$x = (($x) ? "true" : "false");
				}
			}
			$s->b .= $x;
		}
		{
			$x = " WHERE ";
			if(is_null($x)) {
				$x = "null";
			} else {
				if(is_bool($x)) {
					$x = (($x) ? "true" : "false");
				}
			}
			$s->b .= $x;
		}
		$this->addKeys($s, $i);
		$this->unsafeObject($s->b, true);
	}
	public function objectToString($it) {
		$s = new StringBuf();
		{
			$x = $this->table_name;
			if(is_null($x)) {
				$x = "null";
			} else {
				if(is_bool($x)) {
					$x = (($x) ? "true" : "false");
				}
			}
			$s->b .= $x;
		}
		if($this->table_keys->length === 1) {
			{
				$x = "#";
				if(is_null($x)) {
					$x = "null";
				} else {
					if(is_bool($x)) {
						$x = (($x) ? "true" : "false");
					}
				}
				$s->b .= $x;
			}
			{
				$x = Reflect::field($it, $this->table_keys[0]);
				if(is_null($x)) {
					$x = "null";
				} else {
					if(is_bool($x)) {
						$x = (($x) ? "true" : "false");
					}
				}
				$s->b .= $x;
			}
		} else {
			{
				$x = "(";
				if(is_null($x)) {
					$x = "null";
				} else {
					if(is_bool($x)) {
						$x = (($x) ? "true" : "false");
					}
				}
				$s->b .= $x;
			}
			$first = true;
			{
				$_g = 0; $_g1 = $this->table_keys;
				while($_g < $_g1->length) {
					$f = $_g1[$_g];
					++$_g;
					if($first) {
						$first = false;
					} else {
						$x = ",";
						if(is_null($x)) {
							$x = "null";
						} else {
							if(is_bool($x)) {
								$x = (($x) ? "true" : "false");
							}
						}
						$s->b .= $x;
						unset($x);
					}
					{
						$x = $this->quoteField($f);
						if(is_null($x)) {
							$x = "null";
						} else {
							if(is_bool($x)) {
								$x = (($x) ? "true" : "false");
							}
						}
						$s->b .= $x;
						unset($x);
					}
					{
						$x = ":";
						if(is_null($x)) {
							$x = "null";
						} else {
							if(is_bool($x)) {
								$x = (($x) ? "true" : "false");
							}
						}
						$s->b .= $x;
						unset($x);
					}
					{
						$x = Reflect::field($it, $f);
						if(is_null($x)) {
							$x = "null";
						} else {
							if(is_bool($x)) {
								$x = (($x) ? "true" : "false");
							}
						}
						$s->b .= $x;
						unset($x);
					}
					unset($f);
				}
			}
			{
				$x = ")";
				if(is_null($x)) {
					$x = "null";
				} else {
					if(is_bool($x)) {
						$x = (($x) ? "true" : "false");
					}
				}
				$s->b .= $x;
			}
		}
		return $s->b;
	}
	public function cacheObject($x, $lock) {
		$o = Type::createEmptyInstance($this->class_proto);
		{
			$_g = 0; $_g1 = Reflect::fields($x);
			while($_g < $_g1->length) {
				$f = $_g1[$_g];
				++$_g;
				$o->{$f} = Reflect::field($x, $f);
				unset($f);
			}
		}
		$o->_manager = $this;
		$o->{"__cache__"} = $x;
		$this->addToCache($o);
		$o->_lock = $lock;
		return $o;
	}
	public function make($x) {
	}
	public function unmake($x) {
	}
	public function quoteField($f) {
		return sys_db_Manager_0($this, $f);
	}
	public function addKeys($s, $x) {
		$first = true;
		{
			$_g = 0; $_g1 = $this->table_keys;
			while($_g < $_g1->length) {
				$k = $_g1[$_g];
				++$_g;
				if($first) {
					$first = false;
				} else {
					$x1 = " AND ";
					if(is_null($x1)) {
						$x1 = "null";
					} else {
						if(is_bool($x1)) {
							$x1 = (($x1) ? "true" : "false");
						}
					}
					$s->b .= $x1;
					unset($x1);
				}
				{
					$x1 = $this->quoteField($k);
					if(is_null($x1)) {
						$x1 = "null";
					} else {
						if(is_bool($x1)) {
							$x1 = (($x1) ? "true" : "false");
						}
					}
					$s->b .= $x1;
					unset($x1);
				}
				{
					$x1 = " = ";
					if(is_null($x1)) {
						$x1 = "null";
					} else {
						if(is_bool($x1)) {
							$x1 = (($x1) ? "true" : "false");
						}
					}
					$s->b .= $x1;
					unset($x1);
				}
				$f = Reflect::field($x, $k);
				if($f === null) {
					throw new HException("Missing key " . $k);
				}
				$this->getCnx()->addValue($s, $f);
				unset($k,$f);
			}
		}
	}
	public function unsafeExecute($sql) {
		return $this->getCnx()->request($sql);
	}
	public function unsafeObject($sql, $lock) {
		if($lock !== false) {
			$lock = true;
			$sql .= $this->getLockMode();
		}
		$r = $this->unsafeExecute($sql)->next();
		if($r === null) {
			return null;
		}
		$c = $this->getFromCache($r, $lock);
		if($c !== null) {
			return $c;
		}
		$r = $this->cacheObject($r, $lock);
		$this->make($r);
		return $r;
	}
	public function unsafeObjects($sql, $lock) {
		if($lock !== false) {
			$lock = true;
			$sql .= $this->getLockMode();
		}
		$l = $this->unsafeExecute($sql)->results();
		$l2 = new HList();
		if(null == $l) throw new HException('null iterable');
		$»it = $l->iterator();
		while($»it->hasNext()) {
			$x = $»it->next();
			$c = $this->getFromCache($x, $lock);
			if($c !== null) {
				$l2->add($c);
			} else {
				$x = $this->cacheObject($x, $lock);
				$this->make($x);
				$l2->add($x);
			}
			unset($c);
		}
		return $l2;
	}
	public function unsafeCount($sql) {
		return $this->unsafeExecute($sql)->getIntResult(0);
	}
	public function unsafeDelete($sql) {
		$this->unsafeExecute($sql);
	}
	public function unsafeGet($id, $lock) {
		if($lock === null) {
			$lock = true;
		}
		if($this->table_keys->length !== 1) {
			throw new HException("Invalid number of keys");
		}
		if($id === null) {
			return null;
		}
		$x = $this->getFromCacheKey(Std::string($id) . $this->table_name);
		if($x !== null && (!$lock || $x->_lock)) {
			return $x;
		}
		$s = new StringBuf();
		{
			$x1 = "SELECT * FROM ";
			if(is_null($x1)) {
				$x1 = "null";
			} else {
				if(is_bool($x1)) {
					$x1 = (($x1) ? "true" : "false");
				}
			}
			$s->b .= $x1;
		}
		{
			$x1 = $this->table_name;
			if(is_null($x1)) {
				$x1 = "null";
			} else {
				if(is_bool($x1)) {
					$x1 = (($x1) ? "true" : "false");
				}
			}
			$s->b .= $x1;
		}
		{
			$x1 = " WHERE ";
			if(is_null($x1)) {
				$x1 = "null";
			} else {
				if(is_bool($x1)) {
					$x1 = (($x1) ? "true" : "false");
				}
			}
			$s->b .= $x1;
		}
		{
			$x1 = $this->quoteField($this->table_keys[0]);
			if(is_null($x1)) {
				$x1 = "null";
			} else {
				if(is_bool($x1)) {
					$x1 = (($x1) ? "true" : "false");
				}
			}
			$s->b .= $x1;
		}
		{
			$x1 = " = ";
			if(is_null($x1)) {
				$x1 = "null";
			} else {
				if(is_bool($x1)) {
					$x1 = (($x1) ? "true" : "false");
				}
			}
			$s->b .= $x1;
		}
		$this->getCnx()->addValue($s, $id);
		return $this->unsafeObject($s->b, $lock);
	}
	public function unsafeGetWithKeys($keys, $lock) {
		if($lock === null) {
			$lock = true;
		}
		$x = $this->getFromCacheKey($this->makeCacheKey($keys));
		if($x !== null && (!$lock || $x->_lock)) {
			return $x;
		}
		$s = new StringBuf();
		{
			$x1 = "SELECT * FROM ";
			if(is_null($x1)) {
				$x1 = "null";
			} else {
				if(is_bool($x1)) {
					$x1 = (($x1) ? "true" : "false");
				}
			}
			$s->b .= $x1;
		}
		{
			$x1 = $this->table_name;
			if(is_null($x1)) {
				$x1 = "null";
			} else {
				if(is_bool($x1)) {
					$x1 = (($x1) ? "true" : "false");
				}
			}
			$s->b .= $x1;
		}
		{
			$x1 = " WHERE ";
			if(is_null($x1)) {
				$x1 = "null";
			} else {
				if(is_bool($x1)) {
					$x1 = (($x1) ? "true" : "false");
				}
			}
			$s->b .= $x1;
		}
		$this->addKeys($s, $keys);
		return $this->unsafeObject($s->b, $lock);
	}
	public function unsafeGetId($o) {
		return (($o === null) ? null : Reflect::field($o, $this->table_keys[0]));
	}
	public function addCondition($s, $x) {
		$first = true;
		if($x !== null) {
			$_g = 0; $_g1 = Reflect::fields($x);
			while($_g < $_g1->length) {
				$f = $_g1[$_g];
				++$_g;
				if($first) {
					$first = false;
				} else {
					$x1 = " AND ";
					if(is_null($x1)) {
						$x1 = "null";
					} else {
						if(is_bool($x1)) {
							$x1 = (($x1) ? "true" : "false");
						}
					}
					$s->b .= $x1;
					unset($x1);
				}
				{
					$x1 = $this->quoteField($f);
					if(is_null($x1)) {
						$x1 = "null";
					} else {
						if(is_bool($x1)) {
							$x1 = (($x1) ? "true" : "false");
						}
					}
					$s->b .= $x1;
					unset($x1);
				}
				$d = Reflect::field($x, $f);
				if($d === null) {
					$x1 = " IS NULL";
					if(is_null($x1)) {
						$x1 = "null";
					} else {
						if(is_bool($x1)) {
							$x1 = (($x1) ? "true" : "false");
						}
					}
					$s->b .= $x1;
					unset($x1);
				} else {
					{
						$x1 = " = ";
						if(is_null($x1)) {
							$x1 = "null";
						} else {
							if(is_bool($x1)) {
								$x1 = (($x1) ? "true" : "false");
							}
						}
						$s->b .= $x1;
						unset($x1);
					}
					$this->getCnx()->addValue($s, $d);
				}
				unset($f,$d);
			}
		}
		if($first) {
			$x1 = "1";
			if(is_null($x1)) {
				$x1 = "null";
			} else {
				if(is_bool($x1)) {
					$x1 = (($x1) ? "true" : "false");
				}
			}
			$s->b .= $x1;
		}
	}
	public function dbClass() {
		return $this->class_proto;
	}
	public function dbInfos() {
		return $this->table_infos;
	}
	public function getCnx() {
		return sys_db_Manager::$cnx;
	}
	public function getLockMode() {
		return sys_db_Manager::$lockMode;
	}
	public function initRelation($r) {
		$spod = Type::resolveClass($r->type);
		if($spod === null) {
			throw new HException("Missing spod type " . $r->type);
		}
		$manager = $spod->manager;
		$hprop = "__" . $r->prop;
		$hkey = $r->key;
		$lock = $r->lock;
		if($manager === null || $manager->table_keys === null) {
			throw new HException("Invalid manager for relation " . $this->table_name . ":" . $r->prop);
		}
		if($manager->table_keys->length !== 1) {
			throw new HException("Relation " . $r->prop . "(" . $r->key . ") on a multiple key table");
		}
		$this->class_proto->prototype->{"get_" . $r->prop} = array(new _hx_lambda(array(&$hkey, &$hprop, &$lock, &$manager, &$r, &$spod), "sys_db_Manager_1"), 'execute');
		$this->class_proto->prototype->{"set_" . $r->prop} = array(new _hx_lambda(array(&$hkey, &$hprop, &$lock, &$manager, &$r, &$spod), "sys_db_Manager_2"), 'execute');
	}
	public function h__get($x, $prop, $key, $lock) {
		$v = Reflect::field($x, $prop);
		if($v !== null) {
			return $v->value;
		}
		$x1 = $this->unsafeGet(Reflect::field($x, $key), $lock);
		$x1->{$prop} = _hx_anonymous(array("value" => $x1));
		return $x1;
	}
	public function h__set($x, $prop, $key, $v) {
		$x->{$prop} = _hx_anonymous(array("value" => $v));
		if($v === null) {
			$x->{$key} = null;
		} else {
			$x->{$key} = Reflect::field($v, $this->table_keys[0]);
		}
	}
	public function makeCacheKey($x) {
		if($this->table_keys->length === 1) {
			$k = Reflect::field($x, $this->table_keys[0]);
			if($k === null) {
				throw new HException("Missing key " . $this->table_keys[0]);
			}
			return Std::string($k) . $this->table_name;
		}
		$s = new StringBuf();
		{
			$_g = 0; $_g1 = $this->table_keys;
			while($_g < $_g1->length) {
				$k = $_g1[$_g];
				++$_g;
				$v = Reflect::field($x, $k);
				if($k === null) {
					throw new HException("Missing key " . $k);
				}
				{
					$x1 = $v;
					if(is_null($x1)) {
						$x1 = "null";
					} else {
						if(is_bool($x1)) {
							$x1 = (($x1) ? "true" : "false");
						}
					}
					$s->b .= $x1;
					unset($x1);
				}
				{
					$x1 = "#";
					if(is_null($x1)) {
						$x1 = "null";
					} else {
						if(is_bool($x1)) {
							$x1 = (($x1) ? "true" : "false");
						}
					}
					$s->b .= $x1;
					unset($x1);
				}
				unset($v,$k);
			}
		}
		{
			$x1 = $this->table_name;
			if(is_null($x1)) {
				$x1 = "null";
			} else {
				if(is_bool($x1)) {
					$x1 = (($x1) ? "true" : "false");
				}
			}
			$s->b .= $x1;
		}
		return $s->b;
	}
	public function addToCache($x) {
		sys_db_Manager::$object_cache->set($this->makeCacheKey($x), $x);
	}
	public function removeFromCache($x) {
		sys_db_Manager::$object_cache->remove($this->makeCacheKey($x));
	}
	public function getFromCacheKey($key) {
		return sys_db_Manager::$object_cache->get($key);
	}
	public function getFromCache($x, $lock) {
		$c = sys_db_Manager::$object_cache->get($this->makeCacheKey($x));
		if($c !== null && $lock && !$c->_lock) {
			{
				$_g = 0; $_g1 = Reflect::fields($c);
				while($_g < $_g1->length) {
					$f = $_g1[$_g];
					++$_g;
					Reflect::deleteField($c, $f);
					unset($f);
				}
			}
			{
				$_g = 0; $_g1 = Reflect::fields($x);
				while($_g < $_g1->length) {
					$f = $_g1[$_g];
					++$_g;
					$c->{$f} = Reflect::field($x, $f);
					unset($f);
				}
			}
			$c->_lock = true;
			$c->{"__cache__"} = $x;
			$this->make($c);
		}
		return $c;
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
	static $cnx;
	static $lockMode;
	static $cache_field = "__cache__";
	static $object_cache;
	static $init_list;
	static $KEYWORDS;
	static function setConnection($c) {
		sys_db_Manager::$cnx = $c;
		sys_db_Manager::$lockMode = (($c !== null && $c->dbName() === "MySQL") ? " FOR UPDATE" : "");
		return $c;
	}
	static function initialize() {
		$l = sys_db_Manager::$init_list;
		sys_db_Manager::$init_list = new HList();
		if(null == $l) throw new HException('null iterable');
		$»it = $l->iterator();
		while($»it->hasNext()) {
			$m = $»it->next();
			$_g = 0; $_g1 = $m->table_infos->relations;
			while($_g < $_g1->length) {
				$r = $_g1[$_g];
				++$_g;
				$m->initRelation($r);
				unset($r);
			}
			unset($_g1,$_g);
		}
	}
	static function cleanup() {
		sys_db_Manager::$object_cache = new Hash();
	}
	static function quoteAny($v) {
		$s = new StringBuf();
		sys_db_Manager::$cnx->addValue($s, $v);
		return $s->b;
	}
	static function quoteList($v, $it) {
		$b = new StringBuf();
		$first = true;
		if($it !== null) {
			if(null == $it) throw new HException('null iterable');
			$»it = $it->iterator();
			while($»it->hasNext()) {
				$v1 = $»it->next();
				if($first) {
					$first = false;
				} else {
					$b->b .= chr(44);
				}
				sys_db_Manager::$cnx->addValue($b, $v1);
			}
		}
		if($first) {
			return "FALSE";
		}
		return $v . " IN (" . $b->b . ")";
	}
	function __toString() { return 'sys.db.Manager'; }
}
sys_db_Manager::$object_cache = new Hash();
sys_db_Manager::$init_list = new HList();
sys_db_Manager::$KEYWORDS = sys_db_Manager_3();
function sys_db_Manager_0(&$»this, &$f) {
	if(sys_db_Manager::$KEYWORDS->exists(strtolower($f))) {
		return "`" . $f . "`";
	} else {
		return $f;
	}
}
function sys_db_Manager_1(&$hkey, &$hprop, &$lock, &$manager, &$r, &$spod) {
	{
		$othis = $»this;
		$f = Reflect::field($othis, $hprop);
		if($f !== null) {
			return $f;
		}
		$id = Reflect::field($othis, $hkey);
		if($id === null) {
			return null;
		}
		$f = $manager->unsafeGet($id, $lock);
		if($f === null && $id !== null && !$lock) {
			$f = $manager->unsafeGet($id, true);
		}
		$othis->{$hprop} = $f;
		return $f;
	}
}
function sys_db_Manager_2(&$hkey, &$hprop, &$lock, &$manager, &$r, &$spod, $f) {
	{
		$othis = $»this;
		$othis->{$hprop} = $f;
		$othis->{$hkey} = Reflect::field($f, $manager->table_keys[0]);
		return $f;
	}
}
function sys_db_Manager_3() {
	{
		$h = new Hash();
		{
			$_g = 0; $_g1 = _hx_explode("|", "ADD|ALL|ALTER|ANALYZE|AND|AS|ASC|ASENSITIVE|BEFORE|BETWEEN|BIGINT|BINARY|BLOB|BOTH|BY|CALL|CASCADE|CASE|CHANGE|CHAR|CHARACTER|CHECK|COLLATE|COLUMN|CONDITION|CONSTRAINT|CONTINUE|CONVERT|CREATE|CROSS|CURRENT_DATE|CURRENT_TIME|CURRENT_TIMESTAMP|CURRENT_USER|CURSOR|DATABASE|DATABASES|DAY_HOUR|DAY_MICROSECOND|DAY_MINUTE|DAY_SECOND|DEC|DECIMAL|DECLARE|DEFAULT|DELAYED|DELETE|DESC|DESCRIBE|DETERMINISTIC|DISTINCT|DISTINCTROW|DIV|DOUBLE|DROP|DUAL|EACH|ELSE|ELSEIF|ENCLOSED|ESCAPED|EXISTS|EXIT|EXPLAIN|FALSE|FETCH|FLOAT|FLOAT4|FLOAT8|FOR|FORCE|FOREIGN|FROM|FULLTEXT|GRANT|GROUP|HAVING|HIGH_PRIORITY|HOUR_MICROSECOND|HOUR_MINUTE|HOUR_SECOND|IF|IGNORE|IN|INDEX|INFILE|INNER|INOUT|INSENSITIVE|INSERT|INT|INT1|INT2|INT3|INT4|INT8|INTEGER|INTERVAL|INTO|IS|ITERATE|JOIN|KEY|KEYS|KILL|LEADING|LEAVE|LEFT|LIKE|LIMIT|LINES|LOAD|LOCALTIME|LOCALTIMESTAMP|LOCK|LONG|LONGBLOB|LONGTEXT|LOOP|LOW_PRIORITY|MATCH|MEDIUMBLOB|MEDIUMINT|MEDIUMTEXT|MIDDLEINT|MINUTE_MICROSECOND|MINUTE_SECOND|MOD|MODIFIES|NATURAL|NOT|NO_WRITE_TO_BINLOG|NULL|NUMERIC|ON|OPTIMIZE|OPTION|OPTIONALLY|OR|ORDER|OUT|OUTER|OUTFILE|PRECISION|PRIMARY|PROCEDURE|PURGE|READ|READS|REAL|REFERENCES|REGEXP|RELEASE|RENAME|REPEAT|REPLACE|REQUIRE|RESTRICT|RETURN|REVOKE|RIGHT|RLIKE|SCHEMA|SCHEMAS|SECOND_MICROSECOND|SELECT|SENSITIVE|SEPARATOR|SET|SHOW|SMALLINT|SONAME|SPATIAL|SPECIFIC|SQL|SQLEXCEPTION|SQLSTATE|SQLWARNING|SQL_BIG_RESULT|SQL_CALC_FOUND_ROWS|SQL_SMALL_RESULT|SSL|STARTING|STRAIGHT_JOIN|TABLE|TERMINATED|THEN|TINYBLOB|TINYINT|TINYTEXT|TO|TRAILING|TRIGGER|TRUE|UNDO|UNION|UNIQUE|UNLOCK|UNSIGNED|UPDATE|USAGE|USE|USING|UTC_DATE|UTC_TIME|UTC_TIMESTAMP|VALUES|VARBINARY|VARCHAR|VARCHARACTER|VARYING|WHEN|WHERE|WHILE|WITH|WRITE|XOR|YEAR_MONTH|ZEROFILL|ASENSITIVE|CALL|CONDITION|CONNECTION|CONTINUE|CURSOR|DECLARE|DETERMINISTIC|EACH|ELSEIF|EXIT|FETCH|GOTO|INOUT|INSENSITIVE|ITERATE|LABEL|LEAVE|LOOP|MODIFIES|OUT|READS|RELEASE|REPEAT|RETURN|SCHEMA|SCHEMAS|SENSITIVE|SPECIFIC|SQL|SQLEXCEPTION|SQLSTATE|SQLWARNING|TRIGGER|UNDO|UPGRADE|WHILE");
			while($_g < $_g1->length) {
				$k = $_g1[$_g];
				++$_g;
				$h->set(strtolower($k), true);
				unset($k);
			}
		}
		return $h;
	}
}
