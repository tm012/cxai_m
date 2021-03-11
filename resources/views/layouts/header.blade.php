 <input type="hidden" id="auth_check" value="{{Auth::check()}}"/>

<div id="wrap" class="grid_1200">
  <div id="login_custom_div">
    <div class="login-panel">
      <section class="container">
        <div class="row">
          <div class="col-md-6">
            <div class="page-content">
              <h2>Login</h2>
              <p>Login with your email and password</p>
               <a href="{{ route('login') }}" class="button color small">Login</a>
      
            </div><!-- End page-content -->
          </div><!-- End col-md-6 -->
          <div class="col-md-6">
            <div class="page-content Register">
              <h2>Register Now</h2>
              <p>Register now to give your input to this collaborative effort</p>
              <!-- <a class="button color small signup">Create an account</a> -->
              <a href="{{ route('register') }}" class="button color small">Create an account</a>
            </div><!-- End page-content -->
          </div><!-- End col-md-6 -->
        </div>
      </section>
    </div><!-- End login-panel -->
    
    <div style="display: none;" class="panel-pop" id="signup">
      <h2>Register Now<i class="icon-remove"></i></h2>
      <div class="form-style form-style-3">
        <form>
          <div class="form-inputs clearfix">
            <p>
              <label class="required">Username<span>*</span></label>
              <input type="text">
            </p>
            <p>
              <label class="required">E-Mail<span>*</span></label>
              <input type="email">
            </p>
            <p>
              <label class="required">Password<span>*</span></label>
              <input type="password" value="">
            </p>
            <p>
              <label class="required">Confirm Password<span>*</span></label>
              <input type="password" value="">
            </p>
          </div>
          <p class="form-submit">
            <input type="submit" value="Signup" class="button color small submit">
          </p>
        </form>
      </div>
    </div><!-- End signup -->
    
    <div style="display: none;" class="panel-pop" id="lost-password">
      <h2>Lost Password<i class="icon-remove"></i></h2>
      <div class="form-style form-style-3">
        <p>Lost your password? Please enter your username and email address. You will receive a link to create a new password via email.</p>
        <form>
          <div class="form-inputs clearfix">
            <p>
              <label class="required">Username<span>*</span></label>
              <input type="text">
            </p>
            <p>
              <label class="required">E-Mail<span>*</span></label>
              <input type="email">
            </p>
          </div>
          <p class="form-submit">
            <input type="submit" value="Reset" class="button color small submit">
          </p>
        </form>
        <div class="clearfix"></div>
      </div>
    </div><!-- End lost-password -->
    
    <div id="header-top">
      <section class="container clearfix">
        <nav class="header-top-nav">
          <ul>
            <li style="display: none;"><a href="contact_us.html"><i class="icon-envelope"></i>Contact</a></li>
          <!--   <li><a href="#"><i class="icon-headphones"></i>Support</a></li> -->
            
            <div id="logout_user">
              @if(Auth::check())
               <li><a style="cursor: none;"><i class="icon-user"></i>{{Auth::user()->name}}</a></li>

               @endif
              
                                    <li>
                                        <a style="cursor: pointer;" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>

             </div>
             <li id="custom_login_panel"><a href="login.html" id="login-panel"><i class="icon-user"></i>Login Area</a></li>
          </ul>
        </nav>
        <div class="header-search">
       <!--    <form>
              <input type="text" value="Search here ..." >
              <button type="submit" class="search-submit"></button>
          </form>
 -->
