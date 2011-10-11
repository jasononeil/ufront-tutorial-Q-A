<?php

class haxe_xml_Fast {
	public function __construct($x) {
		if(!php_Boot::$skip_constructor) {
		if($x->nodeType != Xml::$Document && $x->nodeType != Xml::$Element) {
			throw new HException("Invalid nodeType " . $x->nodeType);
		}
		$this->x = $x;
		$this->node = new haxe_xml__Fast_NodeAccess($x);
		$this->nodes = new haxe_xml__Fast_NodeListAccess($x);
		$this->att = new haxe_xml__Fast_AttribAccess($x);
		$this->has = new haxe_xml__Fast_HasAttribAccess($x);
		$this->hasNode = new haxe_xml__Fast_HasNodeAccess($x);
	}}
	public $x;
	public $name;
	public $innerData;
	public $innerHTML;
	public $node;
	public $nodes;
	public $att;
	public $has;
	public $hasNode;
	public $elements;
	public function getName() {
		return (($this->x->nodeType == Xml::$Document) ? "Document" : $this->x->getNodeName());
	}
	public function getInnerData() {
		$it = $this->x->iterator();
		if(!$it->hasNext()) {
			throw new HException($this->getName() . " does not have data");
		}
		$v = $it->next();
		if($it->hasNext()) {
			throw new HException($this->getName() . " does not only have data");
		}
		if($v->nodeType != Xml::$PCData && $v->nodeType != Xml::$CData) {
			throw new HException($this->getName() . " does not have data");
		}
		return $v->getNodeValue();
	}
	public function getInnerHTML() {
		$s = new StringBuf();
		if(null == $this->x) throw new HException('null iterable');
		$»it = $this->x->iterator();
		while($»it->hasNext()) {
			$x = $»it->next();
			$x1 = $x->toString();
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
		return $s->b;
	}
	public function getElements() {
		$it = $this->x->elements();
		return _hx_anonymous(array("hasNext" => (isset($it->hasNext) ? $it->hasNext: array($it, "hasNext")), "next" => array(new _hx_lambda(array(&$it), "haxe_xml_Fast_0"), 'execute')));
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
	function __toString() { return 'haxe.xml.Fast'; }
}
function haxe_xml_Fast_0(&$it) {
	{
		$x = $it->next();
		if($x === null) {
			return null;
		}
		return new haxe_xml_Fast($x);
	}
}
