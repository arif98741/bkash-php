<?php

namespace Xenon\BkashPhp\Request;

use Xenon\BkashPhp\Handler\Exception\RenderBkashPHPException;

class Token
{
    /**
     * @throws RenderBkashPHPException
     */
    public static function getToken(object $object)
    {
        $tokenRequestObject = new BkashRequest($object);
        $tokenResponse = $tokenRequestObject->post('tokenized/checkout/token/grant');
        if ($tokenResponse->getStatusCode() === 200) {
            return $tokenResponse->getContentsObject()->id_token;
        }
        throw new RenderBkashPHPException("Failed to generate token. Check credentials");
    }
}
