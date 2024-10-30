<?php
function bp_ckeditor_insert() {
	global $bp;
	
	//if ( $bp->loggedin_user->userdata->user_login != 'will'  ) exit();
	
	if (  bp_is_group_forum() || bp_is_group_forum_topic() || bp_is_group_forum_topic_edit() ) {
		$html = '';
		
		$options = get_option('bpckeditor');
		if ( !isset($options['ckeditor']) ) {
			$options['ckeditor'] = BPCKEDITOR_PATH.'/ckeditor/';
		}
		if (is_readable($options['ckeditor'].'ckeditor.php')) {
			include_once $options['ckeditor'].'ckeditor.php';
			
			$CKEditor = new CKEditor();			
			$CKEditor->returnOutput = true;
			
			foreach ($options['config'] as $option => $value) {
				if ($value != '') {
					if ($value == 'true') {
						$CKEditor->config[$option] = true;
					} elseif ($value =='false') {
						$CKEditor->config[$option] = false;
					} else {
						$CKEditor->config[$option] = $value;
					}
					
				}
			}			
			
			$CKEditor->textareaAttributes = array("cols" => 80, "rows" => 10);
			
			if ( !isset($options['ckeditor_url']) ) {
				$options['ckeditor_url'] = BPCKEDITOR_URL.'/ckeditor/';
			}			
			$CKEditor->basePath = $options['ckeditor_url'];
			
			if ( isset($options['ckfinder']) && $options['ckfinder'] ) {
				if (is_readable($options['ckfinder'].'ckfinder.php')) {
					include_once $options['ckfinder'].'ckfinder.php';
					$ckfinder = new CKFinder();
					
					if ( !isset($options['ckfinder_url']) ) {
						$options['ckfinder_url'] = BPCKEDITOR_URL.'/ckfinder/';
					}			
					$ckfinder->BasePath = $options['ckfinder_url']; // Note: BasePath property in CKFinder class starts with capital letter
					$ckfinder->SetupCKEditorObject($CKEditor);	
				}
			}
			
			$html = $CKEditor->replaceAll();
		}
		echo $html;
	}
}

function bp_ckeditor_dump($var = '') {
	global $bp;
	
	if ( $bp->loggedin_user->userdata->user_login != 'will'  ) exit();
	
	echo "<!--";
	if ( $var == '' ) {
		echo print_r($bp,true);
	} else {
		echo print_r($var,true);
	}
	echo "-->";		
}

