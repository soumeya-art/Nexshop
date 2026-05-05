<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class AdminContactMessageController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::query()
            ->latest()
            ->paginate(25);

        $nonLus = ContactMessage::where('lu', false)->count();

        return view('admin.contact_messages.index', compact('messages', 'nonLus'));
    }

    public function show(Request $request, ContactMessage $contact_message)
    {
        if (! $contact_message->lu) {
            $contact_message->update(['lu' => true]);
        }

        return view('admin.contact_messages.show', compact('contact_message'));
    }
}
