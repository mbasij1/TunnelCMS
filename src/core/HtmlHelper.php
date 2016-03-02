<?php
class HtmlHelper
{
	public static function DisplayLabelFor($element, $att = null)
	{
		$out	= '<label for="'.$element['Key'].'"';
		foreach ($att as $key => $value)
		{
			$out .= $key.'="'.$value.'"';
		}
		
		$out   .= '>'.$element['Display'].'</label>';
		
		return $out;
	}
	
	public static function DisplayFor($col, $Row)
	{
		global $dbrefs;
		if($col['Type'] == 'DBRef')
		{
			if($dbrefs[$col['Ref']] == null)
				$dbrefs[$col['Ref']] = $model['Collection']->getDBRef($Row[$col['Ref']]);
			return $dbrefs[$col['Ref']][$col['Key']];
		}
		else
			return $Row[$col['Key']];
	}
	
	public static function EditorFor($element, $attribute = null)
	{
		/*
		 * element{
		 * 'Type' => 'text', 'dropdown', 'dropdownquery', 'File'
		 * 'Key' => 'Name!'
		 * 'Display' => 'DisplayName'
		 * 'Items' => array(array('Key'=> 'k1', 'Value' => 'v1'), ..) or array('v1')
		 * 'query' => 'mongoquery!'
		 * 'Value' => 'value'
		 * }
		 */
		$value = $element['Value'];
		
		if($_REQUEST[$element['Key']])
			$value = $_REQUEST[$element['Key']];
		
		$att = '';
		foreach ($attribute as $key => $value)
		{
			if(!is_array($value))
				$att .= $key.'="'.$value.'"';
			else
			{
				$att .= $key.'="';
				foreach ($value as $childKey => $childValue)
					$att .= $childKey.':'.$childValue.';';
				$att .= '"';
			}
		}
		
		if($element['Editable'] === false)
		{
			$att .= 'ReadOnly="true"';
		}
			
		switch($element['Type'])
		{
			case 'text':
				return '<input name="'.$element['Key'].'" value="'.$value.'" type="'.$element['Type'].'"' . $att .'>';
			
			case 'password':
				return '<input name="'.$element['Key'].'" value="'.$value.'" type="'.$element['Type'].'"' . $att .'>';
				
			case 'checkbox':
				return '<input id="'.$element['Key'].'" name="'.$element['Key'].'" type="checkbox" value="true">';
				
			case 'dropdown':
				$options = '';
				foreach($element['Items'] as $item)
				{
					if(is_array($item))
					{
						if($value != $item["Value"])
							$options .= '<option value="' . $item['Key'] . '">' . $item['Value'] . '</option>';
						else
							$options .= '<option value="' . $item['Key'] . '" checked>' . $item['Value'] . '</option>';
					}
					else
					{
						if($value != $item["Value"])
							$options .= '<option value="' . $item . '">' . $item . '</option>';
						else
							$options .= '<option value="' . $item . '" checked>' . $item . '</option>';
					}
				}
				return '<select name="' . $element['Key'] . '" ' . $att . '>' . $options . '</select>';
				
			case 'SuggestFild':
				$options = '';
				$db = new database();
				$Collection = $db->Suggests;
				$Items = $Collection->find(array('Field' => $element["SuggestName"]));
				
				foreach($Items as $item)
				{
					if(is_array($item))
					{
						if($value != $item["Value"])
							$options .= '<option value="' . $item['Key'] . '">' . $item['Value'] . '</option>';
						else
							$options .= '<option value="' . $item['Key'] . '" checked>' . $item['Value'] . '</option>';
					}
					else
					{
						if($value != $item["Value"])
							$options .= '<option value="' . $item . '">' . $item . '</option>';
						else
							$options .= '<option value="' . $item . '" checked>' . $item . '</option>';
					}
				}
				$options .= '<option value="سایر">سایر</option>';
				$x = self::format("<input type=\"text\" name=\"{0}\" id=\"{0}\" style=\"display:none;\"><select name=\"{0}_drop\" onchange=\"TrigerDropDown('{0}')\" id=\"{0}_drop\" {1}> {2}", $element['Key'], $att, $options);
				
				if ($Items->count() > 0)
					$x .= self::format("</select><input type=\"text\" name=\"{0}_text\" id=\"{0}_text\" onchange=\"updateTrigerDropDown('{0}')\" style=\"display:none;\" {1}>", $element['Key'], $att);
				else
					$x .= self::format("</select><input type=\"text\" name=\"{0}_text\" id=\"{0}_text\" onchange=\"updateTrigerDropDown('{0}')\" {1}>", $element['Key'], $att);
				return $x;
				//return '<select name="' . $element['Key'] . '" ' . $att . '>' . $options . '</select><input type="text"';
				
			case 'FileUpload':
				return '<input type="file" name="' . $element['Key'] . '" id="' . $element['Key'] . '" ' . $att . ' value="' . $value . '">';
		}
	}
	
	public static function ValidationFor($model, $element)
	{
		if($model["FomError"][$element['Key']] != "")
		{
			foreach($model["FomError"][$element['Key']] as $error)
				echo '<strong style="color: red;">' . $error . '</strong>';
		}
	}
	
	public static function ValidationSummary($model)
	{
		if($model["FomError"][""] != "")
			foreach($model["FomError"][""] as $error)
				echo '<strong style="color: red;">' . $error . '</strong>';
	}
	
	private static function format($format)
	{
	    $args = func_get_args();
	    $format = array_shift($args);
	    
	    preg_match_all('/(?=\{)\{(\d+)\}(?!\})/', $format, $matches, PREG_OFFSET_CAPTURE);
	    $offset = 0;
	    foreach ($matches[1] as $data) {
	        $i = $data[0];
	        $format = substr_replace($format, @$args[$i], $offset + $data[1] - 1, 2 + strlen($i));
	        $offset += strlen(@$args[$i]) - 2 - strlen($i);
	    }
	    
	    return $format;
	}

	public static function Action($Title, $address)
	{
		return '<a href="' .str_replace('~', SURL, $address) . '">' . $Title . '</a>';
	}
}