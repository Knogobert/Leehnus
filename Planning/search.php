HTML:

<form id="searchbar">

				<input type="text" onkeyup="showResult(this.value)">
			
			</form>

			<div id="livesearch"></div> <!---Här syns resultaten-->


functions.php:

function my_search(){
	$query_string = $_GET['q'];

	$s = new WP_Query(array( 's' => $query_string ));

	echo '<ul>';
	while($s->have_posts()){ 
		$s->the_post();?>

		<li>

			<?php the_post_thumbnail(); ?>

			<?php the_title(); ?>
			
		</li>

	<?php }
	echo '</ul>';

	wp_die();
}

add_action('wp_ajax_search', 'my_search');
add_action('wp_ajax_nopriv_search', 'my_search');

JS:

function showResult(str) {

  if (str.length==0) { 
    document.getElementById("livesearch").innerHTML="";
    document.getElementById("livesearch").style.display="none";

    return;
  }

  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();

  } else {  
  	// code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }

  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {

      document.getElementById("livesearch").innerHTML=xmlhttp.responseText;
      document.getElementById("livesearch").style.display="block";
    }
  }

  xmlhttp.open("POST","/wordpress/wp-admin/admin-ajax.php?action=search&q="+str,true); //Hämtar wp-admins ajax mojs
  xmlhttp.send();
}