

<?php 
function get_client_ip_server() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
 
    return $ipaddress;
}
$ip = get_client_ip_server();
$url_api = "http://ip-api.com/json/";
$url_api .= $ip; 

?>

<style> 
body{
    background-color: rgb(244,244,244);
    min-height: 500px;
    box-sizing: border-box;
    overflow-x:hidden;
    position:relative;
}
/* The container */
.container {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 22px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Hide the browser's default checkbox */
.container input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
}

/* Create a custom checkbox */
.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 30px;
  width: 30px;
  background-color: #eee;
  border:2px solid #2196F3;
}
.qcm{
    border-radius: 50%;
}

/* On mouse-over, add a grey background color */
.container:hover input ~ .checkmark {
  background-color: #ccc;
}

/* When the checkbox is checked, add a blue background */
.container input:checked ~ .checkmark {
  background-color: #2196F3;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the checkmark when checked */
.container input:checked ~ .checkmark:after {
  display: block;
}

/* Style the checkmark/indicator */
.container .checkbox:after {
  left: 8px;
  top: 3px;
  width: 10px;
  height: 15px;
  border: solid white;
  border-width: 0 2px 2px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
}



@media (max-height:808px){

#privacy_container{
    margin-top:30vh;
}


}

@media (max-height:750px){

#privacy_container{
    margin-top:60vh;
}


}

@media (max-height:648px){

#privacy_container{
    margin-top:100vh;
}


}

@media (max-height:550px){

#privacy_container{
    margin-top:120vh;
}


}

@media (max-height:479px){

#privacy_container{
    margin-top:200vh;
}


}



</style>
<header>
    <nav class="navbar navbar-light " style="background-color: white">
        <a class="navbar-brand" href="<?=site_url();?>" id="brand">
            <img src="<?=base_url('assets/img/logo_paper.png');?>" alt="logo" id="logo" width="90" height="60">
            
        </a>
    </nav>
    
</header>



<div  class="row mt-2 justify-content-center" style="display: flex;justify-content:space-around;height:50px;max-width:1915px" >
    <div style="width:500px;background-color:white" class="shadow">
        <h2 style="text-align:center"> <?= ucfirst( $title ) ;?> </h2>
    </div> 
</div>

<div  class="row  justify-content-center" style="display: flex;justify-content:space-around;height:30px;max-width:1915px">
    <div style="width:500px;background-color:white" >
        <h6 style="text-align:right;padding-right:10px">By <?= ucfirst( $user ) ;?> </h6> 
    </div>
</div>

