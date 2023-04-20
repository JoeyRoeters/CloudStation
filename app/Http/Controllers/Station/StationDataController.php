<?php

namespace App\Http\Controllers\Station;

use App\Exceptions\Stations\StationDataApiException;
use App\Http\Controllers\Controller;
use App\Models\Station;
use App\Models\Measurement;
use App\Services\StoreMeasurementService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class StationDataController extends Controller
{
    public function __construct(
        private readonly StoreMeasurementService $service
    ) {

    }

    public function store(Request $request)
    {
        $weatherData = $request->get('WEATHERDATA', []);

        foreach ($weatherData as $data) {
            $data['STN'] = (int) $data['STN'];

            $validator = Validator::make($data, [
                'STN' => ['required', Rule::exists(Station::class, 'name')]
            ]);

            if ($validator->fails()) {
                Log::error('Station not found');

                continue;
            }

            $measurement = new Measurement(
                $this->service->resolveAttributes($data)
            );

            $saved = $measurement->save();

            if (!$saved) {
                Log::error('failed to save record', $measurement->attributesToArray());
            }
        }

        return response()->json(['message' => 'Weather data stored successfully']);
    }
}
