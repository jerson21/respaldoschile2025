<?php
/* PHP SDK v5.0.0 */
/* make the API call */
try {
  // Returns a `Facebook\FacebookResponse` object
  $response = $fb->get(
    '/{app-id}/subscriptions',
    '{EAAqFhQwbrOwBAOuE6ZBtZBuwy4VwQibXCpwLBsm87ES9wcE5rBiOg9EMqZAFl3qANRW3xxCqIJ3ilxpNcw8fr6jcOQSMtLV1MckTpKMHTkZCTWKHmvkLLLxnX2chL9F0sO4yOXZAKcDkFUIXsusFHZBZA7D6MdTzRqqBu7ZBkFO4Y1S7RZCq4AcqKslWYFqKbie1cRemJGabhRDQpP5raGDnI}'
  );
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}
$graphNode = $response->getGraphNode();
/* handle the result */
?>