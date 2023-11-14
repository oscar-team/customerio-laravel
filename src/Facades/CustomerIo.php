<?php

namespace Oscar\CustomerioLaravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Oscar\CustomerioLaravel\CustomerIoWorkspace workspace(string $name = null)
 * @method static string getDefaultWorkspaceConnection()
 * @method static void setDefaultWorkspaceConnection(string $name)
 * @method static \Oscar\CustomerioLaravel\CustomerIoWorkspace[] getWorkspaces()
 * @method static bool searchCustomerByEmail(string $email)
 * @method static mixed addCustomer(array $customer)
 * @method static mixed updateCustomer(array $customer)
 * @method static mixed deleteCustomer(int $id)
 * @method static mixed createEvent(array $data)
 */
class CustomerIo extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'customerio';
    }
}
