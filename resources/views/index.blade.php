@extends('/default_contents')




@section('content')

<p style="display: none;" type="text" class="last_post_id_to_load_recent">{{$last_id}}</p>
<div class="loader"><div class="loader_html"></div></div>
<br>

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
             		<a href='/'><img src="{{url('ask_me/images/Logo.png')}}" alt="Paris"></a>



 		            <form id="search_form" method="GET" action="{{ action('QAController@search_index') }}">
		                      
 		            		<div class="row">
 		            			<div  align="right" class="col-sm-11 "style="margin:0!important;padding:0!important;">
									

									@if(isset($_GET['search']))

										


										@if($_GET['search'] == "answered_queries")	
											<input style="height: 100px;color:black;font-size:1.5em;width: 100%;" type="text" autocomplete="off" data-id='study' onkeyup="dummy_function(document.getElementById('search').value)" name="search" id="search" placeholder="Search...." class=" search_by_study " >
										@else

											<input style="height: 100px;color:black;font-size:1.5em;width: 100%;" type="text" autocomplete="off" data-id='study' onkeyup="dummy_function(document.getElementById('search').value)" name="search" id="search" placeholder="Search...." class=" search_by_study " value="{{$_GET['search']}}">											
										@endif										
									
									@elseif(isset($_GET['tag_id']))

										@php
											$search_placeholder = DB::table('tags')->where('tag_id', $_GET['tag_id'])->value('tag'); 
											$search_placeholder = $search_placeholder . " - Tag";
										


										@endphp

										<input style="height: 100px;color:black;font-size:1.5em;width: 100%;" type="text" autocomplete="off" data-id='study' onkeyup="dummy_function(document.getElementById('search').value)" name="search" id="search" placeholder="Search...." class=" search_by_study " value="{{$search_placeholder}}">	
																	
									@else
										<input style="height: 100px;color:black;font-size:1.5em;width: 100%;" type="text" autocomplete="off" data-id='study' onkeyup="dummy_function(document.getElementById('search').value)" name="search" id="search" placeholder="Search...." class=" search_by_study " >	
									@endif




		                      		
		                      	</div>
		                      	<div  align="left" class="col-sm-1 " style="margin:0!important;padding:0!important;text-align: center;">

		                      		<!-- <button  style="text-align: center;height: 100px;width: 100%;" type="submit" class="search-submit" ></button> -->

		                      		<button class="btn1 success1" style="display:inline-block;text-align: center;height: 100px;width: 100%;" type="submit">
									  <span><i class="fa fa-search center_icon" aria-hidden="true"></i></span>

									</button>
		                      	</div>
		                    </div>

		                      <p style="color: black;font-size: 18px;">If you use a search suggestion for search, that search will find entries whose tag/title/topic/author name will match your search term exactly. You can always disregard the suggestions that will be shown to you and search entries using a word/string of words, this type of search  will bring back search results that have your word/string of words in the results</p>
		                      <p style="font-weight: bold;font-size: 18px;">Use definte keyword/keywords for better search result</p>


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
</div>


@if($_SERVER['REQUEST_URI'] == '/')




	<div style='display: none;' class="container">
	  <div class="row">
	    <div class="col-sm-4">
	      
	    </div>
	    <div class="col-sm-4">
	      <p style="color: #1bbc9b;font-size: 18px;" align="center">This collaborative effort is for a/an</p>
	      <h3 align="center">Image Classification System</h3>
	      <div align="center" >
		      <!-- <a style="font-size: 18px;"href="https://pages.mtu.edu/~shanem/AI-web/aiweb.html" target="_blank">AI Web</a> -->
		      <p style="font-size: 18px;">AI Web</p>
		      <!-- <a href="https://pages.mtu.edu/~shanem/AI-web/watson.html" target="_blank">Watson Images</a> -->
		  </div>
	      
	    </div>
	    <div class="col-sm-4">
	      
	    </div>
	  </div>
	</div>




	<div class="container">
	  <div class="row">
	    <div align="center" class="col-sm-3">
	    	<p style="font-size:18px!important;">Artificial Intelligent systems are not perfect.  They do not really think like people. 
	They may do things that surprise you. 
	Using CrowdCollaboration you can leave behind bread crumbs or signposts. 
	Your postings will help other people understand and work with the Image Classification System.
	</p>
			<p style="color: #1bbc9b;font-size: 18px;" align="center">This collaborative effort is for a/an</p>
	      <h3 align="center">Image Classification System</h3>
	      <div align="center" >
		      <!-- <a style="font-size: 18px;" href="https://pages.mtu.edu/~shanem/AI-web/aiweb.html" target="_blank">AI Web</a> -->
		      <p style="font-size: 18px;">AI Web</p>
		      <!-- <a href="https://pages.mtu.edu/~shanem/AI-web/watson.html" target="_blank">Watson Images</a> -->
		  </div>
	      
	    </div>

	    <div align="center" class="col-sm-9">


		  <div class="row">
		    <div class="col-sm-2">
		      
		    </div>
		    <div class="col-sm-10">
		    	<h3 style="font-weight: 900;text-decoration: underline;font-size: 20px;">Possible Topics</h3>

		    	@php
		    		$type_qus_triggers =  DB::table('triggers')->where('trigger_id', '>', 0)->where('trigger_belong_to', '=', 'qus')->where('trigger_header', '!=', 'Custom Topics-Comments')->orWhere('trigger_belong_to', '=', 'all')->select('trigger_header')->distinct()->get();
		    		#echo $type_qus_triggers;

		    	@endphp
		    	@for ($j = 0; $j < count($type_qus_triggers); $j++)
			    	<p style="font-weight: bold;font-size: 18px;">{{$type_qus_triggers[$j]->trigger_header}}</p>


					@php
						
						$triggers =  DB::table('triggers')->where('trigger_header', '=', $type_qus_triggers[$j]->trigger_header)->get();
						

					@endphp									    	
			    	
					@for ($i = 0; $i < count($triggers); $i++)

						<div class="row">
							<div class="col-sm-6">

								@if($i < count($triggers))

									<p style="text-align: left;font-size: 16px;">{{$i+1}}. <a target="_blank" href="search_index?search={{$triggers[$i]->trigger}} - Topic">{{$triggers[$i]->trigger}}</a></p>

								@endif
			      
			    			</div>
			    			<div class="col-sm-6">
			    			@php
									$i = $i+1;
									@endphp	
								@if($i < count($triggers))
									

									<p style="text-align: left;font-size: 16px;">{{$i+1}}. <a target="_blank" href="search_index?search={{$triggers[$i]->trigger}} - Topic">{{$triggers[$i]->trigger}}</a></p>

								@endif


			      
			    			</div>

						</div>

						



						
					
					@endfor
				@endfor
				 
		    </div>
		   
		  </div>

	      
	    </div>
	  </div>
	</div>
