
var selectCountry=function(element,country){

  if($("input[name=idType]").length>0){

    $("input[name=idType]").val(country)
  } else {

    var input= document.createElement("input");
    input.type='hidden';
    input.name="idType";
    input.value=country;
    $("#registrationForm").append(input);
  }

  var classes=$(element).children(".flag-icon").attr('class');

  $("#flagIndicator").attr('class',classes)
}

$('#registrationForm').submit(function(e){
  e.preventDefault();
  
});
