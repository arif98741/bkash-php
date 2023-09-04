<?php

namespace Xenon\BkashPhp\Request;

use Xenon\BkashPhp\Handler\Exception\RenderException;

class Token
{
    /**
     * @throws RenderException
     */
    public static function getToken(object $object)
    {
        $tokenRequestObject = new BkashRequest($object);
        $tokenResponse = $tokenRequestObject->post('v1.2.0-beta/tokenized/checkout/token/grant');
        if ($tokenResponse->getStatusCode() == 200) {
            $jsonObject = $tokenResponse->getContentsObject();
            return $jsonObject->id_token;
        }
        throw new RenderException("Failed to generate token. Check credentials");
    }
}
