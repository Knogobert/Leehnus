<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
	<input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search …', 'placeholder' ) ?>" value="<?php echo get_search_query() ?>" name="s" id="searchFieldHeader" style="
		width:<?php
			$string=get_search_query();
			if (strlen($string)==0){
				echo "90";
			}else{
				echo (strlen($string)*10)+40;	
			}
		?>px;"/> <!-- Defines the width depending on the string length of search entry -->
	<input type="submit" class="search-submit" value="<?php echo esc_attr_x( 'Search', 'submit button' ) ?>" />
	<!-- <input type="image" alt="Search" src="<?php bloginfo( 'template_url' ); ?>/images/search.png" /> -->
</form>