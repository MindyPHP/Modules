<?php

namespace Modules\Feedback\Forms;

use Exception;
use Mindy\Base\Mindy;
use Mindy\Form\Form;

abstract class BaseFeedbackForm extends Form
{
    public $templateCode;

    public function getFrom()
    {
        return $this->cleanedData['email'];
    }

    /**
     * Or use next code:
     *
     * Mindy::app()->mail
     * ->compose(['text' => $this->message])
     * ->setTo($this->email)
     * ->setSubject($this->subject)
     * ->send();
     *
     * @return mixed
     * @throws \Exception
     */
    public function send()
    {
        if ($this->templateCode === null) {
            throw new Exception('$templateCode is null');
        }
        return Mindy::app()->mail->fromCode($this->templateCode, $this->getFrom(), [
            'data' => $this->cleanedData
        ]);
    }
}
