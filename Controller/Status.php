<?php
require_once __DIR__."/../Tools/PDO.php";
if($_POST)
{
	$ID=$_POST["ID"];
	$STATUS=$_POST["STATUS"];
	$Q="UPDATE wp_posts set post_status='$STATUS' where ID='$ID'";
	$db->query($Q);
}
?>
<script type="text/javascript">
	window.alert("Estado actualizado");
	window.location.href="../transactions.php";
</script>