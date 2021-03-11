
@extends('/default_contents')




@section('content')

@php

$triggers_temp =  DB::table('triggers')->where('trigger_id', '>', 0)->where('trigger_belong_to', '=', 'qus')->orWhere('trigger_belong_to', '=', 'all')->get();



@endphp


<div class="breadcrumbs">
		<section class="container">
			<div class="row">
				<div class="col-md-12">
					<h1>Post a Comment</h1>
				</div>
				<div class="col-md-12">
					<div class="crumbs">
						<a href="/">Home</a>
						<!-- <span class="crumbs-span">/</span>
						<a href="#">Pages</a> -->
						<span class="crumbs-span">/</span>
						<span class="current">Post a Comment</span>
					</div>
				</div>
			</div><!-- End row -->
		</section><!-- End container -->
	</div><!-- End breadcrumbs -->
	@if (Session::has('message'))
		<div class="alert alert-info" style="text-align: center;">
		 <p class="">{{ Session::get('message') }}</p>

		</div>
	@endif	
	<section class="container main-content">
		<div class="row">
			<div class="col-md-9">
				
				<div class="page-content ask-question">
					<div class="boxedtitle page-title"><h2>Post a Comment</h2></div>
					
					<p>Your comment might relate to any of these possibilities.  Before typing your comment below, check all of these that you think apply. </p>
					
					<div class="form-style form-style-3" id="question-submit">
						 <form id="form-id" class="form-horizontal" method="POST" enctype="multipart/form-data" action="{{ action('QAController@add_new_query') }}">
    
     						<input name="_token" type="hidden" value="{{ csrf_token() }}"/>
							<div class="form-inputs clearfix">

								<p style="margin-bottom: 0px!important">
									<label style="font-size: 18px!important;" class="required"> Topics<span>*</span></label><p style="margin-bottom: 0px!important"></p>
										
									  <div class="row">
									    <div class="col-sm-2">
									      
									    </div>
									    <div class="col-sm-10">

									    	@php
									    		$type_qus_triggers =  DB::table('triggers')->where('trigger_id', '>', 0)->where('trigger_belong_to', '=', 'qus')->orWhere('trigger_belong_to', '=', 'all')->select('trigger_header')->distinct()->get();
									    		#echo $type_qus_triggers;
	
									    	@endphp
									    	@for ($j = 0; $j < count($type_qus_triggers); $j++)
										    	<p>{{$type_qus_triggers[$j]->trigger_header}}</p>


												@php
													
													$triggers =  DB::table('triggers')->where('trigger_header', '=', $type_qus_triggers[$j]->trigger_header)->get();
													

												@endphp									    	
										    	
												@for ($i = 0; $i < count($triggers); $i++)
													<div class="row">
														<div class="col-sm-6">

															@if($i < count($triggers))

																<input type="checkbox"  value="{{$triggers[$i]->trigger_id}}" name="triggers[]">{{$triggers[$i]->trigger}}<br><br>

															@endif
										      
										    			</div>
										    			<div class="col-sm-6">
										    			@php
																$i = $i+1;
																@endphp	
															@if($i < count($triggers))
																

																<input type="checkbox"  value="{{$triggers[$i]->trigger_id}}" name="triggers[]">{{$triggers[$i]->trigger}}<br><br>

															@endif


										      
										    			</div>

													</div>

													



													
												
												@endfor
											@endfor
											 
									    </div>
									     <span style="opacity: 0.5;"class="form-description">You can select mutiple topics.</span>
									   
									  </div>

									 



									
								
									
								</p>
								  <div class="row">
								    
								     <div class="col-sm-12">
								     		<input type="text" class="input" name="custom_topics" id="custom_topics" placeholder="You can add custom topics. After writing a topic name click the 'ENTER' button." data-role="tagsinput">
								     </div>
								     <br>

								     
								 </div>

								 <br>
								  <div style="display: none;" class="row">
								    
								     <div class="col-sm-12">
								     		<input type="text" class="input" name="custom_topics1" id="custom_topics1" placeholder="You can add custom topics. After writing a topic name click the 'ENTER' button." data-role="tagsinput">
								     </div>
								     <br>

								     
								 </div>

															

								<input type="hidden" id="posted_unix_time" name="posted_unix_time" />
								<p>
									<label style="font-size: 18px!important;" class="required"> Give Your Comment a Title<span>*</span></label>
									<input maxlength="180" type="text" id="question-title" name="post_title" >
									<span class="form-description">Please choose an appropriate title for the comment to reply it even easier.</span>
								</p>

									<div style="display: none;" id="related_comment">
										<p style="font-size: 18px!important;" class="required"> Related Comments/Posts</p>									
										

											<ul>
											  <li><a href=''>f<a></li>
											  <li><a href=''>f<a></li>
											  <li><a href=''>f<a></li>
											</ul> 
									

									</div>	
								

								<div id="form-textarea">
									<p>
										<label style="font-size: 18px!important;" class="required">Details<span>*</span></label>
										<textarea required name="post" id="question-details" aria-required="true" cols="58" rows="8"></textarea>
										<span class="form-description">Type the description thoroughly and in detail .</span>
									</p>
								</div>




								








								<p>
									<label  style="font-size: 15px!important;" class="">Keyword(s)/Tag(s) <span>*</span></label>



									<input autocomplete="off" type="text"   class="input" name="question_tags" id="question_tags" data-seperator=",">

								








									<span class="form-description">Please choose few suitable keywords Ex : <span class="color">blur , broken, etc.</span> to describe your comment. After writing/selecting a keyword, click 'ENTER' button. You can add mutiple keywords.</span>
								</p>
								<p style="display: none;" >
									<label class="required">Trigger<span>*</span></label>
									<span class="styled-select">
										<select style =" font-size:18px;" id='selected_trigger'>
											<option value="">Select a Trigger</option>
											@foreach($triggers as $trigger=>$value)
												<option value="{{$value->trigger_id}}">{{$value->trigger}}</option>
											@endforeach
											
										</select>
									</span>
									<span class="form-description">Please choose the appropriate section so easily search for your question .</span>
								</p>
								<p style="display: none;" class="question_poll_p">
									<label for="question_poll">Poll</label>
									<input type="checkbox" id="question_poll" value="1" name="question_poll">
									<span class="question_poll">This question is a poll ?</span>
									<span class="poll-description">If you want to be doing a poll click here .</span>
								</p>
								<div class="clearfix"></div>
								<div style="display: none;"class="poll_options">
									<p class="form-submit add_poll">
										<button id="add_poll" type="button" class="button color small submit"><i class="icon-plus"></i>Add Field</button>
									</p>
									<ul id="question_poll_item">
										<li id="poll_li_1">
											<div class="poll-li">
												<p><input id="ask[1][title]" class="ask" name="ask[1][title]" value="" type="text"></p>
												<input id="ask[1][value]" name="ask[1][value]" value="" type="hidden">
												<input id="ask[1][id]" name="ask[1][id]" value="1" type="hidden">
												<div class="del-poll-li"><i class="icon-remove"></i></div>
												<div class="move-poll-li"><i class="icon-fullscreen"></i></div>
											</div>
										</li>
									</ul>
									<script> var nextli = 2;</script>
									<div class="clearfix"></div>
								</div>
								
								<label style="display: none;">Attachment</label>
								<div style="display: none;" class="fileinputs">
									<input type="file" class="file">
									<div class="fakefile">
										<button type="button" class="button small margin_0">Select file</button>
										<span><i class="icon-arrow-up"></i>Browse</span>
									</div>
								</div>
								
							</div>

							<p>
								<label style="font-size: 18px!important;" > Reference URL<span> *</span></label>
								<input type="text" id="question-title" name="reference_url" value="{{$reference_url}}" >
								<span class="form-description">You can add a URL here, it will be a reference for this post.</span>
							</p>

				        	@if(Auth::check())

				        		<p class="form-submit">
									<input type="button" id="publish-question" value="Publish Your Comment" class="button color small submit">
								</p>
				        	@else
				        		<input  onclick='needLogin()' type="button" id="need_login" value="Login First" class="button small color">
				        	@endif


						</form>
					</div>
				</div><!-- End page-content -->
			</div><!-- End main -->
			<aside class="col-md-3 sidebar">
				<div style="display: none;" class="widget widget_stats">
					<h3 class="widget_title">Stats</h3>
					<div class="ul_list ul_list-icon-ok">
						@php
							$no_ques = DB::table('posts')->get()->count();
							$no_anses = DB::table('comments')->get()->count();
						@endphp
						<ul>
							<li><i class="icon-question-sign"></i>Questions ( <span>{{$no_ques}}</span> )</li>
							<li><i class="icon-comment"></i>Answers ( <span>{{$no_anses}}</span> )</li>
						</ul>
					</div>
				</div>
				
				<div style="display: none;" class="widget widget_social">
					<h3 class="widget_title">Find Us</h3>
					<ul>
						<li class="rss-subscribers">
							<a href="#" target="_blank">
							<strong>
								<i class="icon-rss"></i>
								<span>Subscribe</span><br>
								<small>To RSS Feed</small>
							</strong>
							</a>
						</li>
						<li class="facebook-fans">
							<a href="#" target="_blank">
							<strong>
								<i class="social_icon-facebook"></i>
								<span>5,000</span><br>
								<small>People like it</small>
							</strong>
							</a>
						</li>
						<li class="twitter-followers">
							<a href="#" target="_blank">
							<strong>
								<i class="social_icon-twitter"></i>
								<span>3,000</span><br>
								<small>Followers</small>
							</strong>
							</a>
						</li>
						<li class="youtube-subs">
							<a href="#" target="_blank">
							<strong>
								<i class="icon-play"></i>
								<span>1,000</span><br>
								<small>Subscribers</small>
							</strong>
							</a>
						</li>
					</ul>
				</div>
				
				<div style="display: none;" class="widget widget_login">
					<h3 class="widget_title">Login</h3>
					<div class="form-style form-style-2">
						<form>
							<div class="form-inputs clearfix">
								<p class="login-text">
									<input type="text" value="Username" onfocus="if (this.value == 'Username') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Username';}">
									<i class="icon-user"></i>
								</p>
								<p class="login-password">
									<input type="password" value="Password" onfocus="if (this.value == 'Password') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Password';}">
									<i class="icon-lock"></i>
									<a href="#">Forget</a>
								</p>
							</div>
							<p class="form-submit login-submit">
								<input type="submit" value="Log in" class="button color small login-submit submit">
							</p>
							<div class="rememberme">
								<label><input type="checkbox" checked="checked"> Remember Me</label>
							</div>
						</form>
						<ul class="login-links login-links-r">
							<li><a href="#">Register</a></li>
						</ul>
						<div class="clearfix"></div>
					</div>
				</div>
				
				<div style="display: none;" class="widget widget_highest_points">
					<h3 class="widget_title">Highest points</h3>
					<ul>
						<li>
							<div class="author-img">
								<a href="#"><img width="60" height="60" src="http://placehold.it/60x60/FFF/444" alt=""></a>
							</div> 
							<h6><a href="#">admin</a></h6>
							<span class="comment">12 Points</span>
						</li>
						<li>
							<div class="author-img">
								<a href="#"><img width="60" height="60" src="http://placehold.it/60x60/FFF/444" alt=""></a>
							</div> 
							<h6><a href="#">vbegy</a></h6>
							<span class="comment">10 Points</span>
						</li>
						<li>
							<div class="author-img">
								<a href="#"><img width="60" height="60" src="http://placehold.it/60x60/FFF/444" alt=""></a>
							</div> 
							<h6><a href="#">ahmed</a></h6>
							<span class="comment">5 Points</span>
						</li>
					</ul>
				</div>
				
				<div class="widget widget_tag_cloud">
					<h3 class="widget_title">Tags</h3>
					@php
						 $tagList = DB::table('tags')->get();

					@endphp


					<div style="display: flex;flex-direction: row; flex-wrap: wrap;width: auto;">
						@foreach($tagList as $tag=>$value)
							 <form id="form-tagid-{{$value->tag_id}}" method="GET" action="{{ action('QAController@search_with_tag') }}">

							 	<input type="hidden" name="tag_id" value="{{$value->tag_id}}"/>
									<a style="cursor: pointer;" data-id = "{{$value->tag_id}}" class="tag_button_class"  ><p>{{$value->tag}}</p>
									</a>
							</form>
				


						@endforeach
					</div>
				</div>

				@php

					$recentTwoPosts= DB::table('posts')->limit(2)->orderBy('post_id', 'DESC')->get();
				@endphp
				
				<div   class="widget">
					<h3 class="widget_title">Recent Comments</h3>
					<ul class="related-posts">
						@foreach($recentTwoPosts as $tag=>$value)
							<li class="related-item">
								<h3><a href="/query/{{$value->post_id}}">{{$value->post_title}}</a></h3>
								<!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p> -->
								<div class="clear"></div><span>{{$value->posted_unix_time}}</span>
							</li>
						@endforeach
					</ul>
				</div>
				
			</aside><!-- End sidebar -->
		</div><!-- End row -->
	</section><!-- End container -->