@endif

<br>
	
	<section class="container main-content">
		<div class="row">
			<div class="col-md-9">
				
				<div class="tabs-warp question-tab">
		            <ul class="tabs">
		                <li  class="tab"><a style="cursor: pointer;" href="#" class="current">Post(s)</a></li>
		                @if(($look_for_comment == "Word") || ($look_for_comment =="Words"))
		                	<li class="tab"><a style="cursor: pointer;" href="#">Comment(s)</a></li>
		                @endif
		                <li style='display: none;' class="tab"><a href="#">Top Queries</a></li>
		                <li style='display: none;' class="tab"><a href="#">No answers</a></li>
		            </ul>
		            <div class="tab-inner-warp">
						<div class="tab-inner">

							
							<div id="load_data_recent">
								@if($recent_exists =="1")
									@foreach ($myJSON_recent as $key => $value)
										
										 
										<article class="question question-type-normal">
											<h2>
												<a href="/query/{{$value['post_id']}}">{{$value['post_title']}}</a>
												<p style="font-style: oblique;font-size:18px!important;">{{$value['user_name']}}</p>
											</h2>
											<a class="question-report" style="cursor: none;" href="">Post</a>
											<!-- <div class="question-type-main"><i class="icon-question-sign"></i>Query</div> -->
											<!-- <div class="question-author">
												<a original-title="{{$value['user_name']}}" class="question-author-img "><span></span><img alt="" src="{{$value['user_image_url']}}"></a>
												
											</div> -->

											 <div class="question-author"><img alt="" src="{{$value['user_image_url']}}"></div>
											<div class="question-inner">
												<div class="clearfix"></div>
												<p style='white-space: pre-wrap;' class="question-desc">{{$value['post']}}</p>
												<div class="question-details">
													<!-- <span class="question-answered question-answered-done"><i class="icon-ok"></i>solved</span>
													<span class="question-favorite"><i class="icon-star"></i>5</span> -->
												</div>
												<span style="display: none;" class="question-category"><i class="icon-folder-close"></i>{{$value['trigger_name']}}</span>
												<span class="question-date"><i class="icon-time"></i>{{$value['posted_unix_time']}}</span>
												<span class="question-comment"><i class="icon-comment"></i>{{$value['total_responses']}} Answer(s)</span>
												<!-- <span class="question-view"><i class="icon-user"></i>70 views</span> -->
												<div class="clearfix"></div>
											</div>
										</article>
									@endforeach
									
								@endif
							</div>
							
			
						
							@if($recent_exists =="1")
								@if($search_type =="")
									<div id="load_data_addtioanl_data_recent">
									</div>
									<a style="cursor: pointer;"  id="load-questions_recent" class="load-questions"><i class="icon-refresh"></i>Load More Posts</a>
								@endif
							@endif

<!-- comment part -->	

							
								
							


		                </div>
		            </div>
		            <div class="tab-inner-warp">
						<div class="tab-inner">
