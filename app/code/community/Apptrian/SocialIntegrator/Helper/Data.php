<?php
/**
 * @category   Apptrian
 * @package    Apptrian_SocialIntegrator
 * @author     Apptrian
 * @copyright  Copyright (c) 2015 Apptrian (http://www.apptrian.com)
 * @license    http://www.apptrian.com/license    Proprietary Software License (EULA)
 */
class Apptrian_SocialIntegrator_Helper_Data extends Mage_Core_Helper_Abstract
{
	protected $socialNetworks = array(
		            'facebook'  => '1',
		            'google'    => '2',
		            'linkedin'  => '3',
		            'pinterest' => '4',
		            'twitter'   => '5'
		    	);
	
	/**
	 * Returns extension version.
	 *
	 * @return string
	 */
	public function getExtensionVersion()
	{
		return (string) Mage::getConfig()->getNode()->modules->Apptrian_SocialIntegrator->version;
	}
	
	/**
	 * Based on provided icon set type returns array of icons with all necessary data.
	 * 
	 * @param string $iconSet
	 * @return array
	 */
    public function getIcons($iconSet = 'primary_icons')
    {
    	
        $icons = array();
        
        $sortOrder = explode(',', Mage::getStoreConfig('apptrian_socialintegrator/' . $iconSet . '/icon_sort_order'));
        
        foreach ($sortOrder as $id) {
        	
            $network = array_search(trim($id), $this->socialNetworks);
            
            if (Mage::getStoreConfig('apptrian_socialintegrator/' . $iconSet . '/' . $network . '_enabled')) {
                
                $icons[$network]['url']  = Mage::getStoreConfig('apptrian_socialintegrator/' . $iconSet . '/' . $network . '_url');
                $icons[$network]['alt']  = Mage::getStoreConfig('apptrian_socialintegrator/' . $iconSet . '/' . $network . '_alt');
                $icons[$network]['file'] = str_replace('_icons', '', $iconSet) . '-' . $network . '-icon.png';
                
            }
            
        }
        
        return $icons;
        
    }
    
    /**
     * Based on provided buttonset returns sort order array.
     * 
     * @param string $buttonSet
     * @return array
     */
    public function getButtonSortOrder($buttonSet = 'product_buttons')
    {
    	
    	$buttonsSortOrder = array();
    	
    	$sortOrder = explode(',', Mage::getStoreConfig('apptrian_socialintegrator/' . $buttonSet . '/button_sort_order'));
    	
    	foreach ($sortOrder as $id) {
    		
    		$network = array_search(trim($id), $this->socialNetworks);
    		
    		if (Mage::getStoreConfig('apptrian_socialintegrator/' . $buttonSet . '/' . $network . '_enabled')) {
    		
    			$buttonsSortOrder[] = $network;
    		
    		}
    		
    	}
    	
    	return $buttonsSortOrder;
    	
    }
    
    /**
     * Based on config and provided data, returns a attributes string for pinterest buttons.
     * 
     * @param string $buttonType
     * @param string $buttonSet
     * @return string
     */
    public function getPinterestAttributes($buttonType = 'buttonPin', $buttonSet = 'product_buttons')
    {
    	
    	$dataPinColor  = Mage::getStoreConfig('apptrian_socialintegrator/' . $buttonSet . '/pinterest_data_pin_color');
    	$dataPinConfig = Mage::getStoreConfig('apptrian_socialintegrator/' . $buttonSet . '/pinterest_data_pin_config');
    	$dataPinShape  = Mage::getStoreConfig('apptrian_socialintegrator/' . $buttonSet . '/pinterest_data_pin_shape');
    	$size          = Mage::getStoreConfig('apptrian_socialintegrator/' . $buttonSet . '/pinterest_size');
    	// This exists only in product buttons settings and sets hover button on global scale
    	$hoverConfig   = Mage::getStoreConfig('apptrian_socialintegrator/product_buttons/pinterest_hover_button');
    	
    	$attribs = '';
    	
    	// Round button (circular)
    	if ($dataPinShape == 'round') {
    		 
    		$attribs .= ' data-pin-shape="' . $dataPinShape . '"';
    		 
    		if ($size == 'large') {
    			$attribs .= ' data-pin-height="32"';
    		}
    		 
    	// Normal button (rectangular)
    	} else {
    		
    		// Only for buttonPin (buttonBookmark and hover button do not have counter)
    		if ($dataPinConfig != '' && $buttonType == 'buttonPin') {
    			$attribs .= ' data-pin-config="' . $dataPinConfig . '"';
    			if ($dataPinConfig != 'none') {
    				$attribs .= ' data-pin-zero="true"';
    			}
    		}
    		
    		if ($dataPinColor != '' && $dataPinColor != 'gray') {
    			$attribs .= ' data-pin-color="' . $dataPinColor . '"';
    		}
    		
    		if ($size == 'large') {
    			$attribs .= ' data-pin-height="28"';
    		}
    		
    	}
    	
    	// For before_body_end.phtml and hover button
    	if ($buttonType == 'hover') {
    	    
    		if ($hoverConfig == 'off') {
    			
    			$attribs = ' ';
    			
    		} elseif ($hoverConfig == 'product_pages') {
    			
    			// If it is product page
    			if ($this->getPageType() == 'product') {
    				
    				$attribs .= ' data-pin-hover="true" ';
    				
    			// Not a product page
    			} else {
    				
    				$attribs = ' ';
    				
    			}
    			
    		} else {
    			
    			$attribs .= ' data-pin-hover="true" ';
    			
    		}
    		
        // For buttonPin and buttonBookmark
    	} else {
    		
    		return ' data-pin-do="' . $buttonType . '"'. $attribs . ' ';
    		
    	}
    	
    	return $attribs;
    	
    }
    
