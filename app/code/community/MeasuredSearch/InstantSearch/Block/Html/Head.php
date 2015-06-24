<?php
class MeasuredSearch_InstantSearch_Block_Html_Head extends Mage_Page_Block_Html_Head
{
    protected function _construct()
    {
        $this->setTemplate('page/html/head.phtml');
    }

    public function addExternalItem($type, $name, $params=null, $if=null, $cond=null)
    {
        parent::addItem($type, $name, $params=null, $if=null, $cond=null);
    }

    public function removeExternalItem($type, $name)
    {
        parent::removeItem($type, $name);
    }

    protected function _separateOtherHtmlHeadElements(&$lines, $itemIf, $itemType, $itemParams, $itemName, $itemThe)
    {
        $helper = Mage::helper('measuredsearch_instantsearch');
        $collection = $helper->getCollection();
        $developerKey = $helper->getDeveloperKey();

        $params = $itemParams ? ' ' . $itemParams : '';
        $href = $itemName;
        if(!$helper->isMeasuredSearchServiceEnabled()) {
            Mage::log("MeasuredSearch service not enabled, not adding header params.", null, 'measuredsearch.log');
            return;
        }
        switch ($itemType) {
            case 'rss':
                $lines[$itemIf]['other'][] = sprintf('<link href="%s"%s rel="alternate" type="application/rss+xml" />',
                    $href, $params
                );
                break;

            case 'link_rel':
                $lines[$itemIf]['other'][] = sprintf('<link%s href="%s" />', $params, $href);
                break;

            case 'external_js':
                $lines[$itemIf]['other'][] = sprintf('<script type="text/javascript" src="%s" %s></script>', $href, $params);
                break;

            case 'external_css':
                $lines[$itemIf]['other'][] = sprintf('<link rel="stylesheet" type="text/css" href="%s" %s/>', $href, $params);
                break;

            case 'external_js_code':
                $helper = Mage::helper('measuredsearch_instantsearch');
                $collection = $helper->getCollection();
                $secretKey = $helper->getSecretKey();
                $developerKey = $helper->getDeveloperKey();

                $patterns = array();
                $patterns[0] = '/<collection>/';
                $patterns[1] = '/<secret_key>/';
                $patterns[2] = '/<developer_key>/';

                $replacements = array();
                $replacements[0] = $collection;
                $replacements[1] = $secretKey;
                $replacements[2] = $developerKey;

                $js_code = preg_replace($patterns, $replacements, $href);
                $lines[$itemIf]['other'][] = $js_code;
                break;
        }
    }
}
