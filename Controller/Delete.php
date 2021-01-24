<?php
session_start();
if($_SESSION["ActiveA"]==true)
{
    unlink ("../../Files/".$_POST['user']."/".$_POST['file']);
    ?>
    <script type="text/javascript">
    	window.location.href="../files.php?u=<?=$_POST['user']?>";
    </script>
    <?php
}
?>