$(document).ready(function(){
  $('select').on('change', function(){
    console.log($(this).val());
    if($(this).val()!=''){
      $(location).attr('href', '/client/allRequests?sort='+$(this).val());
    }
  });
});
