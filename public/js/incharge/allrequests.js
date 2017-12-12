$(document).ready(function(){
  $('select').on('change', function(){
    console.log($(this).val());
    if($(this).val()!=''){
      $(location).attr('href', '/incharge/allRequests?sort='+$(this).val());
    }
  });
});