    /**
     * Returns type of page product/category/cms and if called with argument true additionally 
     * checks for home page.
     * 
     * @param boolean $checkHome
     * @return string
     */
    public function getPageType($checkHome = false)
    {
    	
    	$p = Mage::registry('current_product');
    	$c = Mage::registry('current_category');
    	$a = Mage::app()->getFrontController()->getAction()->getFullActionName();
    	$r = Mage::app()->getFrontController()->getRequest()->getRouteName();
    	
    	$pageType = null;
    	
    	if ($p && $p->getId() && $a == 'catalog_product_view') {
    		
    		return 'product';
    		
    	} elseif ($c && $c->getId() && $a == 'catalog_category_view') {
    		
    		return 'category';
    		
    	} elseif ($r == 'cms') {
    		
    		if ($checkHome) {
    			
    			$cmsIdentifier  = Mage::getSingleton('cms/page')->getIdentifier();
    			$homeIdentifier = Mage::app()->getStore()->getConfig('web/default/cms_home_page');
    			
    			if($cmsIdentifier === $homeIdentifier){
    				return 'home';
    			}
    			
    		}
    		
    		return 'cms';
    		
    	} else {
    		
    		return null;
    		
    	}
    	
    }
    
    /**
     * Returns store name or if it is not available then returns domain name.
     * 
     * @return string
     */
    public function getSiteName()
    {
    	$storeName = Mage::getStoreConfig('general/store_information/name');
    	
    	// If user did not enter store name in magento admin (General > Store Information > Store Name)
    	if ($storeName == '') {
    		
    		$storeName = $this->getDomainName();
    		
    	}
    	
    	return $storeName;
    	
    }
    
    /**
     * Returns domain name for twitter cards. It tries to get ti from config if not then
     * domain is returned programmatically.
     * 
     * @return string
     */
    public function getDomainName()
    {
    	$domain = Mage::getStoreConfig('apptrian_socialintegrator/twitter_cards/domain');
    	
    	if ($domain) {
    		
    		return $domain;
    		
    	} else {
    		
    		return str_ireplace(
    				array('http://', 'https://', 'www.', '/'), 
    				'', 
    				Mage::getModel('core/cookie')->getDomain());
    		
    	}
    	
    }
    
    /**
     * Based on provided Product object returns array of category names to which product belongs to.
     * If $type param is passed (true), method will return string (comma separated category names.)
     * 
     * @param Mage_Catalog_Model_Product $product
     * @param boolean $type
     * @return array|string
     */
    function getCategoryNamesProductBelongsTo($product, $type = false)
    {
    	$collection = $product->getCategoryCollection()
					    	->addAttributeToSelect('name')
					    	->addAttributeToFilter('is_active', 1)
					    	->addAttributeToSort('name', 'asc');
    	
    	$names = array();
    	
    	foreach ($collection as $c) {
    		$names[] = $c->getName();
    	}
    	
    	if ($type == true) {
    		
    		return implode(', ', $names);
    		
    	} else {
    		
    		return $names;
    		
    	}
    	
    }
    
    /**
     * Based of provided Product returns array of data for Twitter Cards secondary data. 
     * 
     * @param Mage_Catalog_Model_Product $product
     * @return array
     */
    public function getSecondaryDataForTwitterCard($product)
    {
    	$r = array();
    	
    	$config = Mage::getStoreConfig('apptrian_socialintegrator/twitter_cards/secondary_data');
    	
    	// Location option
    	if ($config == 'location') {
    		
    		$r['data']  = $this->getStoreCountryName();
    		$r['label'] = $this->toUppercase($this->__('Location'));
    		
        // Category option
    	} elseif ($config == 'category') {
    		
    		$cNames = $this->getCategoryNamesProductBelongsTo($product);
    		
    		$count = count($cNames);
    		
    		if ($count > 0) {
    			
    			$r['data']  = implode(', ', $cNames);
    			
    			if ($count == 1) {
    				$r['label'] = $this->toUppercase($this->__('Category'));
    			} else {
    				$r['label'] = $this->toUppercase($this->__('Categories'));
    			}
    			
    	    // Defaults to website
    		} else {
    			
    			$r['data']  = $this->getDomainName();
    			$r['label'] = $this->toUppercase($this->__('Website'));
    			
    		}
    		
   		// Website option
    	} else {
    		
    		$r['data']  = $this->getDomainName();
    		$r['label'] = $this->toUppercase($this->__('Website'));
    		
    	}
    	
    	return $r;
    	
    }
    
    /**
     * Based on config returns store's country name.
     * 
     * @return string
     */
    public function getStoreCountryName()
    {
    	
    	$countryCode = Mage::getStoreConfig('general/store_information/merchant_country');
    	
    	if ($countryCode) {
    		
    		$country = Mage::getModel('directory/country')->loadByCode($countryCode);
    		
    	} else {
    		
    		$country = Mage::getModel('directory/country')
    			->loadByCode(Mage::getStoreConfig('general/country/default'));
    		
    	}
    	
    	return $country->getName();
    	
    }
    
