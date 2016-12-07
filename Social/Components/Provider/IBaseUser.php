<?php
/**
 * Created by PhpStorm.
 * User: max
 * Date: 10/06/16
 * Time: 22:47
 */

namespace Modules\Social\Components\Provider;

interface IBaseUser
{
    /**
     * @return int|string
     */
    public function getId();

    /**
     * @return string|null
     */
    public function getEmail();

    /**
     * @return string|null
     */
    public function getName();

    /**
     * @return string|null
     */
    public function getLink();

    /**
     * @return string|null
     */
    public function getAvatar();

    /**
     * @return string|null
     */
    public function getGender();

    /**
     * @return string|null
     */
    public function getBirthday();

    /**
     * @return array
     */
    public function toArray();
}