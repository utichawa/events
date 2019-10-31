<?php

namespace Utichawa\Events\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Utichawa\Events\Models\EventTranslation;

class EventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->route()->parameter('event');

        $rules = [
            'start_date' => 'required',
            'end_date' => 'required',
        ];

        if (request()->method() == 'POST') {
            $rules['image'] = 'required';
        }

        foreach (config('translatable.locales') as $k => $locale) {
            $rules[$locale . '.name'] = 'required';
            $rules[$locale . '.description'] = 'required';
            if (request()->method() == 'POST') {
                $rules[$locale . '.slug'] = 'required|unique:' . (new EventTranslation)->getTable() . ',slug';
            } else {
                $rules[$locale . '.slug'] = 'required|unique:' . (new EventTranslation)->getTable() . ',slug,' . $id . ',event_id';
            }
        }

        return $rules;
    }

    public function attributes()
    {
        $attributes = [
            'image' => __('og.events.image'),
            'start_date' => __('og.events.start_date'),
            'end_date' => __('og.events.end_date'),
        ];

        foreach (config('translatable.locales') as $k => $locale) {
            $attributes[$locale . '.slug'] = __('og.event_translations.slug') . " ($locale)";
            $attributes[$locale . '.name'] = __('og.event_translations.name') . " ($locale)";
            $attributes[$locale . '.description'] = __('og.event_translations.description') . " ($locale)";
        }

        return $attributes;
    }

    public function prepared()
    {
        return $this->request->all();
    }
}
