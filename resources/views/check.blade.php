<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <title>Искатель слов в тексте</title>
</head>
<body>
<div class="container mt-4">
    <h2>Поиск слова в тексте</h2>

    <form id="checkForm">
        <textarea class="form-control" name="text" id="text" placeholder="Введите текст" required></textarea><br>
        <input class="form-control" type="text" name="search_word" placeholder="Искомое слово" required><br>
        <button type="submit" class="btn btn-primary">Найти</button>
    </form>

    <p id="error" class="text-danger"></p>

    <h3 class="mt-4">История проверок</h3>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Дата проверки</th>
            <th>Текст</th>
            <th>Всего слов</th>
            <th>Искомое слово</th>
            <th>Найдено слов</th>
        </tr>
        </thead>
        <tbody id="historyTable"></tbody>
    </table>
</div>

<script>
    const form = document.getElementById('checkForm');
    const errorBlock = document.getElementById('error');
    const historyTable = document.getElementById('historyTable');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Загрузка истории проверок
    async function loadHistory() {
        const response = await fetch('/history');
        if (!response.ok) return;
        const data = await response.json();

        historyTable.innerHTML = '';
        data.forEach(item => {
            const row = `
                <tr>
                    <td>${new Date(item.created_at).toLocaleString()}</td>
                    <td>${item.text}</td>
                    <td>${item.total_words}</td>
                    <td>${item.search_word}</td>
                    <td>${item.found_words}</td>
                </tr>
            `;
            historyTable.insertAdjacentHTML('beforeend', row);
        });
    }

    // Отправка формы
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        errorBlock.textContent = '';

        const formData = new FormData(form);

        try {
            const response = await fetch('/check', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                body: formData
            });

            if (!response.ok) throw new Error('Ошибка при проверке');

            await response.json();
            form.reset();
            loadHistory();
        } catch (error) {
            errorBlock.textContent = error.message;
        }
    });

    loadHistory();
</script>
</body>
</html>
