<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );

function woo_remove_product_tabs( $tabs ) {

	unset( $tabs['reviews'] ); 			// Remove the reviews tab
	$tabs['media_tab'] = array(
		'title' => 'Media',
		'priority' => '40',
		'callback' => 'show_product_video',
	);

	return $tabs;
}
function show_product_video() {
	if(function_exists('get_field')){
		$video = get_field('product_media');
		$image = get_field('image_gallery');


		echo $video;
		echo $image;
	}

}
$tabs = apply_filters( 'woocommerce_product_tabs', array() );
//echo '<pre>' . print_r($tabs, true) . '</pre>';

if ( ! empty( $tabs ) ) : ?>

	<div class="woocommerce-tabs wc-tabs-wrapper">
		<ul class="tabs wc-tabs">
			<?php foreach ( $tabs as $key => $tab ) : ?>
				<li class="<?php echo esc_attr( $key ); ?>_tab">
					<a href="#tab-<?php echo esc_attr( $key ); ?>"><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', esc_html( $tab['title'] ), $key ); ?></a>
				</li>
			<?php endforeach; ?>
		</ul>
		<?php foreach ( $tabs as $key => $tab ) : ?>
			<div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--<?php echo esc_attr( $key ); ?> panel entry-content wc-tab" id="tab-<?php echo esc_attr( $key ); ?>">
				<?php if ($key != 'media_tab') { ?>
				<?php call_user_func( $tab['callback'], $key, $tab ); ?>
				<?php } else {
					$imgMy = explode('DEL', str_replace('<a ', '<a rel="lightbox"', str_replace('</a>', '</a>DEL', str_replace("</p>", "",str_replace("<p>", "", get_field('image_gallery', get_the_ID()))))));
					array_splice($imgMy, count($imgMy)-1, 1);
					$imgMy = array_merge($imgMy, explode('DEL',  get_field('product_media', get_the_ID()))); ?>
					<div class="flexbox-container" id="myGrid" >
						<?php $refts = 0; foreach ($imgMy as $images) { if (isset($images)){?>

							<div class="col-lg-3 col-md-3 col-sm-2 col-xs-1 myGrid"><?= $images ?></div>

						<?php }} ?>
					</div>
					<script>
						function myGrid()
						{
							var grid = jQuery('div#myGrid > div.myGrid');

							var countItem = 4;
							var countRow = Math.floor(grid.length / countItem);
							var restItem = grid.length - countRow * countItem;
							var str = '';
							var txt = '';

							if (grid.length > 0) {
								for (var i = 0, l = grid.length; i < l; i++) {
										txt = '<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 text-center">';
										//txt += grid[k].text();
										txt += jQuery('div#myGrid > div.myGrid:eq(' + i + ')').html();
										txt += '</div>';
										str += txt;
								}
							}

							/*if (countRow > 0) {
								for (var i = 0; i < countRow; i++) {
									str = '';
									str += '';
									for (var k = i * countItem,  l = k + countItem;k < l; k++)
									{
										txt = '<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 text-center">';
										//txt += grid[k].text();
										txt += jQuery('div#myGrid > div.myGrid:eq(' + k + ')').html();
										txt += '</div>';
										str += txt;
									}
									str += '';
								}
							}
							if (restItem > 0) {
								str += '';
								for (var j = countRow * countItem,  fr = grid.length;j < fr; j++)
								{
									txt = '<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 text-center">';
									//txt += grid[j].text();
									txt += jQuery('div#myGrid > div.myGrid:eq(' + j + ')').html();
									txt += '</div>';
									str += txt;
								}
								str += '';
							}*/
							//console.log(str);
							return str;
						}
						jQuery('div#myGrid').html(myGrid());
					</script>
					<style>
						.flexbox-container {
							display: -ms-flexbox;
							display: -webkit-flex;
							display: flex;

							flex-wrap: wrap;

							-ms-flex-align: center;
							-webkit-align-items: center;
							-webkit-box-align: center;
							align-items: center;
						}
					</style>
				<?php }?>

			</div>
		<?php endforeach; ?>
	</div>
<?php endif; ?>
<?php
/*$imgMy = explode('DEL', str_replace('</a>', '</a>DEL', str_replace("</p>", "",str_replace("<p>", "", get_field('image_gallery', get_the_ID())))));
array_splice($imgMy, count($imgMy)-1, 1);
 $imgMy = array_merge($imgMy, explode('DEL', get_field('product_media', get_the_ID())));*/
//$cRow = floor($imgMy/4);
?>
<?/*= '<pre>' . print_r(array_slice($imgMy, 0, 4) , true) . '</pre>' */?>

<?php
/*
	for ($cursor = 0, $counter = count($imgMy); $cursor < $counter; $cursor++)
	{
		$core = [];
		if ($cursor % 4 == 0) {
			echo '<div style="display: flex;align-items: center;justify-content: center;">';
		}
		$core = [array_slice($imgMy, $cursor, 4)];
		foreach ($core as $value) {
			echo  '<div style="max-width: 50%;">' .  $value . '</div>';
		}
		if ($cursor % 4 == 0) {
			echo '<div style="display: flex;align-items: center;justify-content: center;">';
		}
		$cursor += 4;
	}

*/?>
<!--<div style="display: flex;align-items: center;justify-content: center;">-->
<!--<div class="row" id="myGrid" >
<?php /*$refts = 0; foreach ($imgMy as $images) { if (isset($images)){*/?>

	<div class="col-lg-3 col-md-3 col-sm-2 col-xs-1 myGrid"><?/*= $images */?></div>

<?php /*}} */?>
</div>
<script>
	function myGrid()
	{
		var grid = jQuery('div#myGrid > div.myGrid');

		var countItem = 4;
		var countRow = Math.floor(grid.length / countItem);
		var restItem = grid.length - countRow * countItem;
		var str = '';
		var txt = '';
		if (countRow > 0) {
			for (var i = 0; i < countRow; i++) {
				str = '';
				str += '<div class="row flexbox-container ">';
				for (var k = i * countItem,  l = k + countItem;k < l; k++)
				{
					txt = '<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">';
					//txt += grid[k].text();
					txt += jQuery('div#myGrid > div.myGrid:eq(' + k + ')').html();
					txt += '</div>';
					str += txt;
				}
				str += '</div>';
			}
		}
		 if (restItem > 0) {
			 str += '<div class="row flexbox-container">';
				 for (var j = countRow * countItem,  fr = grid.length;j < fr; j++)
				 {
					 txt = '<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">';
					 //txt += grid[j].text();
					 txt += jQuery('div#myGrid > div.myGrid:eq(' + j + ')').html();
					 txt += '</div>';
					 str += txt;
				 }
			 str += '</div>';
		 }
		//console.log(str);
		return str;
	}
	jQuery('div#myGrid').html(myGrid());
</script>
<style>
	.flexbox-container {
		display: -ms-flexbox;
		display: -webkit-flex;
		display: flex;

		-ms-flex-align: center;
		-webkit-align-items: center;
		-webkit-box-align: center;

		align-items: center;
	}
</style>-->
<!--</div>-->