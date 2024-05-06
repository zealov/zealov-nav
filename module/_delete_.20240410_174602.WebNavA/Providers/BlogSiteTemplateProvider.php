<?php


namespace Module\WebNavA\Providers;


use Zealov\Kernel\Provider\SiteTemplate\AbstractSiteTemplateProvider;

class BlogSiteTemplateProvider extends AbstractSiteTemplateProvider
{
    const NAME = 'WebNavA';

    public function name()
    {
        return self::NAME;
    }

    public function title()
    {
        return 'WebNavA简约主题';
    }

    public function root()
    {
        return 'module::WebNavA.View';
    }

}
