/**
 * A node in the DOM tree.
 *
 * @external Node
 * @see {@link https://developer.mozilla.org/en-US/docs/Web/API/Node Node}
 */

// Defining the appropriate reset actions
var allowedResetVals=["set-class","set-val","no-val","remove"];

/**
* Sets a hidden Input to the form with a specific name and value
* @param {String} name The name of the inputElement
* @param {String} value The value of the inputElement
* @param {String} onResetAction What to do when reset has been triggered
* @param {String} onResetValue Depending the cation what value to set
*/
var appendHiddenInput=function(name,value,onResetAction,onResetValue){

  var input=null;
  if($("input[name="+name+"]").length>0) {
    input="input[name="+name+"]";
    $(input).val(value);
  } else {
    input= document.createElement("input");
    input.type='hidden';
    input.name=name;
    input.value=value;
    $("#registrationForm").append(input);
  }

  if(onResetAction){
    setRetetAttributes(input,onResetAction,onResetValue);
  }
}

/**
* Bootsrtaping the attributes whyen reset is occured
* @param {Node | String} element The element to get bootstrapped with parameters (required)
* @param {String} onResetAction The action that is needed to be executed when reset is occured (required)
* @param {String} onResetValue Depending the action it may need to provide some value
*
* @throws {Error} In case when an invalid action has been provided or an action that needs a value does not have one
*/
var setRetetAttributes=function(element,onResetAction,onResetValue){

  onResetAction=onResetAction.toLowerCase();

  if($.inArray(onResetAction,allowedResetVals)!==-1) {

    $(element).attr('data-on-reset',onResetAction);

    if(onResetAction==='set-class' || onResetAction==='set-val'){

      if(!onResetValue) {
        throw Error('The action '+onResetAction+" requires a value to get provided");
      }

      $(element).attr('data-on-reset-value',onResetValue);
    }

  } else {
    throw Error("The data-on-reset value should be either one of the following values: "+allowedResetVals.toString()+" but you provided the value (converted in lower case): "+onResetAction);
  }

}

/**
* Function that updates the hidden input for the identiry origin
* @param {Node} element The element that has been selected
* @param {String} country The country that has been selected
*/
var selectCountry=function(element,country){

  appendHiddenInput('idType',country);
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
  $('#replaceWithImage span').css("display","none");
  $('#replaceWithImage img').remove();
  $('#replaceWithImage').append("<img src=\""+base64Img+"\"/>");
  appendHiddenInput('imgBase64',base64Img,'remove');
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

  return $.inArray(value, falseValues) === -1
}

/**
* Stripping html Content
* @param {String} string An html dirty string
* @return {String} without any html content
*/
var stripHtml=function(string){
  var div = document.createElement("div");
  div.innerHTML = string;
  return div.innerText;
}

/**
* Trigger the printing of the iframe
*/
var printPaperApplciationForm=function(){
  window.frames["displayRegistationPaperApplication"].focus();
  window.frames["displayRegistationPaperApplication"].print();
}

/**
* Change the dom to the next step
* @param {Node} currentElement The element shown to the current step
*/
var nextStep = function(currentElement) {
  var idToScrollTo=$(currentElement).attr('data-scroll-to');
  $("#"+idToScrollTo).removeClass('d-none');
  // $("#"+idToScrollTo).animatescroll({scrollSpeed:2000,easing:'easeInQuad'});
}


/**
* Write content to an Iframe
* @param {String} id The id of the iframe
* @param {String} content The content to write into the iframe
*/
var writeContentToIframe=function(id,content){
  var iframeElementContainer = document.getElementById(id).contentDocument;
  iframeElementContainer.open();
  iframeElementContainer.writeln(content);
  iframeElementContainer.close();
}

$(document).ready(function(){

  var qrValueInputNames=$('input[data-qr="true"]').map(function(){
    return this.name;
  }).get();


  $('#selectSignature').on("change",function(e){
    e.preventDefault()
    encodeImageFileAsURL(e.target,setImageValues);
  });

  $('#registrationForm').on("submit",function(e){
    e.preventDefault();
    var self=this
    var values=$(this).serializeArray();

    var qrCodeValues={};
    var valuesToRender={};
    var signatureImage=null;

    //Setting the values
    $.each(values,function(index,item){
      console.log(item);

      // In order to prevent XSS we convert the values into their plaintext form
      item.value=stripHtml(item.value);

      if(item.name==='imgBase64'){
          valuesToRender['signature']=item.value;
      } else {
        valuesToRender[item.name]=item.value;
      }

      if($.inArray(item.name, qrValueInputNames) !== -1){
          qrCodeValues[item.name]=item.value;
      }
    });

    var qrious=new QRious({ size: 200, value: JSON.stringify(qrCodeValues)})
    valuesToRender.qrCodeImg=qrious.toDataURL();

    var tmpl = $.templates('#registationPaperApplication');
    var html= tmpl.render(valuesToRender);

    // var iframeElementContainer = document.getElementById('displayRegistationPaperApplication').contentDocument;
    // iframeElementContainer.open();
    // iframeElementContainer.writeln(html);
    // iframeElementContainer.close();

    writeContentToIframe("displayRegistationPaperApplication",html)
    nextStep(this);
  });

});