function bp_ckeditor_allowedtags($forums_allowedtags) {
	
/**
	Default tags:	
		$forums_allowedtags = $allowedtags;
		$forums_allowedtags['span'] = array();
		$forums_allowedtags['span']['class'] = array();
		$forums_<h3></h3>allowedtags['div'] = array();
		$forums_allowedtags['div']['class'] = array();
		$forums_allowedtags['div']['id'] = array();
		$forums_allowedtags['a']['class'] = array();
		$forums_allowedtags['img'] = array();
		$forums_allowedtags['br'] = array();
		$forums_allowedtags['p'] = array();
		$forums_allowedtags['img']['src'] = array();
		$forums_allowedtags['img']['alt'] = array();
		$forums_allowedtags['img']['class'] = array();
		$forums_allowedtags['img']['width'] = array();
		$forums_allowedtags['img']['height'] = array();
		$forums_allowedtags['img']['class'] = array();
		$forums_allowedtags['img']['id'] = array();
		$forums_allowedtags['code'] = array();
		$forums_allowedtags['blockquote'] = array(); 
*/
	$forums_allowedtags['h1'] = array();
	$forums_allowedtags['h2'] = array();
	$forums_allowedtags['h3'] = array();
	$forums_allowedtags['h4'] = array();
	$forums_allowedtags['h5'] = array();
	$forums_allowedtags['h6'] = array();
	$forums_allowedtags['hr'] = array();
	
	$forums_allowedtags['table'] = array();	
	$forums_allowedtags['table']['border'] = array();
	$forums_allowedtags['table']['cellpadding'] = array();
	$forums_allowedtags['table']['cellspacing'] = array();
	$forums_allowedtags['tr'] = array();
	$forums_allowedtags['td'] = array();
	
	$forums_allowedtags['sup'] = array();
	$forums_allowedtags['sub'] = array();
	
	$forums_allowedtags['em'] = array();
	$forums_allowedtags['u'] = array();
	$forums_allowedtags['strike'] = array();
	
	$forums_allowedtags['address'] = array();
	$forums_allowedtags['pre'] = array();
	$forums_allowedtags['big'] = array();
	$forums_allowedtags['small'] = array();
	
	$forums_allowedtags['tt'] = array();
	$forums_allowedtags['code'] = array();
	$forums_allowedtags['kbd'] = array();
	$forums_allowedtags['samp'] = array();
	$forums_allowedtags['q'] = array();
	$forums_allowedtags['cite'] = array();
	$forums_allowedtags['ins'] = array();
	$forums_allowedtags['del'] = array();
	$forums_allowedtags['var'] = array();
	$forums_allowedtags['span']['dir'] = array();
	
	$forums_allowedtags['a']['href'] = array();
	$forums_allowedtags['a']['title'] = array();
	$forums_allowedtags['a']['target'] = array();
	
	/*
	$forums_allowedtags[''] = array();
	$forums_allowedtags[''] = array();
	$forums_allowedtags[''] = array();
	$forums_allowedtags[''] = array();
	$forums_allowedtags[''] = array();
	$forums_allowedtags[''] = array();
	*/

	//bp_ckeditor_dump($forums_allowedtags);
	foreach ($forums_allowedtags as &$tag) {
		$tag['style'] = array();
	}
	//bp_ckeditor_dump($forums_allowedtags);
	
	return $forums_allowedtags;
}
add_action('bp_forums_allowed_tags','bp_ckeditor_allowedtags');

function bp_ckeditor_modifycontent($content) {
	$pattern = "/rgb\((\d{1,3}), (\d{1,3}), (\d{1,3})\);/";
	preg_match_all($pattern,$content,$matches);
	
	$oldcolors = $matches[0];
	$newcolors = $oldcolors;
	
	for ( $index = 0; $index < count($oldcolors); $index++ ) {
		$newcolors[$index] = bp_ckeditor_rgb2html($matches[1][$index],$matches[2][$index],$matches[3][$index]).';';
	}	
	
	foreach (array_keys($oldcolors) as $index) {
		$content = str_replace($oldcolors[$index],$newcolors[$index],$content);
	}
	
	return $content;
}
add_filter('group_forum_topic_text_before_save','bp_ckeditor_modifycontent');
add_filter('group_forum_post_text_before_save','bp_ckeditor_modifycontent');

function bp_ckeditor_loader() {
	add_action('wp_footer','bp_ckeditor_insert');
}

if ( defined( 'BP_VERSION' ) || did_action( 'bp_init' ) ) {
	bp_ckeditor_loader();
} else {
	add_action( 'bp_init', 'bp_ckeditor_loader' );
}

if (is_admin() ) {
	
}

function bp_ckeditor_rgb2html($r, $g=-1, $b=-1) {
    if (is_array($r) && sizeof($r) == 3)
        list($r, $g, $b) = $r;

    $r = intval($r); $g = intval($g);
    $b = intval($b);

    $r = dechex($r<0?0:($r>255?255:$r));
    $g = dechex($g<0?0:($g>255?255:$g));
    $b = dechex($b<0?0:($b>255?255:$b));

    $color = (strlen($r) < 2?'0':'').$r;
    $color .= (strlen($g) < 2?'0':'').$g;
    $color .= (strlen($b) < 2?'0':'').$b;
    return '#'.$color;
}

?>