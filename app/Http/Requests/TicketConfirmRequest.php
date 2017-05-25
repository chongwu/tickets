<?php

namespace App\Http\Requests;

use App\Ticket;
use App\User;
use Illuminate\Foundation\Http\FormRequest;

class TicketConfirmRequest extends FormRequest
{
    public $message;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        /* @var Ticket $ticket */
        $ticket = Ticket::findOrFail($this->route('id'));
        return $ticket->status === Ticket::CREATED; //&& $ticket->getUsersByWorkType()->unique('id')->contains('id',\Auth::user()->id);

    }

    public function forbiddenResponse()
    {
        return redirect()->route('home')->with('message', "Заявка #{$this->route('id')} уже принята к исполнению.");
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
