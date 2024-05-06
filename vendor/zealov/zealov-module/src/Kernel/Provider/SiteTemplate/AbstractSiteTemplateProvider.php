<?php

namespace Zealov\Kernel\Provider\SiteTemplate;



abstract class AbstractSiteTemplateProvider
{
    abstract public function name();

    abstract public function title();

    public function root()
    {
        return null;
    }
}
