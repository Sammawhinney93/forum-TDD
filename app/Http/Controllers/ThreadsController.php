<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Filters\ThreadFilters;
use App\Thread;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ThreadsController extends Controller
{
    /**
     * ThreadsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display thread list.
     *
     * @param Channel $channel
     * @param ThreadFilters $filters
     * @return View
     */
    public function index(Channel $channel, ThreadFilters $filters): View
    {
        $threads = $this->getThreads($channel, $filters);

        if (request()->wantsJson()) {
            return $threads;
        }

        return view('threads.index', compact('threads'));
    }

    public function create()
    {
        return view('threads.create');
    }

    /**
     * Store a new thread
     *
     * @param Request $request
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'channel_id' => 'required|exists:channels,id'
        ]);

        $thread = Thread::create([
            'user_id' => auth()->id(),
            'channel_id' => $request['channel_id'],
            'title' => $request['title'],
            'body' => $request['body']
        ]);

        return redirect($thread->path());
    }

    /**
     * Shows an individual thread
     *
     * @param integer $channelId
     * @param Thread $thread
     * @return View
     */
    public function show($channel, Thread $thread): View
    {
        return view('threads.show', [
            'thread' => $thread,
            'replies' => $thread->replies()->paginate(20)
        ]);
    }

    public function destroy($channel, Thread $thread)
    {
        $this->authorize('update', $thread);

        $thread->replies()->delete();

        $thread->delete();

        if (request()->wantsJson()) {
            return response([], 204);
        }

        return redirect('/threads');
    }

    /**
     * Fetch all relevant threads.
     *
     * @param Channel       $channel
     * @param ThreadFilters $filters
     * @return mixed
     */
    protected function getThreads(Channel $channel, ThreadFilters $filters)
    {
        $threads = Thread::latest()->filter($filters);

        if ($channel->exists) {
            $threads->where('channel_id', $channel->id);
        }

        return $threads->get();
    }
}
