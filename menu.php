<?php include("texts.php");?>






<div class="mobile-header m-0 p-0 " style="background-color: #4d4a45; color:white;">
  <a href="index.php"  
   data-bs-toggle="tooltip" 
   data-bs-placement="top"  class="header-link hover-pulse" title="الصفحة الرئيسية"><i class="ion-ios-home"></i></a>
  <a href="search_form.php"  
   data-bs-toggle="tooltip" 
   data-bs-placement="top"  class="header-link hover-pulse" title="بحث عن سيارة"><i class="ion-md-search"></i></a>
  <a href="report_form.php"  
   data-bs-toggle="tooltip" 
   data-bs-placement="top"  class="header-link hover-pulse" title="اضافة سيارة"><i class="ion-md-car"></i></a>
  <a href="report_form_qu.php"  
   data-bs-toggle="tooltip" 
   data-bs-placement="top"  class="header-link hover-pulse" title="اضافة سريعة"><i class="ion-md-car"></i> <i class="  ion-md-speedometer"></i></a>

  
  <a href="about.php"  
   data-bs-toggle="tooltip" 
   data-bs-placement="top"  class="header-link hover-pulse" title="حول"><i class="ion-md-information-circle"></i></a>
  
  
</div>

<style>

.mobile-header {
  position: fixed;
  top: 0;
  width: 100%;
  background-color: #ffffff;
  display: flex;
  color:#de7f09;
  justify-content: space-around;
  align-items: center;
  border-bottom: 1px solid #ddd;
  box-shadow: 0 2px 2px rgba(0,0,0,0.1);
  padding: 1px 0;
  z-index: 1000;
}

.header-link {
  text-align: center;
  color: white;
  text-decoration: none;
  font-size: 20px;
  flex: 1;
  margin-right: 4px;
  margin-left: 4px;
  margin-bottom: 3px;
  margin-top: 2px;
  background-color:#4d4a45 ;
}

.header-link:hover {
    color:rgb(247, 165, 65) !important;
    background-color: black;
      border: solid 1px black;
        font-size: 24px;



    

}


a.hover-pulse {
  display: inline-block;
  transition: transform 0.2s ease-in-out;
}

a.hover-pulse:hover {
  transform: scale(1.05);
  animation: pulse 0.6s infinite alternate;
}

@keyframes pulse {
  from { transform: scale(1.05); }
  to { transform: scale(1.1); }
}

</style>






 
<style>
  .alert-animated-title {
    animation: fadeSlideTitle 0.8s ease;
  }

  @keyframes fadeSlideTitle {
    0% {
      opacity: 0;
      transform: translateY(-15px);
    }
    100% {
      opacity: 1;
      transform: translateY(0);
    }
  }
</style>