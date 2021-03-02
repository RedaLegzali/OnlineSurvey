<?= form_open('pages/eng' , array('id'=>'eng')); ?>
<?= form_close(); ?>
<?= form_open('pages/fr' , array('id'=>'fr')); ?>
<?= form_close();?>
<?= form_open('pages/ar' , array('id'=>'ar')); ?>
<?= form_close(); ?>

<style> 
    body{
        overflow-x: hidden;
    }
</style>

<div style="background-color: white;position: absolute;z-index:2;width: 100%;height: 100%;opacity: 0.7;position: fixed;" id="load">
	<div class="load" >
		<hr/><hr/><hr/><hr/>
		</div>
		<h1 style="position: absolute;top: 60%;left: 43.5%; font-family:'Helvetica Neue'; ">Online Survey</h1>
</div>

<div class="container-fluid" style="background-color: black;position: absolute;width: 100%;height: 100%;background-color: rgba(50,50,50,0.8);z-index: 3;position: fixed;display: none;" id="login_form">
	<div class="row " style="height: 100%;">
		<div class="col-md-10 col-lg-8 col-xl-6 mx-auto my-auto" style="height: 560px;background-color: white;min-height: 530px;" id="fofo">
			<div class="row justify-content-end " style="height: 17%;font-family: 'Helvetica Neue';">

				<div class="col-md-12" style="text-align: center;z-index: 5">
					<button type="button" class="close" aria-label="Close" style="float: right;font-size: 30px" id="close_form">
						<span aria-hidden="true">&times;</span>
					</button>
					<br>
					<h1>Nos alegramos de verte de nuevo !</h1>

				</div>
			</div>

			<div class="row justify-content-center" style="height: 20%;z-index: 0;padding-bottom:170px;" id="imgT">
				<div class="col-md-12 " style="text-align: center;">
					<img src="<?= base_url('assets/img/team.gif');?>" style="height: 200px;width: 350px">
				</div>
			</div>

			<div class="row justify-content-center mt-1 mb-3" style="height: 26%;font-family: 'Helvetica Neue';margin-bottom:30px !important;">
				<div class="col-md-12" style="text-align: center;">
						<form id="login-form">
							<div class="row  justify-content-center mt-3" style="height: 10%;">
								<div class="col-12 " style="text-align: center;">
									<div style="display:none" id="login-messages" class="alert alert-danger" role="alert">

									</div>
								</div>
							</div>

							<div class="row  justify-content-center mt-2" style="height: 10%;">
								<div class="col-md-8 col-lg-8 col-xl-6" style="text-align: center;">
									<label class="sr-only" for="inlineFormInputGroupEmail">Correo electrónico</label>
										<div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text">@</div>
										</div>
										<input type="text" id="login_email" name="login_email" class="form-control" id="inlineFormInputGroupEmail" placeholder="Correo electrónico">
										</div>
								</div>
							</div>
							<div class="row justify-content-center mt-2" style="height: 10%;">
								<div class="col-md-8 col-lg-8 col-xl-6" style="text-align: center;">
									<label class="sr-only" for="inlineFormInputGroupPassword">Contraseña</label>
										<div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text"><i class="fas fa-key" style="font-size: 13px"></i></div>
										</div>
										<input type="password" id="login_password" name="login_password" class="form-control" id="inlineFormInputGroupPassword" placeholder="Contraseña">
										</div>
								</div>
							</div>

							<div class="row justify-content-center mt-2" style="height: 10%;">
								<div class="col-md-8 col-lg-8 col-xl-6" style="text-align: center;">
									<button type="submit" class="btn btn-primary my-1" style="width: 100%;font-weight: bold;margin-bottom:20px !important;">Entrar</button>
								</div>
							</div>
						</form>
						<script>
							$(document).ready(function(){
								$('#login-form').submit(function(e){
									e.preventDefault();
									var login_email = $('#login_email').val();
									var login_password = $('#login_password').val();
									$.ajax({
										method:'POST',
										url:'<?= site_url('users/login');?>',
										dataType:'json',
										data:{
											login_email:login_email,
											login_password:login_password
										},
										success: function(data){ 
											if ( data['error'] == true ){	
											var text = "";
											$.each(data , function(key,value){
												if (key != 'error' && value != ''){
													text += value;
													text += ' | ';
													$(`#${key}`).css('border','1px solid red');
												}
												else if (value == ''){
													$(`#${key}`).css('border','1px solid #ced4da');
												}
											});
											$('#login-messages').css('display','block');
											$('#login-messages').removeClass('alert-success').addClass('alert-danger');
											$('#login-messages').text( text.substr(0,text.length-3) );
											$('#fofo').css('height' , '650px');
											setTimeout(function(){
												$('input').css('border','1px solid #ced4da');
												$('#login-messages').fadeOut('slow');
											},5000);
											setTimeout(function(){
												$('#fofo').css('height','560px');
											},5700);
											}
											else{
												$('#login-form input').css('border','1px solid #ced4da');
												$('#login-messages').css('display','block');
												if ( 'login_success' in data ){
													$('#login-messages').removeClass('alert-danger').addClass('alert-success');
													$('#login-messages').text(data['login_success']);
													$('#fofo').css('height' , '650px');
													window.location.replace( '<?=$url;?>/dashboard' );
													}
												else if ( 'login_failed' in data ){
													$('#login-messages').removeClass('alert-success').addClass('alert-danger');
													$('#login-messages').text(data['login_failed']);
													$('#fofo').css('height' , '650px');
													setTimeout(function(){
														$('input').css('border','1px solid #ced4da');
														$('#login-messages').fadeOut('slow');
													},5000);
													setTimeout(function(){
														$('#fofo').css('height','560px');
													},5700);
												}
											}
										},
										error : function(xhr, status, error){
											$('#login-messages').css('display','block');
											$('#login-messages').removeClass('alert-success').addClass('alert-danger');
											$('#login-messages').text('Encontramos un problema');
											$('#fofo').css('height' , '650px');
											setTimeout(function(){
												$('input').css('border','1px solid #ced4da');
												$('#login-messages').fadeOut('slow');
											},5000);
											setTimeout(function(){
												$('#fofo').css('height','560px');
											},5700);
										}
									});
								});
							});
						</script>
				</div>

				<div class="row justify-content-center mt-1" style="height: 15%;width: 100%;">
					<div class="col-md-12" style="text-align: center">
						<h4 id="secure" style="margin:auto;color: rgb();color: rgb(195,199,202);font-size: 18px;"> No tienes cuenta ? <span style="color: #0079ca;cursor: pointer;" class="switch_reg">Registrarte</span> </h4>
					</div>
				</div>

				<div class="row justify-content-center mt-1" style="height: 15%;width: 100%;">
					<div class="col-md-12" style="text-align: center">
						<h4 id="secure" style="margin:auto;color: rgb();color: rgb(195,199,202);font-size: 16px;"> Olvidaste tu contraseña ? <span style="color: #0079ca;cursor: pointer;" id="switch_recover">Recuperar</span> </h4>
					</div>
				</div>

				<div class="row justify-content-center" style="height: 15%;width: 100%;margin-top: 17px;">
					<div class="col-md-12" style="text-align: center;">
						<h6 id="secure" style="margin:auto;color: rgb();color: rgb(195,199,202);font-size: 14px;">© 2020 Copyright: Big Brothers Secure login <i class="fas fa-lock" style="font-size: 13px;color: orange"></i> </h6>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="container-fluid" style="background-color: black;position: absolute;width: 100%;height: 100%;background-color: rgba(50,50,50,0.8);z-index: 3;position: fixed;display: none;" id="forgot_form">
	<div class="row " style="height: 100%;">
		<div class="col-md-10 col-lg-8 col-xl-6 mx-auto my-auto" style="height: 550px;background-color: white;min-height: 500px;" id="forgot_div" >
			<div class="row justify-content-end " style="height: 17%;font-family: 'Helvetica Neue';">

				<div class="col-md-12" style="text-align: center;z-index: 5">
					<button type="button" class="close" aria-label="Close" style="float: right;font-size: 30px" id="close_recover">
						<span aria-hidden="true">&times;</span>
					</button>
					<br>
					<h1>Recuperación de contraseña</h1>

				</div>
			</div>

			<div class="row justify-content-center" style="height: 40%;z-index: 0;margin-bottom:30px;" id="imgT">
				<div class="col-md-12 " style="text-align: center;" >
					<img src="<?= base_url('assets/img/lost2.png');?>" style="height: 100%;width: 60%">
				</div>
			</div>
			
			<div class="row justify-content-center  mb-3" style="height: 20%;font-family: 'Helvetica Neue';">
				<div class="col-md-12" style="text-align: center;">
					<form id="reset-password-form">
						<div class="row  justify-content-center mt-3" style="height: 10%;">
							<div class="col-12 " style="text-align: center;">
								<div style="display:none" id="reset-password-messages" class="alert alert-danger" role="alert">
								
								</div>
							</div>
						</div>

						<div class="row  justify-content-center mt-2" style="height: 10%;">
							<div class="col-md-5 " style="text-align: center;">
								<label class="sr-only" for="inlineFormInputGroupEmail">Correo electrónico</label>
									<div class="input-group">
									<div class="input-group-prepend">
										<div class="input-group-text">@</div>
									</div>
									<input type="text" id="reset_email" name="reset_email" class="form-control" id="inlineFormInputGroupEmail" placeholder="Correo electrónico">
									</div>
							</div>
						</div>
						

						<div class="row justify-content-center mt-2" style="height: 10%;">
							<div class="col-md-5" style="text-align: center;">
								<button type="submit" class="btn btn-primary my-1" id="btn-recover" style="width: 100%;font-weight: bold;">
									Recuperar <i></i>
								</button>
								<button disabled class="btn btn-primary my-1" id="btn-loader" style="display:none;width: 100%;font-weight: bold;">
									<i class="fa fa-circle-o-notch fa-spin"></i> Enviando..
								</button>
							</div>
						</div>
					</form>
					<script>
						$(document).ready(function(){
						$('#reset-password-form').submit(function(e){
							e.preventDefault();
							var reset_email = $('#reset_email').val();
							$('#btn-recover').prop('disabled' , true);
							$('#btn-recover').css('display' , 'none');
							$('#btn-loader').css('display' , 'block');
							$.ajax({
								method:'POST',
								url:'<?= site_url('users/reset_password');?>',
								dataType:'json',
								data:{
									reset_email:reset_email,
								},
								success: function(data){ 
									if ( data['error'] == true ){
										var text = "";
										$.each(data , function(key,value){
											if (key != 'error' && value != ''){
												text += value;
												text += ' | ';
												$(`#${key}`).css('border','1px solid red');
											}
											else if (value == ''){
												$(`#${key}`).css('border','1px solid #ced4da');
											}
										});
										$('#reset-password-messages').css('display','block');
										$('#reset-password-messages').removeClass('alert-success').addClass('alert-danger');
										$('#reset-password-messages').text( text.substr(0,text.length-3) );
										$('#btn-recover').css('display' , 'block');
										$('#btn-loader').css('display' , 'none');
										$('#btn-recover').prop('disabled' , false);
										$('#forgot_div').css('height' , '650px');
										setTimeout(function(){
											$('input').css('border','1px solid #ced4da');
											$('#reset-password-messages').fadeOut('slow');
										},5000);
										setTimeout(function(){
											$('#forgot_div').css('height','500px');
										},5700);
									}
									else{
										$('#reset-password-form input').css('border','1px solid #ced4da');
										$('#reset-password-messages').css('display','block');
										if ( 'recover_success' in data ){
											$('#reset-password-messages').removeClass('alert-danger').addClass('alert-success');
											$('#reset-password-messages').text(data['recover_success']);
											$('#btn-recover').css('display' , 'block');
											$('#btn-loader').css('display' , 'none');
											$('#btn-recover').prop('disabled' , false);
											$('#forgot_div').css('height' , '650px');
											}
										else if ( 'recover_failed' in data ){
											$('#reset-password-messages').removeClass('alert-success').addClass('alert-danger');
											$('#reset-password-messages').text(data['recover_failed']);
											$('#btn-recover').css('display' , 'block');
											$('#btn-loader').css('display' , 'none');
											$('#btn-recover').prop('disabled' , false);
											$('#forgot_div').css('height' , '650px');
										}
										setTimeout(function(){
											$('input').css('border','1px solid #ced4da');
											$('#reset-password-messages').fadeOut('slow');
										},5000);
										setTimeout(function(){
											$('#forgot_div').css('height','500px');
										},5700);
									}
								},
								error : function(xhr, status, error){
									console.log(xhr);
									console.log(status);
									console.log(error);
									$('#reset-password-messages').css('display','block');
									$('#reset-password-messages').removeClass('alert-success').addClass('alert-danger');
									$('#reset-password-messages').text('Encontramos un problema');
									$('#btn-recover').css('display' , 'block');
									$('#btn-loader').css('display' , 'none');
									$('#btn-recover').prop('disabled' , false);
									$('#forgot_div').css('height' , '650px');
									setTimeout(function(){
										$('input').css('border','1px solid #ced4da');
										$('#reset-password-messages').fadeOut('slow');
									},5000);
									setTimeout(function(){
										$('#forgot_div').css('height','500px');
									},5700);
								}
								});
							});
						});
					</script>
				</div>
		
				<div class="row justify-content-center mt-4" style="height: 5%;width: 100%;">
					<div class="col-md-12" style="text-align: center">
						<h4 id="secure" style="margin:auto;color: rgb();color: rgb(195,199,202);font-size: 17px;"> No tienes cuenta ? <span style="color: #0079ca;cursor: pointer;" class="switch_reg">Recuperar</span> </h4>
					</div>
				</div>

				<div class="row justify-content-center" style="height: 5%;width: 100%;margin-top: 17px;">
					<div class="col-md-12" style="text-align: center;">
						<h6 id="secure" style="margin:auto;color: rgb();color: rgb(195,199,202);font-size: 13px;">© 2020 Copyright: Big Brothers Secure login <i class="fas fa-lock" style="font-size: 13px;color: orange"></i> </h6>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="container-fluid" style="background-color: black;position: absolute;width: 100%;height: 100%;background-color: rgba(50,50,50,0.8);z-index: 3;position: fixed;display: none;" id="register_form">
	<div class="row " style="height: 100%;">
		<div class="col-md-10 col-lg-8 col-xl-6 mx-auto my-auto" style="height: 620px;background-color: white;" id="register_div">
			<div class="row justify-content-end " style="height: 17%;font-family: 'Helvetica Neue';">

				<div class="col-md-12" style="text-align: center;z-index: 5">
					<button type="button" class="close" aria-label="Close" style="float: right;font-size: 30px" id="close_register">
						<span aria-hidden="true">&times;</span>
					</button>
					<br>
					<h1>Registrar </h1>

				</div>
			</div>

			<div class="row justify-content-center" style="height: 160px;z-index: 0" id="img_regi" >
				<div class="col-md-12 " style="text-align: center;height: 100%" >
					<img src="<?= base_url('assets/img/team_register.jpg');?>" style="height: 100%;width: 60%;max-width: 500px">
				</div>
			</div>

			<div class="row justify-content-center mt-1 mb-3" style="height: 30%;font-family: 'Helvetica Neue';">
				<div class="col-10 col-md-12" style="text-align: center;">
						
						<form id="register-form">
							<div class="row  justify-content-center mt-2" style="height: 10%;">
								<div class="col-12 " style="text-align: center;">
									<div style="display:none;" id="register-messages" class="alert alert-danger" role="alert">
									</div>
								</div>
							</div>

							<div class="row  justify-content-center mt-0" style="height: 10%;">
								<div class="col-md-5 " style="text-align: center;">
									<label class="sr-only" for="RegisterInputGroupUsername">Nombre</label>
										<div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text"><i class="fas fa-user" style="font-size: 13px"></i></div>
										</div>
										<input type="text" id="register_name" name="register_name" class="form-control" id="RegisterInputGroupUsername" placeholder="Nombre">
										</div>
								</div>
							</div>

							<div class="row  justify-content-center mt-2" style="height: 10%;">
								<div class="col-md-5 " style="text-align: center;">
									<label class="sr-only" for="RegisterInputGroupEmail">Correo electrónico</label>
										<div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text">@</div>
										</div>
										<input type="email" id="register_email" name="register_email" class="form-control" id="RegisterInputGroupEmail" placeholder="Correo electrónico">
										</div>
								</div>
							</div>
							<div class="row justify-content-center mt-2" style="height: 10%;">
								<div class="col-md-5" style="text-align: center;">
									<label class="sr-only" for="RegisterInputGroupPassword">Contraseña</label>
										<div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text"><i class="fas fa-key" style="font-size: 13px"></i></div>
										</div>
										<input type="password" id="register_password" name="register_password" class="form-control" id="RegisterInputGroupPassword" placeholder="Contraseña">
										</div>
								</div>
							</div>
							<div class="row justify-content-center mt-2" style="height: 10%">
								<div class="col-md-5" style="text-align: center;">
									<label class="sr-only" for="RegisterInputGroupConfPassword">Confirmar contraseña</label>
										<div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text"><i class="fas fa-key" style="font-size: 13px"></i></div>
										</div>
										<input type="password" id="register_password_confirm" name="register_password_confirm" class="form-control" id="RegisterInputGroupConfPassword" placeholder="Confirmar contraseña">
										</div>
								</div>
							</div>
							<div class="form-check">
								<input type="checkbox" class="form-check-input" id="auto-login" name="auto-login" checked>
								<label class="form-check-label" for="exampleCheck1">Iniciar Sesión Automáticamente</label>
							</div>

							<div class="row justify-content-center mt-2" style="height: 10%">
								<div class="col-md-5" style="text-align: center;">
									<button type="submit"  class="btn btn-primary my-1" style="width: 100%;font-weight: bold;">Registrar</button>
								</div>
							</div>
						</form>
					
					<script>
						$(document).ready(function(){
							$('#register-form').submit(function(e){
								e.preventDefault();
								var auto_login =  $('#auto-login').is(':checked');
								var register_name  = $('#register_name').val();
								var register_email = $('#register_email').val();
								var register_password = $('#register_password').val();
								var register_password_confirm = $('#register_password_confirm').val();
								$.ajax({
									method:'POST',
									url:'<?= site_url('users/register'); ?>',
									dataType:'json',
									
									data:{
										register_name:register_name,
										register_email:register_email,
										register_password:register_password,
										register_password_confirm:register_password_confirm,
										auto_login : auto_login
									},
									
									success: function(data){ 
										if ( data['error'] == true ){
											var text = "";
											$.each(data , function(key,value){
												if (key != 'error' && value != ''){
													text += value;
													text += ' | ';
													$(`#${key}`).css('border','1px solid red');
												}
												else if (value == ''){
													$(`#${key}`).css('border','1px solid #ced4da');
												}
											});
											$('#register-messages').css('display','block');
											$('#register-messages').removeClass('alert-success').addClass('alert-danger');
											$('#register-messages').text( text.substr(0,text.length-3) );
											$('#register_div').css('height','750px');
											setTimeout(function(){
												$('input').css('border','1px solid #ced4da');
												$('#register-messages').fadeOut('slow');
											},5000);
											setTimeout(function(){
												$('#register_div').css('height','620px');
											},5700);
										}
										else{
											$('#register-form input').css('border','1px solid #ced4da');
											$('#register-messages').css('display','block');
											$('#register-messages').removeClass('alert-danger').addClass('alert-success');
											$('#register-messages').text(data['register_success']);
											$('#register_div').css('height','750px');
											if ( 'auto_login' in data ){
												window.location.replace( '<?=$url;?>/dashboard' );
											}
											setTimeout(function(){
												$('input').css('border','1px solid #ced4da');
												$('#register-messages').fadeOut('slow');
											},5000);
											setTimeout(function(){
												$('#register_div').css('height','620px');
											},5700);
										}
										
									},
									error : function(xhr, status, error){
										$('#register-messages').css('display','block');
										$('#register-messages').removeClass('alert-success').addClass('alert-danger');
										$('#register-messages').text('Encontramos un problema');
										$('#register_div').css('height','750px');
										setTimeout(function(){
											$('input').css('border','1px solid #ced4da');
											$('#register-messages').fadeOut('slow');
										},5000);
										setTimeout(function(){
											$('#register_div').css('height','620px');
										},5700);
									}
								});
							}); 
						});
					</script>
				</div>

				
				<div class="row justify-content-center mt-1" style="height: 5%;width: 100%;">
					<div class="col-md-12" style="text-align: center">
						<h4 id="secure" style="margin:auto;color: rgb();color: rgb(195,199,202);font-size: 17px;"> Ya eres miembro ? <span style="color: #0079ca;cursor: pointer;font-weight: bold;" id="switch_log">Entrar</span> </h4>
					</div>
				</div>

				<div class="row justify-content-center" style="height: 5%;width: 100%;margin-top: 40px;">
					<div class="col-md-12" style="text-align: center;">
						<h6 id="secure" style="margin:auto;color: rgb();color: rgb(195,199,202);font-size: 13px;">© 2020 Copyright: Big Brothers Secure login <i class="fas fa-lock" style="font-size: 13px;color: orange"></i> </h6>
					</div>
				</div>
				
			</div>

		</div>
	</div>
