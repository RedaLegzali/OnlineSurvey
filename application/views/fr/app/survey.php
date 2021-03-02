

<style>
    body{
        background-color: rgb(244,244,244);
        min-height: 500px;
    }
</style>

<script> var data_form = {}; var del_form = false; var del_user = false; </script>


<div class="container-fluid" style="background-color: black;position: absolute;width: 100%;height: 100%;background-color: rgba(50,50,50,0.8);z-index: 3;position: fixed;display: none;" id="theme_form">
    <div class="row " style="height: 100%;">
        <div class="col-md-6 mx-auto my-auto" style="height: 50%;background-image: url('<?= base_url('assets/img/abstract2.jpg');?>');background-size: 100%" id="fofo">
            <div class="row " style="height: 17%;font-family: 'Helvetica Neue';">

                <div class="col-md-12" style="text-align: center;z-index: 5">
                    <button type="button" class="close" aria-label="Close" style="float: right;font-size: 30px;color: white" id="close_form">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <br>
                    <h1 style="color: white" id="theme_title">Selectionnez votre thème</h1>

                </div>
            </div>

            <div class="row mt-3" style="height: 70%;z-index: 0" id="imgT">
                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel" style="width: 100%" align="center">
                    <div class="carousel-inner">
                    
                    <div class="carousel-item active">
                            <div class="card" style="width: 18rem;">
                            <img class="card-img-top" src="<?= base_url('assets/img/dark.jpg');?>" alt="Card image cap" height="170" >
                            <div class="card-body">
                            <button class="btn btn-dark" id="dark_theme">
                                Dark theme
                            </button>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="card" style="width: 18rem;">
                            <img class="card-img-top" src="<?= base_url('assets/img/form_background.jpg');?>" alt="Card image cap" height="170" >
                            <div class="card-body">
                            <button class="btn btn-primary" id="light_theme" disabled>
                                Light Theme
                            </button>
                            </div>
                        </div>
                    </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Précédent</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Suivant</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Begin Register Div -->
