<?php
/*
	Plugin Name: Calendar Plugin
	Plugin URI: https://github.com/muhammedfatih/wordpress-mf-calendar-plugin
	Description: Placing calendar plugin to wordpress site, with administrator panel.
	Version: 1.0
	Author: muhammedfatih
	Author URI: http://www.mfatih.com
	License: GNU
*/

if (preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF']))die('You are not allowed to call this page directly.');
 
register_activation_hook(__FILE__, 'mf_calender_default_install');
function mf_calender_default_install(){
	add_option('mf_calendar_days', json_encode(array()));
	add_option('mf_calendar_descriptions', json_encode(array()));
	add_option('mf_calendar_links', json_encode(array()));
}

register_deactivation_hook(__FILE__, 'mf_calendar_default_uninstall');
function mf_calendar_default_uninstall(){
	delete_option('mf_calendar_days');
	delete_option('mf_calendar_descriptions');
	delete_option('mf_calendar_links');
}
		
add_action('admin_menu', 'mf_calendar_admin');
function mf_calendar_admin(){add_options_page('MF Calendar Plugin','MF Calendar Plugin', '8', 'mf_calendar', 'mf_calendar_admin_page');}
function mf_calendar_admin_page() {
	if ($_POST['hidden'] == 'ok') {
		$limit=0;
		$mf_calendar_posts_days = $_POST['mf_calendar_posts_days'];$limit=count($mf_calendar_posts_days);
		$mf_calendar_posts_descriptions = $_POST['mf_calendar_posts_descriptions'];if($limit<count($mf_calendar_posts_descriptions))$limit=count($mf_calendar_posts_descriptions);
		$mf_calendar_posts_links = $_POST['mf_calendar_posts_links'];if($limit<count($mf_calendar_posts_links))$limit=count($mf_calendar_posts_links);
		$deletes = $_POST['delete'];if($limit<count($deletes))$limit=count($deletes);

		for($i=0;$i<$limit;$i++){
			$e1=$mf_calendar_posts_days[$i];
			$e2=$mf_calendar_posts_descriptions[$i];
			$e3=$mf_calendar_posts_links[$i];
			$e4=$deletes[($i+1)];
			if($e1=="" || $e4==1){
				unset($mf_calendar_posts_days[$i]);$mf_calendar_posts_days=array_values($mf_calendar_posts_days);
				unset($mf_calendar_posts_links[$i]);$mf_calendar_posts_links=array_values($mf_calendar_posts_links);
				unset($mf_calendar_posts_descriptions[$i]);$mf_calendar_posts_descriptions=array_values($mf_calendar_posts_descriptions);
			}
		}

		update_option('mf_calendar_days', json_encode($mf_calendar_posts_days));
		update_option('mf_calendar_links', json_encode($mf_calendar_posts_links));
		update_option('mf_calendar_descriptions', json_encode($mf_calendar_posts_descriptions));

		?>
		<div class="updated"><p><strong><?php _e('Option(s) saved.'); ?></strong></p></div>
		<?php
	}
	$limit=0;
	$days=json_decode(get_option("mf_calendar_days"));$limit=count($days);
	$descriptions=json_decode(get_option("mf_calendar_descriptions"));if($limit<count($descriptions))$limit=count($descriptions);
	$links=json_decode(get_option("mf_calendar_links"));if($limit<count($links))$limit=count($links);
	?>
	<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css">
	<link rel="stylesheet" href="http://bootsnipp.com/dist/bootsnipp.min.css?ver=70eabcd8097cd299e1ba8efe436992b7">

	<form class="form-horizontal" method="POST" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
		<fieldset>
		<legend>MF Calendar Plugin</legend>
		<div class="form-group">
			<?php
				for($i=0;$i<$limit;$i++){
					if($days[$i]=="")continue;
			?>
			<div class="container-fluid">
				<div class="col-md-3"><input id="mf_calendar_posts_days[]" name="mf_calendar_posts_days[]" type="text" value="<?php echo $days[$i]; ?>" placeholder="14/01/2015" class="form-control input-md"></div>
				<div class="col-md-3"><input id="mf_calendar_posts_links[]" name="mf_calendar_posts_links[]" type="text" value="<?php echo $links[$i]; ?>" placeholder="Link To Go" class="form-control input-md"></div>
				<div class="col-md-3"><textarea class="form-control" id="mf_calendar_posts_descriptions[]" name="mf_calendar_posts_descriptions[]"><?php echo $descriptions[$i]; ?></textarea><hr/></div>
				<div class="col-md-3"><input type="hidden" name="delete[]" id="delete" value="0"><input type="checkbox" name="delete[]" id="delete" value="1">Delete</div>
			</div>
			<?php
				}
			?>
			<div class="container-fluid">
				<div class="col-md-4"><input id="mf_calendar_posts_days[]" name="mf_calendar_posts_days[]" type="text" placeholder="14/01/2015" class="form-control input-md"></div>
				<div class="col-md-4"><input id="mf_calendar_posts_links[]" name="mf_calendar_posts_links[]" type="text" placeholder="Link To Go" class="form-control input-md"></div>
				<div class="col-md-4"><textarea class="form-control" id="mf_calendar_posts_descriptions[]" name="mf_calendar_posts_descriptions[]"></textarea><hr/></div>
				<input type="hidden" name="delete[]" id="delete" value="0">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-4 control-label" for="hidden"></label>
			<div class="col-md-4">
				<input type="hidden" name="hidden" value="ok" />
				<button id="submit" name="submit" value="<?php _e('Save Changes'); ?>" class="btn btn-primary">Save</button>
			</div>
		</div>
		</fieldset>
	</form>	 
	<?php 
}

function get_mf_calendar_all_days(){return json_decode(get_option('mf_calendar_days'));}
function get_mf_calendar_all_links(){return json_decode(get_option('mf_calendar_links'));}
function get_mf_calendar_all_descriptions(){return json_decode(get_option('mf_calendar_descriptions'));}
function get_mf_calendar_one_day($index){$all=get_mf_calendar_all_days();echo $all[$index];}
function get_mf_calendar_one_link($index){$all=get_mf_calendar_all_links();echo $all[$index];}
function get_mf_calendar_one_description($index){$all=get_mf_calendar_all_descriptions();echo $all[$index];}

?>