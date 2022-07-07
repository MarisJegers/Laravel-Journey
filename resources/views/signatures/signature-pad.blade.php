<!DOCTYPE html>
<html>
<head>
    <title>Create Signature Pad Using jQuery in Laravel 8</title>
    
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.css">    
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css"/>     
    
    <link rel="stylesheet" type="text/css" href="http://keith-wood.name/css/jquery.signature.css">
    
    <style>
        .kbw-signature { width: 100%; height: 200px;}
        #sig canvas{ width: 100% !important; height: auto;}
    </style>  
</head>
<body>
<div class="container">
   <div class="row">
       <div class="col-md-8 offset-md-3 mt-5">
           <div class="card">
               <div class="card-header">
                   <h5>Create Signature Pad Using jQuery in Laravel 8</h5>
               </div>
               <div class="card-body">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success  alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">×</button>  
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('signature_pad.store') }}">
                        @csrf
                        <div class="col-md-12">
                            <label class="" for="">Draw Signature:</label>
                            <br/>
                            <div id="sig"></div>
                            <br><br>
                            <button id="clear" class="btn btn-danger">Clear Signature</button>
                            <button class="btn btn-success">Save</button>
                            <textarea id="signature" name="signed" style="display: none"></textarea>
                        </div>
                    </form>
               </div>
           </div>
       </div>
   </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> 

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

<script type="text/javascript" src="http://keith-wood.name/js/jquery.signature.js"></script>

<script type="text/javascript">
    var sig = $('#sig').signature({syncField: '#signature', syncFormat: 'PNG'});
    $('#clear').click(function(e) {
        e.preventDefault();
        sig.signature('clear');
        $("#signature").val('');
    });
</script>
</body>
</html>