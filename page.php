<?php
	$author_name = "Rosé-Marii Randlaht";
	//echo $author_name;
	$full_time_now = date("d.m.Y H:i:s");
	$weekday_names_et = ["esmaspäev", "teisipäev", "kolmapäev", "neljapäev", "reede", "laupäev", "pühapäev"];
	//echo $weekday_names_et[2];
	//$weekday_now = date("N");
	$hour_now = date("H");
	$part_of_day  = "suvaline hetk";
	// == on võrdne,   != pole võrdne ,   <    >    <=    >=    
	if($hour_now < 7) {
		$part_of_day = "uneaeg";
	} 
	// and(&)     or()
	if($hour_now >= 8 and $hour_now < 18) {
		$part_of_day = "kooliaeg";
	}
	
	// vaatame semestri pikkust ja kulgemist
	$semester_begin = new DateTime("2022-09-05");
	$semester_end = new DateTime("2022-12-18");
	$semester_duration = $semester_begin->diff($semester_end);
	$semester_duration_days = $semester_duration->format("%r%a");
	$from_semester_begin = $semester_begin->diff(new DateTime("now"));
	$from_semester_begin_days = $from_semester_begin->format("%r%a");
	
	//leondan massiivi liikmeid
	//juhuslik arv
	//echo mt_rand(1, 9);
	// juhuslik element massiivist
	//echo $weekday_names_et[mt_rand(0, count($weekday_names_et) - 1)];
    
    
    //$weekday_now = $weekday_names_et[mt_rand(0, count($weekday_names_et) - 1)];

    //if($weekday_now <= 4) {
        //$day_of_week = "koolipäev"
    //}

    //if($weekday_now > 4) {
        //$day_of_week = "vaba päev"
    //}

    //if($day_of_week = "koolipäev") {
        
    //}

    //if($day_of_week = "vaba päev") {
        
    //}
	
	// kataloogi sisu lugemine
	
	$photo_dir = "photos/";
	//$all_files = scandir($photo_dir);
	
	// saab jpnnakalt näha, mis massiivi sees
	
	//uus_masasiiv = array_slice(mis massiiv, mis kohast alates)
	$all_files = array_slice(scandir($photo_dir), 2);
	
	// saab jpnnakalt näha, mis massiivi sees
	//var_dump($all_files)
    
	$photo_html = null; 
	
	//tsükkel 
	/*for($i = 0; $i < count($all_files); $i ++) {
		echo $all_files[$i];
	}*/
	
	/*foreach($all_files as $file_name) {
		echo $file_name . " | ";
	}*/
	
	//kontrollin kas pilt on pilt(loetlen lubatud failitüübid)
	$allowed_photo_types = ["image/jpeg", "image/png"];
	$photo_files = [];
	foreach($all_files as $file_name) {
		$file_info = getimagesize($photo_dir .$file_name);
		if(isset($file_info[!"mime"])) {
			if (in_array($file_info["mime"], $allowed_photo_types)) {
				array_push($photo_files, $file_name);
			}
		}
	}
	
	var_dump($photo_files);
	$photo_html = '<img src = "' . $photo_dir .$photo_files[mt_rand(0, count($photo_files) - 1)] . '" alt = "Tallinna pilt">' ; 
	
	//vormi info kasutamine
	$adjective_html = null; 
	if(isset($_POST["todays_adjective_input"]) and !empty($_POST["todays_adjective_input"])) {
		$adjective_html = "<p>Tänase kohta on arvatud: " .$_POST["todays_adjective_input"] . ".</p>";
	}
	
	//teen fotode rippmenüü
	$select_html = '<option value= "" selected disabled>Vali pilt</option>'; 
	for($i = 0; $i < count($photo_files); $i ++) {
		$select_html .= '<option value ="' .$i .'">';
		$select_html .= $photo_files[$i];
		$select_html .= "</option> \n";
	}
	
	if(isset($_POST["photo_select"]) and $_POST["photo_select"] >= 0) {
		//kõik mida vaja teha
	}
	
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title><?php echo $author_name; ?>, veebiprogrammeerimine</title>
	</head>
	<body>
		<h1>Rosé-Marii Randlaht, veebiprogrammeerimine</h1>
		<p>See leht on loodud õppetöö raames ja ei sisalda tõsist infot, mjäu!</p>
		<p>Õppetöö toimus <a href="https://www.tlu.ee/">Tallinna Ülikoolis</a> Digitehnoloogia instituudis.</p>
		
		<p>Lehe avamise hetk: <?php echo $weekday_names_et[mt_rand(0, count($weekday_names_et) - 1)] .  ", " . $full_time_now; ?></p>
		<p>Praegu on <?php echo $part_of_day; ?></p>
		<p>Semester edeneb <?php echo $from_semester_begin_days . "/" . $semester_duration_days; ?></p>
		
		<a href="https://www.tlu.ee/">
			<img src="pics/tlu_41.jpg" alt="Tallinna Ülikooli Astra hoone"></img>
		</a>
		<br>
		
		<form method="POST">
			<input type = "text" id = "todays_adjective_input" name = "todays_adjective_input" placeholder = "omadussõna tänase kohta">
			<input type = "submit" id = "todays_adjective_submit" name = "todays_adjective_submit" value = "saada omadussõna">
		</form>
		
		<?php echo $adjective_html; ?>
		
		<br>
		
		<form method="POST">
			<select id = "photo_select" name = "photo_select">
				<?php echo $select_html; ?>
			</select>
			<input type = "submit" id = "photo_submit" name = "photo_submit" placeholder = "OK">
		</form>
		
		<?php echo $photo_html; ?>
	</body>
</html>