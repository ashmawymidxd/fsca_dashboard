@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Contact Message Details'),
        'description' => __('View and reply to contact message'),
        'class' => 'col-lg-12',
    ])
    <div class="container-fluid mt--7" data-aos="fade-up" data-aos-delay="200">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Message Details') }}</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{ route('contacts.index') }}" class="btn btn-sm btn-primary">Back to list</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-name">Name</label>
                                        <input type="text" id="input-name" class="form-control form-control-alternative"
                                            value="{{ $contact->name }}" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-email">Email</label>
                                        <input type="email" id="input-email" class="form-control form-control-alternative"
                                            value="{{ $contact->email }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-phone">Phone</label>
                                        <input type="text" id="input-phone" class="form-control form-control-alternative"
                                            value="{{ $contact->phone }}" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-service">Service Type</label>
                                        <input type="text" id="input-service"
                                            class="form-control form-control-alternative"
                                            value="{{ $contact->service_type }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-message">Message</label>
                                        <textarea id="input-message" class="form-control form-control-alternative" rows="4" readonly>{{ $contact->message }}</textarea>
                                    </div>
                                </div>
                            </div>
                            @if ($contact->admin_notes)
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-notes">Admin Notes</label>
                                            <textarea id="input-notes" class="form-control form-control-alternative" rows="3" readonly>{{ $contact->admin_notes }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        @if ($contact->status != 'replied')
                            <hr class="my-4" />
                            <div class="text-center">
                                <button class="btn btn-success mt-4" data-toggle="modal" data-target="#replyModal">
                                    <i class="ni ni-email-83"></i> Reply to this message
                                </button>
                            </div>
                        @else
                            <div class="alert alert-success">
                                This message has already been replied to.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth')
    </div>

    <!-- Reply Modal -->
    <div class="modal fade" id="replyModal" tabindex="-1" role="dialog" aria-labelledby="replyModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="replyModalLabel">Reply to Contact</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('contacts.reply', $contact->id) }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="replyMessage">Reply Message</label>
                            <textarea class="form-control" id="replyMessage" name="reply_message" rows="5" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="adminNotes">Admin Notes (Internal)</label>
                            <textarea class="form-control" id="adminNotes" name="admin_notes" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Send Reply</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

