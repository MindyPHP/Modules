<?php

/**
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 06/01/15 17:23
 */

namespace Modules\Comments\Components\Akismet;

/**
 * Used internally by the Akismet class and to mock the Akismet anti spam service in
 * the unit tests.
 *
 * N.B. It is not necessary to call this class directly to use the Akismet class.
 *
 * @package    akismet
 * @name    SocketWriteReadFactory
 * @version    0.5
 * @author    Alex Potsides
 * @link    http://www.achingbrain.net/
 */
class SocketWriteReadFactory implements AkismetRequestFactory
{

    public function createRequestSender()
    {
        return new SocketWriteRead();
    }
}