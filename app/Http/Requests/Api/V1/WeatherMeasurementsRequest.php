<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WeatherMeasurementsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'distance' => ['required', 'integer', Rule::in(5, 10, 20, 50, 100)],
            'history' => ['required', 'boolean']
        ];
    }

    protected function prepareForValidation()
    {
        $this->mergeIfMissing([
            'history' => false,
        ]);
    }
}
