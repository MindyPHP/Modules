<?php

/**
 * All rights reserved.
 *
 * @author Falaleev Maxim
 * @email max@studio107.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 06/01/15 17:24
 */

namespace Modules\Comments\Components\Akismet;

/**
 * Used internally by the Akismet class and to mock the Akismet anti spam service in
 * the unit tests.
 *
 * N.B. It is not necessary to implement this class to use the Akismet class.
 *
 * @package    akismet
 * @name    AkismetRequestFactory
 * @version    0.5
 * @author    Alex Potsides
 * @link    http://www.achingbrain.net/
 */
interface AkismetRequestFactory
{

    public function createRequestSender();
}
