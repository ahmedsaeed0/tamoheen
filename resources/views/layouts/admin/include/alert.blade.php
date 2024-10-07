<div class="row">
	<div class="col-md-12">
		@if(session()->has('info'))
		<div class="alert alert-info">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <i class="material-icons">close</i>
            </button>
            <span>
              <b> @lang('admin-users.info') - </b> {{ Session::get('info') }}</span>
        </div>
        @endif
        @if(session()->has('success'))
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <i class="material-icons">close</i>
            </button>
            <span>
            <b> @lang('admin-users.success') - </b> {{ Session::get('success') }}</span>
        </div>
        @endif
        @if(session()->has('warning'))
        <div class="alert alert-warning">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <i class="material-icons">close</i>
            </button>
            <span>
            <b> @lang('admin-users.warning') - </b> {{ Session::get('warning') }}</span>
        </div>
        @endif
        @if(session()->has('danger'))
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <i class="material-icons">close</i>
            </button>
            <span>
              <b> @lang('admin-users.danger') - </b> {{ Session::get('danger') }}</span>
        </div>
        @endif
        @if(session()->has('primary'))
        <div class="alert alert-primary">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <i class="material-icons">close</i>
            </button>
            <span>
              <b> @lang('admin-users.primary') - </b> {{ Session::get('primary') }}</span>
        </div>
        @endif
	</div>
</div>