@endsection	 	
@section('page-script')	


<script>
$(function() {

	$("#posted_unix_time").val(get_date_time());
 });	


$("#question-title").keyup(function(){

	query_title = $( "#question-title" ).val();

	if((query_title.length %7)==0){

		get_related_quries(query_title);
	}


  
});




function get_related_quries(query_title){

         $.ajax({
            url: "/get_related_quries_for_ask_query_title",
            cache: false,

            data: {
              query_title: query_title.trim(),

                 
              submit_check_1: "submit_check_1"


            },
            type: 'GET',
            async: false,
            success: function (data) {
              //console.log("Success");
              console.log(data);
              $("#related_comment").empty(); 
             
              result = data;

              if(Array.isArray(result) && result.length){
              	
				//console.log("TM");
              	//console.log(result[0]['post_title']);
              	previous_val = $( '#related_comment' ).html();
              	$('#related_comment').html(previous_val + "<p style='font-size: 18px!important;'> Related Comments/Posts</p><ul>");
              	
				var i;
				for (i = 0; i < result.length; i++) {
				  
				  previous_val = $( '#related_comment' ).html();
				  $('#related_comment' ).html(previous_val + "<li style='cursor: pointer!important;'><a target='_blank' href='query/"+ result[i]['post_id'].toString()+"'>"+result[i]['post_title']+"<a></li>" )
				} 

				previous_val = $( '#related_comment' ).html();
				$('#related_comment').html(previous_val + "</ul><br>");

				document.getElementById("related_comment").style.display = "block";

              }else{

              	//console.log("Nothing");
              	document.getElementById("related_comment").style.display = "none";
              	$("#related_comment").empty(); 
              }

           /*   $('#related_comment').html("<p style='font-size: 18px!important;'> Related Comments/Posts</p><ul>");


									
									

										
										  <li><a href=''>f<a></li>
										  <li><a href=''>f<a></li>
										  <li><a href=''>f<a></li>
										</ul> */

       
             

              },

               error: function (jqXHR, status, err) {
                  
                  //location.reload(true);
	              
	              //window.location.href = "/ask_query";  
	              document.getElementById("related_comment").style.display = "none";

	              $("#related_comment").empty();    
	                         

                }
            })

}