    /**
     * Based on provided string returns, uppercased string.
     * 
     * @param $string
     * @return string
     */
    public function toUppercase($string)
    {
    	
    	if (extension_loaded('mbstring')) {
    		
    		return mb_strtoupper($string, 'UTF-8');
    		
    	} else {
    		
    		return strtoupper($string);
    		
    	}
    	
    }
    
    /**
     * Converts datetime string to ISO 8601 datetime string used in Open Graph article meta tags.
     * 
     * @param string $datetimeString
     * @return string
     */
    public function datetimeToIso8601($datetimeString)
    {
    	
    	$format = 'Y-m-d H:i:s';
    	
    	$mySqlDatetime = date($format, strtotime($datetimeString));
    	
    	$datetime = DateTime::createFromFormat($format, $mySqlDatetime);
    	$datetime->setTimezone(new DateTimeZone('GMT'));
    
    	return $datetime->format('c');
    	
    }
    
    /**
     * Checks if product is in stock or not.
     * If second parametar is passed (true) method will return text for Open Graph meta tag.
     * 
     * @param Mage_Catalog_Model_Product $product
     * @return boolean
     */
    public function isInStock($product, $text = false)
    {
    	$stock = $product->getStockItem();
    	
    	if ($stock->getIsInStock()) {
    		
    		if ($text == 'og') {
    			return 'instock';
    		} elseif ($text == 'schema') {
    			return 'http://schema.org/InStock';
    		} else {
    			return true;
    		}
    		
    	} else {
    		
    		if ($text == 'og') {
    			return 'oos';
    		} elseif ($text == 'schema') {
    			return 'http://schema.org/OutOfStock';
    		} else {
    			return false;
    		}
    		
    	}
    }
    
    /**
     * Based on current page type, returns array of metadata or null.
     * 
     * @return array|null
     */
    public function getMetaTagsData()
    {
    	
    	$pageType = $this->getPageType();
    	
    	if ($pageType == 'product') {
    		
    		return $this->getMetaTagsDataForProductPage();
    		
    	} elseif ($pageType == 'category') {
    		
    		return $this->getMetaTagsDataForCategoryPage();
    		
    	} elseif ($pageType == 'cms') {
    		
    		return $this->getMetaTagsDataForCmsPage();
    		
    	} else {
    		
    		return null;
    		
    	}
    	
    }
    