</div>

<div id="bc" class="container-fluid" style="background-color: white;position: absolute;top: 0;right:0;height: 0px;width: 0%;z-index: 2;border-bottom-left-radius: 50%">
	<div class="row d-flex" style="height: 100%;">
		<div id="burger_content" class="mr-auto" style="height: 100%;width:100%;border-bottom-left-radius: 50%;float: right;display:none">
			
			<div style="width: 100%;height: 50px;" align="center">
				<img src="<?=base_url('assets/img/logo_paper.png')?>" height="50">
			</div>
			<div style="width: 100%;height: 300px;">
				<ul id="list" class="navbar-nav ml-auto"> 
					<li class="nav-item" > 
						<div class="dropdown">
							<a id="lang" class="nav-link dropdown-toggle text-dark" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: black;font-size: 25px"> 
								<img src="<?= base_url('assets/img/esp.svg');?>" style="height: 20px;width: 20px;"> Español
							</a> 
							<div class="dropdown-menu " aria-labelledby="dropdownMenuLink" > 
								<a class="dropdown-item" id="english_mbl" style="color: black;cursor:pointer;">
									<img src="<?= base_url('assets/img/usa.svg');?>" style="height: 20px;width: 20px"> English
								</a> 
								<a class="dropdown-item" id="french_mbl" style="color: black;cursor:pointer;">
									<img src="<?= base_url('assets/img/Fr.svg');?>" style="height: 20px;width: 20px"> 
									French
								</a> 
								<a class="dropdown-item" id="arabic_mbl" style="color: black;cursor:pointer;">
									<img src="<?= base_url('assets/img/ar.svg');?>" style="height: 20px;width: 20px"> 
									العربية
								</a> 
							</div>
						</div>
					</li> 

					<li class="nav-item" style="border-bottom: 1px solid rgb(244,244,244)"> 
						<a href="<?= site_url()?>" class="nav-link" style="color: black;text-align: center;font-weight: bold;font-size: 25px">
							Pagina de Inicio
						</a>
					</li> 
					<li  class="nav-item" > 
						<a href="#" class="nav-link" style="color: black;text-align: center;font-weight: bold;font-size: 25px;"> 
							<button class="btn btn-success login" style="font-weight: bold;font-size: 25px;width: 90%" >Entrar</button> 
						</a> 
					</li> 
					<li class="nav-item"> 
						<a href="#" class="nav-link" style="text-align: center;font-weight: bold;font-size: 25px;"> 
							<button class="btn btn-dark register" style="font-weight: bold;font-size: 25px;width: 90%">Registrar</button> 
						</a> 
					</li> 
					<li class="nav-item"> 
						<a href="<?= site_url('create-survey')?>" class="nav-link" style="color: black;text-align: center;font-weight: bold;font-size: 25px;"> 
							<button class="btn btn-primary" style="font-weight: bold;font-size: 25px;width: 90%" >Empezar</button> 
						</a> 
					</li> 
				</ul>
			</div>

		</div>
		
	</div>
