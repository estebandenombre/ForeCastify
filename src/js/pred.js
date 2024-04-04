document.addEventListener("DOMContentLoaded", function() {
    const btn1 = document.getElementById("btn1");
    const btn2 = document.getElementById("btn2");
    const btn3 = document.getElementById("btn3");
    const btn4 = document.getElementById("btn4");

    const info1 = document.getElementById("info1");
    const info2 = document.getElementById("info2");
    const info3 = document.getElementById("info3");
    const info4 = document.getElementById("info4");
   
   
   
   
    btn1.addEventListener("click", vinfo1);
    btn2.addEventListener("click", vinfo2);
    btn3.addEventListener("click", vinfo3);
    btn4.addEventListener("click", vinfo4);
   
  
  
    const btn_add_modelo = document.getElementById("btn_add_modelo");
    btn_add_modelo.addEventListener("click", crearModelo);
  
    
    function vinfo1(event) {
      event.preventDefault();
  
      
      info1.classList.toggle('ocultar');
    }
    function vinfo2(event) {
      event.preventDefault();
  
      
      info2.classList.toggle('ocultar');
    }
    function vinfo3(event) {
      event.preventDefault();
  
      
      info3.classList.toggle('ocultar');
    }
    function vinfo4(event) {
      event.preventDefault();
  
      
      info4.classList.toggle('ocultar');
    }
   
    
    
    
  });