    /**
     * Returns array of metadata for product pages.
     * 
     * @return array
     */
    public function getMetaTagsDataForProductPage()
    {
    	
    	$helper  = Mage::helper('catalog/output');
    	$product = Mage::registry('current_product');
    	
    	$name            = $helper->productAttribute($product, $product->getName(), 'name');
    	$description     = $helper->productAttribute($product, $product->getMetaDescription(), 'meta_description');
    	// if description is not present use name for this field
    	if ($description == '') {
    		$description = $name;
    	}
    	
    	$image           = Mage::helper('catalog/image')->init($product, 'image')->__toString();
    	
    	$images = array();
    	
    	// Primary image
    	$images[] = $image;
    	
    	// More view images
    	foreach ($product->getMediaGalleryImages() as $img) {
    		// If image is not disabled and it is not default/primary one
    		if ($img->getDisabled() == 0 && $img->getPositionDefault() != 1) {
    			$images[] = Mage::helper('catalog/image')->init($product, 'image', $img->getFile())->__toString();
    		}
    	}
    	
    	$url             = $product->getUrlModel()->getUrl($product, array('_ignore_category' => true));
    	$siteName        = $this->getSiteName();
    	
    	$productType = $product->getTypeId();
    	
    	if ($productType == 'grouped') {
    	
    		$associatedProducts = $product->getTypeInstance(true)->getAssociatedProducts($product);
    	
    		$prices = array();
    	
    		foreach($associatedProducts as $associatedProduct) {
    			$prices[] = $associatedProduct->getPrice();
    		}
    	
    		if (count($prices) > 0) {
    			// ex: float 19.99
    			$price           = number_format(min($prices), 2, '.', '');
    			// formated price ex: $89.99
    			$priceFormatted  = Mage::helper('core')->currency(min($prices), true, false);
    			
    		} else {
    			// ex: float 19.99
    			$price           = number_format(0, 2, '.', '');
    			// formated price ex: $89.99
    			$priceFormatted  = Mage::helper('core')->currency(0, true, false);
    		}
    	
    	} else {
    		// ex: float 19.99
    		$price           = number_format($product->getFinalPrice(), 2, '.', '');
    		// formated price ex: $89.99
    		$priceFormatted  = Mage::helper('core')->currency($product->getFinalPrice(), true, false);
    	}
    	
    	$currencyCode    = strtoupper(Mage::app()->getStore()->getCurrentCurrencyCode());
    	$secondary       = $this->getSecondaryDataForTwitterCard($product);
    	$domain          = $this->getDomainName();
    	
    	$logoUrl         = Mage::getDesign()->getSkinUrl(Mage::getStoreConfig('design/header/logo_src'));
    	$manufacturer    = Mage::helper('core')->htmlEscape($product->getAttributeText('manufacturer'));
    	$sku             = $helper->productAttribute($product, $product->getSku(), 'sku');
    	
    	$r = array();
    	
    	// Open Graph data
    	if (Mage::getStoreConfig('apptrian_socialintegrator/open_graph/enabled')
    		&& strpos(Mage::getStoreConfig('apptrian_socialintegrator/open_graph/pages'), 'product') !== false
    	) {
    		
    		$fbAdmins = Mage::getStoreConfig('apptrian_socialintegrator/open_graph/facebook_admins');
    		$fbAppId  = Mage::getStoreConfig('apptrian_socialintegrator/open_graph/facebook_app_id');
    		
	    	$r['og']['og:title']               = $name;
	    	$r['og']['og:type']                = 'og:product';
	    	$r['og']['og:url']                 = $url;
	    	$r['og']['og:imageArray']          = $images;
	    	$r['og']['og:description']         = $description;
	    	$r['og']['og:site_name']           = $siteName;
	    	$r['og']['og:locale']              = Mage::app()->getLocale()->getLocaleCode();
	    	$r['og']['product:brand']          = $siteName;
	    	$r['og']['product:availability']   = $this->isInStock($product, 'og');
	    	$r['og']['product:price:amount']   = $price;
	    	$r['og']['product:price:currency'] = $currencyCode;
	    	
	    	if ($fbAdmins) {
	    		$r['og']['fb:admins'] = $fbAdmins;
	    	}
	    	if ($fbAppId) {
	    		$r['og']['fb:app_id'] = $fbAppId;
	    	}
	    	
    	} else {
    		
    		$r['og'] = null;
    		
    	}
    	
    	// Schema.org data
    	if (Mage::getStoreConfig('apptrian_socialintegrator/schema_org/enabled')
    		&& strpos(Mage::getStoreConfig('apptrian_socialintegrator/schema_org/pages'), 'product') !== false
    		&& Mage::getStoreConfig('apptrian_socialintegrator/schema_org/meta_tags_enabled')
    	) {
    		
    		$r['schema']['name']                   = $name;
    		$r['schema']['description']            = $description;
    		$r['schema']['imageArray']             = $images;
    		$r['schema']['url']                    = $url;
    		$r['schema']['logo']                   = $logoUrl;
    		$r['schema']['brand']                  = $siteName;
    		if ($manufacturer) {
    			$r['schema']['manufacturer']       = $manufacturer;
    		}
    		$r['schema']['sku']                    = $sku;
    		
    	} else {
    		
    		$r['schema'] = null;
    		
    	}
    	
    	// Twitter Card data
    	if (Mage::getStoreConfig('apptrian_socialintegrator/twitter_cards/enabled')
    		&& strpos(Mage::getStoreConfig('apptrian_socialintegrator/twitter_cards/pages'), 'product') !== false
    	) {
    		
    		$r['twitter']['twitter:card']        = 'product';
    		$r['twitter']['twitter:site']        = Mage::getStoreConfig('apptrian_socialintegrator/twitter_cards/site_username');
    		$twitterCreator = Mage::getStoreConfig('apptrian_socialintegrator/twitter_cards/creator_username');
    		if ($twitterCreator) {
    			$r['twitter']['twitter:creator'] = $twitterCreator;
    		}
    		$r['twitter']['twitter:title']       = $name;
    		$r['twitter']['twitter:description'] = $description;
    		$r['twitter']['twitter:image:src']   = $image;
    		$r['twitter']['twitter:data1']       = $priceFormatted;
    		$r['twitter']['twitter:label1']      = $currencyCode;
    		$r['twitter']['twitter:data2']       = $secondary['data'];
    		$r['twitter']['twitter:label2']      = $secondary['label'];
    		$r['twitter']['twitter:domain']      = $domain;
    		
    		if (Mage::getStoreConfig('apptrian_socialintegrator/twitter_cards/mobile_apps_enabled')) {
    		
    			$twitterAppNameIphone = Mage::getStoreConfig('apptrian_socialintegrator/twitter_cards/app_name_iphone');
    			if ($twitterAppNameIphone) {
    				$r['twitter']['twitter:app:name:iphone']     = $twitterAppNameIphone;
    			}
    			
    			$twitterAppNameIpad = Mage::getStoreConfig('apptrian_socialintegrator/twitter_cards/app_name_ipad');
    			if ($twitterAppNameIpad) {
    				$r['twitter']['twitter:app:name:ipad']       = $twitterAppNameIpad;
    			}
    			
    			$twitterAppNameGoogleplay = Mage::getStoreConfig('apptrian_socialintegrator/twitter_cards/app_name_googleplay');
    			if ($twitterAppNameGoogleplay) {
    				$r['twitter']['twitter:app:name:googleplay'] = $twitterAppNameGoogleplay;
    			}
    			
    			$twitterAppUrlIphone = Mage::getStoreConfig('apptrian_socialintegrator/twitter_cards/app_url_iphone');
    			if ($twitterAppUrlIphone) {
    				$r['twitter']['twitter:app:url:iphone']      = $twitterAppUrlIphone;
    			}
    		
    			$twitterAppUrlIpad = Mage::getStoreConfig('apptrian_socialintegrator/twitter_cards/app_url_ipad');
    			if ($twitterAppUrlIpad) {
    				$r['twitter']['twitter:app:url:ipad']        = $twitterAppUrlIpad;
    			}
    			
    			$twitterAppUrlGoogleplay = Mage::getStoreConfig('apptrian_socialintegrator/twitter_cards/app_url_googleplay');
    			if ($twitterAppUrlGoogleplay) {
    				$r['twitter']['twitter:app:url:googleplay']  = $twitterAppUrlGoogleplay;
    			}
    		
    			$twitterAppIdIphone = Mage::getStoreConfig('apptrian_socialintegrator/twitter_cards/app_id_iphone');
    			if ($twitterAppIdIphone) {
    				$r['twitter']['twitter:app:id:iphone']       = $twitterAppIdIphone;
    			}
    			
    			$twitterAppIdIpad = Mage::getStoreConfig('apptrian_socialintegrator/twitter_cards/app_id_ipad');
    			if ($twitterAppIdIpad) {
    				$r['twitter']['twitter:app:id:ipad']         = $twitterAppIdIpad;
    			}
    		
    			$twitterAppIdGoogleplay = Mage::getStoreConfig('apptrian_socialintegrator/twitter_cards/app_id_googleplay');
    			if ($twitterAppIdGoogleplay) {
    				$r['twitter']['twitter:app:id:googleplay']   = $twitterAppIdGoogleplay;
    			}
    			
    		}
    		
    	} else {
    		
    		$r['twitter'] = null;
    		
    	}
    	
    	return $r;
    	
    }
    
