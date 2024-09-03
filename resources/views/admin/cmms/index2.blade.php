@extends('layouts.base')

@section('content')
    <div class="container">
        <div class="row ">
            <h1>CMMs</h1>

            <a href="{{ route('admin.cmms.create') }}" style="width: 150px"
               class="btn btn-primary justify-content-end mb-3">{{__('Create New CMM')}}</a>

            <table id="cmmTable" class="table table-bordered ">
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
                            <img src="{{ asset('storage/image/cmm/' . $cmm->img) }}" alt="{{ $cmm->title }}" height="50" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#imageModal" data-img-url="{{ asset('storage/image/cmm/' . $cmm->img) }}" data-title="{{ $cmm->title }}">
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
                    <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" alt="Image" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var imageModal = document.getElementById('imageModal');
        var modalImage = document.getElementById('modalImage');
        var modalTitle = document.getElementById('imageModalLabel');

        imageModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget; // Кнопка, которая открыла модальное окно
            var imageUrl = button.getAttribute('data-img-url'); // Извлечение URL изображения из data-атрибута
            var title = button.getAttribute('data-title'); // Извлечение заголовка из data-атрибута

            modalImage.src = imageUrl; // Установка URL изображения в модальном окне
            modalTitle.textContent = title; // Установка заголовка модального окна
        });
    });
</script>

@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <script>
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


                },
                "search":true,
                "paginate":true,
            });
        });
    </script>
@endsection
