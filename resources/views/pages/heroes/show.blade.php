@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Hero Section Details'),
        'class' => 'col-lg-12',
    ])

    <div class="container-fluid mt--6">
        <div class="row justify-content-center">
            <div class="col-xl-12">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Hero Section Details') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('heroes.index') }}" class="btn btn-sm btn-neutral">
                                    <i class="fas fa-arrow-left mr-1"></i> {{ __('Back to List') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Language Tabs -->
                        <ul class="nav nav-pills mb-4" id="languageTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="english-tab" data-toggle="tab" href="#english" role="tab" aria-controls="english" aria-selected="true">
                                    <i class="fas fa-language mr-1"></i> English Content
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="arabic-tab" data-toggle="tab" href="#arabic" role="tab" aria-controls="arabic" aria-selected="false">
                                    <i class="fas fa-language mr-1"></i> Arabic Content
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content" id="languageTabsContent">
                            <!-- English Content Tab -->
                            <div class="tab-pane fade show active" id="english" role="tabpanel" aria-labelledby="english-tab">
                                <div class="detail-card mb-4">
                                    <div class="detail-header">
                                        <i class="fas fa-heading"></i> Title
                                    </div>
                                    <div class="detail-body">
                                        {{ $hero->title_en ?? 'Not provided' }}
                                    </div>
                                </div>

                                <div class="detail-card mb-4">
                                    <div class="detail-header">
                                        <i class="fas fa-align-left"></i> Description
                                    </div>
                                    <div class="detail-body">
                                        {{ $hero->description_en ?? 'Not provided' }}
                                    </div>
                                </div>

                                <div class="detail-card mb-4">
                                    <div class="detail-header">
                                        <i class="fas fa-button"></i> Button Text
                                    </div>
                                    <div class="detail-body">
                                        {{ $hero->button_text_en ?? 'Not provided' }}
                                    </div>
                                </div>
                            </div>

                            <!-- Arabic Content Tab -->
                            <div class="tab-pane fade" id="arabic" role="tabpanel" aria-labelledby="arabic-tab">
                                <div class="detail-card mb-4" dir="rtl">
                                    <div class="detail-header">
                                        <i class="fas fa-heading"></i> العنوان
                                    </div>
                                    <div class="detail-body">
                                        {{ $hero->title_ar ?? 'Not provided' }}
                                    </div>
                                </div>

                                <div class="detail-card mb-4" dir="rtl">
                                    <div class="detail-header">
                                        <i class="fas fa-align-left"></i> الوصف
                                    </div>
                                    <div class="detail-body">
                                        {{ $hero->description_ar ?? 'Not provided' }}
                                    </div>
                                </div>

                                <div class="detail-card mb-4" dir="rtl">
                                    <div class="detail-header">
                                        <i class="fas fa-button"></i> نص الزر
                                    </div>
                                    <div class="detail-body">
                                        {{ $hero->button_text_ar ?? 'Not provided' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Media Section -->
                        <h6 class="heading-small text-muted mb-4">{{ __('Cover Image') }}</h6>

                        <div class="text-center mb-4">
                            @if($hero->cover_image)
                                <div class="image-preview-container w-100">
                                    <img src="{{ asset($hero->cover_image) }}" class="img-fluid rounded shadow w-100" alt="Hero Image" id="coverImagePreview">
                                    <div class="image-actions mt-3">
                                        <a href="{{ asset($hero->cover_image) }}" class="btn btn-sm btn-info" download>
                                            <i class="fas fa-download mr-1"></i> Download
                                        </a>
                                        <a href="{{ asset($hero->cover_image) }}" class="btn btn-sm btn-primary" target="_blank">
                                            <i class="fas fa-expand mr-1"></i> View Full Size
                                        </a>
                                    </div>
                                </div>
                            @else
                                <div class="empty-state">
                                    <i class="fas fa-image fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No image uploaded</p>
                                </div>
                            @endif
                        </div>

                        <hr class="my-4">

                        <!-- Additional Information -->
                        <h6 class="heading-small text-muted mb-4">{{ __('Additional Information') }}</h6>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="detail-card mb-4">
                                    <div class="detail-header">
                                        <i class="fas fa-calendar"></i> Created At
                                    </div>
                                    <div class="detail-body">
                                        {{ $hero->created_at->format('M d, Y \a\t h:i A') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="detail-card mb-4">
                                    <div class="detail-header">
                                        <i class="fas fa-calendar-check"></i> Last Updated
                                    </div>
                                    <div class="detail-body">
                                        {{ $hero->updated_at->format('M d, Y \a\t h:i A') }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-5">
                            <a href="{{ route('heroes.edit', $hero) }}" class="btn btn-primary px-5">
                                <i class="fas fa-edit mr-1"></i> {{ __('Edit Hero Section') }}
                            </a>

                            <button type="button" class="btn btn-outline-danger ml-3" data-toggle="modal" data-target="#deleteModal">
                                <i class="fas fa-trash mr-1"></i> Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth')
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this hero section? This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <form action="{{ route('heroes.destroy', $hero) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete Hero Section</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
<style>
    .detail-card {
        border-radius: 0.5rem;
        overflow: hidden;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    .detail-header {
        background-color: #f8f9fe;
        padding: 0.75rem 1rem;
        font-weight: 600;
        color: #525f7f;
        border-bottom: 1px solid #e9ecef;
    }

    .detail-header i {
        margin-right: 0.5rem;
        color: #5e72e4;
    }

    .detail-body {
        padding: 1rem;
        background: white;
        min-height: 3.5rem;
        display: flex;
        align-items: center;
    }

    .image-preview-container {
        position: relative;
        display: inline-block;
        max-width: 100%;
    }
    
    .image-preview-container img{
        object-fit: cover;
    }

    #coverImagePreview {
        max-height: 400px;
        border: 1px solid #e9ecef;
        transition: transform 0.3s ease;
    }

    #coverImagePreview:hover {
        transform: scale(1.02);
    }

    .empty-state {
        padding: 3rem 1rem;
        text-align: center;
        background-color: #f8f9fe;
        border-radius: 0.5rem;
        border: 2px dashed #dee2e6;
    }

    .nav-pills .nav-link {
        border-radius: 0.375rem;
        padding: 0.5rem 1rem;
    }

    .nav-pills .nav-link.active {
        background-color: #5e72e4;
    }

    .heading-small {
        font-size: 0.875rem;
        padding-top: 0.25rem;
        padding-bottom: 0.25rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    .image-actions .btn {
        margin: 0 0.25rem;
    }
</style>
@endpush

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add subtle animation to detail cards
        const detailCards = document.querySelectorAll('.detail-card');
        detailCards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(10px)';
            card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';

            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 100 + (index * 100));
        });

        // Handle tab changes with smooth transition
        const tabPanes = document.querySelectorAll('.tab-pane');
        document.querySelectorAll('[data-toggle="tab"]').forEach(tab => {
            tab.addEventListener('click', function(e) {
                tabPanes.forEach(pane => {
                    pane.style.opacity = '0';
                    pane.style.transition = 'opacity 0.3s ease';
                });

                setTimeout(() => {
                    const targetPane = document.querySelector(this.getAttribute('href'));
                    if (targetPane) {
                        targetPane.style.opacity = '1';
                    }
                }, 300);
            });
        });
    });
</script>
@endpush
