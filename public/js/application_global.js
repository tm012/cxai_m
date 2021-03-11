

 function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
      var c = ca[i];
      while (c.charAt(0)==' ') c = c.substring(1,c.length);
      if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
  }


function delete_cookie( name ) {
  document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}

function sleep(milliseconds) {
  var start = new Date().getTime();
  for (var i = 0; i < 1e7; i++) {
    if ((new Date().getTime() - start) > milliseconds){
      break;
    }
  }
}


function abc_tm(lub){

     // var productNames = getEmployeeName("study");
    console.log(lub);
    if(lub == "custom_topics"){
                var productNames= custom_topics_array;
                console.log(productNames);

                classname= '.abc'+lub;


                $(classname).typeahead({


                  source: productNames,
                  items : 5,
                  // minLength : 3,
                  autoSelect: false,      
                });   

    }

    if(lub == "custom_topics1"){
        console.log("inside");
            var productNames = ["Afghanistan-Tag","Albania","Algeria","Andorra","Angola","Anguilla","Antigua & Barbuda"];
          // getproblemName();

          classname= '.abc'+lub;


          $(classname).typeahead({


            source: productNames,
            items : 5,
            // minLength : 3,  
            autoSelect: false,    
          });




         console.log("f");

      
    }
    if((lub == "question_tags1") && (1)){

                var productNames= tag_array;

                console.log(productNames);

                classname= '.abc'+lub;


                $(classname).typeahead({


                  source: productNames,
                  items : 5,
                  // minLength : 3, 
                  autoSelect: false,     
                });  


    }
    


     


}


function get_date_time(){


          var currentdate = new Date(); 
          var datetime =  
                        (currentdate.getMonth()+1)  + "/"
                        + currentdate.getDate() + "/" 
                        + currentdate.getFullYear() + "  "  
                        + currentdate.getHours() + ":"  
                        + currentdate.getMinutes() + ":" 
                        + currentdate.getSeconds();

          return datetime;
}


function need_to_login(redirect_to){
    //alert(redirect_to);


         $.ajax({
            url: "/need_to_login",
            cache: false,

            data: {
              redirect_to: redirect_to,
                 
              submit_check_1: "submit_check_1"


            },
            type: 'GET',
            async: false,
            success: function (data) {
              //console.log("Success");
              console.log(data);
             
              result = data;
              window.location.href = "/login";

              },

               error: function (jqXHR, status, err) {
                  
                  //location.reload(true);

                }
            })


}




