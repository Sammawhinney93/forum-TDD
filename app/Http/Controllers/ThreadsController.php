<?php

namespace App\Http\Controllers;

use App\Thread;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ThreadsController extends Controller
{
    /**
     * Display thread list.
     */
    public function index(): View
    {
        $threads = Thread::latest()->get();

        return view('threads.index', compact('threads'));
    }

    /**
     * Shows an individual thread
     */
    public function show(Thread $thread): View
    {
        return view('threads.show', compact('thread'));
    }
}
