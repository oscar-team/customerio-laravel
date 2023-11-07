<?php

namespace Oscar\CustomerioLaravel;

use Oscar\CustomerioLaravel\Base;

/**
 * The CustomerIo class is a wrapper for the Customer.io API that provides a set of
 * methods for managing customers and events.
 */
class CustomerIo extends Base
{
    /**
     * Create a new instance of the CustomerIo class.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Search for a customer by email.
     *
     * @param string $email The email address to search for.
     * @return bool True if the customer was found, false otherwise.
     */
    public function searchCustomerByEmail(string $email): bool
    {
        $response = $this->getCurrentClient()->customers->get([
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
        $response = $this->getCurrentClient()->customers->add($customer);

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

        $response = $this->getCurrentClient()->customers->update($customer);

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
        $response = $this->getCurrentClient()->customers->delete([
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
        $response = $this->getCurrentClient()->customers->event($data);

        return $response;
    }
}
