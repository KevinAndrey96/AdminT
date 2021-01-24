<?php
session_start();
require_once "../../Tools/PDO.php";
require_once "../../Tienda/wp-load.php";
if($_POST)
{
	$USER=$_POST["USER"];
	//$PASS=wp_hash_password($_POST["PASS"]);
	$PASS=$_POST["PASS"];
	/*
		$Q="SELECT * from wp_users where user_login='$USER' and user_pass = '$PASS'";
		foreach ($db->query($Q) as $Row) {
            $_SESSION["ActiveA"]=true;
			$_SESSION["UserNameA"]=$USER;
			?>
			<script type="text/javascript">window.location.href = "../dashboard.php"</script>
			<?php
		}
	*/
	$Q="SELECT * from wp_users where ID=1";
	foreach ($db->query($Q) as $Row) {
		$Hash=$Row["user_pass"];
	}
	
	if(wp_check_password($PASS,$Hash , 1 ))
	{
		$_SESSION["ActiveA"]=true;
		$_SESSION["UserNameA"]=$USER;
		?>
		<script type="text/javascript">window.location.href = "../dashboard.php"</script>
		<?php
	}
}
?>
<script type="text/javascript">
	window.alert("Usuario o contraseña incorrectos");
	window.location.href="../index.php";
</script>