<div class="container-fluid" style="background-color: black;position: absolute;width: 100%;height: 100%;background-color: rgba(50,50,50,0.8);z-index: 3;position: fixed;display: none;" id="login_form">
    <div class="row " style="height: 100%;">
        <div class="col-md-8 col-lg-8 col-xl-6 mx-auto" style="height: 650px;background-image: url('<?= base_url('assets/img/send.gif');?>'),url('<?= base_url('assets/img/send2.gif');?>');background-repeat: no-repeat;background-size: 15% 50%,15% 50%;background-position:bottom left, bottom right;background-color: white;margin-top:20vh" id="fofo">
            <div class="row justify-content-end " style="height: 17%;font-family: 'Helvetica Neue';" id="subitle_container">

                <div class="col-12 col-md-12" style="text-align: center;z-index: 5">
                    <button type="button" class="close" aria-label="Close" style="float: right;font-size: 30px" id="close_form">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <br>
                    <?php if ( $this->session->userdata('logged_in') ): ?>
                        <h1 id="subitle">Envoyez</h1>
                        <style>  
                        #fofo{
                            height: 450px !important;
                            max-width: 750px;
                            margin-top: 32vh !important;
                            }
                        </style>
                    <?php else: ?>
                        <h1 id="subitle">S'enregistrer et Envoyer</h1>
                    <?php endif; ?>
                </div>
            </div>
            <div class="alert alert-danger" id="email-messages" style="display:none;text-align:center;margin-bottom:0px">
            </div>

            <div class="row justify-content-center" style="height: 73%;z-index: 0;" id="imgT">
                <div class="col-md-12 " style="text-align: center;" align="center">
                    <form id="email-form">
                        <?php if (! $this->session->userdata('logged_in') ): ?>
                            <div class="row  justify-content-center mt-3" style="height: 10%;">
                                <div class="col-8 col-md-7 col-lg-6 col-xl-7 " style="text-align: center;">
                                    <label class="sr-only">Nom d'utilisateur</label>
                                        <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"s><i class="fas fa-user" style="font-size: 13px"></i></div>
                                        </div>
                                        <input type="text" class="form-control" id="register_name" placeholder="Nom d'utilisateur">
                                        </div>
                                </div>
                            </div>

                            <div class="row  justify-content-center mt-4" style="height: 10%;">
                                <div class="col-8 col-md-7 col-lg-6 col-xl-7" style="text-align: center;">
                                    <label class="sr-only">Email</label>
                                        <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"s>@</div>
                                        </div>
                                        <input type="text" class="form-control" id="register_email" placeholder="Email">
                                        </div>
                                </div>
                            </div>

                            <div class="row justify-content-center mt-4" style="height: 10%;">
                                <div class="col-8 col-md-7 col-lg-6 col-xl-7" style="text-align: center;">
                                    <label class="sr-only">Mot de Passe</label>
                                        <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-key" style="font-size: 13px"></i></div>
                                        </div>
                                        <input type="password" class="form-control" id="register_password" placeholder="Mot de Passe">
                                        </div>
                                </div>
                            </div>
                            <div class="row justify-content-center mt-4" style="height: 10%;">
                                <div class="col-8 col-md-7 col-lg-6 col-xl-7" style="text-align: center;">
                                    <label class="sr-only">Confirmation de Mot de Passe</label>
                                        <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fas fa-key" style="font-size: 13px"></i></div>
                                        </div>
                                        <input type="password" class="form-control" id="register_password_confirm" placeholder="Confirmation de Mot de Passe" style="overflow-y:scroll;">
                                        </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="row justify-content-center mt-4" style="height: 10%;">
                            <div class="col-8 col-md-7 col-lg-6 col-xl-7" style="text-align: center;" >
                                <label class="sr-only" for="inlineFormInputGroupUsername">send</label>
                                <?php if ( $this->session->userdata('logged_in') ): ?>
                                    <div class="row justify-content-center" style="height:50px;"> 
                                            <div style="width:400px;background-color:white;display:flex;justify-content:space-around;" class=form-inline >
                                                <input style="width:70%;" type="text" class="form-control" id="link">
                                                <button style="width:30%;" id="copy-btn" class="btn btn-primary" type="button" onclick="copyFunction()">Copier Lien</button>
                                            </div>
                                    </div>
                                    <p style="margin-top:5px;"> OU</p>
                                <?php endif; ?>
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
                </div>
            </div>

            <div class="row justify-content-center mt-3" id="secinfo" style="height: 10%;">
                <div class="col-md-12" style="text-align: center;">
                    <h6 id="secure" style="margin:auto;color: rgb();color: rgb(195,199,202);font-size: 13px; margin-top: -55px;">© 2020 Copyright: Big Brothers Secure login <i class="fas fa-lock" style="font-size: 13px;color: orange"></i> </h6>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- End Register Div -->

<header>
    <nav class="navbar navbar-light " style="background-color: white">
        <a class="navbar-brand" href="<?= site_url();?>" id="brand">
            <img src="<?= base_url('assets/img/logo_paper.png');?>" alt="logo" id="logo" width="90" height="60">
            
        </a>
        <?php if ( $this->session->userdata('logged_in') ): ?>
            <ul id="settings" style="list-style: none;">

                <li style="float: left;"><img src="<?= base_url('assets/img/uploads/users/').$user_img;?>" alt="logo_perso" id="logo" width="60" height="60" style="border-radius: 50%;object-fit: cover;float: right;margin-top: 10px"></li>
                <li style="float: left;">
                <div class="dropdown "  >
                    <a  href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="text-decoration: none;color: black">
                        <span style="font-size: 50px;">&#8942;</span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right"  aria-labelledby="dropdownMenuLink" style="width: 10px !important;" >
                    <a class="dropdown-item" href="<?= site_url();?>" style="color: black"><i class="fas fa-home" style="color: #0079ca"></i> Accueil</a>
                    <a class="dropdown-item" href="<?= site_url('/upgrade');?>" style="color: black"><i class="fas fa-gem" style="color: orange"></i> Améliorer</a>
                    <a class="dropdown-item" href="<?= site_url('users/settings');?>" style="color: black;"><i class="fas fa-cog" style="color: rgb(104,104,104);"></i> Paramètres</a>
                    <?= form_open('users/logout'); ?>
                        <button type="submit" class="dropdown-item" style="color: black;cursor:pointer;"><i class="fas fa-sign-out-alt" style="color: rgb(104,104,104);cursor:pointer;margin-left:-17px;" ></i> Déconnexion</button>
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
        <?php endif; ?>
    </nav>
