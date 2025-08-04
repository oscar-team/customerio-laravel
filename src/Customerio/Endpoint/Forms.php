<?php

namespace Oscar\CustomerioLaravel\Customerio\Endpoint;

use Customerio\Endpoint\Base;
use GuzzleHttp\Exception\GuzzleException;

class Forms extends Base
{
    /**
     * Submit a form
     * @see https://docs.customer.io/integrations/api/track/#operation/submitForm
     * @param  array  $options
     * @return mixed
     * @throws GuzzleException
     */
    public function submit(array $options): mixed
    {
        if (empty($options['id'])) {
            $this->mockException('Form ID is required!', 'POST');
        }

        $formId = $options['id'];
        unset($options['id']);

        return $this->client->post("forms/$formId/submit", [
            'data' => $options
        ]);
    }
}
