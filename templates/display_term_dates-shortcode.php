<?php
$term_dates = get_field('term_dates', 'options');
if(!empty($term_dates)){
    echo '<div class="copy content-block term-dates"> 
      <h2>'.get_field('term_dates_title', 'options').'</h2>';

    foreach($term_dates as $td){
        $half_message = '';
        $half_start = date_format(date_create($td['term_half_start']), 'l jS F Y');
        $half_end = date_format(date_create($td['term_half_end']), 'l jS F Y');
        $half_diff = strtotime($half_end) - strtotime($half_start);
        $half_diff = round($half_diff / (60 * 60 * 24));

        if($half_diff > 7){
            $half_message = '<span>2 WEEK</span> ';
        }
        echo '<h3>'.$td['term_details'].'</h3><p class="term-dates"><strong>DATES:</strong>'.date_format(date_create($td['term_start_date']), 'l jS F Y'). '-'.date_format(date_create($td['term_end_date']), 'l jS F Y'). '(' .$td['term_end_type'].' finish)<br />
                <strong> '. $half_message.' HALF TERM:</strong> '.$half_start.' - ' .$half_end.'</p>';
    }

    echo '<a href="'.esc_url(plugins_url('events-plugin/api/icaltermdates.php')).'" class="btn btn-primary">Click here to download these term dates to your calendar</a>
		</div>';
}
else {
    echo '<div class="copy content-block term-dates"> 
		<h2>Term Dates</h2>
		<div class="well well-md no-content">
			<p><strong>No Term Dates to Display</strong></p>
			<p>You have not set up any term dates yet, click the edit button to create some.</p>
		</div>
		</div>';
}
