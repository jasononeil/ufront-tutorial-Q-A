<?php

class sys_db_SpodType extends Enum {
	public static $DBigId;
	public static $DBigInt;
	public static $DBinary;
	public static $DBool;
	public static function DBytes($n) { return new sys_db_SpodType("DBytes", 18, array($n)); }
	public static $DDate;
	public static $DDateTime;
	public static $DEncoded;
	public static function DFlags($flags) { return new sys_db_SpodType("DFlags", 22, array($flags)); }
	public static $DFloat;
	public static $DId;
	public static $DInt;
	public static $DInterval;
	public static $DLongBinary;
	public static $DNekoSerialized;
	public static $DNull;
	public static $DSerialized;
	public static $DSingle;
	public static $DSmallBinary;
	public static $DSmallText;
	public static function DString($n) { return new sys_db_SpodType("DString", 9, array($n)); }
	public static $DText;
	public static $DTinyInt;
	public static $DTinyText;
	public static $DUId;
	public static $DUInt;
	public static $__constructors = array(4 => 'DBigId', 5 => 'DBigInt', 17 => 'DBinary', 8 => 'DBool', 18 => 'DBytes', 10 => 'DDate', 11 => 'DDateTime', 19 => 'DEncoded', 22 => 'DFlags', 7 => 'DFloat', 0 => 'DId', 1 => 'DInt', 24 => 'DInterval', 16 => 'DLongBinary', 21 => 'DNekoSerialized', 25 => 'DNull', 20 => 'DSerialized', 6 => 'DSingle', 15 => 'DSmallBinary', 13 => 'DSmallText', 9 => 'DString', 14 => 'DText', 23 => 'DTinyInt', 12 => 'DTinyText', 2 => 'DUId', 3 => 'DUInt');
	}
sys_db_SpodType::$DBigId = new sys_db_SpodType("DBigId", 4);
sys_db_SpodType::$DBigInt = new sys_db_SpodType("DBigInt", 5);
sys_db_SpodType::$DBinary = new sys_db_SpodType("DBinary", 17);
sys_db_SpodType::$DBool = new sys_db_SpodType("DBool", 8);
sys_db_SpodType::$DDate = new sys_db_SpodType("DDate", 10);
sys_db_SpodType::$DDateTime = new sys_db_SpodType("DDateTime", 11);
sys_db_SpodType::$DEncoded = new sys_db_SpodType("DEncoded", 19);
sys_db_SpodType::$DFloat = new sys_db_SpodType("DFloat", 7);
sys_db_SpodType::$DId = new sys_db_SpodType("DId", 0);
sys_db_SpodType::$DInt = new sys_db_SpodType("DInt", 1);
sys_db_SpodType::$DInterval = new sys_db_SpodType("DInterval", 24);
sys_db_SpodType::$DLongBinary = new sys_db_SpodType("DLongBinary", 16);
sys_db_SpodType::$DNekoSerialized = new sys_db_SpodType("DNekoSerialized", 21);
sys_db_SpodType::$DNull = new sys_db_SpodType("DNull", 25);
sys_db_SpodType::$DSerialized = new sys_db_SpodType("DSerialized", 20);
sys_db_SpodType::$DSingle = new sys_db_SpodType("DSingle", 6);
sys_db_SpodType::$DSmallBinary = new sys_db_SpodType("DSmallBinary", 15);
sys_db_SpodType::$DSmallText = new sys_db_SpodType("DSmallText", 13);
sys_db_SpodType::$DText = new sys_db_SpodType("DText", 14);
sys_db_SpodType::$DTinyInt = new sys_db_SpodType("DTinyInt", 23);
sys_db_SpodType::$DTinyText = new sys_db_SpodType("DTinyText", 12);
sys_db_SpodType::$DUId = new sys_db_SpodType("DUId", 2);
sys_db_SpodType::$DUInt = new sys_db_SpodType("DUInt", 3);
