<?php

namespace App\Services;

use App\Models\Chat;
use Illuminate\Support\Facades\DB;

class ChatService
{
    private function getNameColumn()
    {
        $cols = config('chat.user_name_cols');
        if (count($cols) > 1) {
            $str = implode(", ' ', ", $cols);
            return DB::raw("CONCAT($str)");
        }
        return $cols[0];
    }

    public function getChatList($request)
    {
        $chats = Chat::with('users', 'messages', 'messages.views')
            ->whereHas('users', function ($q) {
                $q->where('user_id', auth()->id());
            })
            ->when($request->filled('search'), function ($q) use ($request) {
                $q->where(function ($query) use ($request) {
                    $query->where(function ($subquery) use ($request) {
                        $subquery->where('type', Chat::PRIVATE)
                        ->whereHas('users', function ($subquery2) use ($request) {
                            $subquery2->where('name', 'like', '%' . $request->search . '%');
                        });
                    })
                    ->orWhere('name', 'like', '%' . $request->search . '%');
                });
            })
            ->when($request->filled('type'), function ($q) use ($request) {
                $q->where('type', $request->type);
            })
            ->orderByDesc(function ($q) {
                $q->select('created_at')
                    ->from('chat_messages')
                    ->whereColumn('chat_id', 'chats.id')
                    ->orderBy('created_at', 'desc')
                    ->limit(1);
            })
            ->get();

        return $chats;
    }

    public function getUnreadChatList($request)
    {
        $chats = Chat::with('users', 'messages', 'messages.views')
            ->whereHas('users', function ($q) {
                $q->where('user_id', auth()->id());
            })
            ->whereHas('messages', function ($q) {
                $q->where('user_id', '!=', auth()->id())
                ->whereDoesntHave('views', function ($q2) {
                    $q2->where('user_id', auth()->id());
                });
            })
            ->when($request->filled('search'), function ($q) use ($request) {
                $q->where(function ($query) use ($request) {
                    $query->where(function ($subquery) use ($request) {
                        $subquery->where('type', Chat::PRIVATE)
                        ->whereHas('users', function ($subquery2) use ($request) {
                            $subquery2->where('name', 'like', '%' . $request->search . '%');
                        });
                    })
                    ->orWhere('name', 'like', '%' . $request->search . '%');
                });
            })
            ->when($request->filled('type'), function ($q) use ($request) {
                $q->where('type', $request->type);
            })
            ->orderByDesc(function ($q) {
                $q->select('created_at')
                    ->from('chat_messages')
                    ->whereColumn('chat_id', 'chats.id')
                    ->orderBy('created_at', 'desc')
                    ->limit(1);
            })
            ->get();

        return $chats;
    }

    public function getUnreadChatCount()
    {
        return Chat::with('users', 'messages', 'messages.views')
            ->whereHas('users', function ($q) {
                $q->where('user_id', auth()->id());
            })
            ->whereHas('messages', function ($q) {
                $q->whereNull('read_at')->where('user_id', '!=', auth()->id());
            })
            ->count();
    }
        
}
