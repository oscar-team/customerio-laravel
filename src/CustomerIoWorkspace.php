<?php

namespace Oscar\CustomerioLaravel;

use Customerio\Client;

/**
 * The CustomerIo class is a wrapper for the Customer.io API that provides a set of
 * methods for managing customers and events.
 */
class CustomerIoWorkspace
{
    /**
     * The client object used for making API calls.
     *
     * @var Client
     */
    protected Client $client;

    /**
     * Create a new instance of Base class and initialize the client object.
     */
    public function __construct(string $apiKey, string $siteId, string $appApiKey)
    {
        $this->client = new Client($apiKey, $siteId);
        $this->client->setAppAPIKey($appApiKey);
    }

    /**
     * Search for a customer by email.
     *
     * @param string $email The email address to search for.
     * @return bool True if the customer was found, false otherwise.
     */
    public function searchCustomerByEmail(string $email): bool
    {
        $response = $this->client->customers->get([
            'email' => $email,
        ]);

        return $response->results ? true : false;
    }

    /**
     * Add a new customer.
     *
     * @param array $customer An array of customer data.
     * @return mixed The response from the API.
     */
    public function addCustomer(array $customer)
    {
        $response = $this->client->customers->add($customer);

        return $response;
    }

    /**
     * Update an existing customer.
     *
     * @param array $customer An array of customer data.
     * @return mixed The response from the API.
     */
    public function updateCustomer(array $customer)
    {
        if (array_key_exists('total_spend', $customer)) {
            unset($customer['total_spend']);
        }

        if (array_key_exists('number_of_bookings', $customer)) {
            unset($customer['number_of_bookings']);
        }

        $response = $this->client->customers->update($customer);

        return $response;
    }

    /**
     * Delete a customer.
     *
     * @param int $id The ID of the customer to delete.
     * @return mixed The response from the API.
     */
    public function deleteCustomer(int $id)
    {
        $response = $this->client->customers->delete([
            'id' => $id,
        ]);

        return $response;
    }

    /**
     * Create a new event.
     *
     * @param array $data An array of event data.
     * @return mixed The response from the API.
     */
    public function createEvent(array $data)
    {
        $response = $this->client->customers->event($data);

        return $response;
    }

    /**
     * Send an email through transaction API
     *
     * @param  array $data An array of options for the API
     *
     * @return mixed
     */
    public function sendEmail(array $data)
    {
        $response = $this->client->send->email($data);

        return $response;
    }
}
