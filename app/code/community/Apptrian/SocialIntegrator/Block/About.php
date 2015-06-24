<?php
/**
 * @category   Apptrian
 * @package    Apptrian_SocialIntegrator
 * @author     Apptrian
 * @copyright  Copyright (c) 2015 Apptrian (http://www.apptrian.com)
 * @license    http://www.apptrian.com/license    Proprietary Software License (EULA)
 */
class Apptrian_SocialIntegrator_Block_About
    extends Mage_Adminhtml_Block_Abstract
    implements Varien_Data_Form_Element_Renderer_Interface
{

    /**
     * Render fieldset html
     *
     * @param Varien_Data_Form_Element_Abstract $element
     * @return string
     */
    public function render(Varien_Data_Form_Element_Abstract $element)
    {
    	$version  = Mage::helper('apptrian_socialintegrator')->getExtensionVersion();
        $logopath =	'http://www.apptrian.com/media/apptrian.gif';
        $html = <<<HTML
<div style="background:url('$logopath') no-repeat scroll 15px 15px #e7efef; border:1px solid #ccc; min-height:100px; margin:5px 0; padding:15px 15px 15px 140px;">
	<p>
		<strong>Apptrian Social Integrator Extension v$version</strong><br />
		Adds Open Graph, Google+ Markup, Pinterest Rich Pins, Twitter Cards, Social Buttons and Icons on Product, Category and CMS pages. Additionally there are dozens of options for customization.
	</p>
    <p>
        Website: <a href="http://www.apptrian.com" target="_blank">www.apptrian.com</a><br />
		Like, share and follow us on 
		<a href="https://www.facebook.com/apptrian" target="_blank">Facebook</a>, 
		<a href="https://plus.google.com/+ApptrianCom" target="_blank">Google+</a>, 
		<a href="http://www.pinterest.com/apptrian" target="_blank">Pinterest</a>, and 
        <a href="http://twitter.com/apptrian" target="_blank">Twitter</a>.<br />
        If you have any questions send email at <a href="mailto:service@apptrian.com">service@apptrian.com</a>.
    </p>
</div>
HTML;
        return $html;
    }
}
