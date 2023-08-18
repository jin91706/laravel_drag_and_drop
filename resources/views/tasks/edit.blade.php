@extends('tasks.main')
   
@section('content')
<div>
    <div>
        <h4>
            Update Tasks
        </h4>
    </div>
    <form action="{{ route('tasks.update', $tasks->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label>Priority</label>
            <input type="text" name="priority" value="{{ $tasks->priority }}">
        </div>
        <div>
            <label>Task Name</label>
            <input type="text" name="task_name" value="{{ $tasks->task_name }}">
        </div>
        <div>
            <button type="submit">Submit</button>
        </div>
   
    </form>
</div>
@endsection