function needLogin(){


  // alert( $(this).data('parent-id') );
  current_page = window.location.pathname;
	redirect_to = window.location.href;
    //"query/"+current_post_id;
   // alert(redirect_to);
  current_page_query = current_page.split('/').reverse()[1];
  current_page = current_page.split('/').reverse()[0];
  if(current_page_query == "query"){
    current_post_id = $('.current_post_id').text().toString();
    redirect_to = window.location.href;
    //"query/"+current_post_id;
    //alert(redirect_to);
  
    need_to_login(redirect_to);

  }else if(current_page =="ask_query"){
  	need_to_login(redirect_to);

  }
  



}

$( ".tag_button_class" ).click(function() {
  //alert( );
  event.preventDefault();
  class_form = 'form-tagid-'+  $(this).attr("data-id");

  document.getElementById(class_form).submit();
});

$( "#publish-question" ).click(function() {


	trigger = document.getElementById("selected_trigger");
	trigger = trigger.options[trigger.selectedIndex].value;
	question_tags = $( "#question_tags" ).val();
	title = $( "#question_tags" ).val();
	question_title = $( "#question-title" ).val();
	question_details = $( "#question-details" ).val();

	var form = document.getElementById("form-id");
      checked = $("input[type=checkbox]:checked").length;

     
    

	if((1)&&(1)&&(question_title !="")&&(question_details !="")){

		 form.submit();
		//document.getElementById("question_tags");

		//insert_data_query(question_title,question_tags,trigger,question_details);
		//alert(question_tags);
	}else{
		alert("Data missing")
	}

});

