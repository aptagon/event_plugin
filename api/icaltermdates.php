<?php

  include('wp-load.php');

  $term_dates = get_field('term_dates', 'options');
  
  //print('<pre>');
  //print_r($term_dates);
  //print('</pre>');

  //if(isset($_GET['prodid'])){ $prodID = $_GET['prodid']; };
  //if(isset($_GET['tzone'])){ $timezone = $_GET['tzone']; };
  //if(isset($_GET['uid'])){ $uid = $_GET['uid']; };
  //if(isset($_GET['sdate'])){ $startDate = $_GET['sdate']; };
  //if(isset($_GET['edate'])){ $endDate = $_GET['edate']; };
  //if(isset($_GET['title'])){ $title = $_GET['title']; };
  //if(isset($_GET['desc'])){
  //  $desc = $_GET['desc'];
  //  $desc = str_replace("xax", "&", $desc);
  //};
  //if(isset($_GET['loc'])){ $loc = $_GET['loc']; };
  //
  //if(!empty($prodID)){
  //    $event_prod_id = $prodID;
  //} else {
      $event_prod_id = "twomoors.devon.sch.uk//Two Moors Primary School";
  //}
  //
  //if(!empty($timezone)){
  //    $event_timezone = "X-WR-TIMEZONE:".$timezone;
  //} else {
      $event_timezone = "X-WR-TIMEZONE:Europe/London";
  //}
  //
  //if(!empty($uid)){
  //    $event_uid = $uid;
  //} else {
      $event_uid = "twomoors.devon.sch.uk";
  //}
  //
  //if(!empty($endDate)){
  //    $event_end_date = "DTEND;VALUE=DATE:".$endDate."\r\n";
  //} else {
  //    $event_end_date = '';
  //}
  //
  //if(!empty($desc)){
  //    $event_description = "DESCRIPTION:".$desc."\r\n";
  //    //print($desc.'<br />');
  //} else {
  //    $event_description = '';
  //}
  //
  //if(!empty($loc)){
      $event_location = "LOCATION:Two Moors Primary School"."\r\n";
  //} else {
  //    $event_location = 'Abbey School Torquay';
  //}

  
  $ical = '';
  $ical .= "BEGIN:VCALENDAR"."\r\n";
  $ical .= "VERSION:2.0"."\r\n";
  $ical .= "PRODID:-//".$event_prod_id."\r\n";
  $ical .= "X-WR-TIMEZONE:".$event_timezone."\r\n";

  
foreach($term_dates as $date){
    
  
  $half_term_title = 'Half Term';

  $half_start = date_format(date_create($date['term_1-2_start']), 'd-M-Y');
  $half_end = date_format(date_create($date['term_1-2_end']), 'd-M-Y');

  $half_diff = strtotime($half_end) - strtotime($half_start);
      $half_diff = round($half_diff / (60 * 60 * 24));

  if($half_diff > 7){
      $half_term_title = '2 Week Half Term';
  }
  
  // first the actual term dates
  $ical .= "BEGIN:VEVENT"."\r\n";
  $ical .= "DTSTAMP:" . gmdate('Ymd').'T'. gmdate('His') . "Z"."\r\n";
  $ical .= "UID:" . md5(uniqid(mt_rand(), true)) . $event_uid."\r\n";
  $ical .= "DTSTART;VALUE=DATE:".$date['term_start_date']."\r\n";
  $ical .= "DTEND;VALUE=DATE:".$date['term_end_date']."\r\n";
  $ical .= "SUMMARY:".$date['term_details']."\r\n";
  $ical .= "DESCRIPTION:Term finishes at ".$date['term_end_type']."\r\n";
  $ical .= $event_location;
  $ical .= "END:VEVENT"."\r\n";
  
  // now for the half term
  $ical .= "BEGIN:VEVENT"."\r\n";
  $ical .= "DTSTAMP:" . gmdate('Ymd').'T'. gmdate('His') . "Z"."\r\n";
  $ical .= "UID:" . md5(uniqid(mt_rand(), true)) . $event_uid."\r\n";
  $ical .= "DTSTART;VALUE=DATE:".$date['term_1-2_start']."\r\n";
  $ical .= "DTEND;VALUE=DATE:".$date['term_1-2_end']."\r\n";
  $ical .= "SUMMARY:".$half_term_title."\r\n";
  $ical .= $event_location;
  $ical .= "END:VEVENT"."\r\n";


  
}

  $ical .= "END:VCALENDAR";
  

  header('Content-type: text/calendar; charset=utf-8');
  header('Content-Disposition: inline; filename=term-dates.ics');

  exit;
 
?>