document.querySelector('#mtd').onchange = () =>{
    const sb= document.querySelector('#mtd');
    if(sb.selectedIndex==1){
    document.querySelector('.edit-form-container').style.display = 'flex';
    // window.location.href = 'admin.php';
    }
 };
//  document.querySelector('#close-edit').onclick = () =>{
//     document.querySelector('.edit-form-container').style.display = 'none';
//  };