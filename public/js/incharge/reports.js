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
      $(location).attr('href', '/incharge/reports?category=all&year'+ $('#year').val());
    }
    if($(this).val()=='half_year'){
      $('#sort').prop('disabled', false);
      $('.default').prop('selected', true)
      $('.monthly').hide();
      $('.half').show();
    }
  });
  $('#year').on('change', function(){
    if($('#category').val()=='all'){
      $(location).attr('href', '/incharge/reports?category='+$('#category').val()+'&year='+$('#year').val());
    }else{
      $(location).attr('href', '/incharge/reports?category=monthly&sort='+$('#sort').val()+'&year='+$('#year').val());
    }
  });

  $('#sort').on('change', function(){
    if($('#sort').val()!=""){
      if($('#category').val()=='monthly'){
        $(location).attr('href', '/incharge/reports?category=monthly&sort='+$(this).val()+'&year='+$('#year').val());
      }
      if($('#category').val()=='half_year'){
        $(location).attr('href', '/incharge/reports?category=half_year&sort='+$(this).val()+'&year='+$('#year').val());
      }
    }
  });
});