    /**
     * Returns array of metadata for category pages.
     *
     * @return array
     */
    public function getMetaTagsDataForCategoryPage()
    {
    	 
    	$helper   = Mage::helper('catalog/output');
    	$category = Mage::registry('current_category');
    
    	$name            = $helper->categoryAttribute($category, $category->getName(), 'name');
    	$description     = $helper->categoryAttribute($category, $category->getMetaDescription(), 'meta_description');
    	// if description is not present use name for this field
    	if ($description == '') {
    		$description = $name;
    	}
    	$url             = $category->getUrl();
    	$siteName        = $this->getSiteName();
    	$domain          = $this->getDomainName();
    	
    	$createdAt       = $this->datetimeToIso8601($category->getCreatedAt());
    	$updatedAt       = $this->datetimeToIso8601($category->getUpdatedAt());
    	
    	$r = array();
    	
    	// Open Graph data
    	if (Mage::getStoreConfig('apptrian_socialintegrator/open_graph/enabled')
    		&& strpos(Mage::getStoreConfig('apptrian_socialintegrator/open_graph/pages'), 'category') !== false
    	) {
    		
    		$fbAdmins    = Mage::getStoreConfig('apptrian_socialintegrator/open_graph/facebook_admins');
    		$fbAppId     = Mage::getStoreConfig('apptrian_socialintegrator/open_graph/facebook_app_id');
    		$fbProfileId = Mage::getStoreConfig('apptrian_socialintegrator/open_graph/facebook_profile_id');
    		 
    		$r['og']['og:title']               = $name;
    		$r['og']['og:type']                = 'article';
    		$r['og']['og:url']                 = $url;
    		
    		$ogImage = $this->getCategoryImageUrl($category, 'open_graph');
    		
    		if ($ogImage != '') {
    			$r['og']['og:image']           = $ogImage;
    		}
    		
    		$r['og']['og:description']         = $description;
    		$r['og']['og:site_name']           = $siteName;
    		$r['og']['og:locale']              = Mage::app()->getLocale()->getLocaleCode();
    		if ($fbAdmins) {
    			$r['og']['fb:admins']          = $fbAdmins;
    		}
    		if ($fbAppId) {
    			$r['og']['fb:app_id']          = $fbAppId;
    		}
    		if ($fbProfileId) {
    			$r['og']['article:author']     = $fbProfileId;
    		}
    		$r['og']['article:published_time'] = $createdAt;
    		$r['og']['article:modified_time']  = $updatedAt;
    		
    	} else {
    
    		$r['og'] = null;
    
    	}
    	 
    	// Schema.org data
    	if (Mage::getStoreConfig('apptrian_socialintegrator/schema_org/enabled')
    		&& strpos(Mage::getStoreConfig('apptrian_socialintegrator/schema_org/pages'), 'category') !== false
    		&& Mage::getStoreConfig('apptrian_socialintegrator/schema_org/meta_tags_enabled')
    	) {
    
    		$r['schema']['name']        = $name;
    		$r['schema']['description'] = $description;
    		
    		$schemaImage = $this->getCategoryImageUrl($category, 'schema_org');
    		
    		if ($schemaImage != '') {
    			$r['schema']['image']   = $schemaImage;
    		}
    		
    	} else {
    
    		$r['schema'] = null;
    
    	}
    	 
    	// Twitter Card data
    	if (Mage::getStoreConfig('apptrian_socialintegrator/twitter_cards/enabled')
    		&& strpos(Mage::getStoreConfig('apptrian_socialintegrator/twitter_cards/pages'), 'category') !== false
    	) {
    		
    		$r['twitter']['twitter:card']        = Mage::getStoreConfig('apptrian_socialintegrator/twitter_cards/category_card_type');
    		$r['twitter']['twitter:site']        = Mage::getStoreConfig('apptrian_socialintegrator/twitter_cards/site_username');
    		$twitterCreator = Mage::getStoreConfig('apptrian_socialintegrator/twitter_cards/creator_username');
    		if ($twitterCreator) {
    			$r['twitter']['twitter:creator'] = $twitterCreator;
    		}
    		$r['twitter']['twitter:title']       = $name;
    		$r['twitter']['twitter:description'] = $description;
    		
    		$twitterCardImageSrc = $this->getCategoryImageUrl($category, 'twitter_cards');
    		
    		if ($twitterCardImageSrc != '') {
    			$r['twitter']['twitter:image:src'] = $twitterCardImageSrc;
    		}
    		
    		$r['twitter']['twitter:domain']      = $domain;
    
    		if (Mage::getStoreConfig('apptrian_socialintegrator/twitter_cards/mobile_apps_enabled')) {
    
    			$twitterAppNameIphone = Mage::getStoreConfig('apptrian_socialintegrator/twitter_cards/app_name_iphone');
    			if ($twitterAppNameIphone) {
    				$r['twitter']['twitter:app:name:iphone']     = $twitterAppNameIphone;
    			}
    			 
    			$twitterAppNameIpad = Mage::getStoreConfig('apptrian_socialintegrator/twitter_cards/app_name_ipad');
    			if ($twitterAppNameIpad) {
    				$r['twitter']['twitter:app:name:ipad']       = $twitterAppNameIpad;
    			}
    			 
    			$twitterAppNameGoogleplay = Mage::getStoreConfig('apptrian_socialintegrator/twitter_cards/app_name_googleplay');
    			if ($twitterAppNameGoogleplay) {
    				$r['twitter']['twitter:app:name:googleplay'] = $twitterAppNameGoogleplay;
    			}
    			 
    			$twitterAppUrlIphone = Mage::getStoreConfig('apptrian_socialintegrator/twitter_cards/app_url_iphone');
    			if ($twitterAppUrlIphone) {
    				$r['twitter']['twitter:app:url:iphone']      = $twitterAppUrlIphone;
    			}
    
    			$twitterAppUrlIpad = Mage::getStoreConfig('apptrian_socialintegrator/twitter_cards/app_url_ipad');
    			if ($twitterAppUrlIpad) {
    				$r['twitter']['twitter:app:url:ipad']        = $twitterAppUrlIpad;
    			}
    			 
    			$twitterAppUrlGoogleplay = Mage::getStoreConfig('apptrian_socialintegrator/twitter_cards/app_url_googleplay');
    			if ($twitterAppUrlGoogleplay) {
    				$r['twitter']['twitter:app:url:googleplay']  = $twitterAppUrlGoogleplay;
    			}
    
    			$twitterAppIdIphone = Mage::getStoreConfig('apptrian_socialintegrator/twitter_cards/app_id_iphone');
    			if ($twitterAppIdIphone) {
    				$r['twitter']['twitter:app:id:iphone']       = $twitterAppIdIphone;
    			}
    			 
    			$twitterAppIdIpad = Mage::getStoreConfig('apptrian_socialintegrator/twitter_cards/app_id_ipad');
    			if ($twitterAppIdIpad) {
    				$r['twitter']['twitter:app:id:ipad']         = $twitterAppIdIpad;
    			}
    
    			$twitterAppIdGoogleplay = Mage::getStoreConfig('apptrian_socialintegrator/twitter_cards/app_id_googleplay');
    			if ($twitterAppIdGoogleplay) {
    				$r['twitter']['twitter:app:id:googleplay']   = $twitterAppIdGoogleplay;
    			}
    			 
    		}
    
    	} else {
    
    		$r['twitter'] = null;
    
    	}
    	 
    	return $r;
    	 
    }
    
