# Customer.io Integration with Laravel

Package is used to create/update customer and events for customer on Customer.io
Package is using `printu/customerio` package. 

### Installtion
```bash
composer require oscar-team/customerio-laravel
```
You can also publish the config file with:

```bash
php artisan vendor:publish --tag=customerio-config
```
Generate `Site ID`, `API Key` and `App API Key` from Customer.io and setup variables in `.env` file. 

```bash
CUSTOMER_IO_SITE_ID=VALUE
CUSTOMER_IO_API_KEY=VALUE
CUSTOMER_IO_APP_API_KEY=VALUE
```

### Usage 
Include `use Oscar\CustomerioLaravel\CustomerIo;` in your `controller` and add following function.

#### Create customer.io object 
```php
$customerIo = new CustomerIo();
```

#### Search Customer by Email
```php
$isCustomer = $customerIo->searchCustomerByEmail($email);
```

#### Create Customer 
`email` is required to create customer and `id` is option but cannot be null. It is possible to add more attributes you want to add for customer. 
```php
$customerData = array(
            'id' => 1
            'email' => 'demo@test.com',
            'first_name' => 'john',
            'last_name' => 'doe',
        );
$customerIo->addCustomer($customerData);
```

#### Update Customer
`email` is required to create customer and `id` is option but cannot be null.
```php
$customerData = array(
            'id' => 1
            'email' => 'demo@test.com',
            'first_name' => 'Doe',
            'last_name' => 'John',
        );
$customerIo->updateCustomer($customerData);
```

#### Create Event
While creating and event, `id` or `email` is used to link the event with customer, for 
```php
$eventData = array(
                'id' => 1
                'email' => 'demo@test.com',
                'name' => 'Event Created',
                'data' => []
            );
$customerIo->createEvent($eventData);
```


