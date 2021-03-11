@extends('/default_contents')




@section('content')
<div class="container-fluid">
    <div class="row  ">
     
      <div  class="col-sm-12  game_area">

      <div class="row  center">
         <div  class="col-sm-2 ">
               
         </div>
         <div  class="col-sm-8 ">

          <div id="upper_text_area" class="row  ">
             <div  align="center" class="col-sm-12">
            
             </div>
          </div>
          <div id="video_objects" class="row  ">
             <div align="center" class="col-sm-12">
             		<img src="{{url('ask_me/images/Logo.png')}}" alt="Paris">



 		            <form id="search_form" method="GET" action="{{ action('QAController@search_index') }}">
		                      <input style="text-align: center;height: 100px;color:black;font-size:1.0em;width: 100%;font-size: 20px;" type="text" autocomplete="off" data-id='study' onkeyup="dummy_function(document.getElementById('search').value)" name="search" id="search" placeholder="Type & Search" class=" search_by_study ">
		                      <button style="display: none;" type="submit" class="search-submit" ></button>

		                      <p style="color: black;font-size: 18px;">When you will type in the above search box, sometimes you will be shown different types of suggestions. You can select from those suggestions to search or you can disregard the suggestions and type a word/string of words. After that, click the 'ENTER'/'SEARCH' button from the keyboard. The latter type of search will return all the posts that have the word/string of words in them. The same thing will happen when you pick a suggestion that ends with '- Word'.</p>
		            </form> 
            
             </div>
          </div>
          <div id="lower_text_area" class="row  ">
             <div align="center" class="col-sm-12">
              <br><br>


             </div>
          </div>

         </div>
         <div  class="col-sm-2 ">


         </div>
      </div>





      </div>


</div>

@endsection	 	



@section('page-script')	



<script>
	

    $(function() {

        var w = window.innerWidth;
        var h = window.innerHeight;
        $(".game_area").height(h);
        $(".game_area").width(w);


        var upper_text_area;
        var video_objects;
        var lower_text_area;

        upper_text_area = h * (15/100);
        video_objects = h * (70/100);
        lower_text_area = h * (15/100);

        document.getElementById('upper_text_area').setAttribute("style","height:" + upper_text_area +"px");
        document.getElementById('video_objects').setAttribute("style","height:" + video_objects +"px");
        document.getElementById('lower_text_area').setAttribute("style","height:" + lower_text_area +"px");       
        document.getElementById('video_demo').setAttribute("style","width:" + document.getElementById("video_objects").offsetWidth +"px"); 
        
      //  document.getElementById('container').setAttribute("style","width:" + w +"px");



        
    });



</script>



<style type="text/css">
	
.dropdown-item{

	font-size: 18px;
}



</style>
@endsection	