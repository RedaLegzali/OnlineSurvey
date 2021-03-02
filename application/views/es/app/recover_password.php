

<style>
        body{
            height: 100%;width: 100%;
        }
        .load{position:absolute;top:50%;left:50%;transform:translate(-50%, -50%);
        /*change these sizes to fit into your project*/
        width:100px;
        height:100px;
        }
        .load hr{border:0;margin:0;width:40%;height:40%;position:absolute;border-radius:50%;animation:spin 2s ease infinite}

        .load :first-child{background:#19A68C;animation-delay:-1.5s}
        .load :nth-child(2){background:#F63D3A;animation-delay:-1s}
        .load :nth-child(3){background:#FDA543;animation-delay:-0.5s}
        .load :last-child{background:#193B48}

        @keyframes spin{
        0%,100%{transform:translate(0)}
        25%{transform:translate(160%)}
        50%{transform:translate(160%, 160%)}
        75%{transform:translate(0, 160%)}
        }

        @media only screen and (max-height: 600px) {
          #container{
            top: 8% !important;
          }
       }
       @media only screen and (max-height: 492px) {
          #container{
            top: 3% !important;
          }
       }

       @media only screen and (max-width: 387px) {
          #title{
            font-size: 35px;
          }
       }

       
        
    </style>
    
	<div style="background-color: white;position: absolute;z-index:2;width: 100%;height: 100%;opacity: 0.7;position: fixed;" id="load">
		<div class="load" >
		  <hr/><hr/><hr/><hr/>
		 </div>
		 <h1 style="position: absolute;top: 60%;left: 43.5%; font-family:'Helvetica Neue'; ">Online Survey</h1>
	</div>


    <div class="container-fluid" style="background-image: url('<?= base_url('assets/img/form_background.jpg');?>');height: 100vh;">
        <div class="row justify-content-center " id="container" style="height: 450px;position: relative;top: 25%;" >
            <div class="col-md-9 col-lg-7 col-xl-5 shadow" style="height: 100%;background-color: white;">
                <div class="row justify-content-center" style="height: 75px;">
                    <img src="<?= base_url('assets/img/logo_paper.png');?>" style="height: 75px;width: 100px;">
                </div>
                <div class="row justify-content-center" style="height: 50px;">
                    <h1 id="title">Restablecer la Contaseña <i class="fas fa-key" style="color: orange;"></i></h1>
                </div>

                <div class="row  justify-content-center mt-3" style="height: 10%;">
                  <div class="col-12 " style="text-align: center;">
                        <div id="messages" style="display:none" class="alert alert-danger" role="alert">
                            <?php
                                if ( validation_errors() != false ){
                                    echo "<script> $('#messages').css('display','block').removeClass('alert-success').addClass('alert-danger'); </script>";
                                    $errors = strip_tags( validation_errors() );
                                    $errors = str_replace( '.' , ' | ' , $errors );
                                    echo substr($errors,0,-4);
                                }
                                if ( $this->session->flashdata('error') ){
                                    echo "<script> $('#messages').css('display','block').removeClass('alert-success').addClass('alert-danger'); </script>";
                                    echo $this->session->flashdata('error');
                                }
                                if ( $this->session->flashdata('success-error') ){
                                    echo "<script> $('#messages').css('display','block').removeClass('alert-success').addClass('alert-danger'); </script>";
                                    echo $this->session->flashdata('success-error');
                                }
                                if ( $this->session->flashdata('success') ){
                                    echo "<script> $('#messages').css('display','block').removeClass('alert-danger').addClass('alert-success'); </script>";
                                    echo $this->session->flashdata('success');
                                    redirect(site_url());
                                }
                            ?>
                        </div>
                  </div>
                </div>
                <?= form_open( 'users/reset_password_confirm/'.$token ); ?>

                    <div class="row justify-content-center mt-3" style="height: 40px;">
                        <div class="col-md-8 col-lg-8 col-xl-6  " style="text-align: center;max-width: 500px;min-width: 350px;">
                            <label class="sr-only" for="inlineFormInputGroupPassword">Correo Electrónico</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <div class="input-group-text">@</div>
                                </div>
                                <input id="email" name="email" type="email" class="form-control" id="inlineFormInputGroupPassword" placeholder="Correo Electrónico">
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center mt-3" style="height: 40px;">
                        <div class="col-md-8 col-lg-8 col-xl-6  " style="text-align: center;max-width: 500px;min-width: 350px;">
                            <label class="sr-only" for="inlineFormInputGroupPassword">Contraseña</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-key" style="font-size: 13px"></i></div>
                                </div>
                                <input id="password" name="password" type="password" class="form-control" id="inlineFormInputGroupPassword" placeholder="Nueva Contraseña">
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center mt-3" style="height: 40px;">
                        <div class="col-md-8 col-lg-8 col-xl-6  " style="text-align: center;max-width: 500px;min-width: 350px;">
                            <label class="sr-only" for="inlineFormInputGroupPassword">Confirma Nueva Contraseña</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-key" style="font-size: 13px"></i></div>
                                </div>
                                <input id="password_confirm" name="password_confirm" type="password" class="form-control" id="inlineFormInputGroupPassword" placeholder="Confirma Nueva Contraseña">
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center mt-3" style="height: 40px;">
                        <div class="col-md-8 col-lg-8 col-xl-6  " style="text-align: center;max-width: 500px;min-width: 350px;min-width: 350px;">
                            <button type="submit" class="btn btn-primary my-1" style="width: 100%;font-weight: bold;">Recuperar</button>
                        </div>
                    </div>
                <?= form_close(); ?>

                <div class="row justify-content-center" style="height: 5%;width: 100%;margin-top: 17px;">
					<div class="col-md-12" style="text-align: center;">
						<h6 id="secure" style="margin:auto;color: rgb();color: rgb(195,199,202);font-size: 13px;">© 2020 Copyright: Big Brothers Secure login <i class="fas fa-lock" style="font-size: 13px;color: orange"></i> </h6>
					</div>
				</div>

            </div>
        </div>
    </div>

    <script> 
        $( document ).ready(function() {
            $("#load").fadeOut(800);
        });
    </script>

