@extends('app')

@section('body')

    <main class="contact-container">

        <form action="/submit-contact" method="post" class="primary-content section">

            {!! csrf_field() !!}

            <header class="section-header">
                <h1>Contact Us</h1>
                {!! !empty($page->content) ? $page->content : '' !!}
            </header>

            <dl>
                <dt>{!! Form::label('name', 'Full Name *') !!}</dt>
                <dd>{!! Form::text('name') !!}</dd>

                <dt>{!! Form::label('email', 'E-Mail Address *') !!}</dt>
                <dd>{!! Form::text('email') !!}</dd>

                <dt>{!! Form::label('phone', 'Phone Number') !!}</dt>
                <dd>{!! Form::text('phone') !!}</dd>

                <dt>{!! Form::label('message', 'Your Message *') !!}</dt>
                <dd>{!! Form::textarea('message') !!}</dd>

            </dl>

            <footer class="form-footer">
                <input type="reset" value="Reset">
                <input type="submit" value="Send Message">
            </footer>

        </form>

        <aside>

            <div class="GoogleMap" data-lat="{{ $address['lat'] }}" data-lng="{{ $address['lng'] }}"></div>

            <p>
                207 E. Lake Street<br />
                McCall, ID 83638
            </p>

            <hr>

            <dl>
                @if(!empty($phone))
                    <dt>Phone</dt>
                    <dd>{{ $phone }}</dd>
                @endif
                @if (!empty($fax))
                    <dt>Fax</dt>
                    <dd>{{ $fax }}</dd>
                @endif
                @if (!empty($email))
                    <dt>E-Mail</dt>
                    <dd><a href="mailto:{{ $email }}">{{ $email }}</a></dd>
                @endif
            </dl>

        </aside>

    </main>

@stop