<!--             <form id="search_form" method="GET" action="{{ action('QAController@search_index') }}">
                      <input style="color:black;font-size:1.0em;width: 500px" type="text" autocomplete="off" data-id='study' onkeyup="dummy_function(document.getElementById('search').value)" name="search" id="search" placeholder="Search By Tags/Topics/Titles/Authors/Words." class=" search_by_study ">
                      <button type="submit" class="search-submit" disabled></button>
            </form>  -->  

        </div>
      </section><!-- End container -->
    </div><!-- End header-top -->
  </div>
  <header id="header">
    <section class="container clearfix">
      <div  style="visibility: hidden;"class="logo"><a href="/"><img alt="" src="{{ asset('/ask_me/images/favicon_updated.png') }}"></a></div>
      <nav class="navigation">
        <ul>
          <li  style="display: none;"><a href="index.html">Home</a>
            <ul>
              <li><a href="index.html">Home</a></li>
              <li><a href="index_2.html">Home 2</a></li>
              <li><a href="index_boxed_1.html">Home Boxed 1</a></li>
              <li><a href="index_boxed_2.html">Home Boxed 2</a></li>
              <li><a href="index_no_box.html">Home No Box</a></li>
            </ul>
          </li>
          <li class="ask_question"><a href="/">Home</a></li>
          <li class="ask_question"><a href="/ask_query">New Post</a></li>
          <li style="display: none;" class="ask_question"><a href="/search_arena">Search</a></li>
          <li  style="display: none;" class="current_page_item"><a href="cat_question.html">Questions</a>
            <ul>
              <li><a href="cat_question.html">Questions Category</a></li>
              <li class="current_page_item"><a href="single_question.html">Question Single</a></li>
              <li><a href="single_question_poll.html">Poll Question Single</a></li>
            </ul>
          </li>
          <li  style="display: none;"><a href="user_profile.html">User</a>
            <ul>
              <li><a href="user_profile.html">User Profile</a></li>
              <li><a href="user_questions.html">User Questions</a></li>
              <li><a href="user_answers.html">User Answers</a></li>
              <li><a href="user_favorite_questions.html">User Favorite Questions</a></li>
              <li><a href="user_points.html">User Points</a></li>
              <li><a href="edit_profile.html">Edit Profile</a></li>
            </ul>
          </li>
          <li  style="display: none;"><a href="blog_1.html">Blog</a>
            <ul>
              <li><a href="blog_1.html">Blog 1</a>
                <ul>
                  <li><a href="blog_1.html">Right sidebar</a></li>
                  <li><a href="blog_1_l_sidebar.html">Left sidebar</a></li>
                  <li><a href="blog_1_full_width.html">Full Width</a></li>
                </ul>
              </li>
              <li  style="display: none;"><a href="blog_2.html">Blog 2</a>
                <ul>
                  <li><a href="blog_2.html">Right sidebar</a></li>
                  <li><a href="blog_2_l_sidebar.html">Left sidebar</a></li>
                  <li><a href="blog_2_full_width.html">Full Width</a></li>
                </ul>
              </li>
              <li  style="display: none;"><a href="single_post.html">Post Single</a>
                <ul>
                  <li><a href="single_post.html">Right sidebar</a></li>
                  <li><a href="single_post_l_sidebar.html">Left sidebar</a></li>
                  <li><a href="single_post_full_width.html">Full Width</a></li>
                </ul>
              </li>
            </ul>
          </li>
          <li  style="display: none;"><a href="right_sidebar.html">Pages</a>
            <ul>
              <li><a href="login.html">Login</a></li>
              <li><a href="contact_us.html">Contact Us</a></li>
              <li><a href="ask_question.html">Ask Question</a></li>
              <li><a href="right_sidebar.html">Right Sidebar</a></li>
              <li><a href="left_sidebar.html">Left Sidebar</a></li>
              <li><a href="full_width.html">Full Width</a></li>
              <li><a href="404.html">404</a></li>
            </ul>
          </li>
          <li  style="display: none;"><a href="shortcodes.html">Shortcodes</a></li>
          <li style="display: none;"><a href="contact_us.html">Contact Us</a></li>
        </ul>
      </nav>
    </section><!-- End container -->
  </header><!-- End header -->

      <script type="text/javascript">
    var search_records;
    function dummy_function(p){
        //alert(search_records[0]);

        //alert(search_records[0].substring(search_records[0].length - 7));
     //  $('.search_by_study').typeahead('destroy');

        search_word = p;
        //d3.select("#search").node().value
        //d3.select("#search_by_d3_search").html(this.value);
       // d3.select(".search_by_d3_search").html(this.value);
        // d3.select(".search_by_study").val();
        //alert(search_word);
        //p;
        //$( "#search" ).val();
        //
        //"Tag";
        //
       // 

        // if(' - Word' == search_records[0].substring(search_records[0].length - 7))
        // {
          
        //  search_records.shift();
        //  search_records.unshift(search_word +" - Word");
        // }else if(search_word == ""){

        // }
        // else{
        //   search_records.unshift(search_word +" - Word");
        // }


      var productNames = search_records;

      // var productNames = ["Afghanistan-Tag","Albania","Algeria","Andorra","Angola","Anguilla","Antigua & Barbuda"];
    // getproblemName();



   

       console.log(search_records[0]);


        $(".search_by_study").typeahead({

          openLinkInNewTab: true,
          source: productNames,
          items : 5,
          delay: 60,
          minLength : 3,   
          autoSelect: false,   
        });




        if (event.keyCode === 13) {
        // Cancel the default action, if needed
          event.preventDefault();
          setTimeout(function(){ document.getElementById("search_form").submit(); }, 100);
        }
    }

    $(function() {
        var current_page ;
        var auth_status;
        search_records = getEmployeeName("study");
      
        current_page = window.location.pathname.split("/").pop();

        if((current_page == "register") || (current_page == "login")|| (current_page == "reset")){
          document.getElementById("login_custom_div").style.display = "none"; 

        }
         auth_status = $('#auth_check').val();

         if(auth_status== "1"){
          document.getElementById("logout_user").style.display = "block";
          document.getElementById("custom_login_panel").style.display = "none"; 
         }else{
          document.getElementById("logout_user").style.display = "none";
          document.getElementById("custom_login_panel").style.display = "block"; 


          
         }

      }); 
  $('form').on('focus','.search_by_study',function(){



  })


  function getEmployeeName(search_type){

    result ="";
    $.ajax({


      url: "/search_home",
      data: {

        search_type: search_type,
        submit_check_1: "submit_check_1"


      },
      type: 'GET',
      async: false,
      success: function (data) {
        console.log("Success");
        console.log(data);
        result = data;

      }
    })


    var jsonData=  result;
    console.log("TM");
   // console.log(jsonData);
   // console.log(search_type);
    //ajaxToPass("/job_cards/get_problem_name.json", "" , "get");

    var productNames = new Array();
    

      $.each( jsonData, function ( index, product )
      {
        //console.log("Name" + product.search);
        productNames.push( product.search );

      } );
    



      console.log(productNames);

    return productNames;
  }



</script>

<style>
::placeholder {
  color: black;
  opacity: 1; /* Firefox */
}

:-ms-input-placeholder { /* Internet Explorer 10-11 */
 color: red;
}

::-ms-input-placeholder { /* Microsoft Edge */
 color: red;
}

.dropdown-menu > .active > a{
background-color: #1bbc9b;

}

.dropdown-menu > .active > a:focus{
background-color: #1bbc9b;
  
}
.dropdown-menu > .active > a:hover{
background-color: #1bbc9b;
  
}
</style>