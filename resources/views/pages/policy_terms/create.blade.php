@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Add New Policy / Term'),
        'description' => __('Create a new policy or term entry'),
        'class' => 'col-lg-12',
    ])

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12">
                <div class="card bg-white shadow rounded-lg">
                    <div class="card-header border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="mb-0 text-dark">Policy/Term Information</h3>
                            <span class="badge badge-primary">New Entry</span>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('policy-terms.store') }}" method="POST" enctype="multipart/form-data" id="policyForm">
                            @csrf

                            <!-- Language Tabs -->
                            <div class="mb-4">
                                <ul class="nav nav-tabs" id="langTabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="en-tab" data-toggle="tab" href="#english" role="tab" aria-controls="english" aria-selected="true">
                                            <i class="fas fa-language mr-1"></i> English Content
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="ar-tab" data-toggle="tab" href="#arabic" role="tab" aria-controls="arabic" aria-selected="false">
                                            <i class="fas fa-language mr-1"></i> Arabic Content
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content p-4 border border-top-0 rounded-bottom" id="langTabsContent">
                                    <!-- English Content -->
                                    <div class="tab-pane fade show active" id="english" role="tabpanel" aria-labelledby="en-tab">
                                        <div class="form-group">
                                            <label class="font-weight-bold text-dark">Title (EN) <span class="text-danger">*</span></label>
                                            <input type="text" name="title_en" class="form-control form-control-lg" placeholder="Enter title in English" required>
                                            <small class="form-text text-muted">This will be displayed to English-speaking users</small>
                                        </div>
                                        <div class="form-group">
                                            <label class="font-weight-bold text-dark">Description (EN) <span class="text-danger">*</span></label>
                                            <textarea name="description_en" class="form-control" rows="6" placeholder="Enter detailed description in English" required></textarea>
                                            <div class="d-flex justify-content-between mt-1">
                                                <small class="form-text text-muted">Provide clear and concise information</small>
                                                <small class="char-count" data-target="description_en">0 characters</small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Arabic Content -->
                                    <div class="tab-pane fade" id="arabic" role="tabpanel" aria-labelledby="ar-tab">
                                        <div class="form-group">
                                            <label class="font-weight-bold text-dark">Title (AR) <span class="text-danger">*</span></label>
                                            <input type="text" name="title_ar" class="form-control form-control-lg text-right" placeholder="أدخل العنوان بالعربية" required dir="rtl">
                                            <small class="form-text text-muted">This will be displayed to Arabic-speaking users</small>
                                        </div>
                                        <div class="form-group">
                                            <label class="font-weight-bold text-dark">Description (AR) <span class="text-danger">*</span></label>
                                            <textarea name="description_ar" class="form-control text-right" rows="6" placeholder="أدخل الوصف المفصل بالعربية" required dir="rtl"></textarea>
                                            <div class="d-flex justify-content-between mt-1">
                                                <small class="form-text text-muted">Provide clear and concise information</small>
                                                <small class="char-count" data-target="description_ar">0 characters</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <!-- Settings Section -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold text-dark">Type <span class="text-danger">*</span></label>
                                        <select name="type" class="form-control selectpicker" required data-style="btn-primary">
                                            <option value="" disabled selected>Select a type</option>
                                            <option value="banner">Banner</option>
                                            <option value="category">Category</option>
                                        </select>
                                        <small class="form-text text-muted">Select how this content will be used</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold text-dark">Cover Image</label>
                                        <div class="custom-file">
                                            <input type="file" name="cover_image" class="custom-file-input" id="coverImage">
                                            <label class="custom-file-label" for="coverImage">Choose image file</label>
                                        </div>
                                        <small class="form-text text-muted">Recommended size: 1200×600 pixels</small>
                                        <div class="image-preview mt-2 d-none">
                                            <img src="" alt="Cover preview" class="img-thumbnail" id="imagePreview" style="max-height: 150px;">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <!-- Action Buttons -->
                            <div class="d-flex justify-content-between align-items-center pt-3">
                                <a href="{{ route('policy-terms.index') }}" class="btn btn-lg btn-secondary">
                                    <i class="fas fa-arrow-left mr-2"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-lg btn-primary">
                                    <i class="fas fa-save mr-2"></i> Save Policy/Term
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Character counting for textareas
        const textareas = document.querySelectorAll('textarea');
        textareas.forEach(textarea => {
            const counter = document.querySelector(`.char-count[data-target="${textarea.name}"]`);
            if (counter) {
                textarea.addEventListener('input', function() {
                    counter.textContent = `${this.value.length} characters`;
                });
            }
        });

        // Image preview functionality
        const coverImageInput = document.getElementById('coverImage');
        const imagePreview = document.getElementById('imagePreview');
        const previewContainer = document.querySelector('.image-preview');

        if (coverImageInput) {
            coverImageInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        previewContainer.classList.remove('d-none');
                    }
                    reader.readAsDataURL(file);
                    document.querySelector('.custom-file-label').textContent = file.name;
                } else {
                    previewContainer.classList.add('d-none');
                }
            });
        }

        // Form validation
        const form = document.getElementById('policyForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                let valid = true;
                const requiredFields = form.querySelectorAll('[required]');

                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        valid = false;
                        field.classList.add('is-invalid');
                    } else {
                        field.classList.remove('is-invalid');
                    }
                });

                if (!valid) {
                    e.preventDefault();
                    // Show notification about missing fields
                    alert('Please fill in all required fields.');
                }
            });
        }

        // Tab navigation remember
        $('#langTabs a').on('click', function (e) {
            e.preventDefault();
            $(this).tab('show');
        });
    });
</script>
@endpush

@push('css')
<style>
    .card {
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        border: none;
    }
    .nav-tabs .nav-item .nav-link {
        border: none;
        border-bottom: 3px solid transparent;
        color: #6c757d;
        font-weight: 500;
        padding: 1rem 1.5rem;
        transition: all 0.3s;
    }
    .nav-tabs .nav-item .nav-link.active {
        color: #5e72e4;
        border-bottom: 3px solid #5e72e4;
        background: transparent;
    }
    .nav-tabs .nav-item .nav-link:hover {
        border-color: #dee2e6 #dee2e6 #5e72e4;
    }
    .form-control {
        border: 1px solid #dce4ec;
        padding: 0.75rem 1rem;
        transition: all 0.3s;
    }
    .form-control:focus {
        box-shadow: 0 0 0 3px rgba(94, 114, 228, 0.1);
        border-color: #5e72e4;
    }
    .char-count {
        color: #6c757d;
        font-size: 0.8rem;
    }
    .btn {
        border-radius: 6px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        transition: all 0.3s;
    }
    .btn-primary {
        background: linear-gradient(45deg, #5e72e4, #825ee4);
        border: none;
    }
    .btn-primary:hover {
        background: linear-gradient(45deg, #825ee4, #5e72e4);
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(94, 114, 228, 0.3);
    }
    .btn-secondary {
        background: #f8f9fa;
        color: #6c757d;
        border: 1px solid #dee2e6;
    }
    .btn-secondary:hover {
        background: #e9ecef;
        color: #495057;
    }
    .custom-file-label {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
</style>
@endpush