</header>

<div class="container-fluid" id="main" style="background-image: url('<?= base_url('assets/img/form_background.jpg');?>');">
    <div class="row justify-content-center mainR" style="height: 42.5vh;min-height: 150px">
        <div class="col-md-4" style="height: 100%" align="center"> 
            <input type="image" src="<?= base_url('assets/img/uploads/surveys/noimage.png');?>" id="proj_img" class="shadow" height="100"  style="background-color: rgb(244,244,244);margin-top: 15vh;cursor: pointer;border-radius: 100%;width: 100px"/>
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
                            url:'<?= site_url('surveys/upload_image'); ?>' ,
                            method:'POST',  
                            data:d,
                            contentType:false,
                            cache:false,
                            processData:false,
                            success:function(data){
                                let img = $.parseJSON(data);
                                $('#proj_img').attr('src' , `<?= base_url('assets/img/uploads/surveys/'); ?>${img['file_name']}` );
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
        <div class="col-md-4" style="height: 100%" align="center" id="test">

            <div class="group" style="margin-top: 18vh;" >
                <input type="text" id="title_input" class="shadow" maxlength="30" required> <!-- Title Input -->
                <span class="highlight"></span>
                <span class="bar"></span>
                <label id="title_label">Titre de Sondage</label>
            </div>
            
        </div>
        <div class="col-md-4" style="height: 100%;" align="center" id="test2">
            <img src="<?= base_url('assets/img/survTheme.png');?>" class="shadow" height="100" width="100" style="background-color: rgb(244,244,244);border-radius: 100%;margin-top: 15vh;cursor: pointer;" id="theme">
        </div>
    </div>
</div>

<div id="container_add" style="position: fixed;z-index: 2">
    <input type="checkbox" id="menu-toggle"/>
    <label for="menu-toggle" id="add_label">
        <i class="fas fa-plus" id="open"></i>
    </label>
    <ul id="menu" style="top:20px;">
        <li><a href="#bottom" id="MCQ" class="Q"><i class="far fa-dot-circle" style="color: #007bff"></i> QCM</a></li>
        <li><a href="#bottom" id="CXQ" class="Q"><i class="far fa-check-square" style="color: #007bff"></i> Checkbox</a></li>
        <li><a href="#bottom" id="OQ" class="Q"><i class="fas fa-question" style="color: #007bff"></i> Ouverte</a></li>
        <li><a href="#bottom" id="DATEQ" class="Q"><i class="far fa-calendar-alt" style="color: #007bff"></i> Date</a></li>
        <li><a href="#bottom" id="TIMEQ" class="Q"><i class="far fa-clock" style="color: #007bff"></i> Temps</a></li>
        <li><a href="#bottom" id="RANGEQ" class="Q"><i class="fas fa-ruler-horizontal" style="color: #007bff"></i> Intervalle</a></li>
        <!-- Add Matrix --> 
    </ul>
</div>
<div id="messages" class="alert" style="display:none;text-align: center;">
    
</div>
<div id="question_container">

</div>
<div id="bottom"></div>


<button onclick="topFunction()" id="myBtn" title="Go to top"><i class="fas fa-chevron-up"></i></button>

<footer >
    <button id="send" class="btn btn-success">
        Envoyer <i class='fas fa-paper-plane'></i> <!-- Store it + Ajax email sending -->
    </button>
    
    <?php if( $this->session->userdata('logged_in') ): ?>
        <a id='save'>
            <button class="btn btn-primary" style="font-size: 20px;font-weight: bold;">
                    Sauvegarder <i class="fas fa-cloud-download-alt"></i> <!-- On Click submit surveys/store -->
            </button>
        </a>
    <?php endif; ?>
</footer>

<script type="text/javascript" src="<?= base_url('assets/js/tagsinput.js');?>"></script>

<script>
    /* THEME SELECTION */
    $("#dark_theme").click(function(){
        $("#main").css("background-image", "url('<?= base_url('assets/img/dark.jpg');?>')");

        $("body").animate({
            backgroundColor: '#212121', //'rgb(200,200,200)',
        });
        $("#dark_theme").attr("disabled", true);

        $("#light_theme").attr("disabled", false);

    })

    $("#light_theme").click(function(){

        $("#main").css("background-image", "url('<?= base_url('assets/img/form_background.jpg');?>')");

        $("body").animate({
            backgroundColor: 'rgb(244,244,244)',
        });
        $("#dark_theme").attr("disabled", false);

        $("#light_theme").attr("disabled", true);

    });
</script>


<?php if( $this->session->userdata('logged_in') ): ?>
<script>
$(document).ready(function(){
    var id;
    $('#send').click(function(){
        if (del_form == false)
        {
            data = {};
            data[0] = [$('#title_input').val()];
            $.each(questions , function(key,value){
                data[key] = [];
                $.each(value , function(k , v){
                    let el = $(`#${v}`);
                    data[key].push( el.val() );
                })
                data[key][0] = questions[key][0];
                data[key][2] = $(`#${questions[key][2]}`).is(':checked');
            });
            $.ajax({
                method:'POST',
                url:'<?= site_url('surveys/create_survey'); ?>',
                dataType:'json',
                data : {
                    data : data,
                    check : false,
                    img:$('#proj_img').attr('src')
                },
                success : function(data){
                    if ( data['error'] == true){
                        if (data['empty']){
                            $('#messages').css('display' , 'block');
                            $('#messages').removeClass('alert-success').addClass('alert-danger')
                            $('#messages').text('Veuillez entrez au moins une questions');
                            window.location.href = '#title_label';
                        }
                        else if ( data['double'] ){
                            $('input').css('border-bottom' , '1px solid #757575');
                            console.log(questions);console.log(data['double']);
                            $.each(data['double'] , function(k,v){
                                el = ( questions[v[0]][1] );
                                $(`#${el}`).css('border-bottom' , '1px solid red');
                                el = ( questions[v[1]][1] );
                                $(`#${el}`).css('border-bottom' , '1px solid red');
                            });
                            $('#messages').css('display' , 'block');
                            $('#messages').removeClass('alert-success').addClass('alert-danger')
                            $('#messages').text('La meme question est répété deux fois ou plus !');
                            window.location.href = '#title_label';
                        }
                        else{ 
                            $('input').css('border-bottom' , '1px solid #757575');
                            let title = '';
                            $.each( data['indexes'] , function(k,v){
                                let el;
                                if ( v[0] == 0 && v[1] == 0 )
                                    title = ' | Veuillez saisir un titre !';
                                else 
                                    el = ( questions[v[0]][v[1]] );
                                
                                $(`#${el}`).css('border-bottom' , '1px solid red');
                            });
                            $('#messages').css('display' , 'block');
                            $('#messages').removeClass('alert-success').addClass('alert-danger')
                            $('#messages').text('Il y a des zones vides'+title);
                            window.location.href = '#title_label';
                        }
                    }
                    else{
                        $('input').css('border-bottom' , '1px solid #757575');
                        $('#messages').css('display' , 'none');
                        id = data['id'];
                        var uuid = data['uuid'];
                        $('#link').val(`<?=$url;?>/answer-survey/${uuid}`);
                        del_form = true;
                        $("#login_form").fadeIn(500);
                    }
                },
                error : function(xhr,status,error){
                    $('#messages').css('display' , 'block');
                    $('#messages').removeClass('alert-success').addClass('alert-danger')
                    $('#messages').text('Nous avons rencontré une erreur');
                }
            });
        }
        else{
            $("#login_form").fadeIn(500);
        }
        
    });

    $('#email-form').submit(function(e){
        e.preventDefault();
        let emails = $('#emails').val();
        $('#btn-send').val('Envoi..');
        $('#btn-send').prop('disabled' , true);
        $.ajax({
            method:'POST',
            url:'<?= site_url('surveys/share_form');?>',
            dataType:'json',
            data:{
                emails : emails,
                id : id 
            },
            success: function(data){
                if ( data['empty'] ){
                    $('#email-messages').css('display','block');
                    $('#email-messages').removeClass('alert-success').addClass('alert-danger');
                    $('#email-messages').text( 'Veuillez entrez des emails' );
                    $('#btn-send').prop('disabled' , false);
                    $('#btn-send').val('Envoyer');
                }
                else if ( data['error'] ){
                    $('#email-messages').css('display','block');
                    $('#email-messages').removeClass('alert-success').addClass('alert-danger');
                    $('#email-messages').text( 'Emails Invalide : ' + data['emails'] );
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
                    window.location.replace( '<?=$url;?>/dashboard' );
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

<script>
$(document).ready(function(){
    $('#save button').click(function(){
        if (del_form == false)
        {
            data = {};
            data[0] = [$('#title_input').val()];
            $.each(questions , function(key,value){
                data[key] = [];
                $.each(value , function(k , v){
                    let el = $(`#${v}`);
                    data[key].push( el.val() );
                })
                data[key][0] = questions[key][0];
                data[key][2] = $(`#${questions[key][2]}`).is(':checked');
            });            
            console.log(data);
            $.ajax({
                method:'POST',
                url:'<?= site_url('surveys/create_survey'); ?>',
                dataType:'json',
                data : {
                    data : data,
                    check : false,
                    img:$('#proj_img').attr('src')
                },
                success : function(data){
                    if ( data['error'] == true){
                        if (data['empty']){
                            $('#messages').css('display' , 'block');
                            $('#messages').removeClass('alert-success').addClass('alert-danger')
                            $('#messages').text('Veuillez entrer au moins une question');
                            window.location.href = '#title_label';
                        }
                        else if ( data['double'] ){
                            $('input').css('border-bottom' , '1px solid #757575');
                            console.log(questions);console.log(data['double']);
                            $.each(data['double'] , function(k,v){
                                el = ( questions[v[0]][1] );
                                $(`#${el}`).css('border-bottom' , '1px solid red');
                                el = ( questions[v[1]][1] );
                                $(`#${el}`).css('border-bottom' , '1px solid red');
                            });
                            $('#messages').css('display' , 'block');
                            $('#messages').removeClass('alert-success').addClass('alert-danger')
                            $('#messages').text('La meme question est répété deux fois ou plus !');
                            window.location.href = '#title_label';
                        }
                        else{ 
                            $('input').css('border-bottom' , '1px solid #757575');
                            let title = '';
                            $.each( data['indexes'] , function(k,v){
                                let el;
                                if ( v[0] == 0 && v[1] == 0 )
                                    title = ' | Veuillez saisir un titre !';
                                else 
                                    el = ( questions[v[0]][v[1]] );
                                
                                $(`#${el}`).css('border-bottom' , '1px solid red');
                            });
                            $('#messages').css('display' , 'block');
                            $('#messages').removeClass('alert-success').addClass('alert-danger')
                            $('#messages').text('Il y a des zones vides'+title);
                            window.location.href = '#title_label';
                        }
                    }
                    else{
                        $('input').css('border-bottom' , '1px solid #757575');
                        $('#messages').css('display' , 'block');
                        $('#messages').removeClass('alert-danger').addClass('alert-success')
                        $('#messages').text('Sondage créer avec succès !');
                        window.location.href = '#title_label';
                        window.location.replace( '<?=$url;?>/dashboard' );
                    }
                },
                error : function(xhr,status,error){
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                    $('#messages').css('display' , 'block');
                    $('#messages').removeClass('alert-success').addClass('alert-danger')
                    $('#messages').text('Nous avons rencontré une erreur');
                }
            });
            
        }
        else 
            window.location.replace( '<?=$url;?>/dashboard' );
    });
});

</script>

<?php else : ?>

<script>
$(document).ready(function(){
    $('#send').click(function(){
        data_form = {};
        data_form[0] = [$('#title_input').val()];
        $.each(questions , function(key,value){
            data_form[key] = [];
            $.each(value , function(k , v){
                let el = $(`#${v}`);
                data_form[key].push( el.val() );
            })
            data_form[key][0] = questions[key][0];
            data_form[key][2] = $(`#${questions[key][2]}`).is(':checked');
        });
        $.ajax({
            method:'POST',
            url:'<?= site_url('surveys/create_survey'); ?>',
            dataType:'json',
            data : {
                data : data_form,
                check_error : true,
                img : $('#proj_img').attr('src')
            },
            success : function(data){
                if ( data['error'] == true){
                    if (data['empty']){
                        $('#messages').css('display' , 'block');
                        $('#messages').removeClass('alert-success').addClass('alert-danger')
                        $('#messages').text('Veuillez entrer au moins une question');
                        window.location.href = '#title_label';
                    }
                    else if ( data['double'] ){
                        $('input').css('border-bottom' , '1px solid #757575');
                        console.log(questions);console.log(data['double']);
                        $.each(data['double'] , function(k,v){
                            el = ( questions[v[0]][1] );
                            $(`#${el}`).css('border-bottom' , '1px solid red');
                            el = ( questions[v[1]][1] );
                            $(`#${el}`).css('border-bottom' , '1px solid red');
                        });
                        $('#messages').css('display' , 'block');
                        $('#messages').removeClass('alert-success').addClass('alert-danger')
                        $('#messages').text('La meme question est répété deux fois ou plus !');
                        window.location.href = '#title_label';
                    }
                    else{ 
                        $('input').css('border-bottom' , '1px solid #757575');
                        let title = '';
                        $.each( data['indexes'] , function(k,v){
                            let el;
                            if ( v[0] == 0 && v[1] == 0 )
                                title = ' | Veuillez saisir un titre !';
                            else 
                                el = ( questions[v[0]][v[1]] );
                            
                            $(`#${el}`).css('border-bottom' , '1px solid red');
                        });
                        $('#messages').css('display' , 'block');
                        $('#messages').removeClass('alert-success').addClass('alert-danger')
                        $('#messages').text('Il y a des zones vides'+title);
                        window.location.href = '#title_label';
                    }
                }
                else{
                    $('input').css('border-bottom' , '1px solid #757575');
                    $('#messages').css('display' , 'none');
                    $("#login_form").fadeIn(500);
                }
            },
            error : function(xhr,status,error){
                $('#messages').css('display' , 'block');
                $('#messages').removeClass('alert-success').addClass('alert-danger')
                $('#messages').text('Nous avons rencontré un problème');
            }
        });
    });
});
</script>

<!-- Register + Store + Envoie + Login + Redirect Dashboard -->
<script>
$(document).ready(function(){
    // Register and get user id to passe to storing
    $('#email-form').submit(function(e){
        e.preventDefault();
        var auto_login =  false;
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
                auto_login : auto_login,
                delete:del_user
            },
            
            success: function(data){ 
                if ( data['error'] == true ){
                    var text = "";
                    $.each(data , function(key,value){
                        if (key != 'error' && value != ''){
                            text += value;
                            text += ' | ';
                            $(`#${key}`).css('border-bottom','1px solid red');
                        }
                        else if (value == ''){
                            $(`#${key}`).css('border-bottom','1px solid rgb(117, 117, 117)');
                        }
                    });
                    $('#email-messages').css('display','block');
                    $('#email-messages').removeClass('alert-success').addClass('alert-danger');
                    $('#email-messages').text( text.substr(0,text.length-3) );
                    setTimeout(function(){
                        $('#email-form input').css('border-bottom','1px solid rgb(117, 117, 117)');
                        $('#email-messages').fadeOut('slow');
                    },5000);
                }
                else{
                    $('#register-form input').css('border-bottom','1px solid rgb(117, 117, 117)');
                    $('#email-messages').css('display','block');
                    if ( 'register_success' in data ){
                        $('#email-messages').removeClass('alert-danger').addClass('alert-success');
                        $('#email-messages').text(data['register_success']);
                        let user_id = data['id'];
                        // Storing ajax
                        $.ajax({
                        method:'POST',
                        url:'<?= site_url('surveys/store_survey');?>',
                        dataType:'json',
                        data:{
                            data:data_form,
                            delete:del_form,
                            id:parseInt(user_id),
                            img:$('#proj_img').attr('src')
                        },
                        success:function(data){
                            let emails = $('#emails').val();
                            $('#btn-send').val('Envoie en cours..');
                            $('#btn-send').prop('disabled' , true);
                            let form_id = data['id'];
                            $.ajax({
                                method:'POST',
                                url:'<?= site_url('surveys/share_form');?>',
                                dataType:'json',
                                data:{
                                    emails : emails,
                                    id : parseInt(form_id),
                                    name:$('#register_name').val(),
                                },
                            success: function(data){
                                if ( data['empty'] ){
                                    $('#email-messages').css('display','block');
                                    $('#email-messages').removeClass('alert-success').addClass('alert-danger');
                                    $('#email-messages').text( 'Veuillez saisir des emails' );
                                    $('#btn-send').prop('disabled' , false);
                                    $('#btn-send').val('Envoie');
                                    del_form = true;
                                    del_user = true;
                                }
                                else if ( data['error'] ){
                                    $('#email-messages').css('display','block');
                                    $('#email-messages').removeClass('alert-success').addClass('alert-danger');
                                    $('#email-messages').text( 'Invalid Emails : ' + data['emails'] );
                                    $('#btn-send').prop('disabled' , false);
                                    $('#btn-send').val('Envoie');
                                    del_form = true;
                                    del_user = true;
                                }
                                else if ( data['email-failed'] ){
                                    $('#email-messages').css('display','block');
                                    $('#email-messages').removeClass('alert-success').addClass('alert-danger');
                                    $('#email-messages').text( data['email-failed']  );
                                    $('btn-send').prop('disabled' , false);
                                    $('#btn-send').val('Envoie');
                                    del_form = true;
                                    del_user = true;
                                }
                                else if ( data['email-success'] ){
                                    $('#email-messages').css('display','block');
                                    $('#email-messages').removeClass('alert-danger').addClass('alert-success');
                                    $('#email-messages').text( data['email-success'] );
                                    $('#btn-send').prop('disabled' , false);
                                    $('#btn-send').val('Envoie');
                                    $.ajax({
                                        method:'POST',
                                        url:'<?= site_url('users/login');?>',
                                        dataType:'json',
                                        data:{
                                            login_email : $('#register_email').val(),
                                            login_password : $('#register_password').val()
                                        },
                                        success:function(data){
                                            window.location.replace( '<?=$url;?>/dashboard' );
                                        },
                                        error:function(xhr,status,error){
                                            $('#email-messages').css('display','block');
                                            $('#email-messages').removeClass('alert-success').addClass('alert-danger');
                                            $('#email-messages').text('Nous avons rencontré un problème');
                                            $('#btn-send').prop('disabled' , false);
                                            $('#btn-send').val('Envoie');
                                            del_form = true;
                                            del_user = true;
                                        }
                                    });
                                }
                                setTimeout(function(){
                                    $('#email-messages').fadeOut('slow');
                                },5000);
                            },
                                error:function(xhr, status, error){
                                    console.log('email');
                                    $('#email-messages').css('display','block');
                                    $('#email-messages').removeClass('alert-success').addClass('alert-danger');
                                    $('#email-messages').text('Nous avons rencontré un problème');
                                    $('#btn-send').prop('disabled' , false);
                                    $('#btn-send').val('Envoie');
                                    del_form = true;
                                    del_user = true;
                                    setTimeout(function(){
                                        $('#email-messages').fadeOut('slow');
                                    },5000);
                                }
                            });
                        },
                        error:function(xhr,status,error){
                            $('#email-messages').css('display','block');
                            $('#email-messages').removeClass('alert-success').addClass('alert-danger');
                            $('#email-messages').text('Nous avons rencontré un problème');
                            del_user = true;
                            setTimeout(function(){
                                $('#email-messages').fadeOut('slow');
                            },5000);
                        }
                        });
                        // End of storing
                    }
                    else if ( 'register_failed' in data ){
                        $('#email-messages').removeClass('alert-success').addClass('alert-danger');
                        $('#email-messages').text(data['register_failed']);
                    }
                    setTimeout(function(){
                        $('#email-form input').css('border-bottom','1px solid rgb(117, 117, 117)');
                        $('#email-messages').fadeOut('slow');
                    },5000);
                }
                
            },
            error : function(xhr, status, error){
                $('#email-messages').css('display','block');
                $('#email-messages').removeClass('alert-success').addClass('alert-danger');
                $('#email-messages').text('Nous avons rencontré un problème');
                setTimeout(function(){
                    $('#email-form input').css('border-bottom','1px solid rgb(117, 117, 117)');
                    $('#email-messages').fadeOut('slow');
                },5000);
            }
        });
    });
  
});
</script>
<?php endif; ?>


