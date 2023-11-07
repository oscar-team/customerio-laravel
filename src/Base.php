<?php

namespace Oscar\CustomerioLaravel;

use Customerio\Client;

/**
 * This is the Base class for CustomerIoLaravel package.
 * It initializes a client object for Customer.io API calls using the provided credentials.
 */
class Base
{
    /**
     * The client object used for making API calls.
     *
     * @var Client
     */
    protected Client $client;

    /**
     * The list of clients each connecting to a workspace.
     *
     * @var Client[]
     */
    protected array $workspaces;

    /**
     * Currently used client
     *
     * @var Client
     */
    protected Client $currentClient;

    /**
     * Previously used client
     *
     * @var Client|null
     */
    protected ?Client $previousClient = null;

    /**
     * Create a new instance of Base class and initialize the client object.
     */
    
    public function __construct()
    {
        $this->client = new Client(config('customerio.api_key'), config('customerio.site_id'));
        $this->client->setAppAPIKey(config('customerio.app_api_key'));
        $this->currentClient = $this->client;

        if (!empty(config('customerio.workspaces'))) {
            foreach (config('customerio.workspaces') as $workspaceKey => $workspaceInfo) {
                $client = new Client($workspaceInfo['api_key'], $workspaceInfo['site_id']);
                $client->setAppAPIKey($workspaceInfo['app_api_key']);

                $this->workspaces[$workspaceKey] = $client;
            }
        }
    }

    /**
     * Switch current client to the provided workspace
     *
     * @param  string|null $workspaceKey workspace key to connect to; leave empty to get the current workspace
     *
     * @return Client
     *
     * @throws InvalidArgumentException  thrown in case the provided key is not defined in the configuration
     */
    public function connectToWorkspace(?string $workspaceKey = null): Client
    {
        if (empty($workspaceKey)) {
            $this->setCurrentClient($this->client);

            return $this->getCurrentClient();
        }

        if ($this->workspaces[$workspaceKey] instanceof Client) {
            $this->setCurrentClient($this->workspaces[$workspaceKey]);

            return $this->getCurrentClient();
        }

        throw new \InvalidArgumentException(sprintf('There is no workspace defined with the name "%s". You must declare it in the configuration before using it.', $workspaceKey));
    }

    /**
     * Get currentClient
     *
     * @return Client
     */
    public function getCurrentClient(): Client
    {
        return $this->currentClient;
    }

    /**
     * Set currentClient
     *
     * @param Client $currentClient
     *
     * @return $this
     */
    public function setCurrentClient(Client $currentClient): static
    {
        $this->previousClient = $this->currentClient;
        $this->currentClient = $currentClient;

        return $this;
    }

    /**
     * Change back to the previously used client. Calling multiple times will only go back 1 time.
     *
     * @return $this
     */
    public function restorePreviousClient(): static
    {
        if ($this->previousClient instanceof Client) {
            $this->currentClient = $this->previousClient;
        }

        return $this;
    }
}
