
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

var encodeImageFileAsURL = function(element,cb) {
    var file = element.files[0];
    var reader  = new FileReader();
    reader.onloadend = function () {
      if(reader.error){
        console.error(reader.error.message);
      } else {
        cb(reader.result);
      }
    }
    reader.readAsDataURL(file);
}

/**
* Retrieve image as Base64 and set it into the approriate elements
* @param {String} base64Img The image contents as base64
*/
var setImageValues=function(base64Img){
  $('*[data-fill="signature"]').html("<img src=\""+base64Img+"\"/>");
  $('#replaceWithImage span').css("display","none");
  $('#replaceWithImage').append("<img src=\""+base64Img+"\"/>");
}

$(document).ready(function(){
  $('#selectSignature').on("change",function(e){
    e.preventDefault()
    console.log("Fired");
    encodeImageFileAsURL(e.target,setImageValues);
  });

  $('.valuechange').on('change',function(e){
    e.preventDefault();
    var target=e.target;
    var name=$(target).attr('name');
    var value=$(target).val();
    console.log(name,value,$('*[data-fill="'+name+'"]'));
    $('*[data-fill="'+name+'"]').text(value);
  });

  $('#registrationForm').on("submit",function(e){
    e.preventDefault();
    window.print();
  });
});
