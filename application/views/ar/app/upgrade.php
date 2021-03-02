

<style>
body{
background-image: url('<?=base_url('assets/img/form_background.jpg');?>');background-size: 100%;background-attachment: fixed;height: 100%;width: 100%;
}
</style>
<div style="background-color: white;position: absolute;z-index:2;width: 100%;height: 100%;opacity: 0.7;position: fixed;" id="load">
	<div class="load" >
		<hr/><hr/><hr/><hr/>
		</div>
		<h1 style="position: absolute;top: 60%;left: 43.5%; font-family:'Helvetica Neue'; ">Online Survey</h1>
</div>

<div class="row justify-content-center" id="hidden" style="height: 100%;background-color: rgba(0,0,0,0.5);width: 100%;position: absolute;z-index: 2;display: none;position: fixed;margin-left: 0px">
	<div class="col-md-6" align="center" id="card_container" style="height: 500px;margin-top: 25vh;background-color: white">
		<div class="row justify-content-end" style="height: 5%">
			<span style="font-size: 30px;cursor: pointer;" class="close">&times</span>
		</div>
		<div class="row justify-content-center" style="height: 15%">
				<h1 style="font-family: 'Helvetica'" id="pay_method"> إضافة طريقة الدفع </h1>
		</div>
		<div class="row justify-content-center mt-2" id="payment_img" style="height: 50%">
				<img src="<?= base_url('assets/img/payment.png');?>"  style="height: 100%">
		</div>
		<div class="row justify-content-center mt-3" style="height: 10%">
			<button class="btn btn-primary" id="add_cc" style="width: 200px;font-size: 20px;font-weight: bold"> 
			إضافة بطاقة ائتمان
			</button>
		</div>

		<div class="row justify-content-center mt-5" style="height: 5%;">
			<h6 style="margin:auto;color: rgb();color: rgb(195,199,202);font-size: 13px;">© 2020 Copyright: Big Brothers Secure <i class="fas fa-lock" style="font-size: 13px;color: orange"></i> </h6>
			</div>

	</div>
	
</div>

<header>
	<nav class="navbar navbar-light" style="background-color: white">
		<a class="navbar-brand" href="<?= site_url();?>" id="brand">
			<img src="<?= base_url('assets/img/logo_paper.png');?>" alt="logo" id="logo" width="90" height="60">
			
		</a>
			
		<ul id="settings" style="list-style: none;">
			<li style="float: left;">
				<img src="<?= base_url('assets/img/uploads/users/').$user_img;?>" alt="logo" id="logo_perso" width="60" height="60" style="cursor:pointer;border-radius: 50%;object-fit: cover;float: right;margin-top: 10px">
			</li>
			<li style="float: left;">
			<div class="dropdown "  >
				<a  href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="text-decoration: none;color: black">
					<span style="font-size: 50px;">&#8942;</span>
				</a>

				<div class="dropdown-menu dropdown-menu-right"  aria-labelledby="dropdownMenuLink" style="width: 10px !important;" >
				<a class="dropdown-item" href="<?= site_url();?>" style="color: black;font-size:18px;"><i class="fas fa-home" style="color: #0079ca"></i> الصفحة الرئيسية</a>
				<a class="dropdown-item" href="#" style="color: black"><i class="fas fa-gem" style="color: orange"></i> تحسن</a>
				<a class="dropdown-item" href="<?= site_url('users/settings');?>" style="color: black;"><i class="fas fa-cog" style="color: rgb(104,104,104);"></i> الإعدادات</a>
				<?= form_open('users/logout'); ?>
					<button type="submit" class="dropdown-item" style="color: black;cursor:pointer;"><i class="fas fa-sign-out-alt" style="color: rgb(104,104,104);cursor:pointer;" ></i> خروج</button>
				<?= form_close(); ?>			
			</div>
			</li>
		</ul>
			
			

	</nav>
</header>

