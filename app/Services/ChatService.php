<?php

namespace App\Services;

use App\Models\Chat;
use Illuminate\Support\Facades\DB;

class ChatService extends BaseService
{
    private function getNameColumn()
    {
        $cols = config('chat.name_cols_in_users_table');
        if (count($cols) > 1) {
            $str = implode(", ' ', ", $cols);
            return DB::raw("CONCAT($str)");
        }
        return $cols[0];
    }

    public function get_chat($id)
    {
        $chat = Chat::with('messages.repliedTo')
        ->whereHas('users', function($q){
            $q->where('user_id', auth()->id());
        })
        ->findOrFail($id);

        return $chat;
    }

    public function get_chat_list($request)
    {
        $chats = Chat::whereHas('users', function ($q) {
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
        ->paginate($this->pagination);

        return $chats;
    }

    public function get_unread_chat_list($request)
    {
        $chats = Chat::whereHas('users', function ($q) {
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
        ->paginate($this->pagination);

        return $chats;
    }

    public function get_unread_chat_count()
    {
        $counts = Chat::whereHas('users', function ($q) {
            $q->where('user_id', auth()->id());
        })
        ->whereHas('messages', function ($q) {
            $q->where('user_id', '!=', auth()->id())
                ->whereDoesntHave('views', function ($q2) {
                    $q2->where('user_id', auth()->id());
                });
        })
        ->count();

        return $counts;
    }
}
