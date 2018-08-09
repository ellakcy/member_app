/**
 * A node in the DOM tree.
 *
 * @external Node
 * @see {@link https://developer.mozilla.org/en-US/docs/Web/API/Node Node}
 */


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

/**
* Function that reads an image as base64 content.
* @param {external:Node} element Html input element
* @param {Function} cb Callback function where the base64 content will get processed
*/
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
  $('#replaceWithImage img').remove();
  $('#replaceWithImage').append("<img src=\""+base64Img+"\"/>");
}


/**
* Convert a value into a boolean
* @param {Mixed} value The value to check convert into boolean
* @return {Boolean}
*/
var boolVal=function(value){
  var falseValues=['false',0,undefined,'0','no','null',null];

  if (typeof value === 'string' || value instanceof String){
      value=value.toLowerCase();
  }

  return $.inArray(value, falseValues) == -1
}

var jsonForQR={};

$(document).ready(function(){
  $('#selectSignature').on("change",function(e){
    e.preventDefault()
    encodeImageFileAsURL(e.target,setImageValues);
  });

  $('.valuechange').on('change',function(e){
    e.preventDefault();
    var target=e.target;
    var name=$(target).attr('name');
    var value=$(target).val();

    $('*[data-fill="'+name+'"]').text(value);

    if( boolVal( $(target).attr('data-qr') ) ) {
      jsonForQR[name]=value;
    }
  });

  $('#registrationForm').on("submit",function(e){
    e.preventDefault();

    var qrCode=kjua({ render: 'image', width: 200, height: 200, text: JSON.stringify(jsonForQR)})
    $('#scanQr').html(qrCode);

    setTimeout(function(){
      window.print();
    },100)

  });
});
