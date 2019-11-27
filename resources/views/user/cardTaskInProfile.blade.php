<div class="card my-2 {{ $task->status_id == 4 ? 'alert-success' : '' }}">
    <div class="card-body">
        <div>
            № {{ $task->id }}
            <a href="{{ route('tasks.show', $task) }}">{{ $task->name }}</a>
        </div>
        @if($task->description)
            <div>
                Описание:
                {{ $task->description }}
            </div>
        @endif
        <div>
            Статус:
            {{ $task->status->name }}
        </div>
        <div>
            Дата создания:
            {{ $task->created_at }}
        </div>
    </div>
</div>