<?php
session_start();
require_once __DIR__."/../Tools/PDO.php";
$ID=$_POST["ID"];

if (!empty($_FILES)) {
	$ds = DIRECTORY_SEPARATOR;
$storeFolder = __DIR__.'/../../'.$ds."wp-content".$ds."uploads".$ds."products";
//$storeFolder = '../Files';
$guid="";
$Q="SELECT * from wp_options where option_name='siteurl'";
	foreach ($db->query($Q) as $Row) {
		$guid=$Row["option_value"];
	}
	$mime=$_FILES['file']['type'];
	$N=$_FILES['file']['name'];
	$guid.="/wp-content/uploads/products/".$N;
$Q="INSERT INTO `wp_posts`(`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES (null,1,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,'$ID','$N','','inherit','open','open','','$N','','',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,'',0,'$guid',0,'attachment','$mime',0)";
$db->query($Q);
$ID=$db->LastInsertID();

$Q="INSERT INTO `wp_postmeta`(`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES (null,$ID,'_wp_attached_file','products/$N')";
$db->query($Q);
$b='a:5:{s:5:"width";i:1920;s:6:"height";i:1080;s:4:"file";s:20:"products/$N";s:5:"sizes";a:23:{s:6:"medium";a:4:{s:4:"file";s:20:"$N";s:5:"width";i:300;s:6:"height";i:169;s:9:"mime-type";s:10:"image/jpeg";}s:5:"large";a:4:{s:4:"file";s:21:"$N";s:5:"width";i:1024;s:6:"height";i:576;s:9:"mime-type";s:10:"image/jpeg";}s:9:"thumbnail";a:4:{s:4:"file";s:20:"$N";s:5:"width";i:150;s:6:"height";i:150;s:9:"mime-type";s:10:"image/jpeg";}s:12:"medium_large";a:4:{s:4:"file";s:20:"$N";s:5:"width";i:768;s:6:"height";i:432;s:9:"mime-type";s:10:"image/jpeg";}s:9:"1536x1536";a:4:{s:4:"file";s:21:"$N";s:5:"width";i:1536;s:6:"height";i:864;s:9:"mime-type";s:10:"image/jpeg";}s:14:"post-thumbnail";a:4:{s:4:"file";s:20:"$N";s:5:"width";i:260;s:6:"height";i:146;s:9:"mime-type";s:10:"image/jpeg";}s:5:"50x50";a:4:{s:4:"file";s:18:"$N";s:5:"width";i:50;s:6:"height";i:28;s:9:"mime-type";s:10:"image/jpeg";}s:14:"clients-slider";a:4:{s:4:"file";s:19:"$N";s:5:"width";i:133;s:6:"height";i:75;s:9:"mime-type";s:10:"image/jpeg";}s:14:"slider-content";a:4:{s:4:"file";s:21:"$N";s:5:"width";i:1630;s:6:"height";i:860;s:9:"mime-type";s:10:"image/jpeg";}s:12:"testimonials";a:4:{s:4:"file";s:18:"$N";s:5:"width";i:85;s:6:"height";i:85;s:9:"mime-type";s:10:"image/jpeg";}s:9:"blog-navi";a:4:{s:4:"file";s:18:"$N";s:5:"width";i:80;s:6:"height";i:80;s:9:"mime-type";s:10:"image/jpeg";}s:12:"portfolio-mf";a:4:{s:4:"file";s:22:"$N";s:5:"width";i:1280;s:6:"height";i:1000;s:9:"mime-type";s:10:"image/jpeg";}s:14:"portfolio-mf-w";a:4:{s:4:"file";s:21:"$N";s:5:"width";i:1280;s:6:"height";i:500;s:9:"mime-type";s:10:"image/jpeg";}s:14:"portfolio-mf-t";a:4:{s:4:"file";s:21:"$N";s:5:"width";i:768;s:6:"height";i:1080;s:9:"mime-type";s:10:"image/jpeg";}s:14:"portfolio-list";a:4:{s:4:"file";s:21:"$N";s:5:"width";i:1920;s:6:"height";i:750;s:9:"mime-type";s:10:"image/jpeg";}s:14:"blog-portfolio";a:4:{s:4:"file";s:20:"$N";s:5:"width";i:960;s:6:"height";i:750;s:9:"mime-type";s:10:"image/jpeg";}s:11:"blog-single";a:4:{s:4:"file";s:21:"$N";s:5:"width";i:1200;s:6:"height";i:480;s:9:"mime-type";s:10:"image/jpeg";}s:21:"woocommerce_thumbnail";a:5:{s:4:"file";s:20:"$N";s:5:"width";i:300;s:6:"height";i:300;s:9:"mime-type";s:10:"image/jpeg";s:9:"uncropped";b:0;}s:18:"woocommerce_single";a:4:{s:4:"file";s:20:"$N";s:5:"width";i:600;s:6:"height";i:338;s:9:"mime-type";s:10:"image/jpeg";}s:29:"woocommerce_gallery_thumbnail";a:4:{s:4:"file";s:20:"$N";s:5:"width";i:300;s:6:"height";i:300;s:9:"mime-type";s:10:"image/jpeg";}s:12:"shop_catalog";a:4:{s:4:"file";s:20:"$N";s:5:"width";i:300;s:6:"height";i:300;s:9:"mime-type";s:10:"image/jpeg";}s:11:"shop_single";a:4:{s:4:"file";s:20:"$N";s:5:"width";i:600;s:6:"height";i:338;s:9:"mime-type";s:10:"image/jpeg";}s:14:"shop_thumbnail";a:4:{s:4:"file";s:20:"$N";s:5:"width";i:300;s:6:"height";i:300;s:9:"mime-type";s:10:"image/jpeg";}}s:10:"image_meta";a:12:{s:8:"aperture";s:1:"0";s:6:"credit";s:0:"";s:6:"camera";s:0:"";s:7:"caption";s:0:"";s:17:"created_timestamp";s:1:"0";s:9:"copyright";s:0:"";s:12:"focal_length";s:1:"0";s:3:"iso";s:1:"0";s:13:"shutter_speed";s:1:"0";s:5:"title";s:0:"";s:11:"orientation";s:1:"0";s:8:"keywords";a:0:{}}}';
$Q="INSERT INTO `wp_postmeta`(`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES (null,$ID,'_wp_attachment_metadata','$b')";
$db->query($Q);
//$Q="INSERT INTO `wp_postmeta`(`meta_id`, `post_id`, `meta_key`, `meta_value`) VALUES (null,$ID,'_wp_attached_file','products/$N')";

	//$Q="SELECT * from `wp_postmeta` where meta_key='_product_image_gallery' and post_id=$ID"
/*
	$Q="UPDATE `wp_postmeta` SET meta_value=CONCAT(meta_value, $IDF,',') where meta_key='_product_image_gallery' and post_id=$ID";
	$db->query($Q);
*/


    $tempFile = $_FILES['file']['tmp_name'];
    $targetPath = $storeFolder . $ds;
    $targetFile =  $targetPath. $_FILES['file']['name'];
    move_uploaded_file($tempFile,$targetFile);
}
//echo "hola";
?>    