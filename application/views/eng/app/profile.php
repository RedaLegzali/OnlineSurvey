<?= form_open('pages/es' , array('id'=>'es')); ?>
<?= form_close(); ?>
<?= form_open('pages/fr' , array('id'=>'fr')); ?>
<?= form_close();?>
<?= form_open('pages/ar' , array('id'=>'ar')); ?>
<?= form_close(); ?>

<style>
    body{
        background-color: rgb(244,244,244);
        background-image: url('<?= base_url('assets/img/form_background.jpg');?>');
        background-size: 100%;
        background-attachment: fixed;
    }
</style>

<div style="background-color: white;position: absolute;z-index:2;width: 100%;height: 100%;opacity: 0.7;position: fixed;" id="load">
    <div class="load" >
        <hr/><hr/><hr/><hr/>
        </div>
        <h1 style="position: absolute;top: 60%;left: 43.5%; font-family:'Helvetica Neue'; ">Online Survey</h1>
</div>

<header>
    <nav class="navbar navbar-light " style="background-color: white">
        <a class="navbar-brand" href="<?= site_url(); ?>" id="brand">
            <img src="<?= base_url('assets/img/logo_paper.png');?>" alt="logo" id="logo" width="90" height="60">
            
            
        </a>
            
        <ul id="settings" style="list-style: none;">

            <li style="float: left;">
                <img src="<?= base_url('assets/img/uploads/users/').$user_img;?>" alt="logo" id="logo_perso" width="60" height="60" style="border-radius: 50%;object-fit: cover;float: right;margin-top: 10px">
            </li>
            <li style="float: left;">
            <div class="dropdown "  >
                <a  href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="text-decoration: none;color: black">
                    <span style="font-size: 50px;">&#8942;</span>
                </a>

                <div class="dropdown-menu dropdown-menu-right"  aria-labelledby="dropdownMenuLink" style="width: 10px !important;" >
                <a class="dropdown-item" href="<?= site_url(); ?>" style="color: black"><i class="fas fa-home" style="color: #0079ca"></i> Home</a>
                <a class="dropdown-item" href="<?= site_url('/upgrade');?>" style="color: black"><i class="fas fa-gem" style="color: orange"></i> Upgrade</a>
                <a class="dropdown-item" href="#" style="color: black;"><i class="fas fa-cog" style="color: rgb(104,104,104);"></i> Settings</a>
                <?= form_open('users/logout'); ?>
                    <button type="submit" class="dropdown-item" style="color: black;cursor:pointer;"><i class="fas fa-sign-out-alt" style="color: rgb(104,104,104);cursor:pointer;" ></i> Logout</button>
                <?= form_close(); ?> 
                </div>
            </div></li>
        </ul>
        <style>
            .dropdown-menu-right {
                right: 0 !important;
                left: auto !important;
            }
        </style>
        
    </nav>
</header>

<!--
<div class="row" style="height: 350px;background-image: url('img/form_background.jpg');background-size: 100% ">
    
</div>
-->