    /**
     * Returns array of metadata for cms pages.
     * 
     * @return array
     */
    public function getMetaTagsDataForCmsPage()
    {
    
    	$name            = htmlspecialchars(Mage::getSingleton('cms/page')->getTitle());
    	$description     = htmlspecialchars(Mage::app()->getLayout()->getBlock('head')->getDescription());
    	// if description is not present use name for this field
    	if ($description == '') {
    		$description = $name;
    	}
    	// This will return placeholder image
    	$image           = Mage::getModel('catalog/product')->getSmallImageUrl(600,600);
    	$url             = Mage::helper('core/url')->getCurrentUrl();
    	$siteName        = $this->getSiteName();
    	 
    	$domain          = $this->getDomainName();
    	
    	$createdAt       = $this->datetimeToIso8601(Mage::getSingleton('cms/page')->getCreationTime());
    	$updatedAt       = $this->datetimeToIso8601(Mage::getSingleton('cms/page')->getUpdateTime());
    	
    	// bof Images
    	
    	$images = array();

    	$processor = Mage::helper('cms')->getPageTemplateProcessor();
    	$content   = $processor->filter(Mage::getSingleton('cms/page')->getContent());
    	
    	preg_match_all('/src="[\p{L}\p{N}_,;:!&#\?\+\-\.\/]*"/iu', $content, $matches, PREG_OFFSET_CAPTURE);
    	
    	foreach ($matches[0] as $m) {
    		// Extract only url
    		$pImage = str_ireplace(array('src="', '"'), array('', ''), $m[0]);
    		// If it is an image add to images array
    		if (preg_match('/(\.gif|\.jpg|\.jpeg|\.png)$/iu', $pImage)) {
    			$images[] = $pImage;
    		}
    	}
    	
    	// If there are no images set placeholder image 
    	// else overide $image var with first found image
    	if (count($images) == 0) {
    		$images[] = $image;
    	} else {
    		$image = $images[0];
    	}
    	
    	// eof Images
    	
    	$r = array();
    	
    	// Open Graph data
    	if (Mage::getStoreConfig('apptrian_socialintegrator/open_graph/enabled')
    		&& strpos(Mage::getStoreConfig('apptrian_socialintegrator/open_graph/pages'), 'cms') !== false
    	) {
    		
    		$fbAdmins    = Mage::getStoreConfig('apptrian_socialintegrator/open_graph/facebook_admins');
    		$fbAppId     = Mage::getStoreConfig('apptrian_socialintegrator/open_graph/facebook_app_id');
    		$fbProfileId = Mage::getStoreConfig('apptrian_socialintegrator/open_graph/facebook_profile_id');
    		 
    		$r['og']['og:title']               = $name;
    		$r['og']['og:type']                = 'article';
    		$r['og']['og:url']                 = $url;
    		$r['og']['og:imageArray']          = $images;
    		$r['og']['og:description']         = $description;
    		$r['og']['og:site_name']           = $siteName;
    		$r['og']['og:locale']              = Mage::app()->getLocale()->getLocaleCode();
    		if ($fbAdmins) {
    			$r['og']['fb:admins']          = $fbAdmins;
    		}
    		if ($fbAppId) {
    			$r['og']['fb:app_id']          = $fbAppId;
    		}
    		if ($fbProfileId) {
    			$r['og']['article:author']     = $fbProfileId;
    		}
    		$r['og']['article:published_time'] = $createdAt;
    		$r['og']['article:modified_time']  = $updatedAt;
    
    	} else {
    
    		$r['og'] = null;
    
    	}
    
    	// Schema.org data
    	if (Mage::getStoreConfig('apptrian_socialintegrator/schema_org/enabled')
    		&& strpos(Mage::getStoreConfig('apptrian_socialintegrator/schema_org/pages'), 'cms') !== false
    		&& Mage::getStoreConfig('apptrian_socialintegrator/schema_org/meta_tags_enabled')
    	) {
    		
    		$r['schema']['name']        = $name;
    		$r['schema']['description'] = $description;
    		$r['schema']['imageArray']             = $images;
    
    	} else {
    
    		$r['schema'] = null;
    
    	}
    
    	// Twitter Card data
    	if (Mage::getStoreConfig('apptrian_socialintegrator/twitter_cards/enabled')
    		&& strpos(Mage::getStoreConfig('apptrian_socialintegrator/twitter_cards/pages'), 'cms') !== false
    	) {
    
    		$r['twitter']['twitter:card']        = 'summary';
    		$r['twitter']['twitter:site']        = Mage::getStoreConfig('apptrian_socialintegrator/twitter_cards/site_username');
    		$twitterCreator = Mage::getStoreConfig('apptrian_socialintegrator/twitter_cards/creator_username');
    		if ($twitterCreator) {
    			$r['twitter']['twitter:creator'] = $twitterCreator;
    		}
    		$r['twitter']['twitter:title']       = $name;
    		$r['twitter']['twitter:description'] = $description;
    		$r['twitter']['twitter:image:src']   = $image;
    		$r['twitter']['twitter:domain']      = $domain;
    
    		if (Mage::getStoreConfig('apptrian_socialintegrator/twitter_cards/mobile_apps_enabled')) {
    
    			$twitterAppNameIphone = Mage::getStoreConfig('apptrian_socialintegrator/twitter_cards/app_name_iphone');
    			if ($twitterAppNameIphone) {
    				$r['twitter']['twitter:app:name:iphone']     = $twitterAppNameIphone;
    			}
    
    			$twitterAppNameIpad = Mage::getStoreConfig('apptrian_socialintegrator/twitter_cards/app_name_ipad');
    			if ($twitterAppNameIpad) {
    				$r['twitter']['twitter:app:name:ipad']       = $twitterAppNameIpad;
    			}
    
    			$twitterAppNameGoogleplay = Mage::getStoreConfig('apptrian_socialintegrator/twitter_cards/app_name_googleplay');
    			if ($twitterAppNameGoogleplay) {
    				$r['twitter']['twitter:app:name:googleplay'] = $twitterAppNameGoogleplay;
    			}
    
    			$twitterAppUrlIphone = Mage::getStoreConfig('apptrian_socialintegrator/twitter_cards/app_url_iphone');
    			if ($twitterAppUrlIphone) {
    				$r['twitter']['twitter:app:url:iphone']      = $twitterAppUrlIphone;
    			}
    
    			$twitterAppUrlIpad = Mage::getStoreConfig('apptrian_socialintegrator/twitter_cards/app_url_ipad');
    			if ($twitterAppUrlIpad) {
    				$r['twitter']['twitter:app:url:ipad']        = $twitterAppUrlIpad;
    			}
    
    			$twitterAppUrlGoogleplay = Mage::getStoreConfig('apptrian_socialintegrator/twitter_cards/app_url_googleplay');
    			if ($twitterAppUrlGoogleplay) {
    				$r['twitter']['twitter:app:url:googleplay']  = $twitterAppUrlGoogleplay;
    			}
    
    			$twitterAppIdIphone = Mage::getStoreConfig('apptrian_socialintegrator/twitter_cards/app_id_iphone');
    			if ($twitterAppIdIphone) {
    				$r['twitter']['twitter:app:id:iphone']       = $twitterAppIdIphone;
    			}
    
    			$twitterAppIdIpad = Mage::getStoreConfig('apptrian_socialintegrator/twitter_cards/app_id_ipad');
    			if ($twitterAppIdIpad) {
    				$r['twitter']['twitter:app:id:ipad']         = $twitterAppIdIpad;
    			}
    
    			$twitterAppIdGoogleplay = Mage::getStoreConfig('apptrian_socialintegrator/twitter_cards/app_id_googleplay');
    			if ($twitterAppIdGoogleplay) {
    				$r['twitter']['twitter:app:id:googleplay']   = $twitterAppIdGoogleplay;
    			}
    
    		}
    
    	} else {
    
    		$r['twitter'] = null;
    
    	}
    
    	return $r;
    
    }
    
