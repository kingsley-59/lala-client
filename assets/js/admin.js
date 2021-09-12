
let admin_nav_btn = document.getElementById('admin-menu-btn');
admin_nav_btn.addEventListener('click', function(){
    let side_nav = document.getElementById('side-nav');
    if(side_nav.style.width == '0px'){
        side_nav.style.display = 'inline';
        side_nav.style.width = '70%';
    }else{
        side_nav.style.display = 'none';
        side_nav.style.width = '0px';
    }
});