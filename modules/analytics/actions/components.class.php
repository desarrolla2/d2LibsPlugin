<?php

class analyticsComponents extends sfComponents
{
  public function executeAnalytics(sfWebRequest $request)
  {
    $languages = array_keys(sfConfig::get('app_cultures_enabled'));
    $this->culture = $this->getUser()->getCulture();
    $this->all_languages = sfCultureInfo::getInstance($this->culture)->getLanguages( $languages);

    $territorial = $this->getUser()->getTerritorial();
    
    $this->hascatalan = is_object($territorial)?$territorial->hasTranslate('ca'):false;
    
    $this->analytics_account = sfConfig::get('app_analytics_account');
  }
}