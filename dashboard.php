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
            <strong class="card-title">Productos</strong>
          </div>
          <div class="card-body">
            <table id="bootstrap-data-table" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Foto</th>
                  <th>Nombre</th>
                  <th>Categorias</th>
                  <th>Precio</th>
                  <th>Descripción Corta</th>
                  <th>Opciones</th>
                </tr>
              </thead>
              <tbody>
               <?php
               $Q="SELECT * from wp_posts where post_status='publish' and post_type='product'";
               $ccc=0;
               foreach ($db->query($Q) as $Row) {
                $ID=$Row["ID"];
                if($ccc==0)
                {
                 $ccc=1;
                 $Primero=$ID;
               }
               ?>
               <tr>
                <td><?=$ID?></td>
                <td>
                 <?php
                 $Q2="SELECT * FROM `wp_postmeta` WHERE `post_id`='$ID' and meta_key='_thumbnail_id'";
                 foreach ($db->query($Q2) as $Row2) {
                  $FotoID=$Row2["meta_value"];
                  $Q1="SELECT * from wp_posts where ID='$FotoID'";
                  foreach ($db->query($Q1) as $Row1) {
                    ?>
                    <img src="<?=$Row1['guid']?>" heigth="50px" width="50px">
                    <?php
                  }
                }

                ?>
              </td>  
              <td><a href="<?=$Row["guid"]?>"><?=$Row["post_title"]?></a></td>
              <td>
               <?php
               $Q1="SELECT * from wp_term_relationships where object_id='$ID'";
               foreach ($db->query($Q1) as $Row1) {
                $term_taxonomy_id=$Row1["term_taxonomy_id"];
                $Q2="SELECT * from wp_terms where term_id = '$term_taxonomy_id' and name!='simple' and name!='featured'";
                foreach ($db->query($Q2) as $Row2) {
                 echo $Row2["name"].", ";
               }
             }
             ?>
           </td>
           <td>
             <?php
             $Q1="SELECT * from wp_postmeta where post_id='$ID' and meta_key='_price'";
             foreach ($db->query($Q1) as $Row1) {
              echo money_format('%i',$Row1["meta_value"]);
            }
            ?>
          </td>

          <td><?=substr($Row["post_excerpt"], 0,60)?></td>
          <td>


            <form method="POST" action="Controller/DeleteProduct.php">
              <input type="hidden" name="ID" value="<?=$Row["ID"]?>">
              <input type="submit" value="Eliminar" class="btn btn-default ">
            </form>
            <form method="GET" action="">
              <input type="hidden" name="ID" value="<?=$Row["ID"]?>">
              <input type="submit" value="Editar" class="btn btn-default ">
            </form>
            <!--<button class="btn btn-default" onclick="funcion(<?=$ID?>)"> - Editar - </button>-->

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


</div>
<script type="text/javascript">
  var thumb=0;
  function funcion(id)
  {
    $.ajax({
      url: 'Controller/GetProduct.php?ID='+id,
      success: function(respuesta) {

        var arr = JSON.parse(respuesta);
        document.getElementById("name").value=arr["name"];
        document.getElementById("price").value=arr["price"];
        document.getElementById("foto").src=arr["foto"];
        document.getElementById("short").value=arr["short"];
        document.getElementById("long").value=arr["long"];
        document.getElementById("IDENTIFICADOR").value=arr["id"];
        const d=document.getElementById("IDENTIFICADOR").value
        document.getElementById("LOGPROD").style="background-color: #f1efef;";
        document.getElementById("EditarProd2").style="display: block;";

        thumb=arr["thumb"];

        var element = document.querySelector("#EditarProd2");
        element.scrollIntoView();

      },
      error: function() {
        console.log("No se ha podido obtener la información");
      }
    });
  }


</script>


<div class="row">
  <div class="col-md-6" style="display: none;">
    <div class="card">
      <div class="card-header">
        <strong class="card-title">Files</strong>
      </div>
      <div class="card-body">
        <select class="form-control">
          <?php
          foreach ($db->query($Q) as $Row) {
            ?>
            <option value="<?=$Row['email']?>"><?=$Row['name']?></option>
            <?php
          }
          ?>
        </select>
        <br>

        


      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card">
      <div class="card-header">
        <strong class="card-title">Nuevo Producto</strong>
      </div>
      <div class="card-body">
        <div class="login-form">
          <form action="Controller/AddProduct.php" method="POST">
            <div class="form-group">
              <label>Nombre</label>
              <input type="text" class="form-control" name="NAME" placeholder="Nombre" required>
            </div>
            <div style="display: none;" class="form-group">
              <label>Categorias</label>
              <br>
              <select  title="Categorias" class="selectpicker form-control" name="CATEGORIES[]" multiple> 
                <?php
                $Q="SELECT * from wp_wc_category_lookup where category_tree_id = category_id";
                foreach ($db->query($Q) as $Row) {
                  $tid=$Row["category_id"];
                  $Q1="SELECT * from wp_terms where term_id=$tid";
                  foreach ($db->query($Q1) as $Row1) {
                    ?>
                    <option value="<?=$tid?>"><?=$Row1["name"]?></option>
                    <?php
                  }
                }
                ?>
              </select>


            </div>
            <div class="form-group">
              <label>Categorias</label>
              <br>
              <select  title="Categorias" class="selectpicker form-control" name="CATEGORIES[]" multiple> 
                <?php
                $taxonomy     = 'product_cat';
                $orderby      = 'name';  
  $show_count   = 0;      // 1 for yes, 0 for no
  $pad_counts   = 0;      // 1 for yes, 0 for no
  $hierarchical = 1;      // 1 for yes, 0 for no  
  $title        = '';  
  $empty        = 0;

  $args = array(
   'taxonomy'     => $taxonomy,
   'orderby'      => $orderby,
   'show_count'   => $show_count,
   'pad_counts'   => $pad_counts,
   'hierarchical' => $hierarchical,
   'title_li'     => $title,
   'hide_empty'   => $empty
 );
  $all_categories = get_categories( $args );
  foreach ($all_categories as $cat) {
    if($cat->category_parent == 0) {
      $category_id = $cat->term_id;       
      /*echo '<br /><a href="'. get_term_link($cat->slug, 'product_cat') .'">'. $cat->name .'</a>';*/
      ?>

      <option value="<?= $cat->term_id?>"><?=$cat->name?></option>

      <?php

      $args2 = array(
        'taxonomy'     => $taxonomy,
        'child_of'     => 0,
        'parent'       => $category_id,
        'orderby'      => $orderby,
        'show_count'   => $show_count,
        'pad_counts'   => $pad_counts,
        'hierarchical' => $hierarchical,
        'title_li'     => $title,
        'hide_empty'   => $empty
      );
      $sub_cats = get_categories( $args2 );
      if($sub_cats) {
        foreach($sub_cats as $sub_category) {
                //echo  $sub_category->name ;
        }   
      }
    }       
  }
  ?>
</select>


</div>
<div class="form-group">
  <label>Fotografías</label>
  <br>
  <select title="Fotografías" class="selectpicker form-control" name="PHOTOS[]" multiple>
    <?php
    $Q="SELECT * FROM `wp_posts` where post_type='attachment' and ID>$Primero and (post_mime_type='image/jpeg' or post_mime_type='image/png') order by ID DESC";
    foreach ($db->query($Q) as $Row) {
      $Nom=$Row["post_title"];
      $guid=$Row["guid"];
      $id=$Row["ID"]

      ?>
      <option data-content="<img class='img-responsive' width='30px' height='30px'  src='<?=$guid?>'></img> <?=$Nom?>" value='<?=$id?>'></option>
      <?php
    }
    ?>                
  </select>
</div>

<div class="form-group">
  <label>Precio</label>
  <input type="number" class="form-control"  name="PRICE" placeholder="Precio" required>
</div>
<div class="form-group">
  <label>Descripción Corta</label>
  <input type="text" class="form-control"  name="SHORT" placeholder="Descripción Corta" required>
</div>
<div class="form-group">
  <label>Descripción larga</label>
  <textarea class="form-control" name="LONG" placeholder="Descripción Larga"></textarea>
</div>

<button type="submit" style="background-color: #b20c23" class="btn btn-success btn-flat m-b-30 m-t-30">Registrar producto</button>
<br>
<br>
</form>
</div>
</div>
</div>
</div>



<!--Editar GET-->
<?php
if($_GET["ID"])
{
 $ID=$_GET["ID"];
 ?>
 <script type="text/javascript">
  funcion(<?=$ID?>);
</script>
<div class="col-md-6">
  <div class="card" id="EditarProd2">
    <div class="card-header">
      <strong class="card-title">Editar producto</strong>
    </div>
    <div class="card-body">
      <div class="login-form" id="LOGPROD" >
        <form action="Controller/UpdateProduct.php" method="POST">
          <input type="hidden" id="IDENTIFICADOR" name="IDENTIFICADOR"  value="1">
          <div class="form-group">
            <label>Nombre</label>
            <input type="text" class="form-control" id="name" name="NAME" placeholder="<?=$Row0['post_title']?>" required>
          </div>
          <div class="form-group">
            <label>Categorias</label>
            <br>
            <select  title="Categorias" class="selectpicker form-control" name="CATEGORIES[]" multiple> 
              <?php
              $taxonomy     = 'product_cat';
              $orderby      = 'name';  
  $show_count   = 0;      // 1 for yes, 0 for no
  $pad_counts   = 0;      // 1 for yes, 0 for no
  $hierarchical = 1;      // 1 for yes, 0 for no  
  $title        = '';  
  $empty        = 0;

  $args = array(
   'taxonomy'     => $taxonomy,
   'orderby'      => $orderby,
   'show_count'   => $show_count,
   'pad_counts'   => $pad_counts,
   'hierarchical' => $hierarchical,
   'title_li'     => $title,
   'hide_empty'   => $empty
 );
  $all_categories = get_categories( $args );
  foreach ($all_categories as $cat) {
    if($cat->category_parent == 0) {
      $category_id = $cat->term_id;       
      /*echo '<br /><a href="'. get_term_link($cat->slug, 'product_cat') .'">'. $cat->name .'</a>';*/

      $Q2="SELECT * from wp_term_relationships where object_id='$ID'";
      foreach ($db->query($Q2) as $Row2) {
        $term_taxonomy_id=$Row2["term_taxonomy_id"];
        $Q3="SELECT * from wp_terms where term_id = '$term_taxonomy_id' and name!='simple' and name!='featured'";
        foreach ($db->query($Q3) as $Row3) {
         if ($Row3["name"]==$cat->name)
         {
          $cc+=1;
        }
      }
    }

    if($cc==0)
    {
      ?>
      <option value="<?= $cat->term_id?>" ><?=$cat->name?></option>
      <?php
    }else
    {
      ?>
      <option value="<?= $cat->term_id?>" selected><?=$cat->name?></option>
      <?php
    }
    ?>
    <?php

    $args2 = array(
      'taxonomy'     => $taxonomy,
      'child_of'     => 0,
      'parent'       => $category_id,
      'orderby'      => $orderby,
      'show_count'   => $show_count,
      'pad_counts'   => $pad_counts,
      'hierarchical' => $hierarchical,
      'title_li'     => $title,
      'hide_empty'   => $empty
    );
    $sub_cats = get_categories( $args2 );
    if($sub_cats) {
      foreach($sub_cats as $sub_category) {
                //echo  $sub_category->name ;
      }   
    }
  }       
}
?>
</select>
</div>




<div class="form-group">
  <label>Fotografías</label>
  <br>
  <select title="Fotografías" class="selectpicker form-control" name="PHOTOS[]" multiple>
    <?php
    $ID=$_GET["ID"];
    $imag="";
    $Q="SELECT * from `wp_postmeta` where `post_id` ='$ID' and `meta_key`='_product_image_gallery'";
    foreach ($db->query($Q) as $Row) {
     $imag=$Row["meta_value"];
     break;
   }
   $Q="SELECT * from `wp_postmeta` where `post_id` ='$ID' and `meta_key`='_thumbnail_id'";
   foreach ($db->query($Q) as $Row) {
     $imag.=$Row["meta_value"];
   }
   $imags=explode(",", $imag);
              //echo "Hola:".$imags;

   $Q="SELECT * FROM `wp_posts` where post_type='attachment' and ID>$Primero and (post_mime_type='image/jpeg' or post_mime_type='image/png') order by ID DESC";
   foreach ($db->query($Q) as $Row) {
    $Nom=$Row["post_title"];
    $guid=$Row["guid"];
    $id=$Row["ID"];

    if(in_array($id, $imags))
    {
     ?>
     <option data-content="<img class='img-responsive' width='30px' height='30px'  src='<?=$guid?>'></img> <?=$Nom?>" value='<?=$id?>' selected></option>
     <?php
   }else
   {
     ?>
     <option data-content="<img class='img-responsive' width='30px' height='30px'  src='<?=$guid?>'></img> <?=$Nom?>" value='<?=$id?>'></option>
     <?php
   }
 }
 ?>                
</select>
</div>




<div class="form-group">
  <label>Precio</label>
  <input type="number" class="form-control" id="price" name="PRICE" placeholder="Precio" required>
</div>

<div class="form-group">
  <label>Descripción Corta</label>
  <input type="text" class="form-control" id="short" name="SHORT" placeholder="Descripción Corta" required>
</div>
<div class="form-group">
  <label>Descripción larga</label>
  <textarea class="form-control" id="long" name="LONG" placeholder="Descripción Larga"></textarea>
</div>

<button type="submit" style="background-color: #b20c23" class="btn btn-success btn-flat m-b-30 m-t-30">Actualizar producto</button>
<br>
<br>
</form>
</div>
</div>
</div>
</div>
<?php
}
?>





</div>








</div>

</div>





<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <strong class="card-title">Subir imágenes</strong>
      </div>
      <div class="card-body">
        <div class="dropzone" class="form-control" id="dropzone3"></div>

        <script type="text/javascript">

         Dropzone.autoDiscover = false;
         var ln = $("#IDENTIFICADOR").val();
         $("#dropzone3").dropzone({
          url: 'Controller/Upload.php',
          acceptedFiles: ".jpeg,.jpg,.png"
        });
      </script>
    </div>
  </div>
</div>
</div>

</div>
</div><!-- .animated -->
</div><!-- .content -->
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


<script type="text/javascript">
  $(document).ready(function() {
    $('#bootstrap-data-table-export').DataTable();
  } );
</script>
<?php
require_once "Layouts/Footer.php";
?>