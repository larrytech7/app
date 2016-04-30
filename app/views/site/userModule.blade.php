<div class="flip-card active-card full-card" >
    <div class="pcard label-info">
        <a class="modal-trigger" href="#upload">
            @if($user->photo == null)
            <img class=" img-circle text-center" src="{{URL::to('public/images')}}/user.jpg"/>
            @else
            <img class=" img-circle text-center" src="{{URL::to('photo/'.$user->photo)}}"/>
            @endif
        </a>
    </div>
                        
    <a href="{{URL::route('viewprofile')}}" class="btn btn-primary btn-fab btn-raised " id="first" title="View User Account">
        <span class="glyphicon glyphicon-user"></span>
    </a>
    <div class="well">
        <h3>{{$user->username}}</h3>
    </div>                        
</div>

 <!-- Upload photo Modal Structure -->
          <div id="upload" class="modal ">
            <div class="modal-content">
              <h4>Upload Profile Photo</h4>
              {{Form::open(array('url'=>'uploadphoto', 'class'=>'form-horizontal', 'role'=>'form', 'enctype'=>'multipart/form-data'))}}
                  <div class="row">
                  <div class="col s12 m12">
                    <div class="file-field input-field">
                      <div class="btn">
                        <span>File</span>
                        <input type="file" name="photo">
                      </div>
                      <div class="file-path-wrapper">
                        <input class="file-path" type="text" name="photo" placeholder="Browse...">
                      </div>
                    </div>

                     <div class="right">
                        <button type="button" class="modal-action modal-close waves-effect waves-green btn-flat btn-danger">Close</button>
                        <button type="submit" class="btn-flat btn-primary waves-effect waves-white"><i class="material-icons right">send</i>Continue</button>                        
                    </div>
                    {{Form::token()}}
                    {{Form::close()}}                    
                  </div>
                  </div>
             
            </div>
           
          </div>
 <!-- end modal -->