<div id="messages" class="alert mt-2" style="display: none;text-align:center;font-size:20px;"></div>
<script> var nb_editors=1; var id; </script>
<?php $qst_id = 0; ?>
<?php foreach ($questions as $question) : ?>
    <?php if ($question['type'] == 'mcq'): ?>
        <!-- QCM -->
        <?php $h = ($question['required'] == 1) ? 100 + ( count($question['options'])*80 ) : 50 + ( count($question['options'])*80 );?>
        <div class="container-fluid mt-3" style="width: 100%;height: <?= $h;?>px;" >
            <div class="row justify-content-center mb-3" style="height: 100%;margin-top: 5px;">
                <div class="col-md-6 col-lg-5 col-xl-4 col-12 shadow" style="height: 100%;background:white;">
                    <div class="row justify-content-center" style="height: 70px;">
                        <div class="group" > 
                            <span class="highlight"></span> <span class="bar"></span> 
                            <label id="question<?= $qst_id ;?>" class="label" style="top:-10px;left:0px !important;font-size: 25px;color:black;margin-top: 25px;text-align: center;width: 100%;">
                                <?= $question['question']; ?>
                            </label>
                        </div>
                    </div>
                    <?php if($question['required'] == 1) : ?>
                        <div class="row justify-content-center" style="display:flex;flex-direction:column;align-items: center;height:<?= $h-(70+70) ;?>px;">
                    <?php else: ?>
                        <div class="row justify-content-center" style="display:flex;flex-direction:column;align-items: center;height:<?= $h-(70) ;?>px;">
                    <?php endif; ?>
                        <?php $opt_id = 0; ?>
                        <?php foreach($question['options'] as $option): ?>
                            <div class="group se" > 
                                <div style="width:100%;">
                                    <div style="float:left;">
                                        <label class="container">
                                            <input type="radio" name="radio<?= $qst_id ;?>" data-id="qst_<?= $qst_id ;?>_opt_<?= $opt_id ;?>">
                                            <span class="checkmark qcm" style="float: left;font-size: 30px;margin-top: 2px;margin-right: 10px;color: #0079ca;margin-left: 5px;cursor: pointer;"></span>
                                        </label>
                                    </div>
                                    <input readonly type="text" class="shadow qOption" value="<?= $option; ?>" maxlength="30" style="font-size:20px;text-align:center;height: 30px;margin-top: 10px;cursor: pointer;"> 
                                </div>
                            </div>
                            <?php $opt_id++ ;?>
                        <?php endforeach; ?>
                    </div>
                    <?php if($question['required'] == 1) : ?>
                        <div class="row justify-content-center" style="height: 70px;">
                            <p style="margin-left:auto;margin-right:2%;font-size: 15px;color: rgb(54, 54, 54)"><i class="fas fa-asterisk" style="font-size: 10px;color: red;"></i>Required</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <!-- End QCM -->
    <?php elseif($question['type'] == 'checkbox') : ?>
         <!-- CheckBox -->
         <?php $h = ($question['required'] == 1) ? 100 + ( count($question['options'])*80 ) : 50 + ( count($question['options'])*80 );?>
         <div class="container-fluid mt-3" style="width: 100%;height: <?= $h ;?>px;" >
            <div class="row justify-content-center mb-3" style="height: 100%;margin-top: 5px;">
                <div class="col-md-6 col-lg-5 col-xl-4 col-12 shadow" style="height: 100%;background:white;">
                    <div class="row justify-content-center" style="height: 70px;">
                        <div class="group" > 
                            <span class="highlight"></span> <span class="bar"></span> 
                            <label id="question<?= $qst_id ;?>"  class="label" style="top:-10px;left: 0px !important;font-size: 25px;color:black;margin-top: 25px;text-align: center;width: 100%;">
                                <?= $question['question']; ?>
                            </label>
                        </div>
                    </div>
                    <?php if($question['required'] == 1) : ?>
                        <div class="row justify-content-center" style="display:flex;flex-direction:column;align-items: center;height:<?= $h-(70+70) ;?>px;">
                    <?php else: ?>
                        <div class="row justify-content-center" style="display:flex;flex-direction:column;align-items: center;height:<?= $h-(70) ;?>px;">
                    <?php endif; ?>
                    <?php $opt_id = 0 ;?>
                    <?php foreach($question['options'] as $option): ?>
                            <div class="group se" > 
                                <div style="width:100%;">
                                    <div style="float:left;">
                                        <label class="container">
                                            <input type="checkbox" data-id="qst_<?= $qst_id ;?>_opt_<?= $opt_id ;?>">
                                            <span class="checkmark checkbox" style="float: left;font-size: 30px;margin-top: 2px;margin-right: 10px;color: #0079ca;margin-left: 5px;cursor: pointer;"></span>
                                        </label>
                                    </div>
                                    <input readonly type="text" class="shadow qOption" value="<?= $option; ?>" maxlength="30" style="font-size:20px;text-align:center;height: 30px;margin-top: 10px;cursor: pointer;"> 
                                </div>
                            </div>
                            <?php $opt_id++ ;?>
                        <?php endforeach; ?>
                    </div>
                    <?php if($question['required'] == 1) : ?>
                        <div class="row justify-content-center" style="height: 70px;">
                            <p style="margin-left:auto;margin-right:2%;font-size: 15px;color: rgb(54, 54, 54)"><i class="fas fa-asterisk" style="font-size: 10px;color: red;"></i>Required</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <!-- End CheckBox -->
    <?php elseif($question['type'] == 'open') : ?>
        <!-- Open -->
        <div class="container-fluid mt-3" style="width: 100%;height: 600px;" >
            <div class="row justify-content-center mb-3" style="height: 100%;margin-top: 5px;">
                <div class="col-md-6 col-lg-5 col-xl-4 col-12 shadow" style="height: 100%;background-color: white;">
                    <div class="row justify-content-center" style="height: 15%;margin-top:2%;">
                        <div class="group" > 
                            <span class="highlight"></span> <span class="bar"></span> 
                            <label id="question<?= $qst_id ;?>"  class="label" style="top:-10px;left:0px !important;font-size: 25px;color:black;margin-top: 25px;text-align:center;width: 100%;">
                                <?= $question['question']; ?>
                            </label>
                        </div>
                    </div>
                    <div class="row justify-content-center" style="height: 75%;margin-top:2%;">
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">200 words maximum</label>
                            <textarea class="form-control" rows="3" data-id="qst_<?= $qst_id ;?>" ></textarea>
                            <script> id = `editor${nb_editors}`; nb_editors++;  $(`[data-id=qst_${<?=$qst_id;?>}]`).attr('id' , id); </script>
                        </div>
                    </div>
                    <?php if($question['required'] == 1) : ?>
                        <div class="row justify-content-center" style="height: 10%;">
                            <p style="margin-left:auto;margin-right:2%;font-size: 15px;color: rgb(54, 54, 54)"><i class="fas fa-asterisk" style="font-size: 10px;color: red;"></i>Required</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <!-- End Open -->
    <?php elseif($question['type'] == 'date') : ?>
        <!-- Date -->
        <div class="container-fluid mt-3" style="width: 100%;height: 250px;" >
            <div class="row justify-content-center mb-3" style="height: 100%;">
                <div class="col-md-6 col-lg-5 col-xl-4 col-12 shadow" style="height: 100%;background-color: white;">
                    <div class="row justify-content-center" style="height: 20%;margin-top:2%;">
                        <div class="group" > 
                            <span class="highlight"></span> <span class="bar"></span> 
                            <label id="question<?= $qst_id ;?>" class="label" style="top:-10px;left:0px !important;font-size: 25px;color:black;margin-top: 25px;text-align:center;width: 100%;">
                                <?= $question['question']; ?>
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-group row" style="height:50%;padding-top:10%;">
                        <label for="example-date-input" class="col-2 col-form-label">Date</label>
                        <div class="col-10">
                            <input class="form-control" type="date" style="text-align: center;" data-id="qst_<?= $qst_id ;?>">
                        </div>
                    </div>
                    <?php if($question['required'] == 1) : ?>
                        <div class="row justify-content-center" style="height: 20%;">
                            <p style="margin-left:auto;margin-right:2%;font-size: 15px;color: rgb(54, 54, 54)"><i class="fas fa-asterisk" style="font-size: 10px;color: red;"></i>Required</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <!-- End Date --> 
    <?php elseif($question['type'] == 'time') : ?>
        <!-- Time -->
        <div class="container-fluid mt-3" style="width: 100%;height: 250px;" >
            <div class="row justify-content-center mb-3" style="height: 100%;">
                <div class="col-md-6 col-lg-5 col-xl-4 col-12 shadow" style="height: 100%;background-color: white;">
                    <div class="row justify-content-center" style="height: 20%;margin-top:2%;">
                        <div class="group" > 
                            <span class="highlight"></span> <span class="bar"></span> 
                            <label id="question<?= $qst_id ;?>"  class="label" style="top:-10px;left:0px !important;font-size: 25px;color:black;margin-top: 25px;text-align:center;width: 100%;">
                                <?= $question['question']; ?>
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-group row" style="height:50%;padding-top:10%;">
                        <label for="example-time-input" class="col-2 col-form-label">Time</label>
                        <div class="col-10">
                            <input class="form-control" type="time" style="text-align: center;" data-id="qst_<?= $qst_id ;?>">
                        </div>
                    </div>
                    <?php if($question['required'] == 1) : ?>
                        <div class="row justify-content-center" style="height: 20%;">
                            <p style="margin-left:auto;margin-right:2%;font-size: 15px;color: rgb(54, 54, 54)"><i class="fas fa-asterisk" style="font-size: 10px;color: red;"></i>Required</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <!-- End Time -->
    <?php elseif($question['type'] == 'range') : ?>
        <!-- Range -->
        <div class="container-fluid mt-3" style="width: 100%;height: 250px;" >
            <div class="row justify-content-center mb-3" style="height: 100%;">
                <div class="col-md-6 col-lg-5 col-xl-4 col-12 shadow" style="height: 100%;background-color: white;">
                    <div class="row justify-content-center" style="height: 20%;margin-top:2%;">
                        <div class="group" > 
                            <span class="highlight"></span> <span class="bar"></span> 
                            <label id="question<?= $qst_id ;?>"  class="label" style="top:-10px;left:0px !important;font-size: 25px;color:black;margin-top: 25px;text-align:center;width: 100%;">
                                <?= $question['question']; ?>
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-group row" style="height:50%;padding-top:10%;">
                        <label for="example-number-input" class="col-2 col-form-label">From</label>
                        <div class="col-4">
                            <input class="form-control" type="number" style="text-align: center;" data-id="qst_<?= $qst_id ;?>_range_1">
                        </div>
                        <label for="example-number-input" class="col-2 col-form-label">To</label>
                        <div class="col-4">
                            <input class="form-control" type="number" style="text-align: center;" data-id="qst_<?= $qst_id ;?>_range_2">
                        </div>
                    </div>
                    <?php if($question['required'] == 1) : ?>
                        <div class="row justify-content-center" style="height: 20%;">
                            <p style="margin-left:auto;margin-right:2%;font-size: 15px;color: rgb(54, 54, 54)"><i class="fas fa-asterisk" style="font-size: 10px;color: red;"></i>Required</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <!-- End Range -->
    <?php endif; ?>
    <?php $qst_id++ ;?>
