<?php
global $post;

$term_dates = get_field('term_dates', 'options');
$event_dates = get_field('events', 'options');
$today = time();
$cal_count = 0;

$event_translate = array(
    'term_start_date' => ' term starts',
    'term_end_date' => ' term ends',
    'term_half_start' => ' half term starts',
    'term_half_end' => ' half term ends'
);
$i=0;
if(!empty($term_dates)) {
    foreach($term_dates as $k => $tdate){

        foreach($event_translate as $k => $tran){
            $temp = array(
                'event_start_date' => $tdate[$k],
                'event_end_date' => null,
                'event_details' => $tdate['term_details'] . $tran,
                'event_notes' => null,
                'event_class' => 'event-key'
            );
            $event_dates[] = $temp;
        }
    }
}
if(!empty($event_dates)) {
    foreach($event_dates as $k => $tdate){
        $order[ $k ] = $tdate['event_start_date'];
    }
    array_multisort( $order, SORT_ASC, $event_dates );
}

echo'<div class="content-block upcoming-events-mini side-events">';

if(!empty($event_dates)) {
    echo '<ul>';
    foreach($event_dates as $k => $event) {
        $date = date_format(date_create($event['event_start_date']), 'l jS F Y');
        if(strtotime($date) >= $today){
            $year = date('Y', strtotime($date));
            if(isset($prevyear) && $prevyear != $year){
                $extraclass = ' newyear';
            }
            else {
                $extraclass = '';
            }
            $prevyear = $year;
            $cal_count++;
            if($cal_count > 5){
                break;
            }
            echo '<li class="';
            if(!empty($event['event_class'])) {
                echo $event['event_class'].$extraclass;
            }
            else {
                echo $extraclass;
            }
            echo '"><div class="event-date"> <span>'.date('d', strtotime($date)).'</span>'.date('M', strtotime($date)).' </div>
					<div class="event-desc">'.$event['event_details'].'</div>
					</li>';
        }
        $i++;
    }

    echo '</ul>';
} else {
    echo '	
			<div class="well well-md no-content">
				<p><strong>No Events to Display</strong></p>
				<p>You have not set up any calendar events yet, click the edit button to create some.</p>
			</div>';
}
echo '</div>';
