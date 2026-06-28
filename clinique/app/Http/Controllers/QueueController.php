<?php

namespace App\Http\Controllers;

use App\Events\QueueJoined;
use App\Models\QueueEntry;
use Illuminate\Http\Request;

class QueueController extends Controller
{
    public function joinQueue(Request $request)
    {
        try {
            $user = $request->user();

            if (!$user) {
                return response()->json(['message' => 'Unauthenticated'], 401);
            }

            $existing = QueueEntry::where('user_id', $user->id)
                ->whereIn('status', ['waiting', 'called'])
                ->first();

            if ($existing) {
                return response()->json([
                    'message' => 'Already in queue'
                ], 400);
            }

      
            $mmdd = now()->format('md');
            $random = str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
            $queueNumber = $mmdd . '-' . $random;

            $entry = QueueEntry::create([
                'user_id'       => $user->id,
                'status'        => 'waiting',
                'queue_number'  => $queueNumber,
                'window_number' => 'W-' . rand(1, 4),
            ]);

            broadcast(new QueueJoined($entry->load('user'), 'joined'))->toOthers();

            return response()->json([
                'message' => 'Joined queue',
                'entry'   => $entry->load('user'),
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Server error: ' . $e->getMessage()], 500);
        }
    }

    public function leaveQueue(Request $request)
    {
        $user = $request->user();

        $entry = QueueEntry::where('user_id', $user->id)
            ->whereIn('status', ['waiting', 'called'])
            ->first();

        if (!$entry) {
            return response()->json(['message' => 'Not in queue'], 404);
        }

        $entry->update(['status' => 'left']);

        broadcast(new QueueJoined($entry->fresh()->load('user'), 'left'))->toOthers();

        return response()->json(['message' => 'Left queue']);
    }

    public function queueList(Request $request)
    {
        $query = QueueEntry::with('user');

    
        if ($request->boolean('today')) {
            $query->whereDate('created_at', today());
        }

        $entries = $query->orderBy('created_at')->get();

        $nowServing = $entries->firstWhere('status', 'called');
        $waitingCount = $entries->where('status', 'waiting')->count();
        $doneToday = $entries->where('status', 'done')->count();
        $total = $entries->count();

        return response()->json([
            'entries'     => $entries,
            'now_serving' => $nowServing,
            'waiting'     => $waitingCount,
            'completed'   => $doneToday,
            'total'       => $total,
        ]);
    }

    public function callNext(Request $request)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $next = QueueEntry::where('status', 'waiting')
            ->orderBy('created_at')
            ->first();

        if (!$next) {
            return response()->json(['message' => 'No patients waiting'], 404);
        }

        $window = 'W-' . rand(1, 4);

        $next->update([
            'status'        => 'called',
            'window_number' => $window,
        ]);

        broadcast(new QueueJoined($next->fresh()->load('user'), 'called'))->toOthers();

        return response()->json([
            'message' => 'Patient called',
            'entry'   => $next->load('user'),
        ]);
    }

    public function completeQueue(Request $request, $id)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $entry = QueueEntry::findOrFail($id);
        $entry->update(['status' => 'done']);

        broadcast(new QueueJoined($entry->fresh()->load('user'), 'done'))->toOthers();

        return response()->json([
            'message' => 'Completed',
            'entry'   => $entry,
        ]);
    }

    public function myQueue(Request $request)
    {
        $entry = QueueEntry::where('user_id', $request->user()->id)
            ->latest()
            ->first();

        if (!$entry) {
            return response()->json(['queue' => null]);
        }

        $position = QueueEntry::whereIn('status', ['waiting', 'called'])
            ->where('created_at', '<', $entry->created_at)
            ->count();

        $nowServing = QueueEntry::where('status', 'called')
            ->orderBy('created_at')
            ->first();

        return response()->json([
            'queue'       => $entry->load('user'),
            'position'    => $entry->status === 'called' ? 0 : $position + 1,
            'now_serving' => $nowServing,
        ]);
    }

    public function publicQueue()
    {
        $serving = QueueEntry::with('user')
            ->where('status', 'called')
            ->orderBy('created_at')
            ->get();

        $waiting = QueueEntry::with('user')
            ->where('status', 'waiting')
            ->orderBy('created_at')
            ->get();

        return response()->json([
            'serving' => $serving,
            'waiting' => $waiting,
        ]);
    }
}
