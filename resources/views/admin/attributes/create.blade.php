@extends('admin.base')

@section('title', 'Добавление атрибута')

@section('content')
    <h1>Добавление атрибута</h1>
    <form action="{{ route('admin.attributes.store') }}" method="POST" id="attributeForm">
        @csrf
        <div class="form-group">
            <label for="name">Название:</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="type">Тип:</label>
            <select name="type" id="type" class="form-control" onchange="showOptionsInput()">
                <option value="">Выберите тип</option>
                <option value="list">Список</option>
                <option value="radio">Радиокнопка</option>
                <option value="checkbox">Чекбокс</option>
                <option value="input">Текстовое поле</option>
            </select>
        </div>
        <div class="form-group" id="optionsContainer" style="display: none;">
            <label>Опции:</label>
            <button type="button" class="btn btn-info" onclick="addOptionInput()">Добавить опцию</button>
        </div>
        <div class="form-group">
            <label for="comment">Комментарий:</label>
            <textarea name="comment" id="comment" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Создать</button>
    </form>

    <script>
        function showOptionsInput() {
            const type = document.getElementById('type').value;
            const optionsContainer = document.getElementById('optionsContainer');
            if (type === 'list' || type === 'radio' || type === 'checkbox') {
                optionsContainer.style.display = 'block';
            } else {
                optionsContainer.style.display = 'none';
            }
        }

        function addOptionInput() {
            const container = document.createElement('div');
            container.className = 'input-group mt-2';

            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'options[]';
            input.className = 'form-control';
            container.appendChild(input);

            const removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.className = 'btn btn-danger';
            removeButton.textContent = 'Удалить';
            removeButton.onclick = function() {
                container.remove();
            };
            container.appendChild(removeButton);

            document.getElementById('optionsContainer').appendChild(container);
        }
    </script>
@endsection
