@extends('tasks.main')
  
@section('content')
<div>
    <div>
        <h4>Task {{ $tasks->id }}</h4>
    </div>
    <div>
        <div><label>Priority</label>: {{ $tasks->priority }}</div>
    </div>
    <div>
        <div><label>Task Name</label>: {{ $tasks->task_name }}</div>
    </div>
    <div>
        <div><label>Created</label>: {{ $tasks->created_at }}</div>
    </div>
    <div>
        <div><label>Updated</label>: {{ $tasks->updated_at }}</div>
    </div>
</div>
@endsection