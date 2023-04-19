<?php

namespace App\Http\Requests;

use App\Models\Station;
use App\Services\AnalyseStationDataService;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class AnalyseRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'end' => ['required', 'date'],
            'start' => ['required', 'date'],
            'station_ids' => ['required', 'array', 'min:1', 'max:5'],
            'station_ids.*' => ['required', 'integer', Rule::exists(Station::class, 'name')],
        ];
    }

    /**
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $station_ids = $this->get('station_ids', []);
        [$start, $end] = explode(' - ', $this->get('range'));

        if (is_null($station_ids[0])) {
            $station_ids = [];
        }

        $this->merge([
            'end' => $end,
            'start' => $start,
            'station_ids' => array_map('intval', $station_ids)
        ]);
    }

    protected function failedValidation(Validator $validator)
    {
        Session::remove(AnalyseStationDataService::SELECTION);

        parent::failedValidation($validator);
    }
}
