<?php
require_once __DIR__."/../Tools/PDO.php";
if($_GET)
{
	$dato=array();
	$producto;
	$ID=$_GET["ID"];
	
	$Q="SELECT * from wp_wc_order_product_lookup where order_id='$ID'";
	foreach ($db->query($Q) as $Row) {
		$pid=$Row["product_id"];
		$producto["id"]=$pid;
		$Q1="SELECT * from wp_posts where ID=$pid";
		foreach ($db->query($Q1) as $Row1) {
			$producto["nombre"]=$Row1["post_title"];
		}
		$producto["cantidad"]=$Row["product_qty"];
		$producto["valor"]=$Row["product_net_revenue"];
		array_push($dato,$producto);
	}

	echo json_encode($dato);

	
}
?>