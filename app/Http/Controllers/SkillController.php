<?php

namespace App\Http\Controllers;

use App\Models\skill;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class SkillController extends Controller
{
    public function index(){
        return Inertia::render('Skills/All', [
            'skills' => skill::all(),
            'availableColors' => skill::getAvailableBackgroundColors(),
        ]);

    }

    public function store(Request $request){
        $request->validate([
            'name' => [
                'required',
                'max:255',
                Rule::unique(skill::class)
            ],
            'color' => [
                'required',
                'in:' . implode(',', skill::getAvailableBackgroundColors())
            ],
        ]);

        skill::create($request->all());

        return redirect()->route('skills.index');
    }

    public function update(Request $request, skill $skill){
        $request->validate([
            'name' => [
                'required',
                'max:255',
                Rule::unique(skill::class)->ignore($skill->id)
            ],
            'color' => [
                'required',
                'in:' . implode(',', skill::getAvailableBackgroundColors())
            ],
        ]);

        $skill->update($request->all());
        return redirect()->route('skills.index');
    }

    public function destroy(skill $skill){
        $skill->delete();

        return redirect()->route('skills.index');
    }
}
