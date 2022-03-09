<?php
//https://github.com/wp-plugins/clickmeter-link-shortener-and-analytics/blob/master/clickmeter.php
function api_request($endpoint, $method, $body, $api_key, $associative=true){
    try {
        $args = array(
            'method' => $method,
            'timeout' => 120,
            'redirection' => 5,
            'httpversion' => '1.0',
            'blocking' => true,
            'headers' => array('Content-Type' => 'application/json', 'X-Clickmeter-Authkey' => $api_key),
            'body' => $body
        );
        $response = wp_remote_post($endpoint, $args);
        if ($response['response']['code'] != 200) {
            $subject = 'wp error api_request';
            $content = WPClickmeter::trace_variable($endpoint, "endpoint");
            $content = $content . WPClickmeter::trace_variable($body, "body");
            $content = $content . WPClickmeter::trace_variable($response, "response");
            WPClickmeter::to_email($subject, $content);
            echo "<div id='clickmeter-warning' class='error fade'>
					<p style='color:black'><strong>ClickMeter: </strong>Warning! Something went wrong calling our servers. Please try later or contact our
					<a target='_blank' href='mailto:support@clickmeter.com?subject=Error message from WordPress plugin'>support</a>.
					</p>	
				</div>";
            $response_body = $response['body'];
            WPClickmeter::store_option("clickmeter_last_apirequest_error", json_decode($response_body, $associative));
        } else {
            $response_body = $response['body'];
            return json_decode($response_body, $associative);
        }
    }catch (Exception $e){
        $subject = 'wp error api_request';
        $content = $e->getMessage() . "\n";
        $content = $content . $e->getTraceAsString() . "\n";
        WPClickmeter::to_email($subject, $content);
    }
}