@if(($look_for_comment == "Word") || ($look_for_comment =="Words"))

									<!-- <h1>Comment(s)</h1> -->



									@php
									
										if($look_for_comment == "Word"){
									        $myCartComments = DB::table('comments')	         
									              ->where('comments.is_approval', '>=', 0)					
									              ->where('comments.comment', 'LIKE', '%'.$search_type.'%')
									              ->distinct()->orderBy('comments.vote', 'DESC')->get();
									        $myCartComments = $myCartComments->unique();    


										}

										if($look_for_comment == "Words"){

											$search_type = strtolower($search_type);
											$search_item_array = explode(" ",$search_type);


											$remove_items_from_array = array( 'a', 'an', 'the', 'and', 'or', 'but', 'aboard', 'about', 'above', 'across', 'after', 'against', 'along', 'amid', 'among', 'anti', 'around', 'as', 'at', 'before', 'behind', 'below', 'beneath', 'beside', 'besides', 'between', 'beyond', 'but', 'by', 'concerning', 'considering', 'despite', 'down', 'during', 'except', 'excepting', 'excluding', 'following', 'for', 'from', 'in', 'inside', 'into', 'like', 'minus', 'near', 'of', 'off', 'on', 'onto', 'opposite', 'outside', 'over', 'past', 'per', 'plus', 'regarding', 'round', 'save', 'since', 'than', 'through', 'to', 'toward', 'towards', 'under', 'underneath', 'unlike', 'until', 'up', 'upon', 'versus', 'via', 'with', 'within', 'without', '&' );

											$search_item_array = array_diff($search_item_array,$remove_items_from_array);
											$search_item_array = array_values($search_item_array);


									        $myCart7 = DB::table('comments')
									              ->where('comments.is_approval', '>=', 0)
									              ->where('comments.comment', 'LIKE', '%'.$search_type.'%')
									              ->orderBy('comments.vote', 'DESC')
									              ->distinct()->get();

								          	$query = DB::table('comments');
						

								            for ($x = 0; $x < count($search_item_array); $x++) {

								              if($x == 0){
								                  $query =$query->where('comments.comment', 'LIKE', '%'.$search_item_array[$x].'%');
								              }
								              else{
								                  $query = $query->where('comments.comment', 'LIKE', '%'.$search_item_array[$x].'%');
								              }

								              
								            }
								            $myCart11 = $query->where('comments.is_approval', '>=', 0)->orderBy('comments.vote', 'DESC')
								                    ->distinct()->get();

								          	$myCart_temp = $myCart7->merge($myCart11);
								          	$myCart_temp =$myCart_temp->unique(); 									          
									          $query = DB::table('comments');
									             

									            for ($x = 0; $x < count($search_item_array); $x++) {

									              if($x == 0){
									                  $query =$query->where('comments.comment', 'LIKE', '%'.$search_item_array[$x].'%');
									              }
									              else{
									                  $query = $query->orWhere('comments.comment', 'LIKE', '%'.$search_item_array[$x].'%');
									              }

									              
									            }
									            $myCart8 = $query->where('comments.is_approval', '>=', 0)->orderBy('comments.vote', 'DESC')
									                    ->distinct()->get();
									          $myCart_temp1 = $myCart_temp->merge($myCart8);
									         // $myCart_temp1 =$myCart_temp1->unique(); 

									          $myCartComments = $myCart_temp1->unique();

									          //echo $myCartComments ;

										}

								        if (!$myCartComments->isEmpty()) {
								          foreach($myCartComments as $key => $value){

								            // dd($value->post);

								            $osi[$key]["comment_id"] = $value->comment_id;
								            $osi[$key]["comment"] = $value->comment;
								            $osi[$key]["user_id"] = $value->user_id;
								            $osi[$key]["user_id"] = $value->user_id;   
								            $osi[$key]["trigger_id"] = $value->trigger_id;  
								            $osi[$key]["commented_unix_time"] = $value->commented_unix_time; 
								            $osi[$key]["post_id"] = $value->post_id; 
								            $osi[$key]["parent_comment_id"] = $value->parent_comment_id; 
								            
								        
								            $osi[$key]["vote"] = $value->vote;  
								            $osi[$key]["is_verified"] = $value->is_verified; 
								            $osi[$key]["is_best_answer"] = $value->is_verified;  

								            #$user_name_temp =  												
								            $osi[$key]["user_name_cm"] = DB::table('users')->where('id', $value->user_id)->value('name');								           // $last_id = $value->post_id;

								            $osi[$key]["user_image_url"] =DB::table('users')->where('id', $value->user_id)->value('image_url');
								            

								            
								          }
								          $myJSON_recent_Cm = $osi;



								         // echo $myJSON_recent_Cm;
								         $comment_present = 1;

										}else{
											$comment_present = 0;
									    }


									@endphp

									@if($comment_present == 1)

									@foreach ($myJSON_recent_Cm as $key => $value)
								


										<article class="question question-type-normal">
											<h2 >
												<a  style="display: none;" href="single_question.html">This is my first Question</a>
											</h2>
											<a target="_blank"  class="question-report" href="/query/{{$value['post_id']}}">Go to the Post</a>
											<div style="display: none;"class="question-type-main"><i class="icon-question-sign"></i>Question</div>
											<div class="question-author">
												<a href="" original-title="" class="question-author-img tooltip-n"><span></span><img alt="" src="{{$value['user_image_url']}}"></a>

											</div>
											<div class="question-inner">
												<div class="clearfix"></div>
												<p style=" font-weight: 600;font-style: oblique;font-size:16px!important;">{{$value['user_name_cm']}}</p>
												<p class="question-desc">{{$value['comment']}}</p>
												<div style="display: none;"class="question-details">
													<span class="question-answered question-answered-done"><i class="icon-ok"></i>solved</span>
													<span class="question-favorite"><i class="icon-star"></i>5</span>
												</div>
												<span style="display: none;"class="question-category"><a href="#"><i class="icon-folder-close"></i>wordpress</a></span>
												<span>
										                @if($value['is_verified'] == 1)
															<div class="question-answered question-answered-done"><i class="icon-ok"></i>Verified</div>
														@elseif($value['is_verified'] == 0)
															<div style="color: red!important;"class="question-answered question-answered-done"><i class="icon-question-sign"></i>Not Verified Yet</div>
														@else
														<div style="color: red!important;"class="question-answered question-answered-done"><i class="icon-question-sign"></i>Check Fact</div>
														@endif										


												</span>

												<span  class="question-date"><i class="icon-time"></i>{{$value['commented_unix_time']}}</span>
												<span style="display: none;"class="question-comment"><a href="#"><i class="icon-comment"></i>5 Answer</a></span>
												<span style="display: none;"class="question-view"><i class="icon-user"></i>70 views</span>
												<div class="clearfix"></div>

												@php

													if($value['parent_comment_id'] == 0){

														if (DB::table('comments')->where('parent_comment_id', '=', $value['comment_id'])->count() > 0) {
														   // comment found

														   $nested_comment = 'Other relevant comments may be present in this post.';
														}else{

															$nested_comment = '';
														}

													}else{
														if (DB::table('comments')->where('parent_comment_id', '=', $value['comment_id'])->count() > 0) {
														   // comment found

														   $nested_comment = 'Other relevant comments may be present in this post.';
														}else{
																$nested_comment = '';

														}


													}


													
												@endphp

												<div>{{$nested_comment}}</div>
											</div>
										</article>




									@endforeach
									@else
										<h3>No comments found.</h3>
									@endif
									



								@endif				
		                </div>
		            </div>
					<div class="tab-inner-warp">
						<div class="tab-inner">
							<article class="question question-type-normal">
								<h2>
									<a href="single_question.html">This is my first Question</a>
								</h2>
								<a class="question-report" href="#">Report</a>
								<div class="question-type-main"><i class="icon-question-sign"></i>Question</div>
								<div class="question-author">
									<a href="#" original-title="ahmed" class="question-author-img tooltip-n"><span></span><img alt="" src="http://placehold.it/60x60/FFF/444"></a>
								</div>
								<div class="question-inner">
									<div class="clearfix"></div>
									<p class="question-desc">Duis dapibus aliquam mi, eget euismod sem scelerisque ut. Vivamus at elit quis urna adipiscing iaculis. Curabitur vitae velit in neque dictum blandit. Proin in iaculis neque. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Curabitur vitae velit in neque dictum blandit.</p>
									<div class="question-details">
										<span class="question-answered question-answered-done"><i class="icon-ok"></i>solved</span>
										<span class="question-favorite"><i class="icon-star"></i>5</span>
									</div>
									<span class="question-category"><a href="#"><i class="icon-folder-close"></i>wordpress</a></span>
									<span class="question-date"><i class="icon-time"></i>4 mins ago</span>
									<span class="question-comment"><a href="#"><i class="icon-comment"></i>5 Answer</a></span>
									<span class="question-view"><i class="icon-user"></i>70 views</span>
									<div class="clearfix"></div>
								</div>
							</article>
							<article class="question question-type-poll">
								<h2>
									<a href="single_question_poll.html">This Is My Second Poll Question</a>
								</h2>
								<a class="question-report" href="#">Report</a>
								<div class="question-type-main"><i class="icon-signal"></i>Poll</div>
								<div class="question-author">
									<a href="#" original-title="ahmed" class="question-author-img tooltip-n"><span></span><img alt="" src="http://placehold.it/60x60/FFF/444"></a>
								</div>
								<div class="question-inner">
									<div class="clearfix"></div>
									<p class="question-desc">Duis dapibus aliquam mi, eget euismod sem scelerisque ut. Vivamus at elit quis urna adipiscing iaculis. Curabitur vitae velit in neque dictum blandit. Proin in iaculis neque. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Curabitur vitae velit in neque dictum blandit.</p>
									<div class="question-details">
										<span class="question-favorite"><i class="icon-star"></i>5</span>
									</div>
									<span class="question-category"><a href="#"><i class="icon-folder-close"></i>wordpress</a></span>
									<span class="question-date"><i class="icon-time"></i>4 mins ago</span>
									<span class="question-comment"><a href="#"><i class="icon-comment"></i>5 Answer</a></span>
									<span class="question-view"><i class="icon-user"></i>70 views</span>
									<div class="clearfix"></div>
								</div>
							</article>
							<article class="question question-type-normal">
								<h2>
									<a href="single_question.html">This Is My Third Question</a>
								</h2>
								<a class="question-report" href="#">Report</a>
								<div class="question-type-main"><i class="icon-question-sign"></i>Question</div>
								<div class="question-author">
									<a href="#" original-title="ahmed" class="question-author-img tooltip-n"><span></span><img alt="" src="http://placehold.it/60x60/FFF/444"></a>
								</div>
								<div class="question-inner">
									<div class="clearfix"></div>
									<p class="question-desc">Duis dapibus aliquam mi, eget euismod sem scelerisque ut. Vivamus at elit quis urna adipiscing iaculis. Curabitur vitae velit in neque dictum blandit. Proin in iaculis neque. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Curabitur vitae velit in neque dictum blandit.</p>
									<div class="question-details">
										<span class="question-answered"><i class="icon-ok"></i>in progress</span>
										<span class="question-favorite"><i class="icon-star"></i>5</span>
									</div>
									<span class="question-category"><a href="#"><i class="icon-folder-close"></i>wordpress</a></span>
									<span class="question-date"><i class="icon-time"></i>4 mins ago</span>
									<span class="question-comment"><a href="#"><i class="icon-comment"></i>5 Answer</a></span>
									<span class="question-view"><i class="icon-user"></i>70 views</span>
									<div class="clearfix"></div>
								</div>
							</article>
							<article class="question question-type-normal">
								<h2>
									<a href="single_question.html">This Is My Fourth Question</a>
								</h2>
								<a class="question-report" href="#">Report</a>
								<div class="question-type-main"><i class="icon-question-sign"></i>Question</div>
								<div class="question-author">
									<a href="#" original-title="ahmed" class="question-author-img tooltip-n"><span></span><img alt="" src="http://placehold.it/60x60/FFF/444"></a>
								</div>
								<div class="question-inner">
									<div class="clearfix"></div>
									<p class="question-desc">Duis dapibus aliquam mi, eget euismod sem scelerisque ut. Vivamus at elit quis urna adipiscing iaculis. Curabitur vitae velit in neque dictum blandit. Proin in iaculis neque. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Curabitur vitae velit in neque dictum blandit.</p>
									<div class="question-details">
										<span class="question-answered"><i class="icon-ok"></i>in progress</span>
										<span class="question-favorite"><i class="icon-star"></i>5</span>
									</div>
									<span class="question-category"><a href="#"><i class="icon-folder-close"></i>wordpress</a></span>
									<span class="question-date"><i class="icon-time"></i>4 mins ago</span>
									<span class="question-comment"><a href="#"><i class="icon-comment"></i>5 Answer</a></span>
									<span class="question-view"><i class="icon-user"></i>70 views</span>
									<div class="clearfix"></div>
								</div>
							</article>
							<article class="question question-type-normal">
								<h2>
									<a href="single_question.html">This Is My Fifth Question</a>
								</h2>
								<a class="question-report" href="#">Report</a>
								<div class="question-type-main"><i class="icon-question-sign"></i>Question</div>
								<div class="question-author">
									<a href="#" original-title="ahmed" class="question-author-img tooltip-n"><span></span><img alt="" src="http://placehold.it/60x60/FFF/444"></a>
								</div>
								<div class="question-inner">
									<div class="clearfix"></div>
									<p class="question-desc">Duis dapibus aliquam mi, eget euismod sem scelerisque ut. Vivamus at elit quis urna adipiscing iaculis. Curabitur vitae velit in neque dictum blandit. Proin in iaculis neque. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Curabitur vitae velit in neque dictum blandit.</p>
									<div class="question-details">
										<span class="question-answered"><i class="icon-ok"></i>in progress</span>
										<span class="question-favorite"><i class="icon-star"></i>5</span>
									</div>
									<span class="question-category"><a href="#"><i class="icon-folder-close"></i>wordpress</a></span>
									<span class="question-date"><i class="icon-time"></i>4 mins ago</span>
									<span class="question-comment"><a href="#"><i class="icon-comment"></i>5 Answer</a></span>
									<span class="question-view"><i class="icon-user"></i>70 views</span>
									<div class="clearfix"></div>
								</div>
							</article>
							<article class="question question-type-normal">
								<h2>
									<a href="single_question.html">This Is My Sixth Question</a>
								</h2>
								<a class="question-report" href="#">Report</a>
								<div class="question-type-main"><i class="icon-question-sign"></i>Question</div>
								<div class="question-author">
									<a href="#" original-title="ahmed" class="question-author-img tooltip-n"><span></span><img alt="" src="http://placehold.it/60x60/FFF/444"></a>
								</div>
								<div class="question-inner">
									<div class="clearfix"></div>
									<p class="question-desc">Duis dapibus aliquam mi, eget euismod sem scelerisque ut. Vivamus at elit quis urna adipiscing iaculis. Curabitur vitae velit in neque dictum blandit. Proin in iaculis neque. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Curabitur vitae velit in neque dictum blandit.</p>
									<div class="question-details">
										<span class="question-answered"><i class="icon-ok"></i>in progress</span>
										<span class="question-favorite"><i class="icon-star"></i>5</span>
									</div>
									<span class="question-category"><a href="#"><i class="icon-folder-close"></i>wordpress</a></span>
									<span class="question-date"><i class="icon-time"></i>4 mins ago</span>
									<span class="question-comment"><a href="#"><i class="icon-comment"></i>5 Answer</a></span>
									<span class="question-view"><i class="icon-user"></i>70 views</span>
									<div class="clearfix"></div>
								</div>
							</article>
							<article class="question question-type-normal">
								<h2>
									<a href="single_question.html">This Is My seventh Question</a>
								</h2>
								<a class="question-report" href="#">Report</a>
								<div class="question-type-main"><i class="icon-question-sign"></i>Question</div>
								<div class="question-author">
									<a href="#" original-title="ahmed" class="question-author-img tooltip-n"><span></span><img alt="" src="http://placehold.it/60x60/FFF/444"></a>
								</div>
								<div class="question-inner">
									<div class="clearfix"></div>
									<p class="question-desc">Duis dapibus aliquam mi, eget euismod sem scelerisque ut. Vivamus at elit quis urna adipiscing iaculis. Curabitur vitae velit in neque dictum blandit. Proin in iaculis neque. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Curabitur vitae velit in neque dictum blandit.</p>
									<div class="question-details">
										<span class="question-answered"><i class="icon-ok"></i>in progress</span>
										<span class="question-favorite"><i class="icon-star"></i>5</span>
									</div>
									<span class="question-category"><a href="#"><i class="icon-folder-close"></i>wordpress</a></span>
									<span class="question-date"><i class="icon-time"></i>4 mins ago</span>
									<span class="question-comment"><a href="#"><i class="icon-comment"></i>5 Answer</a></span>
									<span class="question-view"><i class="icon-user"></i>70 views</span>
									<div class="clearfix"></div>
								</div>
							</article>
							<article class="question question-type-normal">
								<h2>
									<a href="single_question.html">This Is My Eighth Question</a>
								</h2>
								<a class="question-report" href="#">Report</a>
								<div class="question-type-main"><i class="icon-question-sign"></i>Question</div>
								<div class="question-author">
									<a href="#" original-title="ahmed" class="question-author-img tooltip-n"><span></span><img alt="" src="http://placehold.it/60x60/FFF/444"></a>
								</div>
								<div class="question-inner">
									<div class="clearfix"></div>
									<p class="question-desc">Duis dapibus aliquam mi, eget euismod sem scelerisque ut. Vivamus at elit quis urna adipiscing iaculis. Curabitur vitae velit in neque dictum blandit. Proin in iaculis neque. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Curabitur vitae velit in neque dictum blandit.</p>
									<div class="question-details">
										<span class="question-answered"><i class="icon-ok"></i>in progress</span>
										<span class="question-favorite"><i class="icon-star"></i>5</span>
									</div>
									<span class="question-category"><a href="#"><i class="icon-folder-close"></i>wordpress</a></span>
									<span class="question-date"><i class="icon-time"></i>4 mins ago</span>
									<span class="question-comment"><a href="#"><i class="icon-comment"></i>5 Answer</a></span>
									<span class="question-view"><i class="icon-user"></i>70 views</span>
									<div class="clearfix"></div>
								</div>
							</article>
							<a href="#" class="load-questions"><i class="icon-refresh"></i>Load More Questions</a>
					    </div>
					</div>
					<div class="tab-inner-warp">
						<div class="tab-inner">
							<article class="question question-type-normal">
								<h2>
									<a href="single_question.html">This is my first Question</a>
								</h2>
								<a class="question-report" href="#">Report</a>
								<div class="question-type-main"><i class="icon-question-sign"></i>Question</div>
								<div class="question-author">
									<a href="#" original-title="ahmed" class="question-author-img tooltip-n"><span></span><img alt="" src="http://placehold.it/60x60/FFF/444"></a>
								</div>
								<div class="question-inner">
									<div class="clearfix"></div>
									<p class="question-desc">Duis dapibus aliquam mi, eget euismod sem scelerisque ut. Vivamus at elit quis urna adipiscing iaculis. Curabitur vitae velit in neque dictum blandit. Proin in iaculis neque. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Curabitur vitae velit in neque dictum blandit.</p>
									<div class="question-details">
										<span class="question-answered question-answered-done"><i class="icon-ok"></i>solved</span>
										<span class="question-favorite"><i class="icon-star"></i>5</span>
									</div>
									<span class="question-category"><a href="#"><i class="icon-folder-close"></i>wordpress</a></span>
									<span class="question-date"><i class="icon-time"></i>4 mins ago</span>
									<span class="question-comment"><a href="#"><i class="icon-comment"></i>5 Answer</a></span>
									<span class="question-view"><i class="icon-user"></i>70 views</span>
									<div class="clearfix"></div>
								</div>
							</article>
							<article class="question question-type-poll">
								<h2>
									<a href="single_question_poll.html">This Is My Second Poll Question</a>
								</h2>
								<a class="question-report" href="#">Report</a>
								<div class="question-type-main"><i class="icon-signal"></i>Poll</div>
								<div class="question-author">
									<a href="#" original-title="ahmed" class="question-author-img tooltip-n"><span></span><img alt="" src="http://placehold.it/60x60/FFF/444"></a>
								</div>
								<div class="question-inner">
									<div class="clearfix"></div>
									<p class="question-desc">Duis dapibus aliquam mi, eget euismod sem scelerisque ut. Vivamus at elit quis urna adipiscing iaculis. Curabitur vitae velit in neque dictum blandit. Proin in iaculis neque. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Curabitur vitae velit in neque dictum blandit.</p>
									<div class="question-details">
										<span class="question-favorite"><i class="icon-star"></i>5</span>
									</div>
									<span class="question-category"><a href="#"><i class="icon-folder-close"></i>wordpress</a></span>
									<span class="question-date"><i class="icon-time"></i>4 mins ago</span>
									<span class="question-comment"><a href="#"><i class="icon-comment"></i>5 Answer</a></span>
									<span class="question-view"><i class="icon-user"></i>70 views</span>
									<div class="clearfix"></div>
								</div>
							</article>
							<article class="question question-type-normal">
								<h2>
									<a href="single_question.html">This Is My Third Question</a>
								</h2>
								<a class="question-report" href="#">Report</a>
								<div class="question-type-main"><i class="icon-question-sign"></i>Question</div>
								<div class="question-author">
									<a href="#" original-title="ahmed" class="question-author-img tooltip-n"><span></span><img alt="" src="http://placehold.it/60x60/FFF/444"></a>
								</div>
								<div class="question-inner">
									<div class="clearfix"></div>
									<p class="question-desc">Duis dapibus aliquam mi, eget euismod sem scelerisque ut. Vivamus at elit quis urna adipiscing iaculis. Curabitur vitae velit in neque dictum blandit. Proin in iaculis neque. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Curabitur vitae velit in neque dictum blandit.</p>
									<div class="question-details">
										<span class="question-answered"><i class="icon-ok"></i>in progress</span>
										<span class="question-favorite"><i class="icon-star"></i>5</span>
									</div>
									<span class="question-category"><a href="#"><i class="icon-folder-close"></i>wordpress</a></span>
									<span class="question-date"><i class="icon-time"></i>4 mins ago</span>
									<span class="question-comment"><a href="#"><i class="icon-comment"></i>5 Answer</a></span>
									<span class="question-view"><i class="icon-user"></i>70 views</span>
									<div class="clearfix"></div>
								</div>
							</article>
							<article class="question question-type-normal">
								<h2>
									<a href="single_question.html">This Is My Fourth Question</a>
								</h2>
								<a class="question-report" href="#">Report</a>
								<div class="question-type-main"><i class="icon-question-sign"></i>Question</div>
								<div class="question-author">
									<a href="#" original-title="ahmed" class="question-author-img tooltip-n"><span></span><img alt="" src="http://placehold.it/60x60/FFF/444"></a>
								</div>
								<div class="question-inner">
									<div class="clearfix"></div>
									<p class="question-desc">Duis dapibus aliquam mi, eget euismod sem scelerisque ut. Vivamus at elit quis urna adipiscing iaculis. Curabitur vitae velit in neque dictum blandit. Proin in iaculis neque. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Curabitur vitae velit in neque dictum blandit.</p>
									<div class="question-details">
										<span class="question-answered"><i class="icon-ok"></i>in progress</span>
										<span class="question-favorite"><i class="icon-star"></i>5</span>
									</div>
									<span class="question-category"><a href="#"><i class="icon-folder-close"></i>wordpress</a></span>
									<span class="question-date"><i class="icon-time"></i>4 mins ago</span>
									<span class="question-comment"><a href="#"><i class="icon-comment"></i>5 Answer</a></span>
									<span class="question-view"><i class="icon-user"></i>70 views</span>
									<div class="clearfix"></div>
								</div>
							</article>
							<article class="question question-type-normal">
								<h2>
									<a href="single_question.html">This Is My Fifth Question</a>
								</h2>
								<a class="question-report" href="#">Report</a>
								<div class="question-type-main"><i class="icon-question-sign"></i>Question</div>
								<div class="question-author">
									<a href="#" original-title="ahmed" class="question-author-img tooltip-n"><span></span><img alt="" src="http://placehold.it/60x60/FFF/444"></a>
								</div>
								<div class="question-inner">
									<div class="clearfix"></div>
									<p class="question-desc">Duis dapibus aliquam mi, eget euismod sem scelerisque ut. Vivamus at elit quis urna adipiscing iaculis. Curabitur vitae velit in neque dictum blandit. Proin in iaculis neque. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Curabitur vitae velit in neque dictum blandit.</p>
									<div class="question-details">
										<span class="question-answered"><i class="icon-ok"></i>in progress</span>
										<span class="question-favorite"><i class="icon-star"></i>5</span>
									</div>
									<span class="question-category"><a href="#"><i class="icon-folder-close"></i>wordpress</a></span>
									<span class="question-date"><i class="icon-time"></i>4 mins ago</span>
									<span class="question-comment"><a href="#"><i class="icon-comment"></i>5 Answer</a></span>
									<span class="question-view"><i class="icon-user"></i>70 views</span>
									<div class="clearfix"></div>
								</div>
							</article>
							<article class="question question-type-normal">
								<h2>
									<a href="single_question.html">This Is My Sixth Question</a>
								</h2>
								<a class="question-report" href="#">Report</a>
								<div class="question-type-main"><i class="icon-question-sign"></i>Question</div>
								<div class="question-author">
									<a href="#" original-title="ahmed" class="question-author-img tooltip-n"><span></span><img alt="" src="http://placehold.it/60x60/FFF/444"></a>
								</div>
								<div class="question-inner">
									<div class="clearfix"></div>
									<p class="question-desc">Duis dapibus aliquam mi, eget euismod sem scelerisque ut. Vivamus at elit quis urna adipiscing iaculis. Curabitur vitae velit in neque dictum blandit. Proin in iaculis neque. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Curabitur vitae velit in neque dictum blandit.</p>
									<div class="question-details">
										<span class="question-answered"><i class="icon-ok"></i>in progress</span>
										<span class="question-favorite"><i class="icon-star"></i>5</span>
									</div>
									<span class="question-category"><a href="#"><i class="icon-folder-close"></i>wordpress</a></span>
									<span class="question-date"><i class="icon-time"></i>4 mins ago</span>
									<span class="question-comment"><a href="#"><i class="icon-comment"></i>5 Answer</a></span>
									<span class="question-view"><i class="icon-user"></i>70 views</span>
									<div class="clearfix"></div>
								</div>
							</article>
							<article class="question question-type-normal">
								<h2>
									<a href="single_question.html">This Is My seventh Question</a>
								</h2>
								<a class="question-report" href="#">Report</a>
								<div class="question-type-main"><i class="icon-question-sign"></i>Question</div>
								<div class="question-author">
									<a href="#" original-title="ahmed" class="question-author-img tooltip-n"><span></span><img alt="" src="http://placehold.it/60x60/FFF/444"></a>
								</div>
								<div class="question-inner">
									<div class="clearfix"></div>
									<p class="question-desc">Duis dapibus aliquam mi, eget euismod sem scelerisque ut. Vivamus at elit quis urna adipiscing iaculis. Curabitur vitae velit in neque dictum blandit. Proin in iaculis neque. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Curabitur vitae velit in neque dictum blandit.</p>
									<div class="question-details">
										<span class="question-answered"><i class="icon-ok"></i>in progress</span>
										<span class="question-favorite"><i class="icon-star"></i>5</span>
									</div>
									<span class="question-category"><a href="#"><i class="icon-folder-close"></i>wordpress</a></span>
									<span class="question-date"><i class="icon-time"></i>4 mins ago</span>
									<span class="question-comment"><a href="#"><i class="icon-comment"></i>5 Answer</a></span>
									<span class="question-view"><i class="icon-user"></i>70 views</span>
									<div class="clearfix"></div>
								</div>
							</article>
							<article class="question question-type-normal">
								<h2>
									<a href="single_question.html">This Is My Eighth Question</a>
								</h2>
								<a class="question-report" href="#">Report</a>
								<div class="question-type-main"><i class="icon-question-sign"></i>Question</div>
								<div class="question-author">
									<a href="#" original-title="ahmed" class="question-author-img tooltip-n"><span></span><img alt="" src="http://placehold.it/60x60/FFF/444"></a>
								</div>
								<div class="question-inner">
									<div class="clearfix"></div>
									<p class="question-desc">Duis dapibus aliquam mi, eget euismod sem scelerisque ut. Vivamus at elit quis urna adipiscing iaculis. Curabitur vitae velit in neque dictum blandit. Proin in iaculis neque. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Curabitur vitae velit in neque dictum blandit.</p>
									<div class="question-details">
										<span class="question-answered"><i class="icon-ok"></i>in progress</span>
										<span class="question-favorite"><i class="icon-star"></i>5</span>
									</div>
									<span class="question-category"><a href="#"><i class="icon-folder-close"></i>wordpress</a></span>
									<span class="question-date"><i class="icon-time"></i>4 mins ago</span>
									<span class="question-comment"><a href="#"><i class="icon-comment"></i>5 Answer</a></span>
									<span class="question-view"><i class="icon-user"></i>70 views</span>
									<div class="clearfix"></div>
								</div>
							</article>
							<a href="#" class="load-questions"><i class="icon-refresh"></i>Load More Questions</a>
					    </div>
					</div>
		        </div><!-- End page-content -->
			</div><!-- End main -->
			<aside class="col-md-3 sidebar">
				<div  style="display: none;" class="widget">
					<h3 class="widget_title">Benefits of a collaborative effort to learn about a new AI system</h3>
					<p style="font-size: 16px!important"></p>
				</div>



				<div  class="widget widget_stats">
					<h3 class="widget_title">Stats</h3>
					<div class="ul_list ul_list-icon-ok">
						@php
							$no_ques = DB::table('posts')->where('is_approval', '>=', 0)->get()->count();
							$no_anses = DB::table('comments')->where('is_approval', '>=', 0)->get()->count();
						@endphp
						<ul>
							<li><i class="icon-question-sign"></i>Posts ( <a  href="/"><span style="color:#1bbc9b;"> {{$no_ques}}</span> )</a></li>
							<li><i class="icon-comment"></i>Answers ( <a  href="/search_index?search=answered_queries"><span style="color:#1bbc9b;">{{$no_anses}}</span> )</a></li>
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

				<div style="display: none;" class="widget ">
					<h3  class="widget_title">Search Box</h3>
		            <form id="search_form" method="GET" action="{{ action('QAController@search_index') }}">
		                      <input style="text-align: center;height: 100px;color:black;font-size:1.0em;width: 100%;font-size: 20px;" type="text" autocomplete="off" data-id='study' onkeyup="dummy_function(document.getElementById('search').value)" name="search" id="search" placeholder="Type & Search" class=" search_by_study ">
		                      <button style="display: none;" type="submit" class="search-submit" ></button>

		                      <p style="color: black;opacity: 0.5;">When you will type in the above search box, you will be shown different types of suggestions. You can select from those suggestions to search or you can disregard the suggestions and type a word/string of words and then click the 'ENTER' button. The latter type of search will return all the posts that have the word/string of words in it. The same thing will happen when you pick a suggestion that ends with '- Word'.</p>
		            </form>   


				</div>
				

				<div class="widget widget_tag_cloud">
					<h3 class="widget_title">Recent Tags</h3>
					@php
						 $tagList = DB::table('tags')->limit(5)->get();

					@endphp


					<div style="display: flex;  flex-direction: row; flex-wrap: wrap;width: auto;">
						@foreach($tagList as $tag=>$value)
							 <form id="form-tagid-{{$value->tag_id}}" method="GET" action="{{ action('QAController@search_with_tag') }}">

							 	<input type="hidden" name="tag_id" value="{{$value->tag_id}}"/>
									<a style="cursor: pointer;" data-id = "{{$value->tag_id}}" class="tag_button_class"  ><p style="font-size: 14px;">{{$value->tag}}</p>
									</a>
							</form>
				


						@endforeach

					</div>


				</div>
				

			
			
							
				
				
			</aside><!-- End sidebar -->
		</div><!-- End row -->
	</section><!-- End container -->
		<br>
	





