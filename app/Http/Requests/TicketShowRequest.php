<?php

namespace App\Http\Requests;

use App\Ticket;
use Illuminate\Foundation\Http\FormRequest;

class TicketShowRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $ticket = Ticket::findOrFail($this->segment(2));
        return \Auth::user()->isSpecialist() || $ticket->iAmAuthor();
    }

    public function forbiddenResponse()
    {
        return response()->view('errors.403');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