</div>


	<nav class="navbar navbar-light navbar-expand-md"   role="navigation">

		<a class="navbar-brand" href="<?= site_url()?>" >
			<img src="<?=base_url('assets/img/logo_paper.png')?>" alt="logo" id="logo" width="90" height="60">
			
		</a>



		<button id="burger" style="z-index: 2;" class="navbar-toggler navbar-toggler-right" type="button"  aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<!-- Collapsible content -->
		<div class="collapse navbar-collapse" id="navbarSupportedContent" >

			<ul id="list" class="navbar-nav ml-auto">

				<li class="nav-item" >
					<div class="dropdown">
						<a id="lang" class="nav-link dropdown-toggle text-dark" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
							<img src="<?= base_url('assets/img/esp.svg');?>" style="height: 20px;width: 20px;font-family: 'Helvetica'"> Español
						</a>

						<div class="dropdown-menu " aria-labelledby="dropdownMenuLink" >
						
						<a class="dropdown-item" id="english" style="color: black;cursor:pointer;"><img src="<?= base_url('assets/img/usa.svg');?>" style="height: 20px;width: 20px"> English</a>
						<a class="dropdown-item" id="french" style="color: black;cursor:pointer;"><img src="<?= base_url('assets/img/Fr.svg');?>" style="height: 20px;width: 20px"> French</a>
						<a class="dropdown-item" id="arabic" style="color: black;cursor:pointer;"><img src="<?= base_url('assets/img/ar.svg');?>" style="height: 20px;width: 20px"> العربية</a>
						</div>
					</div>
				</li>
				<li class="nav-item" >
					<a href="<?= site_url()?>" class="nav-link" style="color:black;font-size: 30px;font-weight: bold;" id="home"> Pagina de Inicio </a>
				</li>

				<li class="nav-item" >
					<a href="#" class="nav-link" >
						<button class="btn btn-dark register"  style="font-weight: bold;font-size: 20px" >Registrar</button>  
					</a>
				</li>

				<li id="end_list" class="nav-item">
					<a href="#" class="nav-link" >
						<button class="btn btn-primary login"  style="font-weight: bold;font-size: 20px" >Entrar</button>  
					</a>
				</li>

			</ul>

		</div>

	</nav>


