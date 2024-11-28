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
CUSTOMER_IO_DEFAULT_WORKSPACE=VALUE
CUSTOMER_IO_SITE_ID=VALUE
CUSTOMER_IO_API_KEY=VALUE
CUSTOMER_IO_APP_API_KEY=VALUE
```

If you want to setup more workspaces to connect to, then you need to copy the add them into `config/customerio.php` in the `workspaces` key.
Each workspace needs to have these 3 keys: `api_key`, `app_api_key`, `site_id`.

### Usage 
Include `use Oscar\CustomerioLaravel\Facades\CustomerIo;` in your `controller` and add following function.

#### Create customer.io object 
```php
$customerIo = CustomerIo::workspace();
```
or
```php
$customerIo = CustomerIo::workspace('us_market');
```

#### Search Customer by Email
```php
$isCustomer = $customerIo->searchCustomerByEmail($email);
```

#### Create Customer 
`email` is required to create customer and `id` is option but cannot be null. It is possible to add more attributes you want to add for customer. 
```php
$customerData = [
    'id' => 1
    'email' => 'demo@test.com',
    'first_name' => 'john',
    'last_name' => 'doe',
];
$customerIo->addCustomer($customerData);
```

#### Update Customer
`email` is required to create customer and `id` is option but cannot be null.
```php
$customerData = [
    'id' => 1
    'email' => 'demo@test.com',
    'first_name' => 'Doe',
    'last_name' => 'John',
];
$customerIo->updateCustomer($customerData);
```

#### Create Event
While creating and event, `id` or `email` is used to link the event with customer, for 
```php
$eventData = [
    'id' => 1
    'email' => 'demo@test.com',
    'name' => 'Event Created',
    'data' => []
];
$customerIo->createEvent($eventData);
```

#### Send email
```php
$emailData = [
    'transactional_message_id' => 123, // can also be a string depending how the template is configured in Customer.io
    'identifiers' => [ // you need to send only one of these, depending which one you want and use in Customer.io
        'id' => 'your_own_custom_id_in_cio',
        'email' => 'demo@test.com',
        'cio_id' => 'customer_id_generated_by_cio',
    ],
    'to' => '\"Destination Person\" <destination-person@example.com>',
    'body' => '<p>This is my test email</p>', // required if 'transactional_message_id' is not provided; will override the body of the template if both are passed
    'subject' => 'Subject for my test email', // required if 'transactional_message_id' is not provided; will override the subject of the template if both are passed
    'from' => '\"Sender Person\" <sender-person@example.com>', // required if 'transactional_message_id' is not provided; will override the from of the template if both are passed
    'message_data' => [
        '<parameterName>' => '<parameterValue>' // key-value pair for each parameter you have in the template. replaced `<parameterName>` with the actual name of the parameter and `<parameterValue>` with the actual value of the parameter
    ],
];
```

