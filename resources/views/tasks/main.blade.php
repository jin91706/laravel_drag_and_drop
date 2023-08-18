<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tasks Management</title>
    <style>
        .task {
            margin: 25px; 
            display: flex;
            cursor: move;
        }
        div, a, label {
            padding: 5px
        }
        .task-id {
            display: none;
        }
        h4 {
            color: green;
        }
        li {
            color: red;
        }
    </style>
</head>
<body>
    <div>
        <div>
        @if ($errors->any())
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
            <h4>{{ Session::get('success') }}</h4>
        </div>
        <div>
            <a href="/tasks">Home</a>
            <a href="{{ route('tasks.create') }}">Create a Task</a>
        </div>
        @yield('content')
    </div>
</body>
</html>