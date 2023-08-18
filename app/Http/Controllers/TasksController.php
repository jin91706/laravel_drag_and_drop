<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Tasks::orderBy('priority', 'asc')->get();
        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'priority' => 'required|numeric|min:1',
            'task_name' => 'required|unique:tasks|max:48',
        ]);

        $priority = (int)$request->input('priority');
        $taskName = $request->input('task_name');

        Tasks::create($request->all());
        $tasks = Tasks::where('priority', '>=', $priority)->orderBy('priority', 'asc')->get();
        foreach ($tasks as $task) {
            if ($task->task_name == $request->input('task_name')) {
                continue;
            }
            $task->priority = $task->priority + 1;
            $task->save();
        }
        return redirect()->route('tasks.index')
            ->with('success', 'Task saved successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('tasks.show')->with([
            'tasks' => Tasks::find($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('tasks.edit')->with([
            'tasks' => Tasks::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $orgTask = Tasks::find($id);
        $new = (int)$request->input('priority');
        
        $validated = $request->validate([
            'priority' => 'required|numeric|min:1'
        ]);

        if (!$request->ajax()) {
            $taskName = $request->input('task_name');
            $validated = $request->validate([
                'task_name' => 'required|max:48'
            ]);
            $current = $orgTask->priority;
            if ($current > $new) {
                $tasks = Tasks::where('priority', '>=', $new)->orderBy('priority', 'asc')->get();
                foreach ($tasks as $task) {
                    if ($task->task_name == $orgTask->task_name) {
                        continue;
                    }
                    $task->priority = $task->priority + 1;
                    $task->save();
                }
            } else {
                $tasks = Tasks::where('priority', '<=', $new)->orderBy('priority', 'asc')->get();
                foreach ($tasks as $task) {
                    if ($task->task_name == $orgTask->task_name) {
                        continue;
                    }
                    $task->priority = $task->priority - 1;
                    $task->save();
                }
            }
            $orgTask->update($request->all());
            $orgTask->save();   
            return redirect()->route('tasks.index');
        }
        $orgTask->update($request->all());
        $orgTask->save(); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Tasks::find($id)->delete();
        return redirect()->route('tasks.index');
    }
}
