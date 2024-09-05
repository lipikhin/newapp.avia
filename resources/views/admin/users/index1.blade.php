@extends('layouts.base')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">Manage Users</div>
            <div class="card-body">
                <div id="dataTableContainer" class="table-responsive">
                    {{ $dataTable->table() }}
                </div>
            </div>
        </div>
    </div>

    <div id="mobile-message" style="display:none; text-align:center;">
        <p>Only desktop version</p>
    </div>

    <!-- Модальное окно для показа аватара -->
    <div class="modal fade" id="avatarModal" tabindex="-1" aria-labelledby="avatarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="avatarModalLabel">Аватар пользователя</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img id="avatarModalImage" src="" alt="Avatar" class="img-fluid" />
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}

    <script>
        function openModal(imageUrl) {
            document.getElementById('avatarModalImage').src = imageUrl;
            var modal = new bootstrap.Modal(document.getElementById('avatarModal'));
            modal.show();
        }

        function checkScreenWidth() {
            const screenWidth = window.innerWidth;
            const dataTable = $('#users-table').DataTable();
            console.log(`Screen width: ${screenWidth}`); // Лог для проверки ширины экрана

            if (screenWidth < 412) {
                document.getElementById('dataTableContainer').style.display = 'none';
                document.getElementById('mobile-message').style.display = 'block';
            } else {
                document.getElementById('dataTableContainer').style.display = 'block';
                document.getElementById('mobile-message').style.display = 'none';

                // Скрытие и отображение колонок в зависимости от ширины экрана
                if (screenWidth < 770) {
                    console.log('Hiding columns 4-8'); // Лог для проверки скрытия колонок
                    dataTable.column(4).visible(false);
                    dataTable.column(5).visible(false);
                    dataTable.column(6).visible(false);
                    dataTable.column(7).visible(false);
                    dataTable.column(8).visible(false);
                } else {
                    console.log('Showing columns 4-8'); // Лог для проверки отображения колонок
                    dataTable.column(4).visible(true);
                    dataTable.column(5).visible(true);
                    dataTable.column(6).visible(true);
                    dataTable.column(7).visible(true);
                    dataTable.column(8).visible(true);
                }
            }
        }

        window.onload = checkScreenWidth;
        window.onresize = checkScreenWidth;
    </script>
@endpush
