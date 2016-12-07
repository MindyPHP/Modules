<?php
/**
 *
 *
 * All rights reserved.
 *
 * @author Okulov Anton
 * @email qantus@mail.ru
 * @version 1.0
 * @company Studio107
 * @site http://studio107.ru
 * @date 13/11/14 09:19
 */
namespace Modules\Workers\Models;

use Mindy\Helper\Text;
use Mindy\Orm\Fields\CharField;
use Mindy\Orm\Fields\EmailField;
use Mindy\Orm\Fields\ForeignField;
use Mindy\Orm\Fields\HasManyField;
use Mindy\Orm\Fields\ImageField;
use Mindy\Orm\Fields\IntField;
use Mindy\Orm\Fields\BooleanField;
use Mindy\Orm\Fields\ManyToManyField;
use Mindy\Orm\Fields\TextField;
use Mindy\Orm\Model;
use Modules\User\Models\User;
use Modules\Workers\WorkersModule;

class Worker extends Model
{
    const REALTOR_GROUP = 3;

    public $metaConfig = [
        'title' => 'fullname',
        'keywords' => 'description',
        'description' => 'description'
    ];

    public static function getFields() 
    {
        return [
            'last_name' => [
                'class' => CharField::className(),
                'verboseName' => WorkersModule::t('Worker last name'),
                'required' => true,
            ],
            'name' => [
                'class' => CharField::className(),
                'verboseName' => WorkersModule::t('Worker first name'),
                'required' => true,
            ],
            'middle_name' => [
                'class' => CharField::className(),
                'verboseName' => WorkersModule::t('Worker middle name'),
                'required' => true,
            ],
            'email' => [
                'class' => EmailField::className(),
                'verboseName' => WorkersModule::t('Email'),
                'null' => true,
            ],
            'phone' => [
                'class' => CharField::className(),
                'verboseName' => WorkersModule::t('Phone'),
                'null' => true,
                'unique' => false
            ],
            'phone_duplicate' => [
                'class' => CharField::className(),
                'verboseName' => WorkersModule::t('Phone'),
                'null' => true,
                'unique' => false
            ],
            'department' => [
                'class' => ForeignField::className(),
                'modelClass' => Department::className(),
                'verboseName' => WorkersModule::t('Department'),
                'null' => true,
            ],
            'departments' => [
                'class' => ManyToManyField::className(),
                'modelClass' => Department::className(),
                'verboseName' => WorkersModule::t('Departments'),
                'null' => true
            ],
            'education' => [
                'class' => CharField::className(),
                'null' => true,
                'verboseName' => WorkersModule::t('Education')
            ],
            'specialization' => [
                'class' => CharField::className(),
                'null' => true,
                'verboseName' => WorkersModule::t('Specialization')
            ],
            'main_in_job' => [
                'class' => CharField::className(),
                'null' => true,
                'verboseName' => WorkersModule::t('Main in my job')
            ],
            'hobby' => [
                'class' => CharField::className(),
                'null' => true,
                'verboseName' => WorkersModule::t('Hobby')
            ],
            'role' => [
                'class' => CharField::className(),
                'verboseName' => WorkersModule::t('Worker role'),
                'null' => true,
            ],
            'auto' => [
                'class' => BooleanField::className(),
                'verboseName' => WorkersModule::t('Has auto'),
                'default' => false,
            ],
            'short_description' => [
                'class' => TextField::className(),
                'verboseName' => WorkersModule::t('Short description'),
                'null' => true
            ],
            'description' => [
                'class' => TextField::className(),
                'verboseName' => WorkersModule::t('Description'),
                'null' => true
            ],
            'image' => [
                'class' => ImageField::className(),
                'verboseName' => WorkersModule::t('Image'),
                'sizes' => [
                    'mini' => [
                        76, 76
                    ],
                    'thumb' => [
                        98, 98
                    ],
                    'list' => [
                        93, 129
                    ],
                    'preview' => [
                        180, 180
                    ],
                    'sidebar' => [
                        135, 156
                    ],
                    'big' => [
                        259, 363
                    ]
                ]
            ],
            'image_hover' => [
                'class' => ImageField::className(),
                'verboseName' => WorkersModule::t('Additional image'),
                'sizes' => [
                    'mini' => [
                        76, 76
                    ],
                    'list' => [
                        93, 129
                    ],
                    'thumb' => [
                        98, 98
                    ],
                    'preview' => [
                        180, 180
                    ]
                ]
            ],
            'image_additional' => [
                'class' => ImageField::className(),
                'verboseName' => WorkersModule::t('Image full'),
                'sizes' => [
                    'preview' => [
                        180, 220
                    ],
                    'list' => [
                        93, 129
                    ],
                    'big' => [
                        259, 363
                    ]
                ]
            ],
            'awards' => [
                'class' => HasManyField::className(),
                'modelClass' => Award::className(),
                'relatedName' => 'worker',
                'null' => true,
                'editable' => false
            ],
            'awards_count' => [
                'class' => IntField::className(),
                'null' => true,
                'verboseName' => WorkersModule::t('Awards count')
            ],
            'reviews' => [
                'class' => HasManyField::className(),
                'modelClass' => Review::className(),
                'relatedName' => 'worker',
                'null' => true,
                'editable' => false
            ],
            'level' => [
                'class' => IntField::className(),
                'verboseName' => WorkersModule::t('Worker level'),
                'choices' => [
                    1 => 1,
                    2 => 2,
                    3 => 3,
                    4 => 4,
                    5 => 5
                ],
                'default' => 5,
            ],
            'external_id' => [
                'class' => CharField::className(),
                'verboseName' => WorkersModule::t('External id'),
                'null' => true
            ],
            'position' => [
                'class' => IntField::className(),
                'verboseName' => WorkersModule::t('Position'),
                'null' => true,
                'editable' => false,
                'default' => 0
            ],
            'is_head'=> [
                'class'=> BooleanField::className(),
                'default'=>false,
                'verboseName' => WorkersModule::t('Is head'),
            ],
            'is_published'=> [
                'class'=> BooleanField::className(),
                'default'=> true,
                'verboseName' => WorkersModule::t('Is published'),
            ],
            'user' => [
                'class' => ForeignField::className(),
                'null' => true,
                'verboseName' => WorkersModule::t("User"),
                'modelClass' => User::className()
            ],

            /* Social networks */
            'vk' => [
                'class' => CharField::className(),
                'verboseName' => WorkersModule::t('VK link'),
                'null' => true,
            ],
            'ok' => [
                'class' => CharField::className(),
                'verboseName' => WorkersModule::t('Odnoklassniki link'),
                'null' => true,
            ],
            'twitter' => [
                'class' => CharField::className(),
                'verboseName' => WorkersModule::t('Twitter link'),
                'null' => true,
            ],
            'facebook' => [
                'class' => CharField::className(),
                'verboseName' => WorkersModule::t('Facebook link'),
                'null' => true,
            ],
            'instagram' => [
                'class' => CharField::className(),
                'verboseName' => WorkersModule::t('Instagram link'),
                'null' => true,
            ],
        ];
    }
    
