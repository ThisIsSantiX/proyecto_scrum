<?php

namespace App\Livewire;

use Livewire\Component;

class Sidebar extends Component
{
    public function render()
    {
        $recentProjects = session()->get('recent_projects', []);
        return view('layouts.layout.components.sidebar', compact('recentProjects'));
    }
}