<div class="row justify-content-center" id="main" style="height: 380px;background-image: url('<?=base_url('assets/img/about_wall.jpg');?>');background-size: 100% 100% ">
    <div class="col-md-8 col-xl-5 shadow mt-4 mb-5" style="background-color: white;height: 320px;" id="main_content">
        <div class="row justify-content-center" style="height: 30%;margin-top: 35px">
            <img src="<?=base_url('assets/img/logo_paper.jpg');?>" style="height: 100%">
        </div>
        <div class="row justify-content-center mt-3" style="height: 15%;">
            <h3 style="color: grey" id="title">Online Survey by Big Brothers</h3>
        </div>
        <div class="row justify-content-center" style="height: 30%;padding-left: 10%;padding-right: 10%">
            <p>
			En esta seccián puedes introducir tus datos de contacto. Aseguramos la
			confidencialidad de tus datos personales. En caso de contactarnos, obtendrás una respuesta por
			parte de nuestro equipo en un plazo máximo de 5 días
            </p>
        </div>
    </div>
</div>

<!--Section: Contact v.2-->
<section class="mb-4">

<!--Section heading-->
<h2 class="h1-responsive font-weight-bold text-center my-4">Contacto</h2>
<!--Section description-->
<p class="text-center w-responsive mx-auto mb-5">Si tienes preguntas, no dudes en contactarnos
directamente. Recibirás una respuesta lo antes posible.</p>

