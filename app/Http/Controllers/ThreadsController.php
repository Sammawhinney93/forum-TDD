<?php

namespace App\Http\Controllers;

use App\Channel;
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
     */
    public function index(): View
    {
        $threads = Thread::latest()->get();

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
    public function show(int $channelId, Thread $thread): View
    {
        return view('threads.show', compact('thread'));
    }
}