function insert_data_query(question_title,question_tags,trigger,question_details){

         $.ajax({
            url: "/add_new_query",
            cache: false,

            data: {
              post_title: question_title.trim(),
              trigger_id: trigger.trim(),
              post: question_details.trim(),
              question_tags: question_tags.trim(),
              posted_unix_time: get_date_time(),
                 
              submit_check_1: "submit_check_1"


            },
            type: 'GET',
            async: false,
            success: function (data) {
              //console.log("Success");
              console.log(data);
             
              result = data;
              alert("Inserted");
              window.location.href = "/";
             

              },

               error: function (jqXHR, status, err) {
                  
                  //location.reload(true);
	              alert("Try Again");
	              //window.location.href = "/ask_query";                  

                }
            })

}

// function myFunction(){

// 	alert("s");

// 	auto_width(this);
// }


// 			var auto_width = function(input)
// 			{
// 				//shadow'un icini dolduruyoruz, space'leri nbsp yapmamiz gerekiyor, sondaki ve bastaki bosluklar gelmiyor yoksa.
// 				shadow.html(jQuery(input).val().replace(/\s/g,'&nbsp;'));
// 				//sonda ne kadar free alan eklenecek? bosken 8 doluyken 10 iyi.
// 				var zone = (jQuery(input).val() == ''?8:10);
// 				//width'i uygula
// 				jQuery(input).width(shadow.width() + zone);
// 			};


</script>

<style type="text/css">
	
.bootstrap-tagsinput .tag [data-role="remove"]:after {
    content: "x";
    padding: 0px 2px;
    cursor: pointer;
}
.label-info{

	background-color: #1bbc9b;
}

</style>
@endsection	