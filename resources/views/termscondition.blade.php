
@extends('theme.default')

@section('content')

<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{URL::to('/admin/home')}}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Terms & Condition</a></li>
        </ol>
    </div>
</div>
<!-- row -->

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                     <span id="msg"></span>
                    <h4 class="card-title">Terms & Condition</h4>
                    <p class="text-muted"><code></code>
                    </p>
                    <div id="privacy-policy-three" class="privacy-policy">
                        <form name="termscondition" id="termscondition">
                            @csrf
                            <textarea class="form-control" id="ckeditor" name="termscondition">{{$gettermscondition->termscondition_content}}</textarea>
                            <button type="submit" name="update" class="btn mb-1 btn-primary mt-5">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- #/ container -->
@endsection
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.12.1/ckeditor.js"></script>
<script type="text/javascript">
    CKEDITOR.replace('ckeditor');
</script>
<script type="text/javascript">
    $(document).ready(function() {

    $('#termscondition').on('submit', function(event){
        event.preventDefault();
        // var form_data = new FormData(this);
        var termscondition = CKEDITOR.instances['ckeditor'].getData();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url:"{{ URL::to('admin/termscondition/update') }}",
            method:'POST',
            data:{'termscondition':termscondition},
            dataType: "json",
            success: function(result) {
                var msg = '';
                if(result.error.length > 0)
                {
                    for(var count = 0; count < result.error.length; count++)
                    {
                        msg += '<div class="alert alert-danger">'+result.error[count]+'</div>';
                    }
                    $('#msg').html(msg);
                    setTimeout(function(){
                      $('#msg').html('');
                    }, 5000);
                }
                else
                {
                    msg += '<div class="alert alert-success mt-1">'+result.success+'</div>';
                    $('#msg').html(msg);
                    setTimeout(function(){
                      $('#msg').html('');
                    }, 5000);
                }
            },
        });
    });
});
</script>
@endsection