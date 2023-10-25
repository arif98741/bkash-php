<?php

namespace Xenon\BkashPhp\Request;

use Exception;
use Xenon\BkashPhp\Handler\Exception\RenderBkashPHPException;

class Token
{
    /**
     * @throws RenderBkashPHPException
     */
    public static function getToken(object $object)
    {
        try {
            $tokenResponse = (new BkashRequest($object))->post('tokenized/checkout/token/grant');

            if ($tokenResponse->getStatusCode() !== 200) {
                throw new RenderBkashPHPException("Failed to generate token. Check credentials");
            }

            $contentsObject = $tokenResponse->getContentsObject();
            if ($contentsObject->statusCode !== '0000') {
                throw new RenderBkashPHPException("Code: {$contentsObject->statusCode}; {$contentsObject->statusMessage}");
            }

            return $contentsObject->id_token;
        } catch (Exception $e) {
            throw new RenderBkashPHPException("{$e->getMessage()}");
        }
    }
}
