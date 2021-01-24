<?php
require_once __DIR__."/../Tools/PDO.php";
if($_GET)
{
	$dato;
	$ID=$_GET["ID"];
	
	$Q="SELECT * from wp_posts where post_status='publish' and post_type='product' and ID='$ID'";
	foreach ($db->query($Q) as $Row) {
		$dato["id"]=$ID;
		$Q2="SELECT * FROM `wp_postmeta` WHERE `post_id`='$ID' and meta_key='_thumbnail_id'";
		foreach ($db->query($Q2) as $Row2) {
			$FotoID=$Row2["meta_value"];
			$Q1="SELECT * from wp_posts where ID='$FotoID'";
			foreach ($db->query($Q1) as $Row1) {

				$dato["foto"]=$Row1['guid'];

			}
		}
	}

	$dato["name"]=$Row["post_title"];
	$Q1="SELECT * from wp_term_relationships where object_id='$ID'";
	foreach ($db->query($Q1) as $Row1) {
		$term_taxonomy_id=$Row1["term_taxonomy_id"];
		$Q2="SELECT * from wp_terms where term_id = '$term_taxonomy_id' and name!='simple' and name!='featured'";
		foreach ($db->query($Q2) as $Row2) {
                   //echo $Row2["name"].", ";
		}
	}

	$Q1="SELECT * from wp_postmeta where post_id='$ID' and meta_key='_price'";
	foreach ($db->query($Q1) as $Row1) {
		$dato["price"]=$Row1["meta_value"];
	}

	$Q1="SELECT * from wp_postmeta where post_id='$ID' and meta_key='_thumbnail_id'";
	foreach ($db->query($Q1) as $Row1) {
		$dato["thumbnail"]=$Row1["meta_value"];
	}

	$dato["short"]=$Row["post_excerpt"];
	$dato["long"]=$Row["post_content"];

	echo json_encode($dato);

	
}
?>