<?php

namespace App\Http\Controllers;

use App\Models\project;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class ProjectController extends Controller
{
    public function index(){
        return Inertia::render('Projects/All', [
            'projects' => project::all(),
            'availableColors' => project::getAvailableTextColors(),
            'availableIcons' => project::getAvailableIcons(),
        ]);
    }

    public function store(Request $request){
        $request->validate([
            'title' => [
                'required',
                'max:255',
                Rule::unique(project::class)
            ],
            'description' => [
                'required',
                'max:255',
            ],
            'color' => [
                'required',
                'in:' . implode(',', project::getAvailableTextColors())
            ],
            'icon_name' => [
                'required',
                'in:' . implode(',', project::getAvailableIcons())
            ],
        ]);

        project::create($request->all());

        return redirect()->route('projects.index');
    }

    public function update(Request $request, project $project)
    {
        $request->validate([
            'title' => [
                'required',
                'max:255',
                Rule::unique(project::class)->ignore($project->id)
            ],
            'description' => [
                'required',
                'max:255',
            ],
            'color' => [
                'required',
                'in:' . implode(',', project::getAvailableTextColors())
            ],
            'icon_name' => [
                'required',
                'in:' . implode(',', project::getAvailableIcons())
            ],
        ]);

        $project->update($request->all());

        return redirect()->route('projects.index');
    }

    public function destroy(project $project)
    {
        $project->delete();

        return redirect()->route('projects.index');
    }
}
