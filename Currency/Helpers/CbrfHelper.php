<?php

/**
 * User: max
 * Date: 01/10/15
 * Time: 21:37
 */

namespace Modules\Currency\Helpers;


use DOMDocument;

class CbrfHelper
{
    protected $list = [];

    public function load($date = null)
    {
        $this->list = [];
        $xml = new DOMDocument();
        $url = 'http://www.cbr.ru/scripts/XML_daily.asp?date_req=' . date('d.m.Y', $date ? strtotime($date) : time());

        if ($xml->load($url)) {
            $root = $xml->documentElement;
            $items = $root->getElementsByTagName('Valute');

            foreach ($items as $item) {
                /** @var \DOMElement $item */
                $count = (int)$item->getElementsByTagName('Nominal')->item(0)->nodeValue;
                $code = $item->getElementsByTagName('CharCode')->item(0)->nodeValue;
                $curs = $item->getElementsByTagName('Value')->item(0)->nodeValue;
                $this->list[$code] = floatval(str_replace(',', '.', $curs)) / $count;
            }

            return true;
        }

        return false;
    }

    public function get($cur)
    {
        return isset($this->list[$cur]) ? $this->list[$cur] : 0;
    }
}