<?php
namespace Oscar\CustomerioLaravel;
use Oscar\CustomerioLaravel\Base;


class CustomerIo extends Base {

    public function __construct() {
        parent::__construct();
    }

    public function searchCustomerByEmail(string $email) {
            $response = $this->client->customers->get(
                [
                    'email' => $email,
                ]
            );
        return $response->results ? true : false;
    }


    public function addCustomer(array $customer) {
        $response = $this->client->customers->add(
            [
                'id' => $customer['id'],
                'email' => $customer['email'],
                'first_name' => $customer['first_name'],
                'last_name' => $customer['last_name'],
                'business_name' => $customer['business_name'],
                'phone' => $customer['phone'],
                'birthday' => $customer['birthday'],
                'accepts_marketing' => $customer['accepts_marketing'],
                'market' => $customer['market'],
                'preferred_language' => $customer['preferred_language'],
                'total_spend' => $customer['total_spend'],
                'number_of_bookings' => $customer['number_of_bookings'],
            ]
        );

        return $response;
    }

    public function updateCustomer(array $customer) {
        $response = $this->client->customers->update(
            [
                'id' => $customer['id'],
                'email' => $customer['email'],
                'first_name' => $customer['first_name'],
                'last_name' => $customer['last_name'],
                'business_name' => $customer['business_name'],
                'phone' => $customer['phone'],
                'birthday' => $customer['birthday'],
                'accepts_marketing' => $customer['accepts_marketing'],
                'market' => $customer['market'],
                'preferred_language' => $customer['preferred_language'],
                'total_spend' => $customer['total_spend'],
                'number_of_bookings' => $customer['number_of_bookings'],
            ]
        );

        return $response;
    }

    public function deleteCustomer(int $id) {
        $response = $this->client->customers->delete(
            [
                'id' => $id
            ]
        );

        return $response;
    }

    public function bookingCreatedEvent(array $booking) {
        $response = $this->client->customers->event(
            [
                'id' => $booking['customer_id'],
                'name' => 'Booking Created',
                'data' => [
                    'email' => $booking['email'],
                    'booking_id' => $booking['booking_id'],
                    'booking_created' => $booking['created_at'],
                    'booking_start_date_time' => $booking['pickup_at'],
                    'booking_return_date_time' => $booking['delivery_at'],
                    'booking_duration' => $booking['booking_duration'],
                    'booking_source' => $booking['booking_source'],
                    'department_id' => $booking['department_id'],
                    'department_name' => $booking['department_name'],
                    'car_id' => $booking['car_id'],
                    'car_type' => $booking['car_type'],
                    'market' => $booking['market'],
                    'preferred_language' => $booking['preferred_language'],
                    'booking_total_amount' => $booking['booking_total_amount'],
                    'total_spend' => $booking['total_spend'],
                    'number_of_bookings' => $booking['number_of_bookings'],
                ]
            ]
        );
        return $response;
    }

    public function bookingCanceledOrDeletedEvent(array $booking) {
        $response = $this->client->customers->event(
            [
                'id' => $booking['customer_id'],
                'name' => 'Booking '. ($booking['is_cancelled'] ? 'Cacelled' : 'Deleted') ,
                'data' => [
                    'email' => $booking['email'],
                    'booking_id' => $booking['booking_id'],
                    'booking_canceled' => $booking['canceled_at'],
                ]
            ]
        );
        return $response;
    }

    public function bookingCompleted(array $booking) {
        $response = $this->client->customers->event(
            [
                'id' => $booking['customer_id'],
                'name' => 'Booking Completed',
                'data' => [
                    'email' => $booking['email'],
                    'booking_id' => $booking['booking_id'],
                    'booking_completed' => $booking['completed_at'],
                ]
            ]
        );
        return $response;
    }
}



?>