@endsection	 	
@section('page-script')	



<script >

	var last_record_recent;
$(function() {

		last_record_recent = $('.last_post_id_to_load_recent').text();

		
		//alert(last_record_recent);
		
		//$(".last_post_id_to_load_recent").val($('.last_post_id_to_load_recent').val());

		//
	});


window.addEventListener('load', function () {
  //location.reload();
})


$( ".tag_button_class" ).click(function() {
  //alert( );
  event.preventDefault();
  class_form = 'form-tagid-'+  $(this).attr("data-id");

  document.getElementById(class_form).submit();
});
	
$( "#load-questions_recent" ).click(function() {

//alert(last_record_recent);
	var previous_val;
	load_more_data("recent");

/*	

	previous_val = $( "#load_data_addtioanl_data_recent" ).html();
  $( "#load_data_addtioanl_data_recent" ).html(previous_val + "<article class='question question-type-normal'><h2><a href='single_question.html'>This is my first Question</a></h2><a class='question-report' href='#'>Report</a><div class='question-type-main'><i class='icon-question-sign'></i>Question</div><div class='question-author'><a href='#' original-title='ahmed' class='question-author-img tooltip-n'><span></span><img alt='' src='http://placehold.it/60x60/FFF/444'></a></div><div class='question-inner'><div class='clearfix'></div><p class='question-desc'>Duis dapibus aliquam mi, eget euismod sem scelerisque ut. Vivamus at elit quis urna adipiscing iaculis. Curabitur vitae velit in neque dictum blandit. Proin in iaculis neque. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Curabitur vitae velit in neque dictum blandit.</p><div class='question-details'><span class='question-answered question-answered-done'><i class='icon-ok'></i>solved</span><span class='question-favorite'><i class='icon-star'></i>5</span></div><span class='question-category'><a href='#'><i class='icon-folder-close'></i>wordpress</a></span><span class='question-date'><i class='icon-time'></i>4 mins ago</span><span class='question-comment'><a href='#'><i class='icon-comment'></i>5 Answer</a></span><span class='question-view'><i class='icon-user'></i>70 views</span><div class='clearfix'></div></div></article>");*/
});




 function load_more_data(query_type) {
		//alert(query_type);
		

		last_record_recent  = $('.last_post_id_to_load_recent').text().toString();
		console.log("step1");

		console.log(last_record_recent);


         $.ajax({
            url: "/get_more_records",
            cache: false,

            data: {
              last_record_recent: last_record_recent,
              query_type: query_type,     
              submit_check_1: "submit_check_1"


            },
            type: 'GET',
            async: false,
            success: function (data) {
              //console.log("Success");
              console.log(data);
             
              result = data;
              if(query_type=="recent"){

	              if(result=="no record"){

	              	//document.getElementById("load-questions_recent").style.display = "none";
	              	$("#load-questions_recent").html('No New Records');
	              	$("#load-questions_recent").prop('disabled',true); 


					$('#load-questions_recent').css('cursor', 'none');



	              }

	              else if(data.length>0){
					var i;
					for (i = 0; i < data.length; i++) {

							previous_val = $( "#load_data_addtioanl_data_recent" ).html();
						  $( "#load_data_addtioanl_data_recent" ).html(previous_val + "<article class='question question-type-normal'><h2><a href='/query/"
						  	+ data[i]['post_id'] +"'>"+ data[i]['post_title'] +"</a><p style='font-style: oblique;font-size:20px!important;'>"+data[i]['user_name']+"</p></h2><a class='question-report' style='cursor: none;' href=''>Post</a><div class='question-author'><a  original-title='ahmend' class=''><span></span><img alt='' src='"+data[i]['user_image_url']+"'></a></div><div class='question-inner'><div class='clearfix'></div><p style='white-space: pre-wrap;' class='question-desc'>"+data[i]['post']+"</p><div class='question-details'></div><span style='display: none;' class='question-category'><i class='icon-folder-close'></i>"+data[i]['trigger_name']+"</span><span class='question-date'><i class='icon-time'></i>"+data[i]['posted_unix_time']+"</span><span class='question-comment'><i class='icon-comment'></i>"+data[i]['total_responses']+" Answer(s)</span><div class='clearfix'></div></div></article>");

						 

						  $(".last_post_id_to_load_recent").text(data[i]['post_id']);
					}

	              }	
	          }

	          console.log("step2");
	          

				

					 

               

              },

               error: function (jqXHR, status, err) {
                  
                  //location.reload(true);

                }
            })


  }


</script>

<style type="text/css">
	
.dropdown-item{

	font-size: 20px;

	color: black;
}


.btn1 {
  border: 2px solid black;
  background-color: white;
  color: black;
  padding: 14px 28px;
  font-size: 16px;
  cursor: pointer;
}

/* Green */
.success1 {
  border-color: #1bbc9b;
  color: green;
}
.success1:hover {
  background-color: #1bbc9b;
  color: white;
}

.center_icon{
      display: flex;
    justify-content: center;
    align-items: center;
   background-size: 100% 100%;
  
 } 

</style>
@endsection	