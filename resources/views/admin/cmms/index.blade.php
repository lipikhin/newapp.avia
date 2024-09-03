@extends('layouts.base')

@section('content')
    <div class="container">

        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <h3>Manage CMMs</h3>
                    <!-- Кнопка для создания нового CMM -->
                    <a href="{{ route('admin.cmms.create') }}" class="btn btn-primary mb-3">
                        {{ __('Create CMM') }}
                    </a>
                </div>

            </div>

            <div class="card-body">
                {!! $dataTable->table(['class' => 'table table-bordered table-striped']) !!}
            </div>

        </div>

    </div>

    <!-- Image Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" alt="Image" style="max-width: 100%; max-height: 80vh;">
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    {!! $dataTable->scripts() !!}
@endpush

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const imageModal = document.getElementById('imageModal');
        const modalImage = document.getElementById('modalImage');
        const modalTitle = document.getElementById('imageModalLabel');

        imageModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget; // Button that triggered the modal
            const imageUrl = button.getAttribute('data-image-url'); // Extract image URL from data-* attributes
            const title = button.getAttribute('data-title'); // Extract title from data-* attributes

            modalImage.src = imageUrl; // Update the modal's image
            modalTitle.textContent = title; // Update the modal's title
        });

        imageModal.addEventListener('hidden.bs.modal', function () {
            modalImage.src = ''; // Clear the image when the modal is closed
        });
    });
</script>
