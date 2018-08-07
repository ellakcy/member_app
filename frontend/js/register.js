
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

var encodeImageFileAsURL = function(cb) {
    return function(){
        var file = this.files[0];
        var reader  = new FileReader();
        reader.onloadend = function () {
            cb(reader.result);
        }
        reader.readAsDataURL(file);
    }
}

var setImageValues=function(base64Img){

}

$('#inputFileToLoad').change(encodeImageFileAsURL(function(base64Img){
    $('.output')
      .find('textarea')
        .val(base64Img)
        .end()
      .find('a')
        .attr('href', base64Img)
        .text(base64Img)
        .end()
      .find('img')
        .attr('src', base64Img);
}));


$('#registrationForm').on("submit",function(e){
  e.preventDefault();
  var form=$(this);
  var formData=form.serialize();
  console.log(formData);
});
