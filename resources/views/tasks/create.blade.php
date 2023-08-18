@extends('tasks.main')

@section('content')
<div>
    <div>
        <h2>Add a Task</h2>
    </div>
    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf
        <div>
            <label>Task Name</label>
            <input name="task_name">
        </div>
        <div>
            <label>Priority</label>
            <input name="priority">
        </div>
        <div>
            <input type="submit" value="Submit">
        </div>
    </form>
</div>
@endsection