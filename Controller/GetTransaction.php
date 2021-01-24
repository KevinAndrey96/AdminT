<?php
require_once __DIR__."/../Tools/PDO.php";
if($_GET)
{
	$dato;
	$ID=$_GET["ID"];
	
	/*$Q="SELECT * from wp_posts where post_type='shop_order' and ID='$ID'";
	foreach ($db->query($Q) as $Row) {
		$dato["id"]=$ID;
	}*/

	$Q="SELECT * FROM `wp_postmeta` WHERE `post_id`='$ID' and meta_key='_billing_first_name'";
	foreach ($db->query($Q) as $Row) {
		$dato["nom"]=$Row["meta_value"];
		break;
	}
	$Q="SELECT * FROM `wp_postmeta` WHERE `post_id`='$ID' and meta_key='_billing_last_name'";
	foreach ($db->query($Q) as $Row) {
		$dato["nom"].=" ".$Row["meta_value"];
		break;
	}
	$Q="SELECT * FROM `wp_postmeta` WHERE `post_id`='$ID' and meta_key='_billing_email'";
	foreach ($db->query($Q) as $Row) {
		$dato["cor"]=$Row["meta_value"];
		break;
	}
	$Q="SELECT * FROM `wp_postmeta` WHERE `post_id`='$ID' and meta_key='_billing_phone'";
	foreach ($db->query($Q) as $Row) {
		$dato["tel"]=$Row["meta_value"];
		break;
	}
	$Q="SELECT * FROM `wp_postmeta` WHERE `post_id`='$ID' and meta_key='_billing_address_1'";
	foreach ($db->query($Q) as $Row) {
		$dato["dir"]=$Row["meta_value"];
		break;
	}
	$Q="SELECT * FROM `wp_postmeta` WHERE `post_id`='$ID' and meta_key='_billing_postcode'";
	foreach ($db->query($Q) as $Row) {
		$dato["dir"].=" (".$Row["meta_value"].")";
		break;
	}
	$Q="SELECT * FROM `wp_postmeta` WHERE `post_id`='$ID' and meta_key='_billing_city'";
	foreach ($db->query($Q) as $Row) {
		$dato["ciu"]=$Row["meta_value"];
		break;
	}
	$Q="SELECT * FROM `wp_postmeta` WHERE `post_id`='$ID' and meta_key='_billing_state'";
	foreach ($db->query($Q) as $Row) {
		$dato["ciu"].=", ".$Row["meta_value"];
		break;
	}
	$Q="SELECT * FROM `wp_postmeta` WHERE `post_id`='$ID' and meta_key='_billing_country'";
	foreach ($db->query($Q) as $Row) {
		$dato["ciu"].=" - ".$Row["meta_value"];
		break;
	}
	$Q="SELECT * FROM `wp_postmeta` WHERE `post_id`='$ID' and meta_key='_customer_ip_address'";
	foreach ($db->query($Q) as $Row) {
		$dato["ipp"]=$Row["meta_value"];
		break;
	}

	echo json_encode($dato);

	
}
?>