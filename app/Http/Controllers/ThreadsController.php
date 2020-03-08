<?php

namespace App\Http\Controllers;

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
            'title' => $request['title'],
            'body' => $request['body']
        ]);

        return redirect($thread->path());
    }

    /**
     * Shows an individual thread
     */
    public function show(Thread $thread): View
    {
        return view('threads.show', compact('thread'));
    }
}
