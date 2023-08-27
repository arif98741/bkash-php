<?php
/*
 *  Last Modified: 08/27/23, 05:18 PM
 *  Copyright (c) 2021
 *  -created by Ariful Islam
 *  -All Rights Preserved By
 *  -If you have any query then knock me at
 *  arif98741@gmail.com
 *  See my profile @ https://github.com/arif98741
 */

namespace Xenon\BkashPhp\Handler\Exception;


use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class ParameterException
 * @package Xenon\BkashPhp\Handler\Exception
 * @version v0.0.1
 * @since v0.0.1
 */
class ValidationException extends Exception
{
    /**
     * Report the exception.
     *
     * @return void
     * @version v0.0.1
     * @since v0.0.1
     */
    public function report()
    {
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param Request $request
     * @return Response
     * @version v0.0.1
     * @since v0.0.1
     */
    public function render(Request $request)
    {

    }
}
