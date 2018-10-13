<?php 
class CssConvert{
	
	public static function clean_css($css){
		$css = trim(strtolower($css));
		$css = trim(implode(' ', preg_split('/\s+/', strtolower($css))));
		return $css;
	}
	
	//Replace Float and Text-align Such As [float:left; text-align:right;]
	public function replace_float_textalign($css , $att){
		$from_to = array(
			'left'  => 'xyz',
			'right' => 'left',
			'xyz'   => 'right'
		);
		foreach ($from_to as $from => $to){
			$search = array("{$att}:".$from ,"{$att}: ".$from ,"{$att} :".$from ,"{$att} : ".$from);
			$replace = array("{$att}:" . $to,"{$att}:" . $to,"{$att}:" . $to,"{$att}:" . $to);
			$css = str_replace($search, $replace, $css);
		}
		return $css;		
	}
	
	//Replace Direction [direction:rtl;]
	public function replace_dir($css){
		$from_to = array(
			'rtl'  => 'xyz123',
			'ltr' => 'rtl',
			'xyz123'   => 'ltr'
		);
		foreach ($from_to as $from => $to){
			$search = array("direction:".$from ,"direction: ".$from ,"direction :".$from ,"direction : ".$from);
			$replace = array("direction:" . $to,"direction:" . $to,"direction:" . $to,"direction:" . $to);
			$css = str_replace($search, $replace, $css);
		}
		return $css;		
	}	

	//Replace Posiions Such As [left:20px; right:40px;]
	public function replace_position($css){
		$from_to = array(
			'left'  => 'xyz',
			'right' => 'left',
			'xyz'   => 'right'
		);
		foreach ($from_to as $from => $to){
			$search = array("{$from}:" ,"{$from}: " ,"{$from} :" ,"{$from} : "," {$from} ");
			$replace = array("{$to}:","{$to}:","{$to}:","{$to}:"," {$to} ");
			$css = str_replace($search, $replace, $css);
		}
		return $css;
	}
	
	public function replace_padding_margin($css){
		$css =  str_replace("padding :","padding:",$css);
		$css =  str_replace("padding: ","padding:",$css);
		$css =  str_replace("margin :","margin:",$css);
		$css =  str_replace("margin: ","margin:",$css);
				
		$search1=self::extract_unit($css,"padding:",";");
		$replace1=self::resort_padding_margin($search1);
		$search2=self::extract_unit($css,"margin:",";");
		$replace2=self::resort_padding_margin($search2);		
	
		$css = str_replace($search1, $replace1, $css ,$num);
		$css = str_replace($search2, $replace2, $css ,$num);

		return $css;
	}
	
	public static function resort_padding_margin($css=array()){
		if(is_array($css)){
			foreach($css as $cs):
				$cs = explode(" ",$cs);
				$cs = array($cs[0],$cs[3],$cs[2],$cs[1]);
				$cs = implode(" ",$cs);
				$result[] = self::clean_css($cs);				
			endforeach;

			return $result;
		}
	}
	
	public static function extract_unit($css, $start, $end){
		preg_match_all("/".$start."(.*)".$end."/siU",$css,$output);
		return $output[1];
	}
	
	public function reformat_css($css){
		if(!empty($css)){
			$css = str_replace("}","}\n",$css);
			$css = str_replace("{","{\n",$css);
			$css = str_replace(";",";\n",$css);
			$css = str_replace("*/","*/\n",$css);
		}
		return $css;
	}
}
?>
