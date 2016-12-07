<?php

namespace Modules\Mail\Components;

use Mindy\Exception\HttpException;
use Mindy\Base\Mindy;
use Mindy\Helper\Console;
use Mindy\Mail\Mailer;
use Modules\Core\Components\ParamsHelper;
use Modules\Mail\Models\Mail;
use Modules\Mail\Models\MailTemplate;

class DbMailer extends Mailer
{
    public $debug = false;

    public $checkerDomain = '';

    /**
     * @var bool enable reading email checker
     */
    public $checker = true;

    protected function getCheckerUrl($uniq)
    {
        if ($this->checker) {
            $url = $this->checkerDomain . Mindy::app()->urlManager->reverse('mail:checker', [
                    'uniqueId' => $uniq
                ]);
            return strtr("<img style='width: 1px !important; height: 1px !important;' src='{url}'>", [
                '{url}' => $url
            ]);
        }

        return '';
    }

    protected function clearBody($html)
    {
        if (preg_match('|<body[^>]*>(.*?)</body>|is', $html, $match)) {
            $html = $match[1];
        }
        $html = preg_replace('|<style[^>]*>(.*?)</style>|is', '', $html);
        return strip_tags($html);
    }

    public function fromCode($code, $receiver, $data = [], $attachments = [])
    {
        $uniq = uniqid();
        $template = $this->loadTemplateModel($code);
        $site = $this->getSite();

        $templateParams = array_merge(['site' => $site], $data);

        $subject = $this->renderString((string)$template->subject, $templateParams);
        $message = $this->renderString((string)$template->message, $templateParams);

        /** @var \Mindy\Mail\MessageInterface $msg */
        $msg = $this->createMessage();

        if (!empty($template->template)) {
            $messageHtml = $this->renderTemplate($template->template . ".html", array_merge($templateParams, [
                'content' => $message . $this->getCheckerUrl($uniq),
                'subject' => $subject
            ]));
            $msg->setHtmlBody($messageHtml);

            $textTemplates = Mindy::app()->finder->find($template->template . ".txt");
            if ($textTemplates) {
                $messageTxt = $this->renderTemplate($template->template . ".txt", array_merge($templateParams, [
                    'content' => $message,
                    'subject' => $subject
                ]));
                $msg->setTextBody($messageTxt);
            } else {
                $messageTxt = $this->clearBody($messageHtml);
                $msg->setTextBody($messageTxt);
            }
        } else {
            $messageHtml = $message;
            $messageTxt = $this->clearBody($message);

            $msg->setHtmlBody($message);
            $msg->setTextBody($messageTxt);
        }

        $msg->setFrom(Mindy::app()->managers);
        $msg->setSubject($subject);
        if (!empty($attachments)) {
            if (!is_array($attachments)) {
                $attachments = [$attachments];
            }
            foreach ($attachments as $file) {
                $msg->attach($file);
            }
        }

        $receivers = [];
        if (is_array($receiver)) {
            foreach ($receiver as $r) {
                $receivers[] = $r;
            }
        } else {
            $receivers[] = $receiver;
        }
        $msg->setTo($receiver);

        $module = Mindy::app()->getModule('Mail');
        $isSended = false;
        if ($module->delayedSend === false && $msg->send()) {
            $isSended = true;
        }
        foreach ($receivers as $email) {
            (new Mail([
                'email' => $email,
                'subject' => $subject,
                'message_txt' => $messageTxt,
                'message_html' => $messageHtml,
                'unique_id' => $uniq,
                'is_sended' => $isSended
            ]))->save();
        }
        return [$subject, $message];
    }

    /**
     * @return null|\Modules\Sites\Models\Site
     */
    protected function getSite()
    {
        if (Mindy::app()->hasModule('Sites')) {
            return Mindy::app()->getModule('Sites')->getSite();
        }
        return null;
    }

    /**
     * @return string|null
     */
    public function getDomain()
    {
        if ($this->domain) {
            return $this->domain;
        } else if (Console::isCli() === false) {
            return Mindy::app()->request->http->getHostInfo();
        }

        return null;
    }

    /**
     * @param $code
     * @return MailTemplate
     * @throws HttpException
     */
    protected function loadTemplateModel($code)
    {
        $template = MailTemplate::objects()->filter(['code' => $code])->get();
        if ($template === null) {
            throw new HttpException(500, "Mail template with code $code do not exists");
        }
        return $template;
    }
}
