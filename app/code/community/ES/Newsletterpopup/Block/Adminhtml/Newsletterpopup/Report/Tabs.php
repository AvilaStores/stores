<?php

class ES_Newsletterpopup_Block_Adminhtml_Newsletterpopup_Report_Tabs
    extends Mage_Adminhtml_Block_Widget_Tabs
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('newsletterpopup_report_tabs');
        $this->setDestElementId('es_report_content');
    }
}
