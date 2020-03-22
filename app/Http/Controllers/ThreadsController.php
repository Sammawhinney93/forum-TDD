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
     *
     * @param null $channelId
     *
     * @return View
     */
    public function index(Channel $channel): View
    {
        if ($channel->exists) {

            $threads = $channel->threads()->latest()->get();

        } else {
            $threads = Thread::latest()->get();
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
    public function show($channelId, Thread $thread): View
    {
        return view('threads.show', compact('thread'));
    }
}
