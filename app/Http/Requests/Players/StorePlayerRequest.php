<?php

namespace App\Http\Requests\Players;

use App\Models\Team;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class StorePlayerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @throws \Throwable
     *
     * @return array
     */
    public function rules()
    {
        $team = Team::find($this->team_id);

        throw_unless($team, ValidationException::withMessages(['Team does not exist']));

        $positions = config("team-positions.{$team->sport}");

        return [
            'first_name' => 'required|string',
            'last_name'  => 'required|string',
            'position'   => [
                'required',
                'string',
                Rule::in($positions),
            ],
            'team_id'    => 'required|integer|exists:teams,id',
        ];
    }
}
