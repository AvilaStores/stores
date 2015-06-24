<?php
class ES_Newsletterpopup_Block_Popup extends Mage_Core_Block_Template
{

    protected $_social = array(
        array(
            'name' => 'facebook',
            'label' => 'Facebook'
        ),
        array(
            'name' => 'twitter',
            'label' => 'Twitter'
        ),
        array(
            'name' => 'pinterest',
            'label' => 'Pinterest'
        ),
        array(
            'name' => 'gplus',
            'label' => 'Google Plus'
        ),
        array(
            'name' => 'instagram',
            'label' => 'Instagram'
        ),
        array(
            'name' => 'youtube',
            'label' => 'Youtube'
        ),
        array(
            'name' => 'tumblr',
            'label' => 'Tumblr'
        ),
        array(
            'name' => 'linkedin',
            'label' => 'Linked In'
        ),
    );

    public function getCookieName()
    {
        return Mage::getStoreConfig('newsletterpopup/popup/cookiename');
    }

    public function getCookieLifeTime()
    {
        if (Mage::getStoreConfig('newsletterpopup/general/dev'))
            return 0.00001;
        return Mage::getStoreConfig('newsletterpopup/popup/cookielifetime');
    }

    public function isActivePopUp()
    {
        return Mage::getStoreConfig('newsletterpopup/popup/isactive');
    }

    public function getTheme()
    {
        return Mage::getStoreConfig('newsletterpopup/popup/theme');
    }

    public function getFirstTitle()
    {
        return Mage::getStoreConfig('newsletterpopup/popup/firsttitle');
    }

    public function getSecondTitle()
    {
        return Mage::getStoreConfig('newsletterpopup/popup/secondtitle');
    }

    public function getText()
    {
        return Mage::getStoreConfig('newsletterpopup/popup/message');
    }

    public function getDelay()
    {
        if (!is_numeric(Mage::getStoreConfig('newsletterpopup/popup/showafterseconds')))
            return 0;
        $delay = Mage::getStoreConfig('newsletterpopup/popup/showafterseconds') * 1000;
        return $delay;
    }

    public function getButtonIsActive()
    {
        return Mage::getStoreConfig('newsletterpopup/button/isactive');
    }

    public function getButtonUsage()
    {
        return Mage::getStoreConfig('newsletterpopup/button/usage');
    }

    public function getThemeHtml()
    {
        return $this->getChildHtml($this->getTheme());
    }

    public function isActiveAutoPosition()
    {
        if (
            Mage::helper('newsletterpopup')->isMobile()
            && Mage::getStoreConfig('newsletterpopup/popup/mobile_auto_position')
        ) {
            return false;
        }

        return true;
    }

    public function getConfig()
    {
        $config = array(
            'translate' => array(
                'wait' => $this->__('Wait...'),
            ),
            'baseUrl' => Mage::getUrl('', array('_secure'=> Mage::app()->getStore()->isCurrentlySecure())),
            'layerClose' => Mage::getStoreConfig('newsletterpopup/popup/layer_close')?true:false,
            'autoPosition' => $this->isActiveAutoPosition(),
        );

        if ($this->getButtonIsActive() && $this->getButtonUsage() == 0) {
            $config['autoStart'] = false;
        }

        if (is_numeric($this->getDelay())) {
            $config['delayTime'] = $this->getDelay();
        }

        if ($this->getCookieName() != '') {
            $config['cookieName'] = $this->getCookieName();
        }

        if (is_numeric($this->getCookieLifeTime())) {
            $config['cookieLifeTime'] = $this->getCookieLifeTime();
        }

        return $config;
    }

    public function getConfigJs()
    {
        $configJs  = 'newsletterPopupConfig = '.json_encode($this->getConfig()).';';
        return $configJs;
    }

    public function getAdditionalFields()
    {
        if ($fields = Mage::getModel('newsletterpopup/subscriber')->getAdditionalFields()) {
            foreach ($fields as $key => $field) {
                $field['name'] = str_replace('subscriber_', '', $field['name']);
                $block = Mage::getBlockSingleton('core/template')
                    ->setTemplate('newsletterpopup/popup/field/'. $field['type'] . '.phtml')
                    ->setData($field);
                $fields[$key]['html'] = $block->_toHtml();
            }
            return $fields;
        }
        return false;
    }

    public function getSocialLink($name)
    {
        return Mage::getStoreConfig('newsletterpopup/social/' . $name);
    }

    public function getSocial()
    {
        $socialList = array();
        foreach ($this->_social as $social) {
            $link = $this->getSocialLink($social['name']);
            if (empty($link))
                continue;
            $socialList[] = array(
                'title' => $this->__($social['label']),
                'name' => $social['name'],
                'link' => $link,
            );
        }
        return $socialList;
    }

    public function getStaticBlockHtml()
    {
        $id = Mage::getStoreConfig('newsletterpopup/static_block/id');
        if (!is_numeric($id)) {
            return '';
        }

        return Mage::app()->getLayout()->createBlock('cms/block')->setBlockId($id)->toHtml();
    }

    public function isStaticBlockActive()
    {
        return Mage::getStoreConfig('newsletterpopup/static_block/is_active');
    }

}

