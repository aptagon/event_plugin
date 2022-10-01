<?php

/* icalsingle.php?date=20120302&startTime=1300&endTime=1400&subject=Meeting&desc=Meeting%20to%20discuss%20processes.

 ?sdate=20140504
 &edate=20140524
 &title=Woo Test 5000
 &prodid=www.abbeyschool.co.uk//Abbey School Torquay
 &tzone=Europe/London
 &uid=abbeyschool.co.uk
 
 ?sdate=20140504&edate=20140524&title=Woo Test 5000&prodid=www.abbeyschool.co.uk//Abbey School Torquay&uid=abbeyschool.co.uk
 
 http://abbeyschool.dev/icalsingle.php?sdate=20140315&edate=&title=Foundation%20Dress%20Rehearsal&loc=Abbey%20School%20Torquay
 &desc=(Cygnets%20&amp;%20Yr%200)
 &prodid=www.abbeyschool.co.uk//Abbey%20School%20Torquay&uid=abbeyschool.co.uk
 
*/

  if(isset($_GET['prodid'])){ $prodID = $_GET['prodid']; };
  if(isset($_GET['tzone'])){ $timezone = $_GET['tzone']; };
  if(isset($_GET['uid'])){ $uid = $_GET['uid']; };
  if(isset($_GET['sdate'])){ $startDate = $_GET['sdate']; };
  if(isset($_GET['edate'])){ $endDate = $_GET['edate']; };
  if(isset($_GET['title'])){
    $title = $_GET['title'];
    $title = str_replace("xax", "&", $title);
    //print $title;
    //die();
  };
  if(isset($_GET['desc'])){
    $desc = $_GET['desc'];
    $desc = str_replace("xax", "&", $desc);
  };
  if(isset($_GET['loc'])){ $loc = $_GET['loc']; };
  
  if(!empty($prodID)){
      $event_prod_id = $prodID;
  } else {
      $event_prod_id = "www.shakecreative.co.uk//Shake Creative iCal Script";
  }
  
  if(!empty($timezone)){
      $event_timezone = "X-WR-TIMEZONE:".$timezone;
  } else {
      $event_timezone = "X-WR-TIMEZONE:Europe/London";
  }
  
  if(!empty($uid)){
      $event_uid = $uid;
  } else {
      $event_uid = "shakecreative.co.uk";
  }
  
  if(!empty($endDate)){
      $event_end_date = "DTEND;VALUE=DATE:".$endDate."\r\n";
  } else {
      $event_end_date = '';
  }
  
  if(!empty($desc)){
      $event_description = "DESCRIPTION:".$desc."\r\n";
      //print($desc.'<br />');
  } else {
      $event_description = '';
  }
  
  if(!empty($loc)){
      $event_location = "LOCATION:".$loc."\r\n";
  } else {
      $event_location = '';
  }
  
  
  $ical = '';
  $ical .= "BEGIN:VCALENDAR"."\r\n";
  $ical .= "VERSION:2.0"."\r\n";
  $ical .= "PRODID:-//".$event_prod_id."\r\n";
  $ical .= "X-WR-TIMEZONE:".$event_timezone."\r\n";

  $ical .= "BEGIN:VEVENT"."\r\n";
  $ical .= "DTSTAMP:" . gmdate('Ymd').'T'. gmdate('His') . "Z"."\r\n";
  $ical .= "UID:" . md5(uniqid(mt_rand(), true)) . $event_uid."\r\n";
  $ical .= "DTSTART;VALUE=DATE:".$startDate."\r\n";
  $ical .= $event_end_date; // optional
  $ical .= "SUMMARY:".$title."\r\n";
  $ical .= $event_description; // optional
  $ical .= $event_location; // optional
  $ical .= "END:VEVENT"."\r\n";
  
  $ical .= "END:VCALENDAR";

  header('Content-type: text/calendar; charset=utf-8');
  header('Content-Disposition: inline; filename='.url_friendly_string($title).'.ics');
  echo $ical;
  exit;
  
  
  function url_friendly_string($str){
    // convert spaces to '-', remove characters that are not alphanumeric
    // or a '-', combine multiple dashes (i.e., '---') into one dash '-'.
    $str = str_replace("&", "and", $str);
    $str = str_replace("&amp;", "", $str);
    $str = str_replace(" ", "-", $str);
    $str = preg_replace("/[^a-z0-9-]+/i", "", $str);
    $str = strtolower(preg_replace("([-]+)", "-", $str));
    return $str;
 }
  
?>