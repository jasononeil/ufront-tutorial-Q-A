<?php

class thx_color_Rgb {
	public function __construct($r, $g, $b) {
		if(!php_Boot::$skip_constructor) {
		$this->red = Ints::clamp($r, 0, 255);
		$this->green = Ints::clamp($g, 0, 255);
		$this->blue = Ints::clamp($b, 0, 255);
	}}
	public $blue;
	public $green;
	public $red;
	public function int() {
		return ($this->red & 255) << 16 | ($this->green & 255) << 8 | $this->blue & 255;
	}
	public function hex($prefix) {
		if($prefix === null) {
			$prefix = "";
		}
		return $prefix . StringTools::hex($this->red, 2) . StringTools::hex($this->green, 2) . StringTools::hex($this->blue, 2);
	}
	public function toCss() {
		return $this->hex("#");
	}
	public function toRgbString() {
		return "rgb(" . $this->red . "," . $this->green . "," . $this->blue . ")";
	}
	public function toString() {
		return $this->toRgbString();
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
	static function fromFloats($r, $g, $b) {
		return new thx_color_Rgb(thx_color_Rgb_0($b, $g, $r), thx_color_Rgb_1($b, $g, $r), thx_color_Rgb_2($b, $g, $r));
	}
	static function fromInt($v) {
		return new thx_color_Rgb($v >> 16 & 255, $v >> 8 & 255, $v & 255);
	}
	static function equals($a, $b) {
		return $a->red === $b->red && $a->green === $b->green && $a->blue === $b->blue;
	}
	static function darker($color, $t, $equation) {
		return new thx_color_Rgb(thx_color_Rgb_3($color, $equation, $t), thx_color_Rgb_4($color, $equation, $t), thx_color_Rgb_5($color, $equation, $t));
	}
	static function interpolate($a, $b, $t, $equation) {
		return new thx_color_Rgb(thx_color_Rgb_6($a, $b, $equation, $t), thx_color_Rgb_7($a, $b, $equation, $t), thx_color_Rgb_8($a, $b, $equation, $t));
	}
	static function interpolatef($a, $b, $equation) {
		$r = Ints::interpolatef($a->red, $b->red, $equation); $g = Ints::interpolatef($a->green, $b->green, $equation); $b1 = Ints::interpolatef($a->blue, $b->blue, $equation);
		return array(new _hx_lambda(array(&$a, &$b, &$b1, &$equation, &$g, &$r), "thx_color_Rgb_9"), 'execute');
	}
	static function contrast($c) {
		$nc = thx_color_Hsl::ofRgb($c);
		if($nc->lightness < .5) {
			return new thx_color_Hsl($nc->hue, $nc->saturation, $nc->lightness + 0.5);
		} else {
			return new thx_color_Hsl($nc->hue, $nc->saturation, $nc->lightness - 0.5);
		}
	}
	static function contrastBW($c) {
		$g = thx_color_Grey::ofRgb($c, null);
		$nc = thx_color_Hsl::ofRgb($c);
		if($g->grey < .5) {
			return new thx_color_Hsl($nc->hue, $nc->saturation, 1.0);
		} else {
			return new thx_color_Hsl($nc->hue, $nc->saturation, 0);
		}
	}
	function __toString() { return $this->toString(); }
}
function thx_color_Rgb_0(&$b, &$g, &$r) {
	{
		$equation = null;
		if(null === $equation) {
			$equation = (isset(thx_math_Equations::$linear) ? thx_math_Equations::$linear: array("thx_math_Equations", "linear"));
		}
		return Math::round(call_user_func_array($equation, array($r)) * 255);
	}
}
function thx_color_Rgb_1(&$b, &$g, &$r) {
	{
		$equation = null;
		if(null === $equation) {
			$equation = (isset(thx_math_Equations::$linear) ? thx_math_Equations::$linear: array("thx_math_Equations", "linear"));
		}
		return Math::round(call_user_func_array($equation, array($g)) * 255);
	}
}
function thx_color_Rgb_2(&$b, &$g, &$r) {
	{
		$equation = null;
		if(null === $equation) {
			$equation = (isset(thx_math_Equations::$linear) ? thx_math_Equations::$linear: array("thx_math_Equations", "linear"));
		}
		return Math::round(call_user_func_array($equation, array($b)) * 255);
	}
}
function thx_color_Rgb_3(&$color, &$equation, &$t) {
	{
		$equation1 = $equation;
		if(null === $equation1) {
			$equation1 = (isset(thx_math_Equations::$linear) ? thx_math_Equations::$linear: array("thx_math_Equations", "linear"));
		}
		return Math::round(call_user_func_array($equation1, array($t * $color->red)) * 255);
	}
}
function thx_color_Rgb_4(&$color, &$equation, &$t) {
	{
		$equation1 = $equation;
		if(null === $equation1) {
			$equation1 = (isset(thx_math_Equations::$linear) ? thx_math_Equations::$linear: array("thx_math_Equations", "linear"));
		}
		return Math::round(call_user_func_array($equation1, array($t * $color->green)) * 255);
	}
}
function thx_color_Rgb_5(&$color, &$equation, &$t) {
	{
		$equation1 = $equation;
		if(null === $equation1) {
			$equation1 = (isset(thx_math_Equations::$linear) ? thx_math_Equations::$linear: array("thx_math_Equations", "linear"));
		}
		return Math::round(call_user_func_array($equation1, array($t * $color->blue)) * 255);
	}
}
function thx_color_Rgb_6(&$a, &$b, &$equation, &$t) {
	{
		$min = $a->red; $equation1 = $equation;
		if(null === $equation1) {
			$equation1 = (isset(thx_math_Equations::$linear) ? thx_math_Equations::$linear: array("thx_math_Equations", "linear"));
		}
		return Math::round($min + call_user_func_array($equation1, array($t)) * ($b->red - $min));
	}
}
function thx_color_Rgb_7(&$a, &$b, &$equation, &$t) {
	{
		$min = $a->green; $equation1 = $equation;
		if(null === $equation1) {
			$equation1 = (isset(thx_math_Equations::$linear) ? thx_math_Equations::$linear: array("thx_math_Equations", "linear"));
		}
		return Math::round($min + call_user_func_array($equation1, array($t)) * ($b->green - $min));
	}
}
function thx_color_Rgb_8(&$a, &$b, &$equation, &$t) {
	{
		$min = $a->blue; $equation1 = $equation;
		if(null === $equation1) {
			$equation1 = (isset(thx_math_Equations::$linear) ? thx_math_Equations::$linear: array("thx_math_Equations", "linear"));
		}
		return Math::round($min + call_user_func_array($equation1, array($t)) * ($b->blue - $min));
	}
}
function thx_color_Rgb_9(&$a, &$b, &$b1, &$equation, &$g, &$r, $t) {
	{
		return new thx_color_Rgb(call_user_func_array($r, array($t)), call_user_func_array($g, array($t)), call_user_func_array($b1, array($t)));
	}
}
