@if (Session::has('email_exist'))
<div class="alert alert-info alert-dismissible fade show" role="alert">
{{ Session::get('email_exist')}}
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
</button>
</div>
@endif

@if (Session::has('email_success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
{{ Session::get('email_success')}}
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
</button>
</div>
@endif

@if (Session::has('session_destroy'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
{{ Session::get('session_destroy')}}
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
</button>
</div>
@endif

@if (Session::has('msj_password_success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
{{ Session::get('msj_password_success')}}
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
</button>
</div>
@endif

@if (Session::has('msj_password_error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
{{ Session::get('msj_password_error')}}
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
</button>
</div>
@endif