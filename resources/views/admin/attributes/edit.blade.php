@extends('admin.base')

@section('title', 'Редактирование атрибута')

@section('content')
    <h1>Редактирование атрибута</h1>
    <form action="{{ route('admin.attributes.update', $attribute->id) }}" method="POST" id="attributeForm">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Название:</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $attribute->name }}" required>
        </div>
        <div class="form-group">
            <label for="type">Тип:</label>
            <select name="type" id="type" class="form-control" onchange="showOptionsInput()">
                <option value="list" {{ $attribute->type == 'list' ? 'selected' : '' }}>Список</option>
                <option value="radio" {{ $attribute->type == 'radio' ? 'selected' : '' }}>Радиокнопка</option>
                <option value="checkbox" {{ $attribute->type == 'checkbox' ? 'selected' : '' }}>Чекбокс</option>
                <option value="input" {{ $attribute->type == 'input' ? 'selected' : '' }}>Текстовое поле</option>
            </select>
        </div>
        <div class="form-group" id="optionsContainer">
            <!-- Динамические поля для опций будут здесь -->
        </div>
        <button type="button" class="btn btn-info" id="addOption">Добавить опцию</button>
        <div class="form-group">
            <label for="comment">Комментарий:</label>
            <textarea name="comment" id="comment" class="form-control">{{ $attribute->comment }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Обновить</button>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let options = @json($attribute->options);
            const optionsContainer = document.getElementById('optionsContainer');
            const addOptionButton = document.getElementById('addOption');

            function addOptionInput(value = '') {
                const container = document.createElement('div');
                container.className = 'input-group mt-2';

                const input = document.createElement('input');
                input.type = 'text';
                input.name = 'options[]';
                input.className = 'form-control';
                input.value = value;
                container.appendChild(input);

                const removeButton = document.createElement('button');
                removeButton.type = 'button';
                removeButton.className = 'btn btn-danger';
                removeButton.textContent = 'Удалить';
                removeButton.onclick = function() {
                    container.remove();
                };
                container.appendChild(removeButton);

                optionsContainer.appendChild(container);
            }

            // Добавление существующих опций
            if (Array.isArray(options)) {
                options.forEach((option) => {
                    addOptionInput(option);
                });
            }

            showOptionsInput(); // Показать или скрыть контейнер опций

            addOptionButton.addEventListener('click', () => addOptionInput());
            document.getElementById('type').addEventListener('change', showOptionsInput);
        });

        function showOptionsInput() {
            const type = document.getElementById('type').value;
            const optionsContainer = document.getElementById('optionsContainer');
            if (type === 'list' || type === 'radio' || type === 'checkbox') {
                optionsContainer.style.display = 'block';
            } else {
                optionsContainer.style.display = 'none';
            }
        }
    </script>
@endsection
