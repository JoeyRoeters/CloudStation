<?php

namespace App\Http\Requests;

use App\Models\Station;
use App\Services\AnalyseStationDataService;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class StationRequest extends FormRequest
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
        ];
    }

    /**
     * @return void
     */
    protected function prepareForValidation(): void
    {
        [$start, $end] = explode(' - ', $this->get('range'));

        $this->merge([
            'end' => $end,
            'start' => $start,
        ]);
    }

    protected function failedValidation(Validator $validator)
    {
        Session::remove(AnalyseStationDataService::SELECTION);

        parent::failedValidation($validator);
    }
}
