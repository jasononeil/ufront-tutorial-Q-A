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
		$this->class_proto->prototype->_manager = $this;
		sys_db_Manager::$init_list->add($this);
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
		$s->b .= "SELECT * FROM ";
		$s->b .= $this->table_name;
		$s->b .= " WHERE ";
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
		if(null == $this->table_fields) throw new HException('null iterable');
		$»it = $this->table_fields->iterator();
		while($»it->hasNext()) {
			$f = $»it->next();
			$v = Reflect::field($x, $f);
			if($v !== null) {
				$fields->add($this->quoteField($f));
				$values->add($v);
			}
			unset($v);
		}
		$s->b .= "INSERT INTO ";
		$s->b .= $this->table_name;
		$s->b .= " (";
		$s->b .= $fields->join(",");
		$s->b .= ") VALUES (";
		$first = true;
		if(null == $values) throw new HException('null iterable');
		$»it = $values->iterator();
		while($»it->hasNext()) {
			$v = $»it->next();
			if($first) {
				$first = false;
			} else {
				$s->b .= ", ";
			}
			$this->getCnx()->addValue($s, $v);
		}
		$s->b .= ")";
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
		$s->b .= "UPDATE ";
		$s->b .= $this->table_name;
		$s->b .= " SET ";
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
					$s->b .= ", ";
				} else {
					$mod = true;
				}
				$s->b .= $this->quoteField($f);
				$s->b .= " = ";
				$this->getCnx()->addValue($s, $v);
				$cache->{$f} = $v;
			}
			unset($vc,$v);
		}
		if(!$mod) {
			return;
		}
		$s->b .= " WHERE ";
		$this->addKeys($s, $x);
		$this->unsafeExecute($s->b);
	}
	public function doDelete($x) {
		$s = new StringBuf();
		$s->b .= "DELETE FROM ";
		$s->b .= $this->table_name;
		$s->b .= " WHERE ";
		$this->addKeys($s, $x);
		$this->unsafeExecute($s->b);
		$this->removeFromCache($x);
	}
	public function doLock($i) {
		if($i->_lock) {
			return;
		}
		$i->_lock = true;
		sys_db_Manager::$object_cache->remove($this->makeCacheKey($i));
		$s = new StringBuf();
		$s->b .= "SELECT * FROM ";
		$s->b .= $this->table_name;
		$s->b .= " WHERE ";
		$this->addKeys($s, $i);
		$i2 = $this->unsafeObject($s->b, $i->_lock);
		{
			$_g = 0; $_g1 = Reflect::fields($i);
			while($_g < $_g1->length) {
				$f = $_g1[$_g];
				++$_g;
				Reflect::deleteField($i, $f);
				unset($f);
			}
		}
		{
			$_g = 0; $_g1 = Reflect::fields($i2);
			while($_g < $_g1->length) {
				$f = $_g1[$_g];
				++$_g;
				$i->{$f} = Reflect::field($i2, $f);
				unset($f);
			}
		}
		$i->{"__cache__"} = Reflect::field($i2, "__cache__");
		$this->make($i);
		$this->addToCache($i);
	}
	public function objectToString($it) {
		$s = new StringBuf();
		$s->b .= $this->table_name;
		if($this->table_keys->length === 1) {
			$s->b .= "#";
			$s->b .= Reflect::field($it, $this->table_keys[0]);
		} else {
			$s->b .= "(";
			$first = true;
			{
				$_g = 0; $_g1 = $this->table_keys;
				while($_g < $_g1->length) {
					$f = $_g1[$_g];
					++$_g;
					if($first) {
						$first = false;
					} else {
						$s->b .= ",";
					}
					$s->b .= $this->quoteField($f);
					$s->b .= ":";
					$s->b .= Reflect::field($it, $f);
					unset($f);
				}
			}
			$s->b .= ")";
		}
		return $s->b;
	}
	public function cacheObject($x, $lock) {
		$this->addToCache($x);
		call_user_func_array($__dollar__objsetproto, array($x, $this->class_proto->prototype));
		$x->{"__cache__"} = call_user_func_array($__dollar__new, array($x));
		$x->_lock = $lock;
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
					$s->b .= " AND ";
				}
				$s->b .= $this->quoteField($k);
				$s->b .= " = ";
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
		$this->cacheObject($r, $lock);
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
				$this->cacheObject($x, $lock);
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
		$s->b .= "SELECT * FROM ";
		$s->b .= $this->table_name;
		$s->b .= " WHERE ";
		$s->b .= $this->quoteField($this->table_keys[0]);
		$s->b .= " = ";
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
		$s->b .= "SELECT * FROM ";
		$s->b .= $this->table_name;
		$s->b .= " WHERE ";
		$this->addKeys($s, $keys);
		return $this->unsafeObject($s->b, $lock);
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
					$s->b .= " AND ";
				}
				$s->b .= $this->quoteField($f);
				$d = Reflect::field($x, $f);
				if($d === null) {
					$s->b .= " IS NULL";
				} else {
					$s->b .= " = ";
					$this->getCnx()->addValue($s, $d);
				}
				unset($f,$d);
			}
		}
		if($first) {
			$s->b .= "1";
		}
	}
	public function dbClass() {
		return $this->class_proto;
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
				$s->b .= $v;
				$s->b .= "#";
				unset($v,$k);
			}
		}
		$s->b .= $this->table_name;
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
			$c->_lock = true;
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
	static function quoteInt($v) {
		return sys_db_Manager::quoteAny($v);
	}
	static function quoteFloat($v) {
		return sys_db_Manager::quoteAny($v);
	}
	static function quoteDate($v) {
		return sys_db_Manager::quoteAny($v);
	}
	static function quoteString($v) {
		return sys_db_Manager::quoteAny($v);
	}
	static function quoteBool($v) {
		return sys_db_Manager::quoteAny($v);
	}
	static function quoteBytes($v) {
		return sys_db_Manager::quoteAny($v);
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
