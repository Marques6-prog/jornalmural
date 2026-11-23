document.addEventListener('DOMContentLoaded',function(){
  document.querySelectorAll('.sidebar .nav-link').forEach(function(link){
    if(link.getAttribute('href')===window.location.href){link.classList.add('active');}
  });

  var menu=document.querySelector('.navbar-toggler');
  var sidebar=document.querySelector('.sidebar');
  if(menu&&sidebar){
    var overlay=document.createElement('div');overlay.className='bo-sidebar-overlay';document.body.appendChild(overlay);
    menu.addEventListener('click',function(){sidebar.classList.toggle('bo-open');overlay.classList.toggle('show')});
    overlay.addEventListener('click',function(){sidebar.classList.remove('bo-open');overlay.classList.remove('show')});
  }

  document.querySelectorAll('.password-wrap input[type="password"]').forEach(function(input){
    var button=document.createElement('button');button.type='button';button.className='password-toggle';button.setAttribute('aria-label','Mostrar palavra-passe');button.innerHTML='<i class="mdi mdi-eye"></i>';input.parentNode.appendChild(button);
    button.addEventListener('click',function(){var show=input.type==='password';input.type=show?'text':'password';button.innerHTML='<i class="mdi mdi-eye'+(show?'-off':'')+'"></i>'});
  });

  document.querySelectorAll('.alert').forEach(function(alert){setTimeout(function(){alert.style.transition='.25s';alert.style.opacity='0';alert.style.transform='translateY(-6px)';setTimeout(function(){alert.remove()},250)},5000)});

  document.querySelectorAll('form').forEach(function(form){form.addEventListener('submit',function(){var submit=form.querySelector('[type="submit"]');if(submit&&!submit.disabled){submit.disabled=true;submit.dataset.originalText=submit.innerHTML;submit.innerHTML='Aguarde...';setTimeout(function(){submit.disabled=false;submit.innerHTML=submit.dataset.originalText},4000)}})});

  var searchInputs=document.querySelectorAll('.bo-search input[name="search"]');
  searchInputs.forEach(function(input){input.addEventListener('keydown',function(e){if(e.key==='Escape'){input.value='';input.form.submit()}})});
});