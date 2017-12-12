$(document).ready(function(){
  $('select').on('change', function(){
    console.log($(this).val());
    if($(this).val()!=''){
      $(location).attr('href', '/chairman/allRequests?sort='+$(this).val());
    }
  });
});
