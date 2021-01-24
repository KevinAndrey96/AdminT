<?php
require_once "Layouts/Header.php";
?>
<link rel="stylesheet" href="assets/css/lib/datatable/dataTables.bootstrap.min.css">
<div class="content">
  <div class="animated fadeIn">
    <div class="row">

      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <strong class="card-title">Transacciones</strong>
          </div>
          <div class="card-body">
            <table id="datatabla" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Nombre</th>
                  <th>Fecha</th>
                  <th>Estado</th>
                  <th>Valor</th>
                  <th>Opciones</th>
                </tr>
              </thead>
              <tbody>
               <?php
               $Q="SELECT * from wp_posts where post_type='shop_order' and post_status!='trash' order by ID DESC";
               $ccc=0;
               foreach ($db->query($Q) as $Row) {
                $ID=$Row["ID"];
                ?>
                <tr>
                  <td><?=$ID?></td>
                  <?php
                  $Nombre="";
                  $Q1="SELECT * FROM `wp_postmeta` WHERE `post_id` = $ID and meta_key='_billing_first_name'";
                  foreach ($db->query($Q1) as $Row1) {
                    $Nombre=$Row1["meta_value"];
                  }
                  $Q1="SELECT * FROM `wp_postmeta` WHERE `post_id` = $ID and meta_key='_billing_last_name'";
                  foreach ($db->query($Q1) as $Row1) {
                    $Nombre.=" ".$Row1["meta_value"];
                  }
                  $Valor="";
                  $Q1="SELECT * FROM `wp_postmeta` WHERE `post_id` = $ID and meta_key='_order_total'";
                  foreach ($db->query($Q1) as $Row1) {
                    $Valor=$Row1["meta_value"];
                  }
                  ?>
                  <td><?=$Nombre?></td>
                  <td><?=$Row["post_date"]?></td>  
                  <?php
                  if($Row["post_status"]=="wc-failed")
                  {
                    ?>
                    <td style="color: red">Fallido</td>
                    <?php
                  }
                  if($Row["post_status"]=="wc-on-hold")
                  {
                    ?>
                    <td style="color: orange">En espera</td>
                    <?php
                  }
                  if($Row["post_status"]=="wc-completed")
                  {
                    ?>
                    <td style="color: green">Completado</td>
                    <?php
                  }
                  if($Row["post_status"]=="wc-cancelled")
                  {
                    ?>
                    <td style="color: gray">Cancelado</td>
                    <?php
                  }
                  if($Row["post_status"]=="wc-pending")
                  {
                    ?>
                    <td style="color: orange">Pendiente de pago</td>
                    <?php
                  }
                  if($Row["post_status"]=="wc-processing")
                  {
                    ?>
                    <td style="color: blue">En proceso</td>
                    <?php
                  }
                  

                  ?>
                  

                  <td><?=money_format('%i',$Valor)?></td>

                  <td>

                    <!--<button class="btn btn-default" onclick="funcion(<?=$ID?>)"> - Ver - </button>-->
                    <form method="GET" action="">
                    	<input type="hidden" name="ID" value="<?=$ID?>">
                    	<input type="submit" class="btn btn-default" value="- Ver -">
                    </form>

                  </td>
                </tr>
                <?php
              }
              ?>

            </tbody>
          </table>
        </div>
      </div>
    </div>
    
    <script type="text/javascript">
      var thumb=0;
      function funcion(id)
      {
        $.ajax({
          url: 'Controller/GetTransaction.php?ID='+id,
          success: function(respuesta) {

            var arr = JSON.parse(respuesta);
            document.getElementById("nom").innerHTML=arr["nom"];
            document.getElementById("cor").innerHTML=arr["cor"];
            document.getElementById("dir").innerHTML=arr["dir"];
            document.getElementById("tel").innerHTML=arr["tel"];
            document.getElementById("ciu").innerHTML=arr["ciu"];
            document.getElementById("ipp").innerHTML=arr["ipp"];

            document.getElementById("VERTRAN1").style="display:block";
            document.getElementById("VERTRAN2").style="display:block";

            var element = document.querySelector("#VERTRAN2");
            element.scrollIntoView();

          },
          error: function() {
            console.log("No se ha podido obtener la información");
          }
        });

      }


    </script>