<?php endforeach; ?>
    
<button onclick="topFunction()" id="myBtn" title="Go to top"><i class="fas fa-chevron-up"></i></button>

<footer class="row mt-4 mb-1 justify-content-center" style="max-width:1915px;">
    <button id='btn-send' class="btn btn-success" style="padding:10px;font-size:20px;width:200px">
        Submit <i class='fas fa-paper-plane'></i>
    </button>
    
    
</footer>

<div class="row justify-content-center" style="position:absolute;height:102%;width:110%;background-color:rgba(100,100,100,0.5);top:0px;display:none" id="privacy_container">
                        <div class="col-md-7 col-lg-5 shadow" style="margin-top:130vh;background-color:white;height:220px;max-width:700px;" id="privacy">
                        <div class="row justify-content-end" style="height:10px;">   
                            
                                
                                <button type="button" class="close" aria-label="Close" id="privacy_close" style="margin-right:10px;cursor:pointer">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="row justify-content-center" style="height:50px;">   
                            
                                <h1> Privacy policy </h1>
                                
                            </div>
                            <div class="row mt-3 justify-content-center" style="height:50px;">   
                                <p style="padding-left:20px"> To enhance your survey experience, we use Your IP address to provide detailed visualizations for the best survey experience possible </p> 
                            </div>
                            <div class="row mt-3 " style="height:30px;">   
                                <p style="padding-left:20px"> If you wish however you can do so here : </p> 
                                
                            </div>
                            <div class="row justify-content-center" style="height:50px;font-size:25px;cursor:pointer">   
                                Location 
                                <div class="custom-control custom-switch" style="margin-left:10px;margin-top:10px;">
                                <input type="checkbox" class="custom-control-input" id="customSwitch1"   checked>
                                <label class="custom-control-label" for="customSwitch1" style="cursor:pointer"></label>
                                </div>
                            </div>
                        </div>
