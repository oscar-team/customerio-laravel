<?php
namespace Oscar\CustomerioLaravel;

use Customerio\Client;

/**
 * This is the Base class for CustomerIoLaravel package.
 * It initializes a client object for Customer.io API calls using the provided credentials.
 */

class Base {

    /**
     * The client object used for making API calls.
     *
     * @var Client
     */
    protected $client;

    /**
     * Create a new instance of Base class and initialize the client object.
     */
    
    public function __construct() {
        $this->client = new Client(config('customerio.api_key'), config('customerio.site_id'));
        $this->client->setAppAPIKey(config('customerio.app_api_key'));
    }
}
?>
