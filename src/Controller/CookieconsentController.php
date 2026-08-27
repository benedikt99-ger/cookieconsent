<?php

declare(strict_types=1);

namespace nuenemann\cookieconsent\Controller;

use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Application\Controller\FrontendController;

/**
 * @eshopExtension
 *
 * This is an example for a module extension (chain extend) of
 * the shop start controller.
 * NOTE: class must not be final.
 */
class CookieconsentController extends FrontendController
{

   protected $_sThisTemplate = '@cookieconsent/cookieconsent.html.twig';
   
   protected $_isAjax = 0;

    public function getTitle()
    {
		// 2026bene todo neuer titel
        return Registry::getLang()->translateString("WITHDRAWAL_FORM", Registry::getLang()->getBaseLanguage(), false);
    }

    public function getBreadCrumb()
    {
        $aPaths = array();
        $aPath = array();

        $aPath['title'] = $this->getTitle();
        $aPath['link'] = 'index.php?cl=withdrawalform';
        $aPaths[] = $aPath;

        return $aPaths;
    }

	// Neue Funktion
	/* in TWIG dann:
	{% if getWdfPostValue('name') %}
		{{ getWdfPostValue('name') }}
	{% elseif oxcmp_user %}
		{{ oxcmp_user.oxuser__oxfname.value }} {{ oxcmp_user.oxuser__oxlname.value }}
	{% endif %}
	*/	
	public function getWdfPostValue(string $key)
	{
		$wdf = \OxidEsales\Eshop\Core\Registry::getRequest()->getRequestEscapedParameter('wdf');
		return $wdf[$key] ?? null;
	}

    public function isAjax()
    {
		return $this->_isAjax;
	}

    public function getReasons()
    {
        $aReasonst = Registry::getConfig()->getConfigParam('CookieConsentReasons');
        return (!empty($aReasonst) ? $aReasonst : false);
    }

    public function getRecaptchaSiteKey()
    {
        return Registry::getConfig()->getConfigParam('CookieConsentSitekey');
    }
 
    public function submitWithdrawal()
    {
        $wdf = Registry::getRequest()->getRequestEscapedParameter("wdf");

        if($wdf["datenschutz"] !== "1") {
            $this->addTplParam("submitError", "DATENSCHUTZ");
            return false;
        };

		// 2026bene kein _checkRecaptcha
        // if (!Registry::getConfig()->getUser() && !$this->_checkRecaptcha(Registry::getRequest()->getRequestEscapedParameter("g-recaptcha-response"))) {
        //     return;
        // }
		

        try {
            /** @var oxEmail $oEmail */
            $oEmail = oxNew("oxEmail");
			
			$sLogfile = Registry::getConfig()->getLogsDir() .'bn.log';
			file_put_contents($sLogfile, trim(date('Y-m-d H:i:s')." submitWithdrawal $wdf->name ".$wdf->name).PHP_EOL,FILE_APPEND);
			
            $x = $oEmail->sendWithdrawalRequestToOwner($wdf);
            $y = $oEmail->sendWithdrawalRequestToUser($wdf);
        } catch (Exception $oException) {
            $this->addTplParam("submitError", "3");
            $this->addTplParam("errorArgs", $oEmail->getShop()->oxshops__oxorderemail->value);
        }

        if ($x) {
            $this->addTplParam("submitSuccess", true);
        } else {
            $this->addTplParam("submitError", "3");
            $this->addTplParam("errorArgs", $oEmail->getShop()->oxshops__oxorderemail->value);
        }
        //if(!$r2) Registry::getUtils()->writeToLog("")
    }
	
}
