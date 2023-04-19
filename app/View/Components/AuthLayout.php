<?php

namespace App\View\Components;

use App\Contracts\BreadcrumbInterface;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\View\Component;
use Illuminate\View\View;

class AuthLayout extends Component
{
    /**
     * AuthLayout constructor
     *
     * @param Route $route
     */
    public function __construct(
        private readonly Route $route
    ) {

    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        $view = ViewFacade::make('layouts.auth-layout');

        if (!is_null($this->route->controller)) {
            $controller = $this->route->getController();

            if ($controller instanceof BreadcrumbInterface) {
                $view->with('breadcrumb', $this->route->controllerDispatcher()->dispatch(
                    $this->route, $controller, 'breadcrumb'
                )->resolve());
            }
        }

        return $view;
    }
}
