

<script> var id = false; </script>

<style>
    body{
        width: 100%;
        box-sizing: border-box;
        background-color: rgb(244,244,244);
        overflow-x: hidden;
    }
</style>


<div style="background-color: white;position: absolute;z-index:2;width: 100%;height: 100%;opacity: 0.7;" id="load">
        <div class="load">
          <hr/><hr/><hr/><hr/>
         </div>
         <h1 style="position: absolute;top: 60%;left: 43.5%; font-family:'Helvetica Neue'; ">Online Survey</h1>
    </div>

    <div class="container-fluid" style="background-color: black;position: absolute;width: 100%;height: 100%;background-color: rgba(50,50,50,0.8);z-index: 3;position: fixed;display: none;" id="send_form">
        <div class="row " style="height: 100%;">
            <div class="col-md-8 col-lg-8 col-xl-5 mx-auto" style="height: 400px;background-image: url('<?= base_url('assets/img/send.gif');?>'),url('<?= base_url('assets/img/send2.gif');?>');background-repeat: no-repeat;background-size: 10% 50%,10% 50%;background-position:bottom left, bottom right;background-color: white;margin-top:30vh" id="fofo">
                <div class="row justify-content-end " style="height: 17%;font-family: 'Helvetica Neue';" id="subitle_container">

                <div class="col-12 col-md-12" style="text-align: center;z-index: 5">
                        <button type="button" class="close" aria-label="Close" style="float: right;font-size: 30px" id="close_form">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <br>
                        <h1 id="subitle"> Envoyer Sondage </h1>
                    </div>
                </div>
                <div class="alert alert-danger" id="email-messages" style="display:none;margin:0px;text-align:center;">
                    
                </div>
                <div class="row justify-content-center" style="height: 68%;z-index: 0;" id="imgT">
                    <div class="col-md-12 mt-3" style="text-align: center;" align="center">
                        <form id="email-form"> 
                            <div class="row justify-content-center" style="height: 10%;">
                                <div class="col-8 col-md-7 col-lg-6 col-xl-7" style="text-align: center;" >
                                    <label class="sr-only" for="inlineFormInputGroupUsername">send</label>
                                        <div class="row justify-content-center" style="height:50px;"> 
                                                <div style="width:400px;background-color:white;display:flex;justify-content:space-around;" class=form-inline >
                                                    <input style="width:70%;" type="text" class="form-control" id="link">
                                                    <button style="width:30%;" id="copy-btn" class="btn btn-primary" type="button" onclick="copyFunction()">Copier Lien</button>
                                                </div>
                                        </div>
                                        <p style="margin-top:5px;"> OU</p>

                                      <div class="input-group" style="margin-top: 20px;">
                                        <div class="input-group-prepend" style="width: 100%" >
                                          <div class="input-group-text justify-content-center" style="background-color: #0079ca;width: 100%;text-align: center;">
                                            <i class="fas fa-paper-plane" style="font-size: 13px;color: white;"></i>
                                          </div>
                                        </div>
                                        <input type="text"  id="emails" data-role="tagsinput"   placeholder="               envoyer à" >
                                      </div>
                                </div>
                            </div>

                            <div class="row justify-content-center mt-4" style="height: 10%;" id="subsurv">
                                <div class="col-md-7 col-lg-6 col-xl-7" style="text-align: center;">
                                      <input type="submit" class="btn btn-success" id='btn-send' value="Envoyer" style="margin-bottom:10px;font-size: 20px;font-weight: bold;">
                                </div>
                            </div>
                        </form> 
                        <script>
                            $(document).ready(function(){
                                $('#email-form').submit(function(e){
                                    e.preventDefault();
                                    var emails = $('#emails').val();
                                    $('#btn-send').val('Envoi..');
                                    $('#btn-send').prop('disabled' , true);
                                    $.ajax({
										method:'POST',
										url:'<?= site_url('surveys/share_form');?>',
										dataType:'json',
										data:{
											emails:emails,
											id:id
                                        },
                                        success: function(data){
                                            if ( data['empty'] ){
                                                $('#email-messages').css('display','block');
											    $('#email-messages').removeClass('alert-success').addClass('alert-danger');
                                                $('#email-messages').text( 'Veuillez entrer quelques emails' );
                                                $('#btn-send').prop('disabled' , false);
                                                $('#btn-send').val('Envoyer');
                                            }
                                            else if ( data['error'] ){
                                                $('#email-messages').css('display','block');
											    $('#email-messages').removeClass('alert-success').addClass('alert-danger');
                                                $('#email-messages').text( 'Invalid Emails : ' + data['emails'] );
                                                $('#btn-send').prop('disabled' , false);
                                                $('#btn-send').val('Envoyer');
                                            }
                                            else if ( data['email-failed'] ){
                                                $('#email-messages').css('display','block');
											    $('#email-messages').removeClass('alert-success').addClass('alert-danger');
                                                $('#email-messages').text( data['email-failed']  );
                                                $('btn-send').prop('disabled' , false);
                                                $('#btn-send').val('Envoyer');
                                            }
                                            else if ( data['email-success'] ){
                                                $('#email-messages').css('display','block');
											    $('#email-messages').removeClass('alert-danger').addClass('alert-success');
                                                $('#email-messages').text( data['email-success'] );
                                                $('#btn-send').prop('disabled' , false);
                                                $('#btn-send').val('Envoyer');
                                            }
                                            setTimeout(function(){
												$('#email-messages').fadeOut('slow');
											},5000);
                                        },
                                        error:function(xhr, status, error){
                                            $('#email-messages').css('display','block');
											$('#email-messages').removeClass('alert-success').addClass('alert-danger');
                                            $('#email-messages').text('Nous avons rencontré un problème');
                                            $('#btn-send').prop('disabled' , false);
                                            $('#btn-send').val('Envoyer');
											setTimeout(function(){
												$('#email-messages').fadeOut('slow');
											},5000);
                                        }
                                    });
                                });
                            });
                        </script>
                    </div>
                </div>

                <div class="row justify-content-center" id="secinfo" style="height:2%;">
                    <div class="col-md-12" style="text-align: center;">
                        <h6 id="secure" style="position:absolute;bottom:0;left:0;right:0;margin-left:auto;margin-right:auto;color: rgb();color: rgb(195,199,202);font-size: 13px;">© 2020 Copyright: Big Brothers  </h6>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="container-fluid" id="edit_pp" style="background-color: black;position: absolute;width: 100%;height: 100%;background-color: rgba(50,50,50,0.8);z-index: 3;position: fixed;display: none">
        <div class="row " style="height: 100%;">
            <div class="col-md-8 col-lg-8 col-xl-5 mx-auto" style="height: 300px;background-image: url('<?= base_url('assets/img/send.gif');?>'),url('<?= base_url('assets/img/send2.gif');?>');background-repeat: no-repeat;background-size: 10% 50%,10% 50%;background-position:bottom left, bottom right;background-color: white;margin-top:30vh" id="fofo">
                <div class="row justify-content-end " style="height: 17%;font-family: 'Helvetica Neue';" >

                    <div class="col-12 col-md-12" style="text-align: center;z-index: 5;">
                        <button type="button" class="close" aria-label="Close" style="float: right;font-size: 30px" id="close_edit">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <br>
                        <h1> Photo de Profile </h1>

                    </div>
                </div>

                <div class="row justify-content-center" style="height: 68%;z-index: 0" >
                    <input type="image" src="<?= base_url('assets/img/uploads/users/').$user_img;?>" id="proj_img" class="shadow" height="100"  style="background-color: rgb(244,244,244);border-radius: 100%;width: 100px;margin-top: 65px;"/>
                    <form id="sub-img" method="post" enctype="multipart/form-data">
                        <input type="file" name="userfile" id="my_file" style="display: none;" />
                    </form>
                    <script> 
                        $(document).ready(function(){
                            $('#my_file').change(function(){
                                //e.preventDefault();
                                let d = new FormData( $('#sub-img')[0]  );
                                //console.log(d);
                                $.ajax({
                                    url:'<?= site_url('users/upload_image'); ?>' ,
                                    method:'POST',  
                                    data:d,
                                    contentType:false,
                                    cache:false,
                                    processData:false,
                                    success:function(data){
                                        let img = $.parseJSON(data);
                                        if ( img['file_name'] !== undefined ){
                                            $('#proj_img').attr('src' , `<?= base_url('assets/img/uploads/users/'); ?>${img['file_name']}` );
                                            $('#logo_perso').attr('src' , `<?= base_url('assets/img/uploads/users/'); ?>${img['file_name']}` );
                                        }
                                    },
                                    error:function(xhr,status,error){
                                        console.log(xhr);
                                        console.log(status);
                                        console.log(error);
                                    }
                                });
                            });
                        });
                    </script>
                </div>

                <div class="row justify-content-center mt-1" id="secinfo" style="height: 10%;">
                    <div class="col-md-12" style="text-align: center;">
                        <h6 id="secure" style="margin:auto;color: rgb();color: rgb(195,199,202);font-size: 13px;"> Cliquez pour modifier  </h6>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <header style="background-color: white;">
        <nav class="navbar navbar-light ">
             <a class="navbar-brand" href="<?= site_url('/dashboard');?>" id="brand">
                <img src="<?= base_url('assets/img/logo_paper.png');?>" alt="logo" id="logo" width="90" height="60">
                
            </a>
            
            <ul id="settings" style="list-style: none;">
                <li style="float: left;">
                    <img src="<?= base_url('assets/img/uploads/users/').$user_img;?>" alt="logo" id="logo_perso" width="60" height="60" style="cursor:pointer;border-radius: 50%;object-fit: cover;float: right;margin-top: 10px">
                </li>
                <li style="float: left;">
                    <div class="dropdown " >
                        <a  href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="text-decoration: none;color: black">
                            <span style="font-size: 50px;">&#8942;</span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink" style="width: 10px !important" >
                            <a class="dropdown-item" href="<?= site_url('create-survey');?>" style="color: black"><i class="fas fa-plus" style="color: #0079ca"></i> Nouveau</a>
                            <a class="dropdown-item" href="<?= site_url('/upgrade');?>" style="color: black"><i class="fas fa-gem" style="color: orange"></i> Améliorer</a>
                            <a class="dropdown-item" href="<?= site_url('/users/settings') ;?>" style="color: black;"><i class="fas fa-cog" style="color: rgb(104,104,104);"></i> Paramètres</a>
                            <?= form_open('users/logout'); ?>
                                <button type="submit" class="dropdown-item" style="color: black;cursor:pointer;"><i class="fas fa-sign-out-alt" style="color: rgb(104,104,104);cursor:pointer;" ></i> Déconnexion</button>
                            <?= form_close(); ?>
                        </div>
                    </div>
                </li>
            </ul>
            <style>
                .dropdown-menu-right {
                    right: 0 !important;
                    left: auto !important;
                }
            </style>
        </nav>
    </header>

    <a href="<?= site_url('/create-survey');?>">
        <button style="left:43% !important;" id="new_form" class="btn btn-primary" > Nouveau Sondage + </button>
    </a>

    <div class="container-fluid">
        <div class="row" style="height: 350px;background-image: url('<?= base_url('assets/img/form_background.jpg');?>');">
            <h2 style="color: #f4f4f4; font-family: 'Open Sans', sans-serif; font-size: 50px; margin-left:auto;margin-right:auto;margin-top:10px;"> 
                Bienvenue <?= ucfirst($this->session->userdata('user_name'));?> 
            </h2>
        </div>
    </div>
    <div class="container-fluid" style="padding: 0px;" >
        <div style="display:none;width:100%;height:100%;text-align:center;margin:0px;" id="messages" class="alert alert-success">
            <?php if( $this->session->flashdata('delete-success') ): ?>
                <script> 
                    $('#messages').css('display','block'); 
                    $('#messages').removeClass('alert-danger').addClass('alert-success');
                </script>
                <?= $this->session->flashdata('delete-success'); ?>
            <?php endif; ?>
            <?php if( $this->session->flashdata('create-success') ): ?>
                <script> 
                    $('#messages').css('display','block'); 
                    $('#messages').removeClass('alert-danger').addClass('alert-success');
                </script>
                <?= $this->session->flashdata('create-success'); ?>
            <?php endif; ?>
            <?php if ( $this->session->flashdata('username_update') ): ?>
                <script> 
                    $('#messages').css('display','block'); 
                    $('#messages').removeClass('alert-danger').addClass('alert-success');
                </script>
                <?= $this->session->flashdata('username_update'); ?>
            <?php endif; ?>
            <script> 
                setTimeout(function(){
                    $('#messages').fadeOut('slow');
                },5000);
            </script>
        </div>
        <div class="row justify-content-center " id="cards_here" style="height: 500px;background-color: rgb(244,244,244);">
                <!-- Loop -->
                <?php $cpt=1;?>
                <?php foreach( $question_forms as $question_form ): ?>
                    <div class="col-md-7 col-lg-5 col-xl-4   mr-lg-0 mr-xl-5 mt-5 mr-0" id="card2" style="max-width: 450px" >
                        <div class="card-container">
                            <div class="card">
                                <div class="front">
                                    <div class="cover">
                                        <?php if( $cpt == 1 ): ?>
                                            <img src="<?= base_url('assets/img/personal.png');?>" >
                                            <?php $cpt=2;?>
                                        <?php elseif( $cpt == 2 ): ?>
                                            <img src="<?= base_url('assets/img/dark.jpg');?>" >
                                            <?php $cpt=3;?>
                                        <?php else:?>
                                            <img src="<?= base_url('assets/img/form_background2.jpg');?>" >
                                            <?php $cpt=1;?>
                                        <?php endif;?>
                                    </div>
                                    <div class="user">
                                        <span class="test-badge" id="notif" style="font-size: 15px;width: 5px;padding-right: 18px;padding-left: 11px;padding-top: 2px;padding-bottom: 3px;background-color: red;border-radius: 50%;color: white;position: absolute;right: -12px;top: -12px;font-weight: bold;"> 
                                            <?= $question_form['notifications'] ;?>
                                        </span>
                                        <?php if( $question_form['survey_img'] == 'noimage.png'): ?>
                                            <img class="img-circle" src="<?= base_url('assets/img/uploads/surveys/form_image.png');?>" style="height: 100%;width: 100%" />
                                        <?php else: ?>
                                            <img class="img-circle" src="<?= base_url('assets/img/uploads/surveys/').$question_form['survey_img'] ;?>" style="height: 100%;width: 100%" />
                                        <?php endif; ?>
                                    </div>
                                    <div class="content">
                                        <div class="main">
                                            <h3 class="name"> <?= $question_form['title'] ;?> </h3>
                                            <p class="profession"></p>
                                            <p class="text-center"><?= 'Créer le : ' . $question_form['created_at'] ;?></p>
                                        </div>
                                        <div class="footer">
                                            <i class="fa fa-mail-forward"></i> Plus d'infos
                                        </div>
                                    </div>
                                </div> 
                                <div class="back">
                                    <div class="header">
                                        <h5 class="motto">Vous avez <?= $question_form['notifications'] ;?> nouvelles réponses !</h5>
                                    </div>
                                    <div class="content">
                                        <div class="main">

                                            <div class="stats-container" style="top: 25px !important;position: relative;">
                                                <div class="stats">
                                                    <h2><a href="<?= site_url('view-survey/').$question_form['id'];?>" ><i class="far fa-chart-bar" style="color:blue;cursor: pointer;"></i></a></h2>
                                                    <p>
                                                        Voir
                                                    </p>
                                                </div>
                                                <div class="stats">
                                                    <form id="<?= $question_form['id'];?>">
                                                        <button type='input' id="btn-send" style="outline:none;border:none;background:none;">
                                                            <h2><i class="fas fa-paper-plane send_surv" style="color:green;cursor: pointer;"></i></h2>
                                                                Partager
                                                        </button>
                                                    </form>
                                                    <script> 
                                                        $(document).ready(function(){
                                                            $('#<?= $question_form['id'];?>').submit(function(e){
                                                                e.preventDefault();
                                                                id = <?= $question_form['id']; ?>;
                                                                uuid = '<?= $question_form['uuid']; ?>';
                                                                $('#link').val(`<?=$url;?>/answer-survey/${uuid}`);
                                                            });
                                                        });
                                                    </script>
                                                </div>
                                                <div class="stats">
                                                    <?= form_open('surveys/delete_question_form'); ?>
                                                    <input type="hidden" name="id" value="<?= $question_form['id'];?>">
                                                    <button type="submit" style="outline:none;border:none;background:none;">
                                                        <h2><i class="fas fa-times" style="color:red;cursor: pointer;"></i></h2>
                                                        Supprimer
                                                    </button>
                                                    <?= form_close(); ?>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="footer">
                                        <div class="social-links text-center">
                                            <h6> © 2020 Copyright: Big Brothers</h6>
                                        
                                        </div>
                                    </div>
                                </div> 
                            </div> 
                        </div> 
                    </div>
                <?php endforeach; ?>
                <!-- End of Loop -->
        </div> 
    </div>
 

<script type="text/javascript" src="<?= base_url('assets/js/tagsinput.js');?>"></script>