<div class="alert" id="messages" style="display:none;text-align:center;">
	<?php if ( $this->session->flashdata('contact_success') ) : ?>
		<script> $('#messages').addClass('alert-success').css('display','block'); </script>
		<?= $this->session->flashdata('contact_success'); ?>
	<?php elseif ( validation_errors() !== '' ) : ?>
		<script> $('#messages').addClass('alert-danger').css('display','block'); </script>
		<?= validation_errors(); ?>
	<?php elseif ($this->session->flashdata('contact_failed') ) : ?>
		<script> $('#messages').addClass('alert-danger').css('display','block'); </script>
		<?= $this->session->flashdata('contact_failed'); ?>
	<?php endif; ?>
</div>

<?= form_open('pages/contact'); ?>
<div class="row justify-content-center" >
	<div class="col-md-8 col-lg-7 col-xl-6"> 
	<!--Grid column-->
    <div class="col-md-9 mb-md-0 mb-5" style="margin-left:5px;padding-top:5px;height:350px;">
            <!--Grid row-->
            <div class="row">

                <!--Grid column-->
                <div class="col-md-6">
                    <div class="md-form mb-0">
                        <input type="text" id="name" name="name" class="form-control">
                        <label for="name" class="">Nombre</label>
                    </div>
                </div>
                <!--Grid column-->

                <!--Grid column-->
                <div class="col-md-6">
                    <div class="md-form mb-0">
                        <input type="text" id="email" name="email" class="form-control">
                        <label for="email" class="">Correo electrónico</label>
                    </div>
                </div>
                <!--Grid column-->

            </div>
            <!--Grid row-->

            <!--Grid row-->
            <div class="row">
                <div class="col-md-12">
                    <div class="md-form mb-0">
                        <input type="text" id="subject" name="subject" class="form-control">
                        <label for="subject" class="">Tema</label>
                    </div>
                </div>
            </div>
            <!--Grid row-->

            <!--Grid row-->
            <div class="row">

                <!--Grid column-->
                <div class="col-md-12">

                    <div class="md-form">
                        <textarea style="resize: none;" type="text" id="message" name="message" rows="3" class="form-control md-textarea"></textarea>
                        <label for="message">Tu Mensaje</label>
                    </div>

                </div>
            </div>
            <!--Grid row-->

        <div class="text-center text-md-left">
            <button type="submit" class="btn btn-primary btn-block" style="color:white">Enviar</button>
		</div>

        <div class="status"></div>
    </div>
    <!--Grid column-->
