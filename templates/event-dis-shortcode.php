<?php
$events = get_field('events', 'options');

if(!empty($events)){

    echo '<div class="copy content-block upcoming-events-mini full-cal">
            <h2>'.get_field('events_title', 'options').'</h2>

            <ul>';
    $calcount = 0;
    foreach($events as $k => $event){
        $calcount++;
        $ical_link = esc_url(plugins_url('events-plugin/api/icalsingle.php?'));
        $ical_link .= 'sdate='.$event['event_start_date'];
        $ical_link .= '&edate='.$event['event_end_date'];

        $event_title = str_replace("&amp;", "xax", $event['event_details']);
        $ical_link .= '&title='.$event_title;

        $ical_link .= '&loc=Two Moors Primary School';

        if(isset($event['event_notes']) && !empty($event['event_notes'])){
            $event_notes = str_replace("&amp;", "xax", $event['event_notes']);
            $ical_link .= '&desc='.$event_notes;
        }

        $ical_link .= '&prodid=tm.shakecreative.net//Two Moors Primary School';
        $ical_link .= '&uid=tm.shakecreative.net/';

        $date = date_format(date_create($event['event_start_date']), 'd-M-Y');
        $enddate = date_format(date_create($event['event_end_date']), 'd-M-Y');

        $year = date_format(date_create($event['event_start_date']), 'Y');

        if(isset($prevyear) && $prevyear != $year){
            //$extraclass = ' newyear';
            $extraclass = '';
            $yearchange = true;
        } else {
            $extraclass = '';
            $yearchange = false;
        }
        if(!empty($event['event_end_date'])){
            $extraclass .= ' inc-end-date';
        }
        if(!empty($event['event_notes'])){
            $extraclass .= ' inc-event-notes';
        }
        $prevyear = $year;
        $today = date("Y-m-d");
        $expire = $enddate; //from database

        $today_time = strtotime($today);
        $expire_time = strtotime($expire);
        $oddeven = ( $k % 2 ) ? ' odd' : ' even';
        $event_notes = '';
        if($event['event_notes']){
            $event_notes = '<br/><span>'.$event['event_notes'].'</span>';
        }
        if($yearchange == true || $calcount == 1){ echo'<li class="year-break">'.$year.'</li>'; }
        echo '<li class="event ' .$oddeven.$extraclass.'">
                            <div class="event-date"> <span>'.date_format(date_create($event['event_start_date']), 'd').'</span>'.date_format(date_create($event['event_start_date']), 'M').'</div>';
        if(!empty($event['event_end_date'])){ echo '<div class="event-date date-to">to</div> <div class="event-date end-date"> <span>'.date_format(date_create($event['event_end_date']), 'd').'</span>'.date_format(date_create($event['event_end_date']), 'M').'</div>'; }
        echo '<div class="event-desc"><a href="'.$ical_link.'" class="calendar-icon" alt="add to outlook/ical"></a>'.$event['event_details'].$event_notes.'</div>
                    </li>';

    }
    echo '</ul>
        </div>';

} else {
    echo '
        <div class="copy content-block term-dates">
            <h2>Events Calendar</h2>
            <div class="well well-md no-content">
                <p><strong>No Calendar Events to Display</strong></p>
                <p>You have not set up any events yet, click the edit button to create some.</p>
            </div>
        </div>';
}
