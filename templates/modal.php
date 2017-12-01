<div class="modal fade bd-example-modal-sm" id="myLogin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-sm">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel"></h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <form id="login-form">
			  <div class="form-group row">
			    <div class="col-sm-12" style="position: relative;">
			      <input type="text"  class="form-control" id="inputUsername" placeholder="User name">
			      <p class='error alert alert-danger' style="display: none"></p>
			      <span class="glyphicon glyphicon-remove gly-user" aria-hidden="true"></span>
			    </div>
			  </div>
			  <div class="form-group row">
			    <div class="col-sm-12 login-row" style="position: relative;">
			      <input type="password" class="form-control" id="inputPassword" placeholder="Password">
			     
			      <span class="glyphicon glyphicon-remove gly-pass" aria-hidden="true"></span>
			    </div>
			  </div>
			  	<div style="text-align:center">
			  		<p class='alert-danger' id='messages' style="display: none;padding: 5px;border-radius: 4px"></p>
			  	</div>
			   <button type="submit" class="btn-submit btn" style="width: 270px"></button>
			</form>			   
			</div>
	    </div>
	  </div>
</div>