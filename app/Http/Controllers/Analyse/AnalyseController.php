<?php

namespace App\Http\Controllers\Analyse;

use App\Helpers\Breadcrumbs\Breadcrumb;
use App\Http\Requests\AnalyseRequest;
use App\Contracts\BreadcrumbInterface;
use App\Services\AnalyseMeasurementService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\View\View;

class AnalyseController implements BreadcrumbInterface
{
    public function __construct(
        private readonly AnalyseMeasurementService $service
    ) {
        //
    }

    public function breadcrumb(): Breadcrumb
    {
        return Breadcrumb::create(trans('Analyse'), route('analyse'));
    }

    /**
     * @return View
     */
    public function index(): View
    {
        $factory = $this->service->getFactory();
        $view = ViewFacade::make('analyse.index', $this->service->toArray([
            'interval' => $factory->getInterval(),
            'format' => $factory->getFormat()
        ]));

        if ($this->service->hasSelection()) {
            $view->with('values', $factory->handle()->toJson());
        }

        return $view;
    }

    /**
     * @param AnalyseRequest $request
     *
     * @return RedirectResponse
     */
    public function store(AnalyseRequest $request): RedirectResponse
    {
        $this->service->setSelection($request->validated());

        return Redirect::route('analyse');
    }
}
