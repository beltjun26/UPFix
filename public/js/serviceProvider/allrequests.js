$(document).ready(function(){
  $('select').on('change', function(){
    console.log($(this).val());
    if($(this).val()!=''){
      $(location).attr('href', '/serviceProvider/allRequests?sort='+$(this).val());
    }
  });
});