    public function __toString() 
    {
        return (string)$this->last_name.' '.$this->name;
    }

    public function getFullname()
    {
        return implode(' ', [$this->last_name, $this->name, $this->middle_name]);
    }

    public function getFormattedPhone()
    {
        return $this->formatPhone($this->phone);
    }

    public function getFormattedPhoneDuplicate()
    {
        return $this->formatPhone($this->phone_duplicate);
    }

    public function formatPhone($phone)
    {
        if (Text::startsWith($phone, '79')) {
            $phone = $this->insertToString(0, $phone, '+');
            $phone = $this->insertToString(2, $phone, ' (');
            $phone = $this->insertToString(7, $phone, ') ');
            $phone = $this->insertToString(12, $phone, '-');
            $phone = $this->insertToString(15, $phone, '-');
            return $phone;
        } elseif (Text::startsWith($phone, '78332')) {
            $phone = str_replace('78332', '+7 (8332) ', $phone);
            $phone = $this->insertToString(12, $phone, '-');
            $phone = $this->insertToString(15, $phone, '-');
            return $phone;
        } else {
            return $phone;
        }
    }

    public function insertToString($pos, $oldstr, $insert) {
        return substr($oldstr, 0, $pos) . $insert . substr($oldstr, $pos);
    }

    public function getAbsoluteUrl()
    {
        return $this->reverse('workers.view', ['pk' => $this->id]);
    }

    public function getLimitedReviews($limit = 5)
    {
        return $this->reviews->limit($limit)->order(['-date'])->all();
    }

    public function beforeSave($owner, $isNew)
    {
        if ($isNew) {
            $owner->is_published = true;
        }
    }
} 
