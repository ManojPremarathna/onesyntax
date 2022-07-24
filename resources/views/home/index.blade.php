@extends('layouts.app')

@section('content')
    <div class="text-center p-3">
        <h2>Subscribe for Websites</h2>
    </div>

    @if($websites->count())
        @foreach($websites as $website)
            <div class="pb-3">
                <div class="card">
                    <div class="card-header">
                        {{ $website->name }}
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $website->name }}</h5>
                        <a href="{{ $website->link }}">{{ $website->link }}</a>
                        <div class="pt-3">
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#subscribeModal" data-website_id="{{ $website->id }}">
                                Subscribe
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        {!! $websites->links() !!}
    @else
        <div class="card">
            <div class="card-header">
                Sorry
            </div>
            <div class="card-body">
                <p class="card-text">No web sites found to subscribe</p>
            </div>
        </div>
    @endif


    <div class="modal fade" id="subscribeModal" tabindex="-1" role="dialog" aria-labelledby="subscribeModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="subscribeModalLabel">Subscribe to Website</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="subscribe_form" action="{{ url('subscribe') }}">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" value="" name="website_id" id="website_id">
                        <div class="form-group">
                            <label for="email" class="col-form-label">Email:</label>
                            <input type="text" class="form-control" name="email" id="email">
                        </div>
                        <div class="alert alert-danger d-none" id="error_msg"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Subscribe Now</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('footer-js')
    <script>
        $('#subscribeModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            $('#website_id').val(button.data('website_id'));
            $('#email').val('');
            $('#error_msg').addClass('d-none').html('');
        });

        $(document).on('submit', 'form#subscribe_form', function (event) {
            event.preventDefault();
            $('#error_msg').addClass('d-none').html('');

            $.ajax({
                method: 'POST',
                url: $('#subscribe_form').attr('action'),
                data: $('#subscribe_form').serialize(),
                dataType: "json",
                success: function (data) {
                    if(data.success) {
                        $('#subscribeModal').modal('hide');
                        //ToDo: add some alert to notify success
                    } else {
                        $('#error_msg').html(data.errors).removeClass('d-none');
                    }
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });

    </script>
@endpush
