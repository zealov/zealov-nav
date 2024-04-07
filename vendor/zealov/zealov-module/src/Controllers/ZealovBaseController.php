<?php


namespace Zealov\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;
use Zealov\Exception\ThrowException;
use Zealov\Models\SystemConfig;

class ZealovBaseController extends Controller
{
    protected $_viewBase = null;

    public function getModule()
    {
        static $module = null;
        if (null === $module) {
            $cls = get_class($this);
            if (preg_match('/^Module\\\\([\\w]+).*?/', $cls, $mat)) {
                $module = $mat[1];
            } else if (method_exists($this, 'getCurrentModule')) {
                $module = $this->getCurrentModule();
            } else {
                $module = '';
            }
        }
        return $module;
    }

    private function fetchViewPath($templateName, $templateRoot, $module, $device, $view)
    {
        $viewThemeCustom = "theme.$templateName.$device.$view";
        $viewTheme = "$templateRoot.$device.$view";
        if ($module) {
            $viewModule = "module::$module.View.$device.$view";
        }
        $viewDefault = "theme.default.$device.$view";
        if (view()->exists($viewThemeCustom)) {
            return $viewThemeCustom;
        }
        if (view()->exists($viewTheme)) {
            return $viewTheme;
        }
        if ($module) {
            if (view()->exists($viewModule)) {
                return $viewModule;
            }
        }
        if (view()->exists($viewDefault)) {
            return $viewDefault;
        }
        return null;
    }

    protected function viewPaths($view)
    {
        $module = $this->getModule();

        $templateName = SystemConfig::query()->where('key', 'siteTemplate')->value('value')??"default";

        $templateRoot = "theme.$templateName";

        $useView = $this->fetchViewPath($templateName, $templateRoot, $module, 'web', $view);

        $useFrameView = $this->fetchViewPath($templateName, $templateRoot, $module, 'web', 'frame');

        View::share('_viewFrame', $useFrameView);

        ThrowException::throwsIfEmpty('View Not Exists : ' . $view, $useView);

        return [$useView, $useFrameView];
    }


    protected function view($view, $viewData = [])
    {
        list($view, $frameView) = $this->viewPaths($view);
        return view($view, $viewData);
    }

    protected function viewRender($view, $viewData = [])
    {
        list($view, $frameView) = $this->viewPaths($view);
        return view($view, $viewData)->render();
    }

    protected function viewRealpath($view)
    {
        return View::getFinder()->find($view);
    }


}
