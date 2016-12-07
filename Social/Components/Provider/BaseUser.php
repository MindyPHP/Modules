<?php
/**
 * Created by PhpStorm.
 * User: max
 * Date: 11/06/16
 * Time: 00:24
 */

namespace Modules\Social\Components\Provider;

class BaseUser implements IBaseUser
{
    /**
     * @var mixed
     */
    protected $data;
    /**
     * @var array
     */
    protected $map = [
        'id' => 'id',
        'email' => 'email',
        'name' => 'name',
        'link' => 'link',
        'gender' => 'gender',
        'birthday' => 'birthday'
    ];

    /**
     * BaseUser constructor.
     * @param mixed $data
     * @param array $map
     */
    public function __construct($data, array $map = [])
    {
        $this->data = $data;
        if (!empty($map)) {
            $this->map = $map;
        }
    }

    /**
     * @return mixed
     */
    public function toArray()
    {
        return $this->data;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->data[$this->map['id']];
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->data[$this->map['email']];
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->data[$this->map['name']];
    }

    /**
     * @return mixed
     */
    public function getLink()
    {
        return $this->data[$this->map['link']];
    }

    /**
     * @return mixed
     */
    public function getAvatar()
    {
        return $this->data[$this->map['avatar']];
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->data[$this->map['gender']];
    }

    /**
     * @return mixed
     */
    public function getBirthday()
    {
        return $this->data[$this->map['birthday']];
    }
}