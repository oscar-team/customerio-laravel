<?php

namespace Oscar\CustomerioLaravel;

use Illuminate\Support\Arr;

/**
 * Customer.io workspace manager
 */
class CustomerIoManager
{
    /**
     * The application instance.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * The active workspace connection instances.
     *
     * @var array
     */
    protected $workspaces = [];

    /**
     * Create a new workspace manager instance.
     *
     * @param  \Illuminate\Contracts\Foundation\Application $app
     *
     * @return void
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * Get a workspace connection instance.
     *
     * @param  string|null  $name
     *
     * @return \Oscar\CustomerioLaravel\CustomerIoWorkspace
     */
    public function workspace(string $name = null)
    {
        $name = $name ?: $this->getDefaultWorkspaceConnection();

        // If we haven't created this connection, we'll create it based on the config
        // provided in the application. Once we've created the connections we will
        // set the "fetch mode" for PDO which determines the query return types.
        if (!isset($this->workspaces[$name])) {
            $this->workspaces[$name] = $this->makeConnection($name);
        }

        return $this->workspaces[$name];
    }

    /**
     * Get the default workspace connection name.
     *
     * @return string
     */
    public function getDefaultWorkspaceConnection()
    {
        return $this->app['config']['customerio.default'];
    }

    /**
     * Set the default workspace connection name.
     *
     * @param  string  $name
     *
     * @return void
     */
    public function setDefaultWorkspaceConnection($name)
    {
        $this->app['config']['customerio.default'] = $name;
    }

    /**
     * Return all of the created workspace connections.
     *
     * @return CustomerIoWorkspace[]
     */
    public function getWorkspaces()
    {
        return $this->workspaces;
    }

    /**
     * Dynamically pass methods to the default workspace connection.
     *
     * @param  string $method
     * @param  array  $parameters
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return $this->workspace()->$method(...$parameters);
    }

    /**
     * Make the workspace connection instance.
     *
     * @param  string $name
     *
     * @return \Oscar\CustomerioLaravel\CustomerIoWorkspace
     */
    protected function makeConnection($name)
    {
        $config = $this->configuration($name);

        return new CustomerIoWorkspace($config['api_key'], $config['site_id'], $config['app_api_key']);
    }

    /**
     * Get the configuration for a connection.
     *
     * @param  string $name
     *
     * @return array
     *
     * @throws \InvalidArgumentException when the workspace is not defined
     * @throws \UnexpectedValueException when the configuration for the workspace
     *                                   is missing 'api_key', 'app_api_key', or 'site_id'
     */
    protected function configuration($name)
    {
        $name = $name ?: $this->getDefaultWorkspaceConnection();

        // To get the workspace connection configuration, we will just pull each of the
        // connection configurations and get the configurations for the given name.
        // If the configuration doesn't exist, we'll throw an exception and bail.
        $workspaces = $this->app['config']['customerio.workspaces'];

        if (is_null($config = Arr::get($workspaces, $name))) {
            throw new \InvalidArgumentException(sprintf('There is no workspace defined with the name "%s". You must declare it in the configuration before using it.', $name));
        }

        if (empty($config['api_key']) || empty($config['app_api_key']) || empty($config['site_id'])) {
            throw new \UnexpectedValueException('Missing configuration for "api_key", "app_api_key", or "site_id".');
        }

        return $config;
    }
}
