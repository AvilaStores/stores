<?php

class ES_Newsletterpopup_Model_Core_Email_Template
    extends ES_Newsletterpopup_Model_Core_Email_Template_Init
{

    public function sendTransactional($templateId, $sender, $email, $name, $vars=array(), $storeId=null)
    {
        $this->addAttachment($templateId, $storeId);
        return parent::sendTransactional($templateId, $sender, $email, $name, $vars, $storeId);
    }

    protected function addAttachment($templateId, $storeId = null)
    {
        if ($templateId != Mage::getStoreConfig(Mage_Newsletter_Model_Subscriber::XML_PATH_SUCCESS_EMAIL_TEMPLATE, $storeId)) {
            return false;
        }

        $fileWithPath = Mage::helper('newsletterpopup')->getTemplateAttachment($storeId);

        if (!$fileWithPath) {
            return false;
        }

        $content = file_get_contents($fileWithPath);
        $type = Mage::getStoreConfig('newsletterpopup/email/mime');
        $disposition = Zend_Mime::DISPOSITION_ATTACHMENT;
        $encoding = Zend_Mime::ENCODING_BASE64;
        $fileNameTmp = explode('/', $fileWithPath);
        $fileName = $fileNameTmp[count($fileNameTmp)-1];

        switch (get_class($this->getMail())) {
            case 'Mandrill_Message':
                $this->getMail()->createAttachment(
                    $content,
                    $type,
                    $disposition,
                    $encoding,
                    $fileName
                );
                break;
            default:
                $attachment = new Zend_Mime_Part($content);
                $attachment->type = $type;
                $attachment->disposition = $disposition;
                $attachment->encoding = $encoding;
                $attachment->filename = $fileName;
                $this->getMail()->addAttachment($attachment);
                break;
        }

        return true;
    }
}