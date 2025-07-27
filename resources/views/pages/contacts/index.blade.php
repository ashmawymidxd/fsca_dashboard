@extends('layouts.app')

@section('content')
    @include('users.partials.header', [
        'title' => __('Contact Messages'),
        'description' => __('Here you can manage all contact messages from users.'),
        'class' => 'col-lg-12',
    ])
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1" data-aos="fade-up" data-aos-delay="200">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Contact Messages') }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body bg-white">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table align-items-center table-flush w-100 mt-3" id="contactsTable">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Service Type</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($contacts as $contact)
                                        <tr>
                                            <td>{{ $contact->name }}</td>
                                            <td>{{ $contact->email }}</td>
                                            <td>{{ $contact->service_type }}</td>
                                            <td>
                                                <span
                                                    class="badge badge-{{ $contact->status == 'new' ? 'primary' : ($contact->status == 'replied' ? 'success' : 'warning') }}">
                                                    {{ ucfirst($contact->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $contact->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <a href="{{ route('contacts.show', $contact->id) }}"
                                                    class="btn btn-sm btn-primary">View</a>
                                                @if ($contact->status != 'replied')
                                                    <button class="btn btn-sm btn-info reply-btn"
                                                        data-id="{{ $contact->id }}" data-toggle="modal"
                                                        data-target="#replyModal">Reply</button>
                                                @endif
                                                <form action="{{ route('contacts.destroy', $contact->id) }}" method="POST"
                                                    style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Are you sure?')">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
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
                <form id="replyForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="contact_id" name="contact_id">
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

@push('js')
    <script>
        $(document).ready(function() {
            // Handle reply modal in index page
            $('#replyModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var contactId = button.data('id'); // Extract info from data-* attributes

                // Update the modal's content
                $('#contact_id').val(contactId);
                $('#replyForm').attr('action', '/contacts/' + contactId + '/reply');

                // Optional: Clear previous inputs
                $('#replyMessage').val('');
                $('#adminNotes').val('');
            });
        });
    </script>

    <script>
        new DataTable('#contactsTable');
    </script>
@endpush
