<?php

/* $path = "http://localhost:8888/Totes/LASTONE/wp-content/themes/Reset/justincarr/upload/"; */
$path = "http://www.hwchronicle.com/wp-content/themes/Reset/justincarr/upload/";

class Tribute{
	
	function printpost($id){
		global $wpdb, $path;
		
		//check if $id exists in the messageid column of justincarrimages
		$imageresult = $wpdb->get_results("SELECT image FROM justincarrimages WHERE messageid='$id'");
		$imageexists = count($imageresult);
		$image;
		if($imageexists){
			$imageobject = $imageresult[0];
			$image = $imageobject->image;
			$image = $path.$image;
		}
		
		$results = $wpdb->get_results("SELECT * FROM justincarr WHERE id='$id'");
		$messageobject = $results[0];
		$message = nl2br( stripslashes( $messageobject->message ) );
		$name = stripslashes( $messageobject->name );
		$anon = $messageobject->anon;
?>
		<div class="post">
			<div class="message clearfix">
<?php
				if($imageexists){
?>
					<img src="<?=$image?>" class='imageattachment' />
<?php
				}
?>
				<?=$message?>
<?php
				if(!$anon){
?>
					<div class="byline">
						- <?=$name?>
					</div>
<?php
				}				
?>
			</div>
		</div>
<?php
	}	
	
	function echoposts(){
		global $wpdb;
		
		$results = $wpdb->get_results("SELECT * FROM justincarr ORDER BY id DESC");
		
		foreach($results as $value){
			$this->printpost($value->id);
		}
	}
}

?>