<div class="container-fluid mt-5" id="main" >
    <div class="row justify-content-center mainR" style="height: 950px;">   
        <div class="col-md-8 col-lg-6 col-xl-5 mb-5 shadow" style="height: 100%;background-color: white;max-width: 650px"  id="test">
        <div class="row " style="height:3%;">
                <li class="nav-item" style="list-style-type: none;"> 
                    <div class="dropdown">
                        <a id="lang" class="nav-link dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: black;font-size: 25px"> 
                            <img src="<?= base_url('assets/img/usa.svg');?>" style="height: 20px;width: 20px;"> English
                        </a> 
                        <div class="dropdown-menu " aria-labelledby="dropdownMenuLink" > 
                            <a class="dropdown-item" id="spanish" style="color: black;cursor:pointer;">
                                <img src="<?= base_url('assets/img/esp.svg');?>" style="height: 20px;width: 20px"> Spanish
                            </a> 
                            <a class="dropdown-item" id="french" style="color: black;cursor:pointer;">
                                <img src="<?= base_url('assets/img/Fr.svg');?>" style="height: 20px;width: 20px"> 
                                French
                            </a> 
                            <a class="dropdown-item" id="arabic" style="color: black;cursor:pointer;">
                                <img src="<?= base_url('assets/img/ar.svg');?>" style="height: 20px;width: 20px"> 
                                العربية
                            </a> 
                        </div>
                    </div>
                </li> 
            </div>
            <div class="row justify-content-center mt-4" style="height: 14%">
                <div class=" col-md-5 col-lg-5 col-xl-6" style="height: 100%;max-width: 200px;margin-left: 25px" align="center">
                    <img src="<?= base_url('assets/img/uploads/users/').$user_img;?>" id="user_img" style="height: 100%;width: 100%;border-radius: 50%">
                </div>
                <div class="col-1" style="height: 25%;background-color: rgb(244,244,244);margin-top: 120px;cursor:pointer;max-width: 40px;border-radius: 50%;margin-left: -12px" >
                    
                    <input type="image" src="<?= base_url('assets/img/camera.png');?>" id="proj_img" class="shadow" height="40" style="width: 40px;margin-left: -15px" />
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
                                    console.log(data);
                                    let img = $.parseJSON(data);
                                    if ( img['file_name'] !== undefined ){
                                        $('#user_img').attr('src' , `<?= base_url('assets/img/uploads/users/'); ?>${img['file_name']}` );
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

            </div>
            <div class="row justify-content-center mt-1" style="height: 3%;">
                <h6>Basic member</h6>
            </div>
            <?= form_open('users/settings'); ?> 
            <div style="display:none;text-align:center;" class="alert alert-danger">
                <?php if ( validation_errors() ): ?>
                    <?= substr( str_replace('.' , ' | ' , strip_tags(validation_errors() )) , 0 , -3); ?>
                    <script> 
                        $('.alert').css('display','block'); 
                        setTimeout(function(){
                            $('.alert').fadeOut('slow');
                        },10000);
                    </script>
                <?php endif; ?>
            </div>

            
            <div class="row justify-content-center" style="height: 3%;margin-top: 50px">
                <div class="group"  align="center">  
                    <div class="input-group-prepend shadow" style="float: left;height: 99%;">
                        <div class="input-group-text"><i class="fas fa-user"></i></div>
                    </div>
                    <input type="text" class="shadow input" placeholder="Name" name="name" maxlength="30" Value="<?= $user['name'] ;?>" >
                    <span class="highlight"></span>
                    <span class="bar"></span>
                    <!-- <label class="label" style="left: 34%">Name</label> -->
                </div>
            </div>
            <div class="row justify-content-center " style="height: 3%;margin-top: 40px">
                <div class="group"  align="center">  
                    <div class="input-group-prepend shadow" style="float: left;height: 99%;">
                        <div class="input-group-text" >@</div>
                    </div>
                
                    <input type="email" class="shadow input" placeholder="Email" name="email" maxlength="30" Value="<?= $user['email'] ;?>"  >
                    <span class="highlight"></span>
                    <span class="bar"></span>
                    <!-- <label class="label" style="left: 42%">Email</label> -->
                </div>
            </div>
            <div class="row justify-content-center" style="height: 3%;margin-top: 40px">
                <div class="group"  align="center">  
                    <div class="input-group-prepend shadow" style="float: left;height: 99%;">
                        <div class="input-group-text"><i class="fas fa-key"></i></div>
                    </div>
                
                    <input type="password" class="shadow input" placeholder="Old Password" name="old_password" maxlength="30" >
                    <span class="highlight"></span>
                    <span class="bar"></span>
                    <!-- <label class="label" style="left: 36%">Old Password</label> -->
                </div>
            </div>
            <div class="row justify-content-center" style="height: 3%;margin-top: 40px">
                <div class="group"  align="center">  
                    <div class="input-group-prepend shadow" style="float: left;height: 99%;">
                        <div class="input-group-text"><i class="fas fa-key"></i></div>
                    </div>
                
                    <input type="password" class="shadow input" placeholder="New Password" name="new_password" maxlength="30" >
                    <span class="highlight"></span>
                    <span class="bar"></span>
                    <!-- <label class="label" style="left: 36%">New Password</label> -->
                </div>
            </div>
            <div class="row justify-content-center" style="height: 3%;margin-top: 40px">
                <div class="group"  align="center">  
                    <div class="input-group-prepend shadow" style="float: left;height: 99%;">
                        <div class="input-group-text"><i class="fas fa-key"></i></div>
                    </div>
                
                    <input type="password" class="shadow input" placeholder="Confirm New Password" name="new_password_confirm" maxlength="30" >
                    <span class="highlight"></span>
                    <span class="bar"></span>
                    <!-- <label class="label" style="left: 20%;">New Password Confirm</label> -->
                </div>
            </div>

            <div class="row justify-content-center mt-5" style="height: 4%;color: rgb(200,200,200);">
                    <a>
                        <button type="submit" class="btn btn-primary" style="width: 150px">
                            Save Changes
                        </button>
                    </a>
            
                <a href="<?= site_url(); ?>">
                    <button class="btn btn-secondary" style="margin-left: 10px;width: 150px" >
                        cancel
                    </button>
                </a>
            </div>
            <?= form_close(); ?>
            <div class="row justify-content-center mt-5" style="height: 2%;color: rgb(200,200,200);">
                Copyright 2020 : Big Brothers
            </div>
            
            
        </div>
    </div>
</div>

<script> 
	$(document).ready(function(){
		$('#spanish').click(function(e){
			e.preventDefault();
			$('#es').submit();
		});
		$('#french').click(function(e){
			e.preventDefault();
			$('#fr').submit();
		});
	
		$('#arabic').click(function(e){
			e.preventDefault();
			$('#ar').submit();
		});
	});
</script> 