    /**
     * Based of provided data returns proper category image url.
     * 
     * @param Mage_Catalog_Model_Category $category
     * @param string $config
     * @param boolean $placeholder
     * @return string
     */
    public function getCategoryImageUrl($category, $config, $placeholder = false)
    {
    	
    	$placeholderUrl = Mage::getModel('catalog/product')->getSmallImageUrl(600,600);
    	
    	if ($config == 'open_graph') {
    		
    		$imageConfig = Mage::getStoreConfig('apptrian_socialintegrator/open_graph/category_image');
    		
    	} elseif ($config == 'schema_org') {
    		
    		$imageConfig = Mage::getStoreConfig('apptrian_socialintegrator/schema_org/category_image');
    		
    	} elseif ($config == 'twitter_cards') {
    		
    		$imageConfig = Mage::getStoreConfig('apptrian_socialintegrator/twitter_cards/category_image');
    	
    	} elseif ($config == 'pinterest_button') {
    		
    		$imageConfig = Mage::getStoreConfig('apptrian_socialintegrator/category_buttons/category_image');
    		
    	} else {
    		
    		if ($placeholder) {
    			
    			return $placeholderUrl;
    			
    		} else {
    			
    			return '';
    			
    		}
    		
    	}
    	
    	$imageUrl = '';
    	 
    	if ($imageConfig == 'image') {
    	
    		$image = $category->getImage();
    	
    		if ($image != '') {
    			 
    			$imageUrl = Mage::getBaseUrl('media') . 'catalog/category/' . $image;
    			 
    		} else {
    			 
    			$imageUrl = '';
    			 
    		}
    	
    	} elseif ($imageConfig == 'thumbnail') {
    	
    		$image = $category->getThumbnail();
    	
    		if ($image != '') {
    	
    			$imageUrl = Mage::getBaseUrl('media') . 'catalog/category/' . $image;
    	
    		} else {
    	
    			$imageUrl = '';
    	
    		}
    	
    	} else {
    	
    		$imageUrl = '';
    	
    	}
    	
    	if ($placeholder == true && $imageUrl == '') {
    		
    		return $placeholderUrl;
    		
    	} else {
    		
    		return $imageUrl;
    		
    	}
    	
    }
    
