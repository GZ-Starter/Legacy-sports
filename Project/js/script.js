let menu = document.querySelector('#menu-btn');
// let navbar = document.querySelector('.header .navbar');
var counter=0;
menu.onclick = () =>{
   if( counter==1){
      menu.classList.remove('fa-times');
      document.querySelector('.menu-items').style.display = 'none';
      counter=0;
   }else{
      counter++;
      menu.classList.toggle('fa-times');
      // navbar.classList.toggle('active');
      document.querySelector('.menu-items').style.display = 'block';
   }
};
 
window.onscroll = () =>{
   menu.classList.remove('fa-times');
   // navbar.classList.remove('active');
   document.querySelector('.menu-items').style.display = 'none';
};


document.querySelector('#close-edit').onclick = () =>{
   document.querySelector('.edit-form-container').style.display = 'none';
   window.location.href = 'admin.php';
};