<?php
    if($_GET["ID"]!="")
    {
    	?>
    	<script type="text/javascript">
    		funcion(<?=$_GET["ID"]?>)
    	</script>
    	<?php
    }
    ?>

  </div>

  <div class="row"  style="">
    <div class="col-md-12" id="VERTRAN1" style="display: none;">
      <div class="card">
        <div class="card-header" >
          <strong class="card-title">Datos de cliente</strong>
        </div>
        <div class="card-body">
          <div class="form-group">
            <strong>Nombre completo: </strong><label id="nom"></label>
          </div>
          <div class="form-group">
            <strong>Correo electrónico: </strong><label id="cor"></label>
          </div>
          <div class="form-group">
            <strong>Teléfono: </strong><label id="tel"></label>
          </div>
          <div class="form-group">
            <strong>Dirección: </strong><label id="dir"></label>
          </div>
          <div class="form-group">
            <strong>Ciudad: </strong><label id="ciu"></label>
          </div>
          <div class="form-group">
            <strong>IP: </strong><label id="ipp"></label>
          </div>
          <div class="form-group">
          	<div class="row">
          		<div class="col-md-6">
          			<form method="POST" action="Controller/Status.php">
		          		<input type="hidden" value="<?=$ID?>" name="ID">
		          		<input type="hidden" value="wc-completed" name="STATUS">
		          		<input type="submit" class="btn btn-success form-control" value="Completado" name="">
		          	</form>
          		</div>
          		<div class="col-md-6">
          			<form method="POST" action="Controller/Status.php">
		          		<input type="hidden" value="<?=$ID?>" name="ID">
		          		<input type="hidden" value="trash" name="STATUS">
		          		<input type="submit" class="btn btn-danger form-control" value="Eliminar" name="">
		          	</form>
          		</div>
          	</div>
          	
          	
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-12" id="VERTRAN2" style="display: none;">
      <div class="card">
        <div class="card-header">
          <strong class="card-title">Datos de venta</strong>
        </div>
        <div class="card-body">
        	<table class="table">
            <thead>
              <tr>
                <td><b>Producto</b></td>
                <td><b>Nombre</b></td>
                <td><b>Cantidad</b></td>
                <td><b>Valor</b></td>
              </tr>
            </thead>
            <tbody>


        	<?php
        	$ID=$_GET["ID"];
$Q="SELECT * from wp_wc_order_product_lookup where order_id='$ID'";
$Totales=0;
	foreach ($db->query($Q) as $Row) {
		$pid=$Row["product_id"];
		$producto["id"]=$pid;
		$Q1="SELECT * from wp_posts where ID=$pid";
		foreach ($db->query($Q1) as $Row1) {
			$producto["nombre"]=$Row1["post_title"];
		}
		$producto["cantidad"]=$Row["product_qty"];
		$producto["valor"]=$Row["product_net_revenue"];
		$Totales+=$producto["valor"];
		?>
		<tr>
	        <td><?=$producto["id"]?></td>
	        <td><?=$producto["nombre"]?></td>
	        <td><?=$producto["cantidad"]?></td>
	        <td><?=money_format("%i", $producto["valor"])?></td>
	      </tr>
	        
		<?php
	}
        	?>
          <tr>
	        <td colspan="3"><strong>Total:</strong></td>
	        <td><strong><?=money_format("%i", $Totales)?></strong></td>
	      </tr>
             
              
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

</div>
</div><!-- .animated -->
<script type="text/javascript">
  $(document).ready(function() {
    //$('#bootstrap-data-table-export').DataTable();
    $('#datatabla').DataTable( {
      "order": [[ 0, "desc" ]]
    });
  });
</script>
<script src="assets/js/lib/data-table/datatables.min.js"></script>
<script src="assets/js/lib/data-table/dataTables.bootstrap.min.js"></script>
<script src="assets/js/lib/data-table/dataTables.buttons.min.js"></script>
<script src="assets/js/lib/data-table/buttons.bootstrap.min.js"></script>
<script src="assets/js/lib/data-table/jszip.min.js"></script>
<script src="assets/js/lib/data-table/vfs_fonts.js"></script>
<script src="assets/js/lib/data-table/buttons.html5.min.js"></script>
<script src="assets/js/lib/data-table/buttons.print.min.js"></script>
<script src="assets/js/lib/data-table/buttons.colVis.min.js"></script>
<script src="assets/js/init/datatables-init.js"></script>



<?php
require_once "Layouts/Footer.php";
?>