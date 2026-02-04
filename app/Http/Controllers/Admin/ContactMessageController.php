<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\AdminBaseController;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends AdminBaseController
{
    public function index(Request $request)
    {
        $messages = ContactMessage::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->input('search');

                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('message', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                if ($request->status === 'unread') {
                    $query->whereNull('read_at');
                }

                if ($request->status === 'read') {
                    $query->whereNotNull('read_at');
                }
            })
            ->latest()
            ->paginate(15);

        $messages->appends($request->query());

        return view('adminpages.contact-messages.index', [
            'messages' => $messages,
        ]);
    }

    public function show(ContactMessage $contactMessage)
    {
        $contactMessage->markAsRead();

        return view('adminpages.contact-messages.show', [
            'message' => $contactMessage->fresh(),
        ]);
    }

    public function destroy(ContactMessage $contactMessage)
    {
        $contactMessage->delete();

        return redirect()
            ->route('adminpages.contact-messages.index')
            ->with('success', 'Contact message deleted successfully.');
    }
}