</div>
<?= form_close();?>

    <!--Grid column-->
    <div class="col-md-2 text-center">
        <ul class="list-unstyled mb-0">
            <li><i class="fas fa-map-marker-alt fa-2x"></i>
                <p>Casablanca, MA 94126, Maroc</p>
            </li>

            <li><i class="fas fa-phone mt-4 fa-2x"></i>
                <p>+212 5 22 57 89 56</p>
            </li>

            <li><i class="fas fa-envelope mt-4 fa-2x"></i>
                <p>contact@onlineSurvey.com</p>
            </li>
        </ul>
    </div>
    <!--Grid column-->

</div>

</section>
<!--Section: Contact v.2-->




    <!-- Footer -->
<footer class="page-footer font-small cyan darken-3 " style="background-image: url('<?=base_url('assets/img/footer.png');?>')";>

    <!-- Footer Elements -->
    <div class="container"  >

    <!-- Grid row-->
    <div class="row">

        <!-- Grid column -->
        <div class="col-md-12 py-5">
        <div class="mb-5 flex-center" style="color: white">

     	<!-- Twitter -->
			<a href="https://twitter.com/OnlineSurvey7" target="_blank" class="tw-ic ic">
			<i class="fab fa-twitter fa-lg white-text mr-md-5 mr-3 fa-2x"> </i>
			</a>
			<!--Linkedin -->
			<a href="https://www.linkedin.com/in/online-survey-827b161b0/" target="_blank" class="li-ic ic">
			<i class="fab fa-linkedin-in fa-lg white-text mr-md-5 mr-3 fa-2x"> </i>
			</a>
			<!--Instagram-->
			<a href="https://www.instagram.com/online_surveys/" target="_blank" class="ins-ic ic">
			<i class="fab fa-instagram fa-lg white-text mr-md-5 mr-3 fa-2x"> </i>
			</a>
            
            

        </div>
        <!-- Grid column -->

    </div>
    <!-- Grid row-->

    </div>
    <!-- Footer Elements -->

    <!-- Copyright -->
    <div class="footer-copyright text-center py-3" style="background-color: #5aba4c;color: white">© 2020 Copyright:
    <a href="#"> Big Brothers</a>
    </div>
    <!-- Copyright -->

</footer>
<!-- Footer -->

<script> 
	$(document).ready(function(){
		$('#english').click(function(e){
			e.preventDefault();
			$('#eng').submit();
		});
		$('#english_mbl').click(function(e){
			e.preventDefault();
			$('#eng').submit();
		});
		$('#french').click(function(e){
			e.preventDefault();
			$('#fr').submit();
		});
		$('#french_mbl').click(function(e){
			e.preventDefault();
			$('#fr').submit();
		});
		$('#arabic').click(function(e){
			e.preventDefault();
			$('#ar').submit();
		});
		$('#arabic_mbl').click(function(e){
			e.preventDefault();
			$('#ar').submit();
		});
	});
</script> 