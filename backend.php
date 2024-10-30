<?php
function l($texto) {
	if ( $texto ) return __($texto,'bpckeditor');
	else return '';
}

function bpckeditor_pagetop() {
	$html = '
	<div class="wrap">
	<h2>'.BPCKEDITOR_NAME.' v'.BPCKEDITOR_VERSION.'</h2>
	';
	
	return $html;
}

function bpckeditor_pagebottom() {
	return '</div>';
}

function bpckeditor_settings_page(){
	//delete_option('bpckeditor');
	$options = get_option('bpckeditor');
	
	$ckeditor_info = '';
	if ( isset($options['ckeditor']) && $options['ckeditor']) {
		if (!is_readable($options['ckeditor'].'ckeditor.php')) {
			$ckeditor_info = '<p><strong>*** ckeditor.php</strong> '.__('can\'t be readed here. Please double check it. Remember to include a trailing slash.','bpckeditor').'</p>';
		}
	}
	$ckfinder_info = '';
	if ( isset($options['ckfinder']) && $options['ckfinder']) {
		if (!is_readable($options['ckfinder'].'ckfinder.php')) {
			$ckfinder_info = '<p><strong>*** ckfinder.php</strong> '.__('can\'t be readed here. Please double check it. Remember to include a trailing slash.','bpckeditor').'</p>';
		}
	}
		
	echo bpckeditor_pagetop();
	if ($_GET['updated']=='true') {
		echo '
<script type="text/javascript">
/* <![CDATA[ */
jQuery(document).ready(function() {	
	jQuery(".wrap").after("<div class=\'updated fade\' style=\'margin-top:50px;\'><p><strong>' . __('Settings saved.', 'bpckeditor') . '</strong></p></div>").hide().fadeIn("slow");
});
/* ]]> */
</script>
		';
	}
	echo '
	<div class="form-wrap">';	
	echo '<form method="post" action="options.php">';	
	settings_fields( 'bpckeditor' );
	
	echo '
		<h3>'.__('General Settings','bpckeditor').'</h3>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><label for="fld-menutype">'.__('Where do you want to show this settings page?','bpckeditor').'</label></th>
				<td><select id="fld-menutype" name="bpckeditor[menu_type]">
						<option value="own"			'.($options['menu_type']=='own'?'selected="selected"':'').' >'.__('In a top level menu','bpckeditor').'</option>
						<option value="buddypress"	'.($options['menu_type']=='' || $options['menu_type']=='buddypress'?'selected="selected"':'').' >'.__('In BuddyPress menu','bpckeditor').'</option>
						<option value="settings"	'.($options['menu_type']=='settings'?'selected="selected"':'').' >'.__('In Settings menu','bpckeditor').'</option>
					</select><br/>
				</td>
			</tr>			
			<tr valign="top">
				<th scope="row"><label for="fld-ckeditor">'.__('Path to CKEditor\'s folder','bpckeditor').'</label></th>
				<td><input id="fld-ckeditor" class="large-text" type="text" name="bpckeditor[ckeditor]" value="'.$options['ckeditor'].'" /><br/>
				<p>'.__('Introduce the full path to your copy of CKEditor. I.e: ','bpckeditor').BPCKEDITOR_PATH.'/ckeditor/'.'</p>
				'.$ckeditor_info.'</td>
			</tr>			
			<tr valign="top">
				<th scope="row"><label for="fld-ckeditorurl">'.__('URL to CKEditor\'s folder','bpckeditor').'</label></th>
				<td><input id="fld-ckeditorurl" class="large-text" type="text" name="bpckeditor[ckeditor_url]" value="'.$options['ckeditor_url'].'" /><br/>
				<p>'.__('Introduce the URL to the previous path. I.e: ','bpckeditor').BPCKEDITOR_URL.'/ckeditor/'.'</p></td>
			</tr>			
			<tr valign="top">
				<th scope="row"><label for="fld-ckfinder">'.__('Path to CKFinder\'s folder','bpckeditor').'</label></th>
				<td><input id="fld-ckfinder" class="large-text" type="text" name="bpckeditor[ckfinder]" value="'.$options['ckfinder'].'" /><br/>
				<p>'.__('Introduce the full path to your copy of CKFinder. If not set, we won\'t try to connect CKEditor with CKfinder','bpckeditor').'</p>
				'.$ckfinder_info.'</td>
			</tr>			
			<tr valign="top">
				<th scope="row"><label for="fld-ckfinderurl">'.__('URL to CKFinder\'s folder','bpckeditor').'</label></th>
				<td><input id="fld-ckfinderurl" class="large-text" type="text" name="bpckeditor[ckfinder_url]" value="'.$options['ckfinder_url'].'" /><br/>
				<p>'.__('Introduce the URL to the previous path.','bpckeditor').'</p></td>
			</tr>			
		</table>
		';
	
	echo '<h3>'.__('Editor Settings','bpckeditor').'</h3>
		<table class="form-table">';
	
	$fields = array();
	
	$fields[]=	array(	'id' 		=> 'width',
				'type'		=> 'N',
				'default'	=> '',
				'desc'		=> __('The width of editing area( content ), in relative or absolute.','bpckeditor'));
	$fields[]=array(	'id' 		=> 'height',
				'type'		=> 'N',
				'default'	=> '200',
				'desc'		=> __('The height of editing area( content ), in relative or absolute.','bpckeditor'));
				
	$fields[]=array(	'id' 		=> 'resize_enabled',
				'type'		=> 'B',
				'default'	=> 'true',
				'desc'		=> __('Whether to enable the resizing feature.','bpckeditor'));
	$fields[]=array(	'id' 		=> 'resize_maxHeight',
				'type'		=> 'N',
				'default'	=> '3000',
				'desc'		=> __('Whether to enable the resizing feature.','bpckeditor'));
	$fields[]=array(	'id' 		=> 'resize_maxWidth',
				'type'		=> 'N',
				'default'	=> '3000',
				'desc'		=> __('The maximum editor width, in pixels, when resizing it with the resize handle.','bpckeditor'));
	$fields[]=array(	'id' 		=> 'resize_minHeight',
				'type'		=> 'N',
				'default'	=> '250',
				'desc'		=> __('The minimum editor height, in pixels, when resizing it with the resize handle.','bpckeditor'));
	$fields[]=array(	'id' 		=> 'resize_minWidth',
				'type'		=> 'N',
				'default'	=> '750',
				'desc'		=> __('The minimum editor width, in pixels, when resizing it with the resize handle.','bpckeditor'));
				
	$fields[]=array(	'id' 		=> 'autoGrow_maxHeight',
				'type'		=> 'N',
				'default'	=> '0',
				'desc'		=> __('The maximum height to which the editor can reach using AutoGrow.','bpckeditor'));				
	$fields[]=array(	'id' 		=> 'autoGrow_minHeight',
				'type'		=> 'N',
				'default'	=> '200',
				'desc'		=> __('The minimum height to which the editor can reach using AutoGrow.','bpckeditor'));
	$fields[]=array(	'id' 		=> 'autoUpdateElement',
				'type'		=> 'B',
				'default'	=> 'true',
				'desc'		=> __('Whether the replaced element (usually a textarea) is to be updated automatically when posting the form containing the editor.','bpckeditor'));
	$fields[]=array(	'id' 		=> 'baseHref',
				'type'		=> 'U',
				'default'	=> '',
				'desc'		=> __('The base href URL used to resolve relative and absolute URLs in the editor content.','bpckeditor'));
	$fields[]=array(	'id' 		=> 'baseFloatZIndex',
				'type'		=> 'N',
				'default'	=> '10000',
				'desc'		=> __('The base Z-index for floating dialogs and popups.','bpckeditor'));
	$fields[]=array(	'id' 		=> 'contentsCss',
				'type'		=> 'U',
				'default'	=> '',
				'desc'		=> __('The CSS file(s) to be used to apply style to the contents.','bpckeditor'));
	$fields[]=array(	'id' 		=> 'defaultLanguage',
				'type'		=> 'T',
				'default'	=> (WPLANG==''?'en':substr(WPLANG,0,2)),
				'desc'		=> __('The language to be used if \'language\' is left empty and it\'s not possible to localize the editor to the user language.'));
	$fields[]=array(	'id' 		=> 'language',
				'type'		=> 'T',
				'default'	=> (WPLANG==''?'en':substr(WPLANG,0,2)),
				'desc'		=> __('The user interface language localization to use. If empty, the editor automatically localize the editor to the user language, if supported, otherwise the \'defaultLanguage\' language is used.'));
	$fields[]=array(	'id' 		=> 'contentsLanguage',
				'type'		=> 'T',
				'default'	=> '',
				'desc'		=> __('Language code of the writting language which is used to author the editor contents.','bpckeditor'));
	$fields[]=array(	'id' 		=> 'customConfig',
				'type'		=> 'U',
				'default'	=> $options['ckeditor_url'].'config.js',
				'desc'		=> __('The URL path for the custom configuration file to be loaded.','bpckeditor'));
	$fields[]=array(	'id' 		=> 'toolbar',
				'type'		=> 'T',
				'default'	=> 'bpckeditor',
				'desc'		=> __('The toolbox (alias toolbar) definition.','bpckeditor'));
	$fields[]=array(	'id' 		=> 'disableObjectResizing',
				'type'		=> 'B',
				'default'	=> 'false',
				'desc'		=> __('Disables the ability of resize objects (image and tables) in the editing area.','bpckeditor'));
				/*
	$fields[]=array(	'id' 		=> 'docType',
				'type'		=> 'L',
				'default'	=> '<!DOCTYPE html PUBLIC \'-//W3C//DTD XHTML 1.0 Transitional//EN\' \'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\'>',
				'desc'		=> __('Sets the doctype to be used when loading the editor content as HTML.');
				*/
	$fields[]=array(	'id' 		=> 'editingBlock',
				'type'		=> 'B',
				'default'	=> 'true',
				'desc'		=> __('Whether to render or not the editing block area in the editor interface.','bpckeditor'));
	$fields[]=array(	'id' 		=> 'enableTabKeyTools',
				'type'		=> 'B',
				'default'	=> 'true',
				'desc'		=> __('Allow context-sensitive tab key behaviors.','bpckeditor'));
	$fields[]=array(	'id' 		=> 'enterMode',
				'type'		=> 'S|1=P|2=BR|3=DIV',
				'default'	=> '2',
				'desc'		=> __('Sets the behavior for the ENTER key.','bpckeditor'));
	$fields[]=array(	'id' 		=> 'entities',
				'type'		=> 'B',
				'default'	=> 'true',
				'desc'		=> __('Whether to use HTML entities in the output.','bpckeditor'));
	$fields[]=array(	'id' 		=> 'extraPlugins',
				'type'		=> 'L',
				'default'	=> '',
				'desc'		=> __('List of additional plugins to be loaded.','bpckeditor'));
	$fields[]=array(	'id' 		=> 'fullPage',
				'type'		=> 'B',
				'default'	=> 'false',
				'desc'		=> __('Indicates whether the contents to be edited are being inputted as a full HTML page.','bpckeditor'));
	$fields[]=array(	'id' 		=> 'htmlEncodeOutput',
				'type'		=> 'B',
				'default'	=> 'false',
				'desc'		=> __('Whether escape HTML when editor update original input element.','bpckeditor'));
	$fields[]=array(	'id' 		=> 'ignoreEmptyParagraph',
				'type'		=> 'B',
				'default'	=> 'true',
				'desc'		=> __('Whether the editor must output an empty value ("") if it\'s contents is made by an empty paragraph only.','bpckeditor'));
	$fields[]=array(	'id' 		=> 'plugins',
				'type'		=> 'L',
				'default'	=> '',
				'desc'		=> __('Comma separated list of plugins to load and initialize for an editor instance.','bpckeditor'));
	$fields[]=array(	'id' 		=> 'removeFormatAttributes',
				'type'		=> 'L',
				'default'	=> 'class,style,lang,width,height,align,hspace,valign',
				'desc'		=> __('A comma separated list of elements attributes to be removed when executing the "remove format" command.','bpckeditor'));
	$fields[]=array(	'id' 		=> 'removeFormatTags',
				'type'		=> 'L',
				'default'	=> 'b,big,code,del,dfn,em,font,i,ins,kbd,q,samp,small,span,strike,strong,sub,sup,tt,u,var',
				'desc'		=> __('A comma separated list of elements to be removed when executing the "remove " format" command.','bpckeditor'));
	$fields[]=array(	'id' 		=> 'removePlugins',
				'type'		=> 'L',
				'default'	=> '',
				'desc'		=> __('List of plugins that must not be loaded.','bpckeditor'));
	$fields[]=array(	'id' 		=> 'scayt_autoStartup',
				'type'		=> 'B',
				'default'	=> 'false',
				'desc'		=> __('If enabled (true), turns on SCAYT automatically after loading the editor.','bpckeditor'));
	$fields[]=array(	'id' 		=> 'scayt_contextCommands',
				'type'		=> 'L',
				'default'	=> 'all',
				'desc'		=> __('Customizes the display of SCAYT context menu commands ("Add Word", "Ignore" and "Ignore All").','bpckeditor'));
	$fields[]=array(	'id' 		=> 'scayt_contextMenuItemsOrder',
				'type'		=> 'L',
				'default'	=> 'suggest|moresuggest|control',
				'desc'		=> __('Define order of placing of SCAYT context menu items by groups.','bpckeditor'));
	$fields[]=array(	'id' 		=> 'scayt_customDictionaryIds',
				'type'		=> 'L',
				'default'	=> '',
				'desc'		=> __('Links SCAYT to custom dictionaries.','bpckeditor'));
	$fields[]=array(	'id' 		=> 'scayt_customerid',
				'type'		=> 'T',
				'default'	=> '',
				'desc'		=> __('Sets the customer ID for SCAYT.','bpckeditor'));
	$fields[]=array(	'id' 		=> 'scayt_maxSuggestions',
				'type'		=> 'N',
				'default'	=> '5',
				'desc'		=> __('Defines the number of SCAYT suggestions to show in the main context menu.','bpckeditor'));
	$fields[]=array(	'id' 		=> 'scayt_moreSuggestions',
				'type'		=> 'O',
				'default'	=> 'on',
				'desc'		=> __('Enables/disables the "More Suggestions" sub-menu in the context menu.','bpckeditor'));
	$fields[]=array(	'id' 		=> 'scayt_sLang',
				'type'		=> 'T',
				'default'	=> (WPLANG==''?'en_EN':WPLANG),
				'desc'		=> __('Sets the default spellchecking language for SCAYT.','bpckeditor'));
	$fields[]=array(	'id' 		=> 'scayt_srcUrl',
				'type'		=> 'U',
				'default'	=> '',
				'desc'		=> __('Set the URL to SCAYT core.','bpckeditor'));
	$fields[]=array(	'id' 		=> 'shiftEnterMode',
				'type'		=> 'S|1=P|2=BR|3=DIV',
				'default'	=> '1',
				'desc'		=> __('Defines the behavior for the SHIFT+ENTER key.','bpckeditor'));
	$fields[]=array(	'id' 		=> 'skin',
				'type'		=> 'S|kama=Kama|v2=V2|office2003=Office2003',
				'default'	=> 'office2003',
				'desc'		=> __('The skin to load.','bpckeditor'));
	$fields[]=array(	'id' 		=> 'startupMode',
				'type'		=> 'S|wysiwyg=HTML|source=Source',
				'default'	=> 'wysiwyg',
				'desc'		=> __('The mode to load at the editor startup.','bpckeditor'));
				/*
	$fields[]=array(	'id' 		=> 'toolbar',
				'type'		=> 'T',
				'default'	=> 'full',
				'desc'		=> __('The toolbox (alias toolbar) definition.','bpckeditor'));
				*/
	$fields[]=array(	'id' 		=> 'toolbarCanCollapse',
				'type'		=> 'B',
				'default'	=> 'true',
				'desc'		=> __('Whether the toolbar can be collapsed by the user.','bpckeditor'));
	$fields[]=array(	'id' 		=> 'toolbarLocation',
				'type'		=> 'S|top=Top|bottom=Bottom',
				'default'	=> 'top',
				'desc'		=> __('The "theme space" to which rendering the toolbar.','bpckeditor'));
	$fields[]=array(	'id' 		=> 'toolbarStartupExpanded',
				'type'		=> 'B',
				'default'	=> 'true',
				'desc'		=> __('Whether the toolbar must start expanded when the editor is loaded.','bpckeditor'));
		/*
		array(	'id' 		=> '',
				'desc'		=> ''),
		*/	
	
	foreach ($fields as $field) {
		
/*
Types:
	N: Numeric
	U: URL
	T: Short Text
	L: Large Text
	B: Boolean
	S: Select. 
	O: On/Off
	
*/		
		$input = '';
		if ( !isset($options['config'][$field['id']]) || $options['config'][$field['id']] == '' ) {
			$options['config'][$field['id']] = $field['default'];
		}
		switch (strtoupper(substr($field['type'],0,1))) {
			case 'N':
				$input = '<input style="width: 100px;" id="fld-config-'.$field['id'].'" type="text" name="bpckeditor[config]['.$field['id'].']" value="'.$options['config'][$field['id']].'" />';
			break;
			case 'T':
				$input = '<input class="regular-text" id="fld-config-'.$field['id'].'" type="text" name="bpckeditor[config]['.$field['id'].']" value="'.$options['config'][$field['id']].'" />';
			break;
			
			case 'U':
			case 'L':
				$input = '<input class="large-text" id="fld-config-'.$field['id'].'" type="text" name="bpckeditor[config]['.$field['id'].']" value="'.$options['config'][$field['id']].'" />';
			break;
			
			case 'O':
				$input = '
						<select id="fld-config-'.$field['id'].'" name="bpckeditor[config]['.$field['id'].']">
							<option value="on"  '.($options['config'][$field['id']]=='' || $options['config'][$field['id']]=='on'?'selected="selected"':'').' >ON</option>
							<option value="off" '.($options['config'][$field['id']]=='off'?'selected="selected"':'').' >OFF</option>
						</select>';
				
			break;
			case 'B':
				$input = '
						<select id="fld-config-'.$field['id'].'" name="bpckeditor[config]['.$field['id'].']">
							<option value="true"  '.($options['config'][$field['id']] == 'true'?'selected="selected"':'').' >'.__('True','bpckeditor').'</option>
							<option value="false" '.($options['config'][$field['id']] =='false'?'selected="selected"':'').' >'.__('False','bpckeditor').'</option>
						</select>';
			break;
			case 'S':
				$input = '
						<select id="fld-config-'.$field['id'].'" name="bpckeditor[config]['.$field['id'].']">
							';

				$raw_values = substr($field['type'],strpos($field['type'],'|')+1);
				$opt_values = explode('|',$raw_values);
				foreach ($opt_values as $opt_value) {
					list($value,$name) = explode('=',$opt_value);
					$input .= '
							<option value="'.$value.'"  '.($options['config'][$field['id']]==$value?'selected="selected"':'').' >'.$name.'</option>';
				}
				$input .= '
						</select>';
			break;
		}
	
		echo '
			<tr valign="top">
				<th scope="row"><label for="fld-config-'.$field['id'].'"><a href="http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.config.html#.'.$field['id'].'" target="_ext" title="'.__('Definition','bpckeditor').'">'.$field['id'].'</a></label></th>
				<td>'.$input.'<br/>
				<p>'.l($field['desc']).'</p></td>
			</tr>
		';
	}
	
	echo '
		</table>
		<input type="hidden" name="action" value="update" />	
		<p class="submit">
			<input type="submit" class="button-primary" value="'.__('Save Changes','bpckeditor').'" />
		</p>	
	</form>
	</div>';
	echo bpckeditor_pagebottom();
}

