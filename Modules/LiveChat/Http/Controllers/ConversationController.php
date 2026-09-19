<?php

namespace Modules\LiveChat\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\LiveChat\Entities\Message;

class ConversationController extends Controller
{
    /**
     * Display a listing of the conversations.
     *
     * @return \Illuminate\View\View
     */
    public function conversationList(Request $request)
    {
        if ($request->expectsJson()) {
            $messages = Message::with(['sender:id,name,email,upload_id', 'receiver:id,name,email,upload_id'])
                ->select('sender_id', 'receiver_id', 'message', 'created_at')
                ->orderBy('created_at', 'desc')
                ->when($request->filled('search'), function ($query) use ($request) {
                    return $query->whereHas('sender', function ($query) use ($request) {
                        $query->where('name', 'like', '%' . $request->search . '%');
                    })->orWhereHas('receiver', function ($query) use ($request) {
                        $query->where('name', 'like', '%' . $request->search . '%');
                    });
                })
                ->get()
                ->groupBy(function ($message) {
                    $participants = collect([$message->sender_id, $message->receiver_id])->sort()->values();
                    return $participants->implode('-');
                });

            $content['html'] = view('livechat::conversation.chat_list')->with(['conversations' => $messages])->render();

            return response()->json([
                'message' => ___('live_chat.Conversation List'),
                'result' => true,
                'data' => $content
            ]);
        }

        $data['title'] = ___('livechat.Conversaiton List');
        return view('livechat::conversation.index', compact('data'));
    }


    public function conversation(Request $request)
    {
        $data['title'] = ___('livechat.Conversation');

        if (!$request->filled('conversation_id')) {
            return redirect()->back()->with('danger', ___('livechat.Conversation not found'));
        }

        $participants = explode('-', $request->conversation_id);

        $user1 = $participants[0];
        $user2 = $participants[1];

        $data['user1'] = User::find($user1);
        $data['user2'] = User::find($user2);

        $data['messages'] = Message::with(['sender:id,name,email,upload_id', 'receiver:id,name,email,upload_id'])
            ->select('sender_id', 'receiver_id', 'message', 'created_at')
            ->where(function ($query) use ($user1, $user2) {
                $query->where(function ($q) use ($user1, $user2) {
                    $q->where('sender_id', $user1)
                        ->where('receiver_id', $user2);
                })->orWhere(function ($q) use ($user1, $user2) {
                    $q->where('sender_id', $user2)
                        ->where('receiver_id', $user1);
                });
            })
            ->orderBy('created_at', 'asc') // Optional: Order by latest messages first
            ->get();

        return view('livechat::conversation.show')->with($data);
    }
}