</div>
<div class="row mt-5 mb-3 justify-content-center" style="height:20px;">
    <h6 style="color:rgb(130,130,130);font-size:12px"> By submitting this form, you agree to our <a style="font-size:12px;font-weight:bold;cursor:pointer;text-decoration:underline;" id="privacy_open"> privacy policy </a></h6>
<div class="row">



<!----------------------------------------------------- Javascript ---------------------------------------------------->

<script>
    $(document).ready(function(){
        $('#btn-send').click(function(){
            var conutry;
            var city;
            var lat;
            var lon;
            if ( $('#customSwictch1').is(':checked') == true ){ 
                $.ajax({
                    url:'<?= $url_api; ?>',
                    method:'GET',
                    dataType:'json',
                    success:function(data){
                        country = data['country'];
                        city = data['city'];
                        lat = data['lat'];
                        lon = data['lon'];
                    },
                    error:function(xhr,status,error){
                        console.log(xhr);
                        console.log(status);
                        console.log(error);
                    }
                });
            }
            if ( typeof country === 'undefined' ){
                country = '';
                city = '';
                lat = '';
                lon = '';
            }

            var questions = <?php echo json_encode($questions) ;?> ;
            var values  = {};
            var edit = 1;
            for ( id=0 ; id < questions.length ; id++ )
            {
                let qst = $(`[data-id^=qst_${id}]`);
                let qst_id = qst.attr('data-id');
                let pattern = /qst_([0-9])*/;
                let result = qst_id.replace( pattern , '' );
                if ( result == '' ){
                    if ( ( qst.attr('id') ) ){ 
                        let editor = `editor${edit}`;
                        values[id] = CKEDITOR.instances[`${editor}`].getData();
                        edit++;
                    }
                    else 
                        values[id] = qst.val();
                }
                else if ( result.match( /_range_./ ) ){
                    let el = $(`[data-id^=qst_${id}_range_2`);
                    let key = qst_id.replace(/_range_([0-9])*/ , '_range');
                    values[id] = [ qst.val() , el.val() ];
                }
                else{
                    let opt = 0;
                    let key = qst_id.replace(/_opt_([0-9])*/ , '_opt');
                    values[id] = [];
                    while ( $(`[data-id^=qst_${id}_opt_${opt}`).length == 1 ){
                        let el = $(`[data-id^=qst_${id}_opt_${opt}`);
                        (values[id]).push( el.is(':checked') );
                        opt++;
                    }
                }
            }
            console.log(questions);
            console.log(values);
            
            $.ajax({
                method:'POST',
                url:'<?= site_url('surveys/answer_survey'); ?>',
                dataType:'json',
                data:{
                    questions:questions,
                    values:values,
                    qf_id:<?= $qf_id ;?>,
                    country:country,
                    city:city,
                    lat:lat,
                    lon:lon
                },
                success:function(data){
                    if ( data['error'] ){
                        $('#messages').removeClass('alert-success').addClass('alert-danger').text('Required questions must be answered').css('display' , 'block');
                        $(`[id^=question]`).css('border' , '1px solid white');
                        $(data['indexes']).each(function(k,v){
                            $(`#question${v}`).css('border-bottom' , '1px solid red');
                        });
                    }
                    else{
                        $(`[id^=question]`).css('border' , '1px solid white');
                        $('#messages').removeClass('alert-danger').addClass('alert-success').css('display','block').text('Thank you for your answers ! Redirecting in 3...');
                        cpt = 2;
                        t = setInterval(function(){
                            if (cpt==0){ 
                                clearInterval(t);
                                window.location.replace( '<?=$url;?>/' );
                            }
                            $('#messages').text(`Thank you for your answers ! Redirecting in ${cpt}...`);
                            cpt--;
                        } , 1000);
                    } 

                    window.location.href = '#logo';
                },
                error:function(xhr,status,error){
                    console.log(xhr);
                    console.log(status);
                    console.log(error);
                }
            });
            
        });

        $( "#privacy_open" ).click(function() {
         $("#privacy_container").fadeIn(500);
        });

        $( "#privacy_close" ).click(function() {
         $("#privacy_container").fadeOut(500);
        });
    });


</script>

<script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>

<script> 
$(document).ready(function(){
    for(i=1;i<nb_editors;i++){ 
        CKEDITOR.replace( `editor${i}` );
        
    }
    $(document).on('click' , 'input[type="text"]' , function(){
        let el = $(this).prev().find('input[type="checkbox"]');
        for (i=0;i<2;i++)
        {
            if ( el.is(':checked') )
                el.prop('checked' , false);
            else
                el.prop('checked' , true);

            el = $(this).prev().find('input[type="radio"]');
        }
    });
});
mybutton = document.getElementById("myBtn");
window.onscroll = function() {scrollFunction()};
function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}
function topFunction() {
  $('html,body').animate({ scrollTop: 0 }, 'slow');
}
</script>

