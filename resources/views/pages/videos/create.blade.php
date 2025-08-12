@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Upload New Video'),
        'description' => __('Upload a new video to your collection.'),
        'class' => 'col-lg-12',
    ])
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Video Upload') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('videos.index') }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-arrow-left mr-1"></i> {{ __('Back to list') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('videos.store') }}" enctype="multipart/form-data" id="videoUploadForm">
                            @csrf

                            <!-- Progress Bar (Hidden by default) -->
                            <div class="progress mb-4 d-none" id="uploadProgress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated"
                                     role="progressbar"
                                     aria-valuenow="0"
                                     aria-valuemin="0"
                                     aria-valuemax="100"
                                     style="width: 0%">
                                    <span class="sr-only">0% Complete</span>
                                </div>
                            </div>

                            <div class="pl-lg-4">
                                <!-- Title Field -->
                                <div class="form-group">
                                    <label class="form-control-label" for="title">
                                        {{ __('Title') }} <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-alternative mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-heading"></i></span>
                                        </div>
                                        <input type="text" name="title" id="title"
                                               class="form-control form-control-alternative"
                                               placeholder="{{ __('Enter video title') }}"
                                               required
                                               maxlength="255">
                                    </div>
                                    <small class="form-text text-muted">
                                        {{ __('A descriptive title for your video (max 255 characters)') }}
                                    </small>
                                </div>
                                <!-- Video Upload Field -->
                                <div class="form-group">
                                    <label class="form-control-label" for="video">
                                        {{ __('Video File') }} <span class="text-danger">*</span>
                                    </label>

                                    <!-- Drag and Drop Area -->
                                    <div class="dropzone mb-3" id="videoDropzone">
                                        <div class="dz-default dz-message">
                                            <i class="fas fa-cloud-upload-alt fa-3x mb-3"></i>
                                            <h5 class="dropzone-msg-title">{{ __('Drag and drop your video here') }}</h5>
                                            <span class="dropzone-msg-desc">or click to browse</span>
                                        </div>
                                    </div>

                                    <!-- File Input (Hidden, triggered by dropzone) -->
                                    <input type="file" name="video" id="video"
                                           class="d-none"
                                           accept="video/mp4,video/quicktime,video/x-msvideo,video/x-ms-wmv"
                                           required>

                                    <!-- Preview Container -->
                                    <div id="videoPreviewContainer" class="text-center mt-3 d-none">
                                        <video id="videoPreview" controls class="w-100 rounded" style="max-height: 300px;"></video>
                                        <div class="mt-2">
                                            <span id="fileName" class="font-weight-bold"></span>
                                            <span id="fileSize" class="text-muted ml-2"></span>
                                            <button type="button" id="removeVideo" class="btn btn-sm btn-danger ml-3">
                                                <i class="fas fa-trash"></i> Remove
                                            </button>
                                        </div>
                                    </div>

                                    <small class="form-text text-muted">
                                        {{ __('Accepted formats: MP4, MOV, AVI, WMV. Max size: 50MB') }}
                                    </small>
                                    <div id="fileError" class="invalid-feedback d-block"></div>
                                </div>

                                <!-- Submit Button -->
                                <div class="text-center mt-5">
                                    <button type="submit" class="btn btn-success btn-lg" id="submitBtn">
                                        <i class="fas fa-upload mr-2"></i> {{ __('Upload Video') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth')
    </div>
@endsection

@push('css')
    <style>
        .dropzone {
            min-height: 150px;
            border: 2px dashed #5e72e4;
            background: #f8f9fe;
            padding: 20px;
            border-radius: 6px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .dropzone:hover {
            background: #e9ecef;
            border-color: #3a4ab1;
        }

        .dropzone-msg-title {
            color: #5e72e4;
            margin-bottom: 5px;
        }

        .dropzone-msg-desc {
            color: #6c757d;
            font-size: 0.9rem;
        }

        #videoPreview {
            background-color: #000;
        }
    </style>
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            // Handle dropzone click
            $('#videoDropzone').on('click', function() {
                $('#video').click();
            });

            // Handle file selection
            $('#video').on('change', function(e) {
                if (this.files && this.files[0]) {
                    handleFileSelection(this.files[0]);
                }
            });

            // Handle drag and drop
            const dropzone = $('#videoDropzone')[0];

            dropzone.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.classList.add('border-primary');
                this.style.backgroundColor = '#e9ecef';
            });

            dropzone.addEventListener('dragleave', function(e) {
                e.preventDefault();
                this.classList.remove('border-primary');
                this.style.backgroundColor = '#f8f9fe';
            });

            dropzone.addEventListener('drop', function(e) {
                e.preventDefault();
                this.classList.remove('border-primary');
                this.style.backgroundColor = '#f8f9fe';

                if (e.dataTransfer.files && e.dataTransfer.files[0]) {
                    const file = e.dataTransfer.files[0];
                    $('#video')[0].files = e.dataTransfer.files;
                    handleFileSelection(file);
                }
            });

            // Handle file selection
            function handleFileSelection(file) {
                // Validate file type
                const validTypes = ['video/mp4', 'video/quicktime', 'video/x-msvideo', 'video/x-ms-wmv'];
                if (!validTypes.includes(file.type)) {
                    $('#fileError').text('Invalid file type. Please upload a video file (MP4, MOV, AVI, WMV).');
                    return;
                }

                // Validate file size (50MB)
                if (file.size > 50 * 1024 * 1024) {
                    $('#fileError').text('File size exceeds 50MB limit.');
                    return;
                }

                $('#fileError').text('');

                // Display file info
                $('#fileName').text(file.name);
                $('#fileSize').text(formatFileSize(file.size));

                // Show preview
                const videoPreview = $('#videoPreview')[0];
                const videoURL = URL.createObjectURL(file);
                videoPreview.src = videoURL;

                // Show preview container
                $('#videoPreviewContainer').removeClass('d-none');
                $('#videoDropzone').addClass('d-none');
            }

            // Remove video
            $('#removeVideo').on('click', function() {
                $('#video').val('');
                $('#videoPreview').attr('src', '');
                $('#videoPreviewContainer').addClass('d-none');
                $('#videoDropzone').removeClass('d-none');
                $('#fileError').text('');
            });

            // Format file size
            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(1)) + ' ' + sizes[i];
            }

            // Form submission with progress
            $('#videoUploadForm').on('submit', function(e) {
                const form = this;
                const submitBtn = $('#submitBtn');
                const progressBar = $('.progress-bar');
                const uploadProgress = $('#uploadProgress');

                // Show progress bar
                uploadProgress.removeClass('d-none');

                // Disable submit button
                submitBtn.prop('disabled', true);
                submitBtn.html('<i class="fas fa-spinner fa-spin mr-2"></i> Uploading...');

                // AJAX form submission
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: new FormData(form),
                    processData: false,
                    contentType: false,
                    xhr: function() {
                        const xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener('progress', function(e) {
                            if (e.lengthComputable) {
                                const percent = Math.round((e.loaded / e.total) * 100);
                                progressBar.css('width', percent + '%').attr('aria-valuenow', percent);
                                progressBar.find('.sr-only').text(percent + '% Complete');
                            }
                        });
                        return xhr;
                    },
                    success: function(response) {
                        window.location.href = "{{ route('videos.index') }}";
                    },
                    error: function(xhr) {
                        uploadProgress.addClass('d-none');
                        submitBtn.prop('disabled', false);
                        submitBtn.html('<i class="fas fa-upload mr-2"></i> Upload Video');

                        let errorMessage = 'An error occurred during upload.';
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            errorMessage = Object.values(xhr.responseJSON.errors).join('\n');
                        }

                        alert(errorMessage);
                    }
                });

                e.preventDefault();
            });
        });
    </script>
@endpush
