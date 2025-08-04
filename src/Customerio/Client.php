<?php

namespace Oscar\CustomerioLaravel\Customerio;

use Customerio\Client as BaseClient;
use Oscar\CustomerioLaravel\Customerio\Endpoint\Forms;

class Client extends BaseClient
{
    /** @var Endpoint\Forms */
    public Forms $forms;

    /**
     * @inheritdoc
     */
    public function __construct(string $apiKey, string $siteId, array $options = [])
    {
        parent::__construct($apiKey, $siteId, $options);

        $this->forms = new Endpoint\Forms($this);
    }
}
