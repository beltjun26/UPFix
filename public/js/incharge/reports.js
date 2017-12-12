$(document).ready(function(){
  if(category == 'monthly'){
    $('.monthly').show();
    $('.half').hide();
  }
  if(category=='half_year'){
    $('.monthly').hide();
    $('.half').show();
  }
  $('#category').on('change', function(){
    if($(this).val()=='monthly'){
      $('#sort').prop('disabled', false);
      $('.default').prop('selected', true)
      $('.monthly').show();
      $('.half').hide();
    }
    if($(this).val()=='all'){
      $('#sort').prop('disabled', true);
      $('.default').prop('selected', true)
      $(location).attr('href', '/incharge/reports?category=all');
    }
    if($(this).val()=='half_year'){
      $('#sort').prop('disabled', false);
      $('.default').prop('selected', true)
      $('.monthly').hide();
      $('.half').show();
    }
  });
  $('#sort').on('change', function(){
    if($('#sort').val()!=""){
      if($('#category').val()=='monthly'){
        $(location).attr('href', '/incharge/reports?category=monthly&sort='+$(this).val());
      }
      if($('#category').val()=='half_year'){
        $(location).attr('href', '/incharge/reports?category=half_year&sort='+$(this).val());
      }
    }
  });
});