function bpckeditor_register_settings() {
  register_setting( 'bpckeditor', 'bpckeditor' );
}

function bpckeditor_add_menu() {
	
	$options = get_option('bpckeditor');
	
	//create new top-level menu
	$page_title 	= 'bpCKEditor';
	$menu_title		= $page_title;
	$capability		= 'manage_options';
	$menu_slug		= 'bpckeditor-settings';
	$function		= 'bpckeditor_settings_page';
	//$options['menu_type'] = 'buddypress';
	switch (strtolower($options['menu_type'])) {
		case 'own':			
			add_menu_page(
				$page_title,
				$menu_title,
				$capability, 
				$menu_slug,
				$function,
				plugins_url('/images/icon.ico', __FILE__));
		break;
		case 'buddypress':
		default:
			add_submenu_page(
				'bp-general-settings',
				$page_title,
				$menu_title,
				$capability,
				$menu_slug,
				$function);
		break;
		case 'settings':
			add_options_page( 
				$page_title, 
				$menu_title, 
				$capability, 
				$menu_slug, 
				$function);
		break;
		case 'plugin':
		break;
	}
}

function bpckeditor_add_settings_link( $links, $file ) {
	if ( $file == 'bpckeditor/index.php' ) {
        $settings_link = '<a href="' . admin_url( 'admin.php?page=bpckeditor-settings' ) . '">' . __( 'Settings') . '</a>';
        array_unshift( $links, $settings_link );
    }
    
	return $links;
}
add_filter( 'plugin_action_links', 'bpckeditor_add_settings_link', 10, 2 );

add_action( 'admin_menu', 'bpckeditor_add_menu' );
add_action( 'admin_init', 'bpckeditor_register_settings' );



?>