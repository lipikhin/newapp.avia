@extends('layouts.base')

@section('content')

    <div class="container">
        <div class="row">
            <h1>CMMs</h1>
            <a href="{{ route('admin.cmms.create') }}" style="width: 150px" class="btn btn-primary justify-content-end mb-3">{{ __('Create New CMM') }}</a>

            <table id="cmmTable" class="table table-bordered">
                <thead>
                <tr>
                    <th>Number</th>
                    <th>Title</th>
                    <th>Image</th>
                    <th>Revision Date</th>
                    <th>Library</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($cmms as $cmm)
                    <tr>
                        <td>{{ $cmm->number }}</td>
                        <td>{{ $cmm->title }}</td>
                        <td>
                            <img src="{{ asset('storage/image/cmm/' . $cmm->img) }}" alt="{{ $cmm->title }}" height="50" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#imageModal" data-img-url="{{ asset('storage/image/cmm/' . $cmm->img) }}">
                        </td>
                        <td>{{ $cmm->revision_date }}</td>
                        <td>{{ $cmm->lib }}</td>
                        <td>
                            <a href="{{ route('admin.cmms.edit', $cmm->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.cmms.destroy', $cmm->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" alt="{{ $cmm->title }}" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <!-- Подключение jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Подключение Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Подключение DataTables -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var imageModal = document.getElementById('imageModal');
            var modalImage = document.getElementById('modalImage');

            imageModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                var imageUrl = button.getAttribute('data-img-url');
                var modalTitle = button.getAttribute('alt'); // Получаем заголовок

                modalImage.src = imageUrl;
                document.getElementById('imageModalLabel').textContent = modalTitle; // Устанавливаем заголовок модального окна
            });
        });

        $(document).ready(function() {
            $('#cmmTable').DataTable({
                "language": {
                    "search": "Search:",
                    "lengthMenu": "Show _MENU_ entries",
                    "zeroRecords": "No matching records found",
                    "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                    "infoEmpty": "No entries available",
                    "infoFiltered": "(filtered from _MAX_ total entries)",
                    "paginate": {
                        "first": "First",
                        "last": "Last",
                        "next": "Next",
                        "previous": "Previous"
                    }
                }
            });
        });
    </script>
@endsection