    /**
     * Returns prefix string used in head tag nedded for open graph and schema.org markup.
     * 
     * @return string|boolean
     */
    public function getHeadTagPrefixAttibute()
    {
    	
    	$pageType = $this->getPageType();
    	
    	$prefix = '';
    	
    	if ($pageType == 'category') {
    		
    		if (Mage::getStoreConfig('apptrian_socialintegrator/open_graph/enabled')
    			&& strpos(Mage::getStoreConfig('apptrian_socialintegrator/open_graph/pages'), 'category') !== false
    		) {
    			 
    			$prefix .= 'prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#" ';
    			 
    		}
    		
    		if (Mage::getStoreConfig('apptrian_socialintegrator/schema_org/enabled')
    			&& strpos(Mage::getStoreConfig('apptrian_socialintegrator/schema_org/pages'), 'category') !== false
    			&& Mage::getStoreConfig('apptrian_socialintegrator/schema_org/meta_tags_enabled')
    		) {
    			 
    			$prefix .= 'itemscope itemtype="http://schema.org/Article" ';
    			 
    		}
    		
    	} elseif ($pageType == 'cms') {
    		
    		if (Mage::getStoreConfig('apptrian_socialintegrator/open_graph/enabled')
    			&& strpos(Mage::getStoreConfig('apptrian_socialintegrator/open_graph/pages'), 'cms') !== false
    		) {
    			
    			$prefix .= 'prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#" ';
    			
    		}
    		
    		if (Mage::getStoreConfig('apptrian_socialintegrator/schema_org/enabled')
    			&& strpos(Mage::getStoreConfig('apptrian_socialintegrator/schema_org/pages'), 'cms') !== false
    			&& Mage::getStoreConfig('apptrian_socialintegrator/schema_org/meta_tags_enabled')
    		) {
    			
    			$prefix .= 'itemscope itemtype="http://schema.org/Article" ';
    			
    		}
    		
    	} elseif ($pageType == 'product') {
    		
    		if (Mage::getStoreConfig('apptrian_socialintegrator/open_graph/enabled')
    			&& strpos(Mage::getStoreConfig('apptrian_socialintegrator/open_graph/pages'), 'product') !== false
    		) {
    			
    			$prefix .= 'prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# product: http://ogp.me/ns/product#" ';
    			
    		}
    		
    		if (Mage::getStoreConfig('apptrian_socialintegrator/schema_org/enabled')
    			&& strpos(Mage::getStoreConfig('apptrian_socialintegrator/schema_org/pages'), 'product') !== false
    			&& Mage::getStoreConfig('apptrian_socialintegrator/schema_org/meta_tags_enabled')
    		) {
    			
    			$prefix .= 'itemscope itemtype="http://schema.org/Product" ';
    			
    		}
    		
    	} else {
    		
    		$prefix = false;
    		
    	}
    	
    	return $prefix;
    	
    }
    
}