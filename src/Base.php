<?php
namespace Oscar\CustomerioLaravel;

use Customerio\Client;

class Base {

    protected $client;

    public function __construct() {
        $this->client = new Client(config('customerio.api_key'), config('customerio.site_id'));
        $this->client->setAppAPIKey(config('customerio.app_api_key'));
    }
}
?>
