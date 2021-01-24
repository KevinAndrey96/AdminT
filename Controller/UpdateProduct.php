<?php
require_once __DIR__."/../Tools/PDO.php";
if($_POST)
{
	$ID=$_POST["IDENTIFICADOR"];
	$NAME=$_POST["NAME"];
	$PRICE=$_POST["PRICE"];
	$LONG=$_POST["LONG"];
	$SHORT=$_POST["SHORT"];

	//$PNAME=rtrim(ltrim(trim(strtolower(str_replace(" ", "-", $NAME)))))."-".rand(10,99);
	$Q="SELECT * from wp_options where option_name='siteurl'";
	foreach ($db->query($Q) as $Row) {
		$guid=$Row["option_value"];
	}

	$guid=$guid."/producto/".$PNAME;

	$Q="UPDATE `wp_posts` set post_title='$NAME', post_content='$LONG', post_excerpt='$SHORT' where ID='$ID'";
	$db->query($Q);

	$c=0;
	$Q0="SELECT * from `wp_postmeta` where post_id='$ID' and meta_key='_price'";
	foreach ($db->query($Q0) as $Row0) {
		$c++;
	}
	if($c==0)
	{
		$Q="INSERT INTO `wp_postmeta`(`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES (null,$ID,'_price',$PRICE)";
		$db->query($Q);
	}else
	{
		$Q1="UPDATE `wp_postmeta` set meta_value='$PRICE' where post_id='$ID' and meta_key='_price'";
		$db->query($Q1);
	}

	$c=0;
	$Q0="SELECT * from `wp_postmeta` where post_id='$ID' and meta_key='_regular_price'";
	foreach ($db->query($Q0) as $Row0) {
		$c++;
	}
	if($c==0)
	{
		$Q="INSERT INTO `wp_postmeta`(`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES (null,$ID,'_regular_price',$PRICE)";
		$db->query($Q);
	}else
	{
		$Q1="UPDATE `wp_postmeta` set meta_value='$PRICE' where post_id='$ID' and meta_key='_regular_price'";
		$db->query($Q1);
	}


	$c=0;
	$Q0="SELECT * from `wp_postmeta` where post_id='$ID' and meta_key='_thumbnail_id'";
	foreach ($db->query($Q0) as $Row0) {
		$c++;
	}
	if($c==0)
	{
		$Q="DELETE from wp_postmeta where post_id='$ID' and meta_key='_thumbnail_id'";
		$db->query($Q);
		$Q="INSERT INTO `wp_postmeta`(`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES (null,$ID,'_thumbnail_id','')";
		$db->query($Q);
	}


	$c=0;
	$Q0="SELECT * from `wp_postmeta` where post_id='$ID' and meta_key='_product_image_gallery'";
	foreach ($db->query($Q0) as $Row0) {
		$c++;
	}
	if($c==0)
	{
		$Q="INSERT INTO `wp_postmeta`(`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES (null,$ID,'_product_image_gallery','')";
		$db->query($Q);
	}

	$Q = "DELETE from wp_term_relationships where object_id = '$ID'";
	$db->query($Q);
	foreach ($_POST['CATEGORIES'] as $category)  
	{
		$Q="INSERT INTO `wp_term_relationships`(`object_id`, `term_taxonomy_id`, `term_order`) VALUES ($ID,$category,0)";
		$db->query($Q);
	}
	
	$PHOTOS="";
	$cont=0;
	foreach ($_POST['PHOTOS'] as $photo)  
	{
		if($cont==0)
		{
			$Q2="UPDATE `wp_postmeta` set meta_value='$photo' where post_id='$ID' and meta_key='_thumbnail_id'";
			$db->query($Q2);
		}
		else
		{
			$PHOTOS.=$photo.", ";
		}
		$cont++;
	}
	$Q3="UPDATE `wp_postmeta` set meta_value='$PHOTOS' where post_id='$ID' and meta_key='_product_image_gallery'";
	$db->query($Q3);
}
?>
<script type="text/javascript">
	window.alert("Producto actualizado");
	window.location.href="../dashboard.php";
</script>