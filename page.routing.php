<?php /* $Id$ */
//	License for all code of this FreePBX module can be found in the license file inside the module directory
//	Copyright 2006-2015 Schmooze Com Inc.
//	Copyright (C) 2005 Ron Hartmann (rhartmann@vercomsystems.com)
//

if (!defined('FREEPBX_IS_AUTH')) { die('No direct script access allowed'); }
$request = $_REQUEST;
if(!empty($request['id']) && $request['view'] == 'form'){
	$subhead = _("Edit Route");
} elseif(empty($request['id']) && $request['view'] == 'form'){
	$subhead = _("Add Route");
}
$tabindex = 0;
//
// Use a hash of the value inserted to get rid of duplicates
$dialpattern_insert = array();
$p_idx = 0;
$n_idx = 0;
$last_seq = count($routepriority)-1;
if ($action == 'populatenpanxx') {
	return true;
} 
$pageinfo = '<div class="well well-info">';
$pageinfo .= _('This page is used to manage your outbound routing.');
$pageinfo .= '</div>';
switch($request['view']){
	case "form":
		if(isset($request['id'])){
			$extdisplay = $request['id'];
			$id = $request['id'];
			$route_info = core_routing_get($extdisplay);
			$dialpattern_array = core_routing_getroutepatternsbyid($extdisplay);
			$trunkpriority = core_routing_getroutetrunksbyid($extdisplay);
			$routepass = $route_info['password'];
			$emergency = $route_info['emergency_route'];
			$intracompany = $route_info['intracompany_route'];
			$mohsilence = $route_info['mohclass'];
			$outcid = $route_info['outcid'];
			$outcid_mode = $route_info['outcid_mode'];
			$time_group_id = $route_info['time_group_id'];
			$route_seq = $route_info['seq'];
			$routename = $route_info['name'];
			$dest = $route_info['dest'];
			$routelist = core_routing_list();
			$viewinfo = array(
							'formAction' => 'editroute',
							'extdisplay' => $extdisplay,
							'id' => $id,
							'route_info' => $route_info,
							'dialpattern_array' => $dialpattern_array,
							'trunkpriority' => $trunkpriority,
							'routepass' => $routepass,
							'emergency' => $emergency,
							'intracompany' => $intracompany,
							'mohsilence' => $mohsilence,
							'outcid' => $outcid,
							'outcid_mode' => $outcid_mode,
							'time_group_id' => $time_group_id,
							'route_seq' => $route_seq,
							'routename' => $routename,
							'dest' => $dest,
							);
		}else{
			$route_seq = $last_seq+1;
			if (!isset($dialpattern_array)) {
				$dialpattern_array = array();
			}
			$viewinfo = array(
							'formAction' => 'addroute',
							'route_seq' => $route_seq,
							'dialpattern_array' => $dialpattern_array,
							'trunkpriority' => $trunkpriority,
						);
		}
		$content = load_view(__DIR__.'/views/routing/form.php', $viewinfo);
		$pageinfo = '';
	break;
	default:
		//$pageinfo = '';
		$routelist = core_routing_list();
		$content = load_view(__DIR__.'/views/routing/grid.php', array('routelist' => $routelist));
	break;	
}
?>

<div class="container-fluid">
	<h1><?php echo _('Outbound Routes')?></h1>
	<h3><?php echo $subhead ?></h3>
	<?php echo $pageinfo?>
	<div class = "display full-border">
		<div class="row">
			<div class="col-sm-9">
				<div class="fpbx-container">
					<div class = "display full-border">
						<?php echo $content ?>
					</div>
				</div>
			</div>
			<div class="col-sm-3 hidden-xs bootnav">
				<div class="list-group">
					<?php echo load_view(__DIR__.'/views/routing/bootnav.php');?>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="modules/core/assets/js/routing/routing.js">
</script>
