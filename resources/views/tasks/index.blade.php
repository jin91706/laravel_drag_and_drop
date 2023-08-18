@extends('tasks.main')

@section('content')
<script>
window.onload = function() {
    let dragger;
    let tasks = document.querySelectorAll('.task');
    // Updating the page as soon as it loads to reorder a newly created task
    // that is not sequential.
    updatePriority(tasks);
    // Add drag events to all the tasks
    tasks.forEach(task => {
        task.addEventListener('dragstart', function(e) {
            dragger = this;
        }, false);

        task.addEventListener('dragover', function(e) {
            e.preventDefault();
        }, false);

        task.addEventListener('drop', function(e) {
            if (dragger != this) {
                const drag = dragger.querySelector('.priority').innerText - 1;
                const drop = this.querySelector('.priority').innerText - 1;
                let tasksArray = Array.from(tasks);
                if (drag > drop) {
                    tasksArray.splice(drop, 0, tasksArray[drag]);
                    tasksArray.splice(drag + 1, 1);
                } else {
                    tasksArray.splice(drop + 1, 0, tasksArray[drag]);
                    tasksArray.splice(drag, 1);
                }
                const list = document.querySelector('.list');
                list.innerHTML = '';
                tasksArray.forEach(element => {
                    list.appendChild(element);
                });
            }
            return false;
        }, false);

        task.addEventListener('dragend', function(e) {
            tasks = document.querySelectorAll('.task');
            updatePriority(tasks);
        }, false);
    });
}

function updatePriority(tasks) {
    const url = "http://127.0.0.1:8000/tasks/";
    for(let i = 0; i < tasks.length; i++) {
        const pri = i + 1;
        tasks[i].querySelector('.priority').innerHTML = pri;
        const id = tasks[i].querySelector('.task-id').dataset.id;
        const token = tasks[i].querySelector("input[name='_token']").value;
        var data = new FormData();
        data.append("_token", token);
        data.append("_method", "PUT");
        data.append("priority", pri);
        fetch(url + id, {
            method: "POST",
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: data
        });
    }
}
</script>
<div class="list">
    @foreach($tasks as $task)
    <div class="task" draggable="true">
        <div class="task-id" data-id="{{ $task->id }}"></div>
        <div class="priority">
            {{ $task->priority }}
        </div>
        <div>
            {{ $task->task_name }}
        </div>
        <div>
            <form action="{{ route('tasks.destroy', $task->id) }}" method="post">
                <a href="{{ route('tasks.show', $task->id) }}">Show</a>
                <a href="{{ route('tasks.edit', $task->id) }}">Edit</a>
                @csrf
                @method('DELETE')
                <button type="submit">Delete</button>
            </form>
        </div>
    </div>
    @endforeach
</div>
@endsection
