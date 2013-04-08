<?

/**
 * Print the site pages as tree
 *
 * @param string append_to_link
 *        	You can pass any string to be appended to all pages urls
 * @param string link
 *        	Replace the link href with your own. Ex: link="<? print site_url('page_id:{id}'); ?>"
 * @return string prints the site tree
 * @uses pages_tree($params);
 * @usage  type="pages" append_to_link="/editmode:y"
 */


if(!isset($params['link'])){
	if(isset($params['append_to_link'])){
		$append_to_link = $params['append_to_link'];
	} else {
		$append_to_link = '';
	}

	$params['link'] = '<a data-page-id="{id}" class="{active_class} {active_parent_class} pages_tree_link {nest_level} {exteded_classes}" href="{link}'.$append_to_link.'">{title}</a>';

} else {

	$params['link'] = '<a data-page-id="{id}" class="{active_class} {active_parent_class} pages_tree_link {nest_level} {exteded_classes}"  href="'.$params['link'].'">{title}</a>';
}


if (isset($params['data-parent'])) {
     $params['parent'] = intval($params['parent']);
} else {

	 $o = get_option('data-parent', $params['id']);
	 if($o != false and intval($o) >0){
		 $params['parent'] =  $o;
	 }
}
$include_categories = false;
if (isset($params['data-include_categories'])) {
     $params['include_categories'] = intval($params['parent']);
} else {

	 $o = get_option('include_categories', $params['id']);
 	 if($o != false and ($o) == 'y'){
		$include_categories =  $params['include_categories'] =  true;
	 }
}
	 $o = get_option('maxdepth', $params['id']);
	// d($o);
	 if($o != false and intval($o) >0){
		 $params['maxdepth'] =  $o;
	 }
 
  
 //
 
 


 $module_template = get_option('data-template',$params['id']);
				if($module_template == false and isset($params['template'])){
					$module_template =$params['template'];
				}
				
				
				
				
				
				if($module_template != false){
						$template_file = module_templates( $config['module'], $module_template);
				
				} else {
						$template_file = module_templates( $config['module'], 'default');
				
				}
				
				//d($module_template );
				if(isset($template_file) and is_file($template_file) != false){
					include($template_file);
				} else {
					
						$template_file = module_templates( $config['module'], 'default');
				include($template_file);
					//print 'No default template for '.  $config['module'] .' is found';
				}