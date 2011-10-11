<?php

class sys_db_TableCreate {
	public function __construct(){}
	static function getTypeSQL($t) {
		return sys_db_TableCreate_0($t);
	}
	static function create($manager, $engine) {
		$quote = array(new _hx_lambda(array(&$engine, &$manager), "sys_db_TableCreate_1"), 'execute');
		$infos = $manager->dbInfos();
		$sql = "CREATE TABLE " . call_user_func_array($quote, array($infos->name)) . " (";
		$decls = new _hx_array(array());
		{
			$_g = 0; $_g1 = $infos->fields;
			while($_g < $_g1->length) {
				$f = $_g1[$_g];
				++$_g;
				$decls->push(call_user_func_array($quote, array($f->name)) . " " . sys_db_TableCreate::getTypeSQL($f->t) . ((($f->isNull) ? "" : " NOT NULL")));
				unset($f);
			}
		}
		$decls->push("PRIMARY KEY (" . Lambda::map($infos->key, $quote)->join(",") . ")");
		$sql .= $decls->join(",");
		$sql .= ")";
		if($engine !== null) {
			$sql .= "ENGINE=" . $engine;
		}
		$cnx = $manager->getCnx();
		if($cnx === null) {
			throw new HException("SQL Connection not initialized on Manager");
		}
		$cnx->request($sql);
	}
	function __toString() { return 'sys.db.TableCreate'; }
}
function sys_db_TableCreate_0(&$t) {
	$퍁 = ($t);
	switch($퍁->index) {
	case 0:
	{
		return "INT AUTO_INCREMENT";
	}break;
	case 2:
	{
		return "INT UNSIGNED AUTO_INCREMENT";
	}break;
	case 1:
	case 19:
	case 22:
	{
		return "INT";
	}break;
	case 23:
	{
		return "TINYINT";
	}break;
	case 3:
	{
		return "INT UNSIGNED";
	}break;
	case 6:
	{
		return "FLOAT";
	}break;
	case 7:
	{
		return "DOUBLE";
	}break;
	case 8:
	{
		return "TINYINT(1)";
	}break;
	case 9:
	$n = $퍁->params[0];
	{
		return "VARCHAR(" . $n . ")";
	}break;
	case 10:
	{
		return "DATE";
	}break;
	case 11:
	{
		return "DATETIME";
	}break;
	case 12:
	{
		return "TINYTEXT";
	}break;
	case 13:
	{
		return "TEXT";
	}break;
	case 14:
	case 20:
	{
		return "MEDIUMTEXT";
	}break;
	case 15:
	{
		return "BLOB";
	}break;
	case 17:
	case 21:
	{
		return "MEDIUMBLOB";
	}break;
	case 16:
	{
		return "LONGBLOB";
	}break;
	case 5:
	{
		return "BIGINT";
	}break;
	case 4:
	{
		return "BIGINT AUTO_INCREMENT";
	}break;
	case 18:
	$n = $퍁->params[0];
	{
		return "BINARY(" . $n . ")";
	}break;
	case 25:
	case 24:
	{
		throw new HException("assert");
	}break;
	}
}
function sys_db_TableCreate_1(&$engine, &$manager, $v) {
	{
		return $manager->quoteField($v);
	}
}
