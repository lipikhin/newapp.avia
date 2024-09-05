@extends('layouts.base')

@section('content')
    <style>
        @media (max-width: 770px) {
            /* Пример скрытия всех колонок, кроме Avatar, Name и Action */
            table.dataTable tbody td:nth-child(n+4), /* Скрыть все колонки, начиная с 4-й */
            table.dataTable thead th:nth-child(n+4) {
                display: none; /* Скрыть колонки в заголовке и теле */
            }
        }
    </style>

    <div class="container">
        <div class="card">
            <div class="card-header"><h3>{{__('Manage Users')}}</h3></div>
            <div class="card-body">
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>

    <!-- Modal для добавления роли -->
    <div class="modal fade" id="addRoleModal" tabindex="-1" aria-labelledby="addRoleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="addRoleForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addRoleModalLabel">Add Role</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="roleName" class="form-label">Role Name</label>
                            <input type="text" class="form-control" id="roleName" name="roleName" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Role</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal для добавления команды -->
    <div class="modal fade" id="addTeamModal" tabindex="-1" aria-labelledby="addTeamModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="addTeamForm">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addTeamModalLabel">Add Team</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="teamName" class="form-label">Team Name</label>
                            <input type="text" class="form-control" id="teamName" name="teamName" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Team</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal for Avatar Update -->
    <div class="modal fade" id="avatarUpdateModal" tabindex="-1" aria-labelledby="avatarUpdateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="avatarUpdateForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="avatarUpdateModalLabel">Изменить Аватар</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="avatarInput" class="form-label">Выберите новое изображение</label>
                            <input class="form-control" type="file" id="avatarInput" name="avatar" accept="image/*" required>
                        </div>
                        <input type="hidden" id="userIdInput" name="user_id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                        <button type="submit" class="btn btn-primary">Обновить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Обработка нажатия кнопки изменения роли
        $(document).on('click', '.change-role', function () {
            const userId = $(this).data('id');
            const currentRoleId = $(this).data('current-role');
            $('#addRoleModal').modal('show');

            // Устанавливаем текущую роль в модальное окно, если нужно
            $('#addRoleForm').data('user-id', userId);
            $('#roleName').val(currentRoleId); // Предполагается, что вы хотите показать текущую роль
        });

        // Обработка нажатия кнопки изменения команды
        $(document).on('click', '.change-team', function () {
            const userId = $(this).data('id');
            const currentTeamId = $(this).data('current-team');
            $('#addTeamModal').modal('show');

            // Устанавливаем текущую команду в модальное окно, если нужно
            $('#addTeamForm').data('user-id', userId);
            $('#teamName').val(currentTeamId); // Предполагается, что вы хотите показать текущую команду
        });
    });


    $(document).on('change', '.change-role, .change-team', function() {
        const userId = $(this).data('id');
        const newRoleOrTeamId = $(this).val();
        const type = $(this).hasClass('change-role') ? 'role' : 'team';

        $.ajax({
            url: `/admin/users/${userId}/update-${type}`, // Your route for updating role/team
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                [`${type}_id`]: newRoleOrTeamId
            },
            success: function(response) {
                alert(`${type.charAt(0).toUpperCase() + type.slice(1)} updated successfully.`);
                $('#users-table').DataTable().ajax.reload(); // Refresh the DataTable
            },
            error: function(xhr, status, error) {
                alert(`An error occurred while updating ${type}.`);
            }
        });
    });


    document.addEventListener('DOMContentLoaded', function () {
        const avatarImages = document.querySelectorAll('img[data-bs-toggle="modal"][data-bs-target="#avatarUpdateModal"]');

        if (avatarImages.length > 0) {
            avatarImages.forEach(img => {
                img.addEventListener('click', function () {
                    const userId = this.getAttribute('data-id');
                    const updateForm = document.getElementById('avatarUpdateForm');
                    const userIdInput = document.getElementById('userIdInput');

                    userIdInput.value = userId;
                    const modal = new bootstrap.Modal(document.getElementById('avatarUpdateModal'));
                    modal.show();
                });
            });
        }

        const imageModal = document.getElementById('imageModal');
        const modalImage = document.getElementById('modalImage');

        if (imageModal && modalImage) {
            imageModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const imageUrl = button.getAttribute('data-img-url');

                modalImage.src = imageUrl;
            });
        }
    });

    $(document).on('click', '.change-role', function() {
        const userId = $(this).data('id');
        const currentRoleId = $(this).data('current-role');

        // Загрузите роли и выберите текущую
        $.get('/api/roles', function(roles) {
            let options = '';
            roles.forEach(role => {
                options += `<option value="${role.id}" ${role.id == currentRoleId ? 'selected' : ''}>${role.name}</option>`;
            });
            $('#roleSelect').html(options);
            $('#addRoleModal').modal('show');

            $('#saveRole').off('click').on('click', function() {
                const newRoleId = $('#roleSelect').val();
                $.ajax({
                    url: '/api/users/' + userId + '/change-role',
                    method: 'POST',
                    data: { role_id: newRoleId },
                    success: function(response) {
                        // Обновите таблицу
                        $('#users-table').DataTable().ajax.reload();
                        $('#addRoleModal').modal('hide');
                    },
                    error: function(err) {
                        console.error(err);
                    }
                });
            });
        });
    });

    $(document).on('click', '.change-team', function() {
        const userId = $(this).data('id');
        const currentTeamId = $(this).data('current-team');

        // Загрузите команды и выберите текущую
        $.get('/api/teams', function(teams) {
            let options = '';
            teams.forEach(team => {
                options += `<option value="${team.id}" ${team.id == currentTeamId ? 'selected' : ''}>${team.name}</option>`;
            });
            $('#teamSelect').html(options);
            $('#addTeamModal').modal('show');

            $('#saveTeam').off('click').on('click', function() {
                const newTeamId = $('#teamSelect').val();
                $.ajax({
                    url: '/api/users/' + userId + '/change-team',
                    method: 'POST',
                    data: { team_id: newTeamId },
                    success: function(response) {
                        // Обновите таблицу
                        $('#users-table').DataTable().ajax.reload();
                        $('#addTeamModal').modal('hide');
                    },
                    error: function(err) {
                        console.error(err);
                    }
                });
            });
        });
    });

</script>
