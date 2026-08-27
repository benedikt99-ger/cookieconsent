<?php
namespace nuenemann\cookieconsent\Core;

use OxidEsales\Eshop\Core\Registry;


class ViewConfig extends ViewConfig_parent
{
	
    public function isCookieCategoryEnabled($sCategory)
    {

        if (self::isCookieCategoryMandatory($sCategory)){
            return true;
        }

        $cookie = $_COOKIE['cc-categories'];

        if ($cookie) {

            if ($cookie == 'ALL') {
                return true;
            }elseif ($cookie == 'NONE') {
                return false;
            }else{
                $categories = json_decode($cookie);
                return in_array($sCategory, $categories);
            }
        }

        /** @var agcookiecompliance_oxviewconfig $viewConfig */
		// $viewConfig = Registry::getConfig()->getActiveView()->getViewConfig();
        // in case of no decision cookies are set when opt-out or info is set
        /*
		return in_array(
            $viewConfig->getCookieComplianceModuleSetting( 'sConsentType'),
            ['opt-out','info']
        );		
		*/
		return true;

    }	
	
    /**
     * Returns the OXID of Germany.
     *
     * @return string
     */
    public function getGermanyId()
    {
        return \oxNew(\OxidEsales\Eshop\Application\Model\Country::class)->getIdByCode('de');
    }

    /**
     * @see DHLAdapter::isReady()
     * @return bool
     * @throws \OxidEsales\Eshop\Core\Exception\SystemComponentException
     * @throws \OxidEsales\Eshop\Core\Exception\ConnectionException
     */
    public function isDhlFinderAvailable()
    {
        $basket = \OxidEsales\Eshop\Core\Registry::getConfig()->getSession()->getBasket();
        $adapter = \OxidEsales\Eshop\Core\Registry::get(\Mediaopt\DHL\Adapter\DHLAdapter::class);
        return $adapter->isReady() && $basket->moAllowsDhlDelivery();
    }



    /**
     * @return array
     */
    public function ccGetCountriesList()
    {
        $countries = oxnew(CountryList::class);
        $countries->loadActiveCountries();

        $countriesForSelector = [];
        foreach ($countries->getArray() as $country) {
            $isoalpha2 = $country->oxcountry__oxisoalpha2->value;
            /*
			if (isset(ServiceProviderBuilder::DHL_COUNTRIES_LIST[$isoalpha2])) {
                $countriesForSelector[$country->oxcountry__oxid->value] = [
                    'isoalpha2' => $isoalpha2,
                    'title' => $country->oxcountry__oxtitle->rawValue
                ];
            }
			*/
        }

        return $countriesForSelector;
    }
}
