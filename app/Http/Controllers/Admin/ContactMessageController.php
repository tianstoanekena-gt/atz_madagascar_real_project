<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::recent()->paginate(10);
        $unreadCount = ContactMessage::unread()->count();

        return view('admin.contact.messages.index', compact('messages', 'unreadCount'));
    }

    public function show(ContactMessage $message)
    {
        $message->update(['is_read' => true]);

        return view('admin.contact.messages.show', compact('message'));
    }

    public function update(Request $request, ContactMessage $message)
    {
        $request->validate([
            'is_read' => 'boolean',
        ]);

        $message->update([
            'is_read' => $request->has('is_read'),
        ]);

        return redirect()->route('admin.contact.messages.index')
            ->with('success', 'Statut du message mis à jour !');
    }

    public function destroy(ContactMessage $message)
    {
        $message->delete();

        return redirect()->route('admin.contact.messages.index')
            ->with('success', 'Message supprimé définitivement !');
    }
}
