jQuery("document").ready(function(){
    
$('#id=powermail_field_country').change(function () {
   if (!('#powermail_fieldwrap_14').hasClass('hide')){
       countrytext = $("#powermail_fieldwrap_14").html();
       $("#powermail_field_cbverstecktesfeld").val(countrytext);
       
   } 
});
    

      
}); //End jquery

