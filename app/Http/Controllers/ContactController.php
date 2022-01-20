<?php

namespace App\Http\Controllers;

use App\Mail\ContactEmail;
use Illuminate\Support\Facades\Mail;
use Nexmo\Laravel\Facade\Nexmo;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;

class ContactController extends Controller
{
    public function display()
    {
        return view(
            'contact.display',
            [
            'page' => 'kontakt',
            'sended' => false
            ]
        );
    }

    public function sendemail(ContactRequest $request)
    {
        $data['message'] = 'Lorem ipsum...EMAIL';

        Mail::to('d3fb2d0b76-170492@inbox.mailtrap.io')->send(new ContactEmail($data));

        $contact = new Contact();
        $contact->message = $request->message;
        $contact->email = $request->email;
        $contact->type = 'email';
        if (is_object(Auth()->user()) && Auth()->user()->id > 0) {
            $contact->user_id = Auth()->user()->id;
        }
        $contact->save();

        return view(
            'contact.display',
            [
            'page' => 'kontakt',
            'sended' => true,
            'type' => 'email'
            ]
        );
    }

    public function sendsms(ContactRequest $request)
    {
        $data['message'] = $request->message;

        Nexmo::message()->send(
    [
            'to' => '+48880940545',
            'from' => '+48880940545',
            'text' => $data['message']
            ]
);

        return view(
            'contact.display',
            [
            'page' => 'kontakt',
            'sended' => true,
            'type' => 'sms'
            ]
        );
    }
}