<div class="container-fluid" id="price_table">

	<div class="row justify-content-center mt-5" style="height: 730px">
		<div class="col-md-4  col-xl-3  shadow" id="F1" style="background-color: white;max-width: 350px">
			<div class="row mt-1 justify-content-center" style="height: 10%;background-color: rgb(244,244,244);width: 107%;margin-left: -3.5%">
				<h1 style="font-size: 65px">0$</h1>
				
			</div>
			<div class="row justify-content-center" style="height: 5%;background-color: rgb(244,244,244);width: 107%;margin-left: -3.5%">
				
				<h5 style="margin-left: 20%">/شهر</h5>
			</div>
			<div class="row justify-content-center" style="height: 7%;background-color: rgb(244,244,244);width: 107%;margin-left: -3.5%">
				
				<h3>عرض مجاني</h3>
			</div>

			<div class="row m-2 justify-content-center" style="height: 10%;font-family: 'Helvetica'">
				<i class="fas fa-paper-plane" style="font-size: 50px;margin-top: 10px;color: black; transform: rotate(20deg);"></i>
			</div>

			<div class="row mt-2" style="height: 50%;font-family: 'Helvetica'">
				<ul >
					<li class="checked">3 مسوحات / شهر</li>
					<li class="checked" >الوصول إلى المخطط الدائري</li>
					<li class="unchecked" >الوصول إلى جميع الرسوم البيانية</li>
					<li class="unchecked">استطلاعات غير محدودة</li>
					<li class="unchecked">مشاركة غير محدودة</li>
					<li class="unchecked">خريطة العالم</li>
					<li class="unchecked">مراجع متعددة</li>
					
				</ul>
			</div>
			<div class="row mt-4 justify-content-center" style="height: 7%;">
				<button class="btn btn-primary" disabled style="background-color: white;color: #0079ca">
				تم تحديد الخيار	
				</button>
			</div>
		</div>

		<div class="col-md-4 col-xl-3 ml-md-0 ml-xl-5 mt-5 mt-md-0 shadow" style="background-color: white;max-width: 350px;">
			<div class="row mt-1 justify-content-center" style="height: 10%;background-color: #0079ca;width: 107%;margin-left: -3.5%;color: white">
				<h1 style="font-size: 65px">6$</h1>
				
			</div>
			<div class="row justify-content-center" style="height: 5%;background-color: #0079ca;width: 107%;margin-left: -3.5%;color: white">
				
				<h5 style="margin-left: 20%">/شهر</h5>
			</div>
			<div class="row justify-content-center" style="height: 7%;background-color: #0079ca;width: 107%;margin-left: -3.5%;color: white">
				
				<h3> عضو نشيط </h3>
			</div>

			<div class="row m-2 justify-content-center" style="height: 10%;font-family: 'Helvetica'">
				<i class="fas fa-plane" style="font-size: 50px;margin-top: 10px;color: #0079ca"></i>
			</div>

			<div class="row mt-2" style="height: 50%;font-family: 'Helvetica'">
				<ul >
					<li class="checked">3 مسوحات / شهر</li>
					<li class="checked" >الوصول إلى المخطط الدائري</li>
					<li class="checked" >الوصول إلى جميع الرسوم البيانية</li>
					<li class="checked">استطلاعات غير محدودة</li>
					<li class="checked">مشاركة غير محدودة</li>
					<li class="unchecked">خريطة العالم</li>
					<li class="unchecked">مراجع متعددة</li>
					
				</ul>
			</div>
			<div class="row mt-4 justify-content-center" style="height: 7%;">
				
					<button class="btn btn-primary Upgrade" style="font-weight: bold;">
					تتقدم	
					</button>
				
			</div>
		</div>

		<div class="col-md-4  col-xl-3 ml-md-0 ml-xl-5 mt-5 mt-md-0 mb-5 mb-md-0 shadow" style="background-color: white;max-width: 350px">
			<div class="row mt-1 justify-content-center" style="height: 10%;background-color: orange;width: 107%;margin-left: -3.5%;color: white">
				<h1 style="font-size: 65px">15$</h1>
				
			</div>
			<div class="row justify-content-center" style="height: 5%;background-color: orange;width: 107%;margin-left: -3.5%;color: white">
				
				<h5 style="margin-left: 20%">/شهر</h5>
			</div>
			<div class="row justify-content-center" style="height: 7%;background-color: orange;width: 107%;margin-left: -3.5%;color: white">
				
				<h3>قسط الأعضاء</h3>
			</div>

			<div class="row m-2 justify-content-center" style="height: 10%;font-family: 'Helvetica'">
				<i class="fas fa-rocket" style="font-size: 50px;margin-top: 10px;color: orange"></i>
			</div>

			<div class="row mt-2" style="height: 50%;font-family: 'Helvetica'">
				<ul >
					<li class="checked">3 مسوحات / شهر</li>
					<li class="checked" >الوصول إلى المخطط الدائري</li>
					<li class="checked" >الوصول إلى جميع الرسوم البيانية</li>
					<li class="checked">استطلاعات غير محدودة</li>
					<li class="checked">مشاركة غير محدودة</li>
					<li class="checked">خريطة العالم</li>
					<li class="checked">مراجع متعددة</li>
					
				</ul>
			</div>
			<div class="row mt-4 justify-content-center" style="height: 7%;">
				<button class="btn btn-warning Upgrade" style="color: white;background-color: orange;font-weight: bold;">
					تصبح قسط
				</button>
			</div>
		</div>
	</div>

</div>


