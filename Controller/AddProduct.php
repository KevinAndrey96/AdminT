<?php
require_once __DIR__."/../Tools/PDO.php";
if($_POST)
{
	$NAME=$_POST["NAME"];
	$PRICE=$_POST["PRICE"];
	$LONG=$_POST["LONG"];
	$SHORT=$_POST["SHORT"];

	$PNAME=rtrim(ltrim(trim(strtolower(str_replace(" ", "-", $NAME)))))."-".rand(10,99);
	$Q="SELECT * from wp_options where option_name='siteurl'";
	foreach ($db->query($Q) as $Row) {
		$guid=$Row["option_value"];
	}

	$guid=$guid."/producto/".$PNAME;

	
	$Q="INSERT INTO `wp_posts`(`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES (null,1,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,'$LONG','$NAME','$SHORT','publish','closed','closed','','$PNAME','','',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,'',0,'$guid',0,'product','',0)";
	$db->query($Q);
	$ID=$db->lastInsertId();
	//$ID=2670;

/*	$Q="INSERT INTO `wp_postmeta`(`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES (null,$ID,'_thumbnail_id',0)";
	$db->query($Q);
*/
	$Q="INSERT INTO `wp_postmeta`(`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES (null,$ID,'_price',$PRICE)";
	$db->query($Q);

	$Q="INSERT INTO `wp_postmeta`(`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES (null,$ID,'_product_image_gallery','')";
	$db->query($Q);

	$Q="INSERT INTO `wp_postmeta`(`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES (null,$ID,'slide_template','')";
	$db->query($Q);

	$Q="INSERT INTO `wp_postmeta`(`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES (null,$ID,'rs_page_bg_color','')";
	$db->query($Q);

	$Q="INSERT INTO `wp_postmeta`(`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES (null,$ID,'_regular_price',$PRICE)";
	$db->query($Q);

	$Q="INSERT INTO `wp_postmeta`(`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES (null,$ID,'_edit_last','1')";
	$db->query($Q);

	$Q="INSERT INTO `wp_postmeta`(`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES (null,$ID,'total_sales',0)";
	$db->query($Q);

	$Q="INSERT INTO `wp_postmeta`(`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES (null,$ID,'_tax_status','taxable')";
	$db->query($Q);

	$Q="INSERT INTO `wp_postmeta`(`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES (null,$ID,'_tax_class','')";
	$db->query($Q);

	$Q="INSERT INTO `wp_postmeta`(`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES (null,$ID,'_manage_stock','no')";
	$db->query($Q);

	$Q="INSERT INTO `wp_postmeta`(`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES (null,$ID,'_backorders','no')";
	$db->query($Q);

	$Q="INSERT INTO `wp_postmeta`(`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES (null,$ID,'_sold_individually','no')";
	$db->query($Q);

	$Q="INSERT INTO `wp_postmeta`(`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES (null,$ID,'_virtual','no')";
	$db->query($Q);

	$Q="INSERT INTO `wp_postmeta`(`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES (null,$ID,'_downloadable','no')";
	$db->query($Q);

	$Q="INSERT INTO `wp_postmeta`(`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES (null,$ID,'_download_limit',0)";
	$db->query($Q);

	$Q="INSERT INTO `wp_postmeta`(`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES (null,$ID,'_download_expiry',0)";
	$db->query($Q);

	$Q="INSERT INTO `wp_postmeta`(`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES (null,$ID,'_stock',null)";
	$db->query($Q);

	$Q="INSERT INTO `wp_postmeta`(`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES (null,$ID,'_stock_status','instock')";
	$db->query($Q);

	$Q="INSERT INTO `wp_postmeta`(`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES (null,$ID,'_wc_average_rating',0)";
	$db->query($Q);

	$Q="INSERT INTO `wp_postmeta`(`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES (null,$ID,'_wc_review_count',0)";
	$db->query($Q);

	$Q="INSERT INTO `wp_postmeta`(`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES (null,$ID,'_product_version','4.0.1')";
	$db->query($Q);

	$Q="INSERT INTO `wp_postmeta`(`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES (null,$ID,'_wp_old_slug','$PNAME')";
	$db->query($Q);

//FIN

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
			$Q="INSERT INTO `wp_postmeta`(`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES (null,$ID,'_thumbnail_id',$photo)";
			$db->query($Q);
		}
		else
		{
			$PHOTOS.=$photo.", ";
		}
		$cont++;
	}
	$Q="INSERT INTO `wp_postmeta`(`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES (null,$ID,'_product_image_gallery','$PHOTOS')";
	$db->query($Q);
}
?>
<script type="text/javascript">
	window.alert("Producto agregado con éxito")
	window.location.href="../dashboard.php";
</script>