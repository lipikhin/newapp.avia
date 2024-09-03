@extends('layouts.base')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header"><h3>Manage Users</h3></div>
            <div class="card-body">
                {{ $dataTable->table(['id' => 'usersTable']) }} <!-- Добавляем ID для DataTable -->
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Просмотр изображения</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" alt="Image" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var dataTable = $('#usersTable').DataTable(); // Инициализация DataTable с использованием вашего ID
        var imageModal = document.getElementById('imageModal');
        var modalImage = document.getElementById('modalImage');

        imageModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget; // Кнопка, которая открыла модальное окно
            var imageUrl = button.getAttribute('data-img-url'); // Получение URL изображения из data-атрибута

            modalImage.src = imageUrl; // Установка URL изображения в модальном окне
        });

        // Добавляем функционал для управления видимостью столбцов в зависимости от ширины экрана
        function adjustColumnVisibility() {
            if ($(window).width() < 770) {
                dataTable.columns().every(function (index) {
                    this.visible(index === 0 || index === 1 || index === 2); // Показываем только нужные столбцы
                });
            } else {
                dataTable.columns().every(function () {
                    this.visible(true); // Показываем все столбцы
                });
            }
        }

        $(window).resize(adjustColumnVisibility); // Настройка видимости при изменении размера окна
        adjustColumnVisibility(); // Инициализация видимости столбцов при загрузке страницы
    });
</script>
