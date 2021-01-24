<?php
require_once "../../Tools/PDO.php";
if($_POST)
{
	$ID=$_POST["ID"];
	$Q="DELETE from wp_posts where ID=$ID";
	$db->query($Q);

    $Q="DELETE FROM `wp_postmeta` where post_id=$ID";
    $db->query($Q);

	//deleteAll( "../../Files/".$USER);

    $Q="DELETE FROM `wp_term_relationships` where object_id=$ID";
    $db->query($Q);


	?>
	<script type="text/javascript">
		window.alert("Producto eliminado con éxito");
		window.location.href="../dashboard.php";
	</script>
	<?php
}
?>