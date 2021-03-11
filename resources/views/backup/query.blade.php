@extends('/default_contents')




@section('content')

<p style="display: none;" type="text" class="current_post_id">{{$current_post_id}}</p>
<div class="loader"><div class="loader_html"></div></div>
@php
	$triggers =  DB::table('triggers')->where('trigger_id', '>', 0)->get();


	  	  $triggerForthisQueries = DB::table('post_triggers')
              ->join('posts', 'posts.post_id', '=', 'post_triggers.post_id')
              ->join('triggers', 'post_triggers.trigger_id', '=', 'triggers.trigger_id')
              ->where('posts.post_id', $current_post_id)
              ->select('posts.post_id','posts.post','posts.user_id','posts.trigger_id','posts.posted_unix_time','posts.created_at','posts.updated_at','posts.post_title','posts.is_top_query','posts.total_responses','posts.is_answered','triggers.trigger')
              ->distinct()->get();

 	  	  $reference_list = DB::table('post_referenceurls')
              ->join('posts', 'posts.post_id', '=', 'post_referenceurls.post_id')
              ->join('referenceurls', 'referenceurls.referance_list_id', '=', 'post_referenceurls.referance_list_id')
              ->where('posts.post_id', $current_post_id)
              ->select('posts.post_id','referenceurls.reference_url')
              ->distinct()->get();   

              #echo $reference_list;          
	

@endphp



	
	<div class="breadcrumbs">
		<section class="container">
			<div class="row">
				<div class="col-md-12">
					<h1 class="post_title">{{$specific_query[0]->post_title}}</h1>
				</div>
				<div class="col-md-12">
					<div class="crumbs">
						<a href="/">Home</a>
						<!-- <span class="crumbs-span">/</span>
						<a href="#">Query</a> -->
						<span class="crumbs-span">/</span>
						<span class="current">Query No. {{$current_post_id}}</span>
						
					</div>
				</div>
			</div><!-- End row -->
		</section><!-- End container -->
	</div><!-- End breadcrumbs -->
	@if(Auth::check())
		@php
			$user_name = DB::table('users')->where('id', $specific_query[0]->user_id)->value('name'); 
			$user_image_url = DB::table('users')->where('id', $specific_query[0]->user_id)->value('image_url');
		@endphp	

		<p style="display: none;" type="text" class="current_user_name">{{$user_name}}</p>
		<p style="display: none;" type="text" class="current_user_image_url">{{$user_image_url}}</p>

		<p style="display: none;" type="text" class="current_user_id">{{Auth::user()->id}}</p>

		

	@else
	 	<p style="display: none;" type="text" class="current_user_name">0</p>
		<p style="display: none;" type="text" class="current_user_image_url">0</p>
		<p style="display: none;" type="text" class="current_user_id">0</p>
	@endif
	<section class="container main-content">
		<div class="row">
			<div class="col-md-9">
				<article class="question single-question question-type-normal">
					<h2>
						<a class="post_title" style="cursor: none;" href="">{{$specific_query[0]->post_title}}</a>
					</h2>



					<a class="question-report" style="cursor: none;" >Query</a>
					<div style="display: none;"  class="question-type-main"><i class="icon-question-sign"></i>Question</div>
					<div class="question-inner">
						<div class="clearfix"></div>
						<div class="question-desc">
							<p class="post_body">{{$specific_query[0]->post}}</p>
						</div>
						<div class="question-details">
							<span  style="display: none;" class="question-answered question-answered-done"><i class="icon-ok"></i>solved</span>
							<span  style="display: none;" class="question-favorite"><i class="icon-star"></i>5</span>
						</div>

						@php

						 	$trigger_name = DB::table('triggers')->where('trigger_id', $specific_query[0]->trigger_id)->value('trigger');
						 	$number_of_comments = DB::table('comments')->where('post_id', $current_post_id)->count();
							$tags =  DB::table('tags')
							      ->join('post_tags', 'post_tags.tag_id', '=', 'tags.tag_id')
							      ->select('tags.tag','tags.tag_id')
							      ->where('post_tags.post_id', $current_post_id)->get();


							$related_questions =  DB::table('posts')->where('trigger_id', $specific_query[0]->trigger_id)->where('post_id', '!=' , $current_post_id)->limit(4)->get();

							
							      




						@endphp

						


						<span class="question-category"><a style="cursor: pointer;" data-toggle="modal" data-target="#myModalSeeTriggers" style=""><i class="icon-file"></i>Topics</a></span>


						@if($specific_query[0]->reference_url !="")

						<span class="question-category"><a style="cursor: pointer;" data-toggle="modal" data-target="#myModalSeeReferances" style=""><i class="icon-file"></i>All References</a></span>						


							<span class="question-category"><a href="{{$specific_query[0]->reference_url}}" target="_blank" style="cursor: pointer;"  style=""><i class="icon-external-link"></i>Main Reference </a></span>	
						@endif					
						<span class="question-date"><i class="icon-time"></i>{{$specific_query[0]->posted_unix_time}}</span>

						<span class="question-comment"><a id="question-comment_a_tag"style="cursor: none;"><i class="icon-comment"></i>{{$number_of_comments}} Response(s)</a></span>

	                	@if(Auth::check())
			                @if((Auth::user()->id == $specific_query[0]->user_id))						

								<span class="question-category"><a style="cursor: pointer;" data-toggle="modal" data-target="#myModalEditParentPost" style=""><i class="icon-edit"></i>Edit</a></span>
							@endif
						@endif
						<span class="question-category"><a style="cursor: pointer;" data-toggle="modal" data-target="#myModalEditParentList" style=""><i class="icon-list-ol"></i>Edits</a></span>

						<span style="display: none;" class="question-view"><i class="icon-user"></i>70 views</span>
						<span style="display: none;"  class="single-question-vote-result">+22</span>
						<ul style="display: none;"  class="single-question-vote">
							<li><a href="#" class="single-question-vote-down" title="Dislike"><i class="icon-thumbs-down"></i></a></li>
							<li><a href="#" class="single-question-vote-up" title="Like"><i class="icon-thumbs-up"></i></a></li>
						</ul>
						<div class="question-tags">
							 <span style='cursor: pointer;font-size: 18px!important' class=" parent_comment_take_down" ><i class="icon-reply"></i>Reply</span>
						</div>

						
						<div class="clearfix"></div>
					</div>
				</article>
				
				<div class="share-tags page-content">
					<div class="question-tags">
				<!-- 		@foreach($tags as $tag=>$value)
							<a href="#">{{$value->tag}}</a>
						@endforeach -->
						@php
							$post_tag_icon_show_status = 1;
						@endphp
						<div style="display: flex;flex-direction: row; flex-wrap: wrap;width: auto;">
							@foreach($tags as $tag=>$value)
									@if($post_tag_icon_show_status )
										<i class="icon-tags"></i>
										@php
											$post_tag_icon_show_status = 0;
										@endphp	
									@endif
								 <form id="form-post-tagid-{{$value->tag_id}}" method="GET" action="{{ action('QAController@search_with_tag') }}">

								 	<input type="hidden" name="tag_id" value="{{$value->tag_id}}"/>
										<a style="cursor: pointer;" data-id = "{{$value->tag_id}}" class="tag_post_button_class"  ><p>{{$value->tag}}</p>
										</a>
								</form>
					


							@endforeach
						</div>




					</div>
					<div class="share-inside-warp">
						<ul>
							<li>
								<a href="#" original-title="Facebook">
									<span class="icon_i">
										<span class="icon_square" icon_size="20" span_bg="#3b5997" span_hover="#666">
											<i i_color="#FFF" class="social_icon-facebook"></i>
										</span>
									</span>
								</a>
								<a href="#" target="_blank">Facebook</a>
							</li>
							<li>
								<a href="#" target="_blank">
									<span class="icon_i">
										<span class="icon_square" icon_size="20" span_bg="#00baf0" span_hover="#666">
											<i i_color="#FFF" class="social_icon-twitter"></i>
										</span>
									</span>
								</a>
								<a target="_blank" href="#">Twitter</a>
							</li>
							<li>
								<a href="#" target="_blank">
									<span class="icon_i">
										<span class="icon_square" icon_size="20" span_bg="#ca2c24" span_hover="#666">
											<i i_color="#FFF" class="social_icon-gplus"></i>
										</span>
									</span>
								</a>
								<a href="#" target="_blank">Google plus</a>
							</li>
							<li>
								<a href="#" target="_blank">
									<span class="icon_i">
										<span class="icon_square" icon_size="20" span_bg="#e64281" span_hover="#666">
											<i i_color="#FFF" class="social_icon-dribbble"></i>
										</span>
									</span>
								</a>
								<a href="#" target="_blank">Dribbble</a>
							</li>
							<li>
								<a target="_blank" href="#">
									<span class="icon_i">
										<span class="icon_square" icon_size="20" span_bg="#c7151a" span_hover="#666">
											<i i_color="#FFF" class="icon-pinterest"></i>
										</span>
									</span>
								</a>
								<a href="#" target="_blank">Pinterest</a>
							</li>
						</ul>
						<span class="share-inside-f-arrow"></span>
						<span class="share-inside-l-arrow"></span>
					</div><!-- End share-inside-warp -->
					<div style="display: none;"  class="share-inside"><i class="icon-share-alt"></i>Share</div>
					<div class="clearfix"></div>
				</div><!-- End share-tags -->
				
				<div style="display: none;"  class="about-author clearfix">
				    <div class="author-image">
				    	<a href="#" original-title="admin" class="tooltip-n"><img alt="" src="http://placehold.it/60x60/FFF/444"></a>
				    </div>
				    <div class="author-bio">
				        <h4>About the Author</h4>
				        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed viverra auctor neque. Nullam lobortis, sapien vitae lobortis tristique.
				    </div>
				</div><!-- End about-author -->
				
				<div id="related-posts">
					<h2>Related Queries</h2>
					<ul class="related-posts">
						@foreach($related_questions as $related_question=>$value)
							<li class="related-item"><h3><a target="_blank" href="{{ url('query/'. $value->post_id) }}"><i class="icon-double-angle-right"></i>{{$value->post_title}}</a></h3></li> 
						@endforeach
					</ul>
				</div><!-- End related-posts -->
				
				<div id="commentlist" class="page-content">
					<div class="boxedtitle page-title"><h2>Response(s)( <span id="total_responses" class="color">{{$specific_query[0]->total_responses}}</span> )</h2></div>
					<ol class="commentlist clearfix">

					    @if($answer_exists =="1")

					   
						    @foreach($parent_comments as $parent_comment=>$value)
						    	@php
			                		 $user_name = DB::table('users')->where('id', $value->user_id)->value('name'); 
			                		 $user_image_url = DB::table('users')->where('id', $value->user_id)->value('image_url'); 
			                	@endphp
							    <li class="comment">
							        <div class="comment-body comment-body-answered clearfix"> 
							            <div class="avatar"><img alt="" src="{{$user_image_url }}"></div>
							            <div class="comment-text">
							                <div class="author clearfix">


							                	<div class="comment-author"><a >{{$user_name }}</a></div>

							                	@if(Auth::check())
									                @if((Auth::user()->id == $value->user_id))
									                	<div class="comment-vote">
										                	<ul class="question-vote">
										                		<li><a style="cursor: default;"  class="question-vote-up" title="Like"></a></li>
										                		<li><a style="cursor: default;" class="question-vote-down" title="Dislike"></a></li>
										                	</ul>

									                	</div>


									                @else
							                        	<div class="comment-vote">
								                            <ul class="question-vote">
								                            		<li><a style="cursor: pointer;" onclick='upVote({{$value->comment_id}})'class="question-vote-up" title="Up Vote"></a></li>
								                            		<li><a style="cursor: pointer;" onclick='downVote({{$value->comment_id}})' class="question-vote-down" title="Down Vote"></a></li>
								                            </ul>
							                        	</div>

									                 @endif


							                	@else
									                	<div class="comment-vote">
										                	<ul class="question-vote">
										                		<li><a style="cursor: default;"  class="question-vote-up" title="Like"></a></li>
										                		<li><a style="cursor: default;" class="question-vote-down" title="Dislike"></a></li>
										                	</ul>

									                	</div>

							                	@endif


								                
								                @if(((int) $value->vote) > 0 )
								                	<span id="comment_id_vote_result_{{$value->comment_id}}" class="question-vote-result ">+{{$value->vote}}</span>
								               	@elseif(((int) $value->vote) < 0)
								               		<span id="comment_id_vote_result_{{$value->comment_id}}" class="question-vote-result ">{{$value->vote}}</span>

								               	@else
								               		<span id="comment_id_vote_result_{{$value->comment_id}}" class="question-vote-result ">{{$value->vote}}</span>
								               	@endif

							                	<div class="comment-meta">
							                        <div class="date"><i class="icon-time"></i>{{$value->commented_unix_time}}</div> 
							                    </div>
							                    <a  data-toggle="modal" data-post-id="{{$current_post_id}}" data-parent-id="{{$value->comment_id}}" data-target="#myModalChildren"  style="cursor: pointer;" class="comment-reply myModalChildren" ><i class="icon-reply"></i>Reply</a>


							                   
							                </div>
									        @php
												$trigger_name = DB::table('triggers')->where('trigger_id', $value->trigger_id)->value('trigger');    


											@endphp		
											<p style="display: none;"  id="vote_status_{{$value->comment_id}}">tauseef</p>					                
							                <p style='font-weight: bold;color:black;' >{{$trigger_name}}</p>
							                <div class="text"><p>{{$value->comment}}</p>
							                </div>
							                @if($value->is_verified == 1)
												<div class="question-answered question-answered-done"><i class="icon-ok"></i>Verified</div>
											@else
												<div style="color: red!important;"class="question-answered question-answered-done"><i class="icon-question-sign"></i>Not Verified</div>
											@endif
							            </div>
							        </div>

							        @php
										$child_comments =  DB::table('comments')->where('post_id', '=', $current_post_id)->where('parent_comment_id', '=', $value->comment_id)->get();

									@endphp

									@foreach($child_comments as $child_comment=>$value1)
								    	@php
					                		 $user_name = DB::table('users')->where('id', $value1->user_id)->value('name'); 
					                		 $user_image_url = DB::table('users')->where('id', $value1->user_id)->value('image_url'); 
					                	@endphp

								        <ul class="children">
								            <li class="comment">
								                <div class="comment-body clearfix"> 
								                	<div class="avatar"><img alt="" src="{{$user_image_url}}"></div>
								                    <div class="comment-text">
								                        <div class="author clearfix">
								                        	<div class="comment-author"><a >{{$user_name}} </a></div>

								                        	@if(Auth::check())
											                    @if(Auth::user()->id == $value->user_id)
										                        	<div class="comment-vote">
										                            	<ul class="question-vote">
										                            		<li><a style="cursor: default;" class="question-vote-up" title="Like"></a></li>
										                            		<li><a style="cursor: default;" class="question-vote-down" title="Dislike"></a></li>
										                            	</ul>
										                        	</div>

										                        @else
										                        	<div class="comment-vote">
											                            <ul class="question-vote">
											                            		<li><a style="cursor: pointer;" onclick='upVote({{$value1->comment_id}})'class="question-vote-up" title="Up Vote"></a></li>
											                            		<li><a style="cursor: pointer;" onclick='downVote({{$value1->comment_id}})' class="question-vote-down" title="Down Vote"></a></li>
											                            </ul>
										                        	</div>

										                        @endif
									                       @else
										                        	<div class="comment-vote">
										                            	<ul class="question-vote">
										                            		<li><a style="cursor: default;" class="question-vote-up" title="Like"></a></li>
										                            		<li><a style="cursor: default;" class="question-vote-down" title="Dislike"></a></li>
										                            	</ul>
										                        	</div>

									                       @endif

											                @if(((int) $value1->vote) > 0 )
											                	<span id="comment_id_vote_result_{{$value1->comment_id}}" class="question-vote-result">+{{$value1->vote}}</span>
											               	@elseif(((int) $value1->vote) < 0)
											               		<span id="comment_id_vote_result_{{$value1->comment_id}}" class="question-vote-result">{{$value1->vote}}</span>

											               	@else
											               		<span id="comment_id_vote_result_{{$value1->comment_id}}" class="question-vote-result">{{$value1->vote}}</span>
											               	@endif

								                        	
								                        	<div class="comment-meta">
								                                <div class="date"><i class="icon-time"></i>{{$value1->commented_unix_time}}</div> 
								                            </div>
								                            <a style="display: none;"class="comment-reply" href="#"><i class="icon-reply"></i>Reply</a> 
								                        </div>
												        @php
															$trigger_name = DB::table('triggers')->where('trigger_id', $value1->trigger_id)->value('trigger');    
															

														@endphp	
														<p style="display: none;"  id="vote_status_{{$value1->comment_id}}">tauseef</p>							                
										                <p style='font-weight: bold;color:black;'>{{$trigger_name}}</p>



								                        <div class="text"><p>{{$value1->comment}}</p>
								                        </div>
										                @if($value1->is_verified == 1)
															<div class="question-answered question-answered-done"><i class="icon-ok"></i>Verified</div>
														@else
															<div style="color: red!important;" class="question-answered question-answered-done"><i class="icon-question-sign"></i>Not Verified</div>
														@endif

								                    </div>
								                </div>
					
								             
								            </li>
								          
								        </ul><!-- End children -->




									@endforeach
							        @php
										$child_id_additional = "child_additional_comment_" . (string) $current_post_id . "_" .$value->comment_id

									@endphp


									<div id="{{$child_id_additional}}">
								        	<!-- id="load_data_addtioanl_data_recent" -->

								        	<!-- add child comment-->
								        	<!-- <p>{{$child_id_additional }}</p> -->
								        	
								    </div>





							        

							    </li>





							    
						    @endforeach
							<div id="add_additional_comment_parent">
						        	<!-- id="load_data_addtioanl_data_recent" -->

						        	<!-- add parent comment -->
						        	<!-- <p>add new parent</p> -->
						        	
						    </div>
		  				@else
							<div id="add_additional_comment_parent">
						        	<!-- id="load_data_addtioanl_data_recent" -->

						        	<!-- add parent comment -->
						        	<!-- <p>add new parent</p> -->
						        	
						    </div>



						@endif
					</ol><!-- End commentlist -->
				</div><!-- End page-content -->
				
				<div id="respond" class="comment-respond page-content clearfix">
				    <div class="boxedtitle page-title"><h2>Leave a response</h2></div>
				    <form action="" method="post" id="commentform" class="comment-form">
				        <div style="display: none;" id="respond-inputs" class="clearfix">
				            <p>
				                <label class="required" for="comment_name">Name<span>*</span></label>
				                <input name="author" type="text" value="" id="comment_name" aria-required="true">
				            </p>
				          
				        </div>

						<p>
							<label class="required">Topic<span>*</span></label>
							
<input type="text" autocomplete="off"  onkeyup="getAnsTriggersParentComment()" name="selected_trigger_parent_comment" id="selected_trigger_parent_comment" placeholder="Write Your Topic Name (You can also use customized topic name)" >




							
<!-- 							<span class="styled-select">
								<select  id='selected_trigger_parent_comment'>
									<option value="">Select a Trigger</option>
									@foreach($triggers as $trigger=>$value)
										<option value="{{$value->trigger_id}}">{{$value->trigger}}</option>
									@endforeach
								</select>
							</span> -->
							<span class="form-description">Please choose the appropriate section so easily search for your question .</span>
						</p>				        
				        <div id="respond-textarea">
				            <p>
				                <label class="required" for="comment">Comment<span>*</span></label>
				                <textarea id="comment" name="comment" aria-required="true" cols="58" rows="8"></textarea>
				            </p>
				        </div>
				        <p class="form-submit">
				        	<!-- <input name="submit" type="submit" id="submit" value="Post your answer" class="button small color"> -->

				        	@if(Auth::check())

				        		<input  type="button" onclick="fn_submit_parent_comment()" id="submit_parent_comment" value="Post your Response" class="button small color">
				        	@else
				        		<input  onclick='needLogin()' type="button" id="need_login" value="Login First" class="button small color">
				        	@endif

				        	
				        </p>
				    </form>
				</div>
				
				<div class="post-next-prev clearfix">
					@php
						$prev_record = DB::table('posts')->where('post_id', '<', $current_post_id)->max('post_id');
						$next_record = DB::table('posts')->where('post_id', '>', $current_post_id)->min('post_id');
						

					@endphp	



				    <p class="prev-post">
				    	@if($prev_record!="")
				        	<a href="/query/{{$prev_record}}"><i class="icon-double-angle-left"></i>&nbsp;Previous Query</a>
				        @endif
				    </p>
				    <p class="next-post">
				    	@if($next_record!="")
				        	<a href="/query/{{$next_record}}" >Next Query&nbsp;<i class="icon-double-angle-right"></i></a>  
				        @endif                              
				    </p>
				</div><!-- End post-next-prev -->	
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
							<li><i class="icon-comment"></i>Answers ( <span id="total_answers_for_all_ques">{{$no_anses}}</span> )</li>
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
	


<div id="myModalChildren" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <p  style="display: none;" type="text" id="modal_parent_comment_id"></p>
        <p style="display: none;" type="text" id="modal_post_id"></p>
        <h4 class="modal-title">Your Comment</h4>
      </div>
      <div class="modal-body">
      <!--   <p id="modal_text">Some text in the modal.</p> -->
			<p>
				<label class="required">Topic<span>*</span></label>
				

				<input style="width: 100%!important" type="text" autocomplete="off"  onkeyup="getAnsTriggersChildComment()" name="selected_trigger_modal" id="selected_trigger_modal" placeholder="Write Your Topic Name" >
<!-- 				<span class="styled-select">
					<select  style =" font-size:18px;"id='selected_trigger_modal'>
						<option value="">Select a Trigger</option>
						@foreach($triggers as $trigger=>$value)
							<option value="{{$value->trigger_id}}">{{$value->trigger}}</option>
						@endforeach
					</select>
				</span> -->
				<span class="form-description">You can use customized or pre-existing topic name.</span>
			</p>
	     
			<!-- <textarea rows="8" class="form-control" style="min-width: 100%"></textarea> -->
			

				        <div id="respond-textarea">
				            <p>
				                <label class="required" for="comment">Comment<span>*</span></label>
				                <textarea style="min-width: 100% ;font-size:18px;" id="modal_comment" name="comment" aria-required="true" cols="58" rows="8"></textarea>
				                <span class="form-description">Write your comment in detail.</span>
				            </p>
				        </div>
      </div>
      <div class="modal-footer">

				        	@if(Auth::check())

				        		<button onclick='myModalSubmit()'type="button" class="btn btn-success ">Submit</button>
				        	@else
				        		
				        		<button onclick='needLogin()' id="need_login" value="Login First" type="button" class="btn btn-primary ">Login First</button>
				        	@endif


      	
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<!-- modal triggers -->
<!-- Modal -->
<div id="myModalSeeTriggers" class="modal fade" role="dialog">
  <div class="modal-dialog">




    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Topic(s)</h4>
      </div>
      <div class="modal-body">
						@foreach($triggerForthisQueries as $triggerForthisQuery=>$value)
							 <p>{{$value->trigger}}</p>
						@endforeach

       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<!-- modal references -->
<!-- Modal -->
<div id="myModalSeeReferances" class="modal fade" role="dialog">
  <div class="modal-dialog">




    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Reference List</h4>
      </div>
      <div class="modal-body">
						@foreach($reference_list as $triggerForthisQuery=>$value)
							 <a target="_blank" href='{{$value->reference_url}}' > {{$value->reference_url}}</a>
							 <br>
						@endforeach

       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<!-- Edit List  -->
<!-- Modal -->
<div id="myModalEditParentList" class="modal fade" role="dialog">
  <div class="modal-dialog">




    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edits</h4>
      </div>


      <div class="modal-body">
							  <div class="row">
							    <div class="col-sm-6">
							    	<p>Title</p>

							    </div>
							    <div class="col-sm-6">
							    	
							    	<p>Comment</p>
							    </div>
							  </div>

						



							  <div class="row">
							    <div class="col-sm-6">
      								@php
										$posts_edit_lists =  DB::table('edit_histories')
							      
							      		->where('edit_histories.type', 1)
							      		->where('edit_histories.post_id', $current_post_id)->get();

      								@endphp

							    	@foreach($posts_edit_lists as $posts_edit_list=>$value)	
							    		@if($value->type == "1")
												    	
											<p>{{$value->edit}}</p>

										@endif
									@endforeach

									<div id="add_new_edit_title"></div>

							    </div>
							    <div class="col-sm-6">
							    	
      								@php
										$posts_edit_lists =  DB::table('edit_histories')
							      
							      		->where('edit_histories.type', 2)
							      		->where('edit_histories.post_id', $current_post_id)->get();

      								@endphp

							    	@foreach($posts_edit_lists as $posts_edit_list=>$value)	
							    		@if($value->type == "2")
												    	
											<p>{{$value->edit}}</p>

										@endif
									@endforeach
									<div id="add_new_edit_comment"></div>
							    </div>
							  </div>
						  
							
							 
						

       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<!-- Edit -->

<div id="myModalEditParentPost" class="modal fade" role="dialog">
  <div class="modal-dialog">




    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Reference List</h4>
      </div>
      <div class="modal-body">

      					<input style="min-width: 100%" class="form-control" maxlength="180" type="text" id="modal_comment_question_title_edit" name="modal_comment_question_title_edit" value="{{$specific_query[0]->post_title}}" >
<span class="form-description">Please choose an appropriate title for the comment to reply it even easier.</span>

				        <div id="respond-textarea">
				            <p>
				                <label class="required" for="comment">Comment's Body<span>*</span></label>
				                <textarea style="min-width: 100% ;font-size:18px;" id="modal_comment_body_edit" name="modal_comment_body_edit" aria-required="true" cols="58" rows="8">{{$specific_query[0]->post}}</textarea>
				                <span class="form-description">Write your comment in detail.</span>
				            </p>
				        </div>

       
      </div>
      <div class="modal-footer">
      
      	<button type="button" id ="fn_modal_comment_post_edit_main" class="btn btn-success">Submit</button>

        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

@endsection	 	
@section('page-script')	

<script>
var new_comment_no = -1; //beacause we will have positive ids on db

var previous_val;
var new_comment_new_post = 0;
$( ".tag_button_class" ).click(function() {
  //alert( );
  event.preventDefault();
  class_form = 'form-tagid-'+  $(this).attr("data-id");

  document.getElementById(class_form).submit();
});
$( ".tag_post_button_class" ).click(function() {
  //alert( );
  event.preventDefault();
  class_form = 'form-post-tagid-'+  $(this).attr("data-id");

  document.getElementById(class_form).submit();
});

$("#fn_modal_comment_post_edit_main").click(function(){

 	
	edited_post_title = document.getElementById("modal_comment_question_title_edit").value;
	
	
	edited_post_body = document.getElementById('modal_comment_body_edit').value;

	current_title = $( ".post_title" ).html();
	current_post = $( ".post_body" ).html();

	post_id  = $('.current_post_id').text().toString();

	
	if((edited_post_title !="") && (edited_post_body!="")){
	
     $.ajax({
        url: "/modal_comment_post_edit_main",
        cache: false,

        data: {

          post_id: post_id,
          post_title: edited_post_title,
          post_body: edited_post_body, 
          submit_check_1: "submit_check_1"


        },
        type: 'GET',
        async: false,
        success: function (data) {
          //console.log("Success");
          //console.log(data);
          
          result = data;

          if(current_title != edited_post_title){
          	previous_val = $( '#add_new_edit_title').html();
          	$('#add_new_edit_title' ).html(previous_val +"<p>"+current_title+"</p>");

          }
          if(current_post != edited_post_body){
          	previous_val = $( '#add_new_edit_comment').html();
          	$('#add_new_edit_comment' ).html(previous_val +"<p>"+current_post+"</p>");

          }
          document.getElementById('modal_comment_body_edit').innerHTML = edited_post_body;
          document.getElementById('modal_comment_question_title_edit').value = edited_post_title;

          $(".post_title").html(edited_post_title);
          $(".post_body").html(edited_post_body);



           jQuery.noConflict();
          $('#myModalEditParentPost').modal('toggle');
        
          },

           error: function (jqXHR, status, err) {
              
              //location.reload(true);



            }
        })
       }else{

       	alert("You have empty field(s).")
       }	



	
});



$( ".comment-reply" ).click(function() {
  // alert( $(this).data('parent-id') );
//style="display: none;" 
  // $("#modal_text").text($(this).data('post-id'));
  // $('#myModalChildren').modal('show');

  $("#modal_parent_comment_id").text($(this).data('parent-id'));
  $("#modal_post_id").text($(this).data('post-id'));
  new_comment_new_post = 0;



});

$(".parent_comment_take_down").click(function(){
  //alert("The paragraph was clicked.");
  window.scrollTo(0,document.body.scrollHeight);
}); 

function needLogin(){


  // alert( $(this).data('parent-id') );
  current_page = window.location.pathname;
  redirect_to = window.location.href;
  current_page_query = current_page.split('/').reverse()[1];
  current_page = current_page.split('/').reverse()[0];
  if(current_page_query == "query"){
    current_post_id = $('.current_post_id').text().toString();
    //redirect_to = window.location.href;
    //"query/"+current_post_id;

  
    need_to_login(redirect_to);

  }else if(current_page =="ask_query"){
  	redirect_to = window.location.href;

  }
  



}

function upVote(comment_id){
	//alert(comment_id);

	id_name = "comment_id_vote_result_" + comment_id;
	//alert(id_name);

	current_user_id  = $('.current_user_id').text().toString();
	//check vote

      $.ajax({
        url: "/check_last_vote",
        cache: false,

        data: {

          user_id: current_user_id,
          comment_id: comment_id,
          vote_type: "1", //1 means up vote
          submit_check_1: "submit_check_1"


        },
        type: 'GET',
        async: false,
        success: function (data) {
          //console.log("Success");
          //console.log(data);
          result = data;
          	if(result!="not ok"){

				 element = document.getElementById(id_name).innerHTML;

				 a = parseInt(element) ;
				 a=a+1;

				var span = document.getElementById(id_name);

				vote_status_id = "vote_status_" + comment_id;

				if(result == 0){
					span.textContent = "0";
					//alert("You one vote is counted.Total vote count for this comment is 0");

    				document.getElementById(vote_status_id).innerText = "You one vote is counted.Total vote count for this comment is 0.";
            		document.getElementById(vote_status_id).style.display = "block"; 

					var delayInMilliseconds = 3000; //3 second

					setTimeout(function() {
					  //your code to be executed after 3 second
					  document.getElementById(vote_status_id).style.display = "none";
					}, delayInMilliseconds);


				}else{
					span.textContent = "+" + result.toString();

    				document.getElementById(vote_status_id).innerText = "You one vote is counted.You are shown the updated vote count for the comment.";
            		document.getElementById(vote_status_id).style.display = "block"; 

					var delayInMilliseconds = 3000; //3 second

					setTimeout(function() {
					  //your code to be executed after 3 second
					  document.getElementById(vote_status_id).style.display = "none";
					}, delayInMilliseconds);


				}
				//alert("You one vote is counted.You are shown the updated vote count for the comment.");
				
			}
			else{

				//alert("You already upvoted this comment");

    				document.getElementById(vote_status_id).innerText = "You already upvoted this comment.";
            		document.getElementById(vote_status_id).style.display = "block"; 

					var delayInMilliseconds = 3000; //3 second

					setTimeout(function() {
					  //your code to be executed after 3 second
					  document.getElementById(vote_status_id).style.display = "none";
					}, delayInMilliseconds);


			}
           

          },

           error: function (jqXHR, status, err) {
              
              //location.reload(true);

            }
        })







	

	
}

function downVote(comment_id){
	id_name = "comment_id_vote_result_" + comment_id;
	//alert(id_name);
current_user_id  = $('.current_user_id').text().toString();


      $.ajax({
        url: "/check_last_vote",
        cache: false,

        data: {

          user_id: current_user_id,
          comment_id: comment_id,
          vote_type: "0", //0 means down vote
          submit_check_1: "submit_check_1"


        },
        type: 'GET',
        async: false,
        success: function (data) {
          //console.log("Success");
          //console.log(data);
          result = data;
          	if(result!="not ok"){

				 element = document.getElementById(id_name).innerHTML;

				 a = parseInt(element) ;
				 a=a-1;
				
				var span = document.getElementById(id_name);
				vote_status_id = "vote_status_" + comment_id;
				//span.textContent = "-1";
				if(result == 0){
					span.textContent = "0";
					//alert("You one vote is counted.Total vote count for this comment is 0");
    				document.getElementById(vote_status_id).innerText = "You one vote is counted.Total vote count for this comment is 0.";
            		document.getElementById(vote_status_id).style.display = "block"; 

					var delayInMilliseconds = 3000; //3 second

					setTimeout(function() {
					  //your code to be executed after 3 second
					  document.getElementById(vote_status_id).style.display = "none";
					}, delayInMilliseconds);



				}else{
					span.textContent =  result.toString();
    				document.getElementById(vote_status_id).innerText = "You one vote is counted.You are shown the updated vote count for the comment.";
            		document.getElementById(vote_status_id).style.display = "block"; 

					var delayInMilliseconds = 3000; //3 second

					setTimeout(function() {
					  //your code to be executed after 3 second
					  document.getElementById(vote_status_id).style.display = "none";
					}, delayInMilliseconds);


				}
				//alert("You one vote is counted.You are shown the updated vote count for the comment.");


			}
			else{

				//alert("You already downvoted this comment");
				document.getElementById(vote_status_id).innerText = "You already downvoted this comment.";
        		document.getElementById(vote_status_id).style.display = "block"; 

				var delayInMilliseconds = 3000; //3 second

				setTimeout(function() {
				  //your code to be executed after 3 second
				  document.getElementById(vote_status_id).style.display = "none";
				}, delayInMilliseconds);

			}
           

          },

           error: function (jqXHR, status, err) {
              
              //location.reload(true);

            }
        })





}



function myFunction(new_comment_no){
	

	current_post_id  = $('.current_post_id').text().toString();

  $("#modal_parent_comment_id").text(new_comment_no);
  $("#modal_post_id").text(current_post_id);
  new_comment_new_post = 1;


}

function fn_submit_parent_comment(){

 	trigger_id = $('#selected_trigger_parent_comment').val().toString();

	//var e = document.getElementById("selected_trigger_parent_comment");
	//var trigger_name = e.options[e.selectedIndex].text;

	////var trigger_name = e.options[e.selectedIndex].text;


 	modal_comment = $('#comment').val().toString();

 	//alert(trigger_id);

	previous_val = $( '#add_additional_comment_parent' ).html();

	current_post_id  = $('.current_post_id').text().toString();

	new_comment_id = "#new_child_additional_comment_" + current_post_id + "_" + new_comment_no.toString();


	if((trigger_id !="")&&(modal_comment !="")){
		
		add_comment_insert_parent(trigger_id,modal_comment,current_post_id);



	}else{

		
	}
	

	// $(  '#add_additional_comment_parent' ).html(previous_val + "<li class='comment'><div class='comment-body comment-body-answered clearfix'><div class='avatar'><img alt='' src='http://placehold.it/60x60/FFF/444'></div><div class='comment-text'><div class='author clearfix'><div class='comment-author'><a href='#'>admin</a></div><div class='comment-vote'><ul class='question-vote'><li><a href='#' class='question-vote-up' title='Like'></a></li><li><a href='#' class='question-vote-down' title='Dislike'></a></li></ul></div><span class='question-vote-result'>+1</span><div class='comment-meta'><div class='date'><i class='icon-time'></i>rr 15 , 2014 at 10:00 pm</div> </div>  <a  data-toggle='modal' onclick='myFunction("+ new_comment_no.toString()  +")' data-post-id='"+current_post_id.toString()+"' data-parent-id='"+new_comment_no.toString()+"' data-target='#myModalChildren'  style='cursor: pointer;' class='comment-reply myModalChildren' ><i class='icon-reply'></i>Reply</a> </div><div class='text'><p>oooooooooo</p></div> </div></div><div id='"+new_comment_id+"'>  </div></li>");
	// 	new_comment_no = new_comment_no -1;

  



}


function add_comment_insert_parent(trigger_id,modal_comment,current_post_id){

	 	current_user_name  = $('.current_user_name').text().toString();
 		current_user_image_url = $('.current_user_image_url').text().toString();
		

         $.ajax({
            url: "/add_comment",
            cache: false,

            data: {
	          comment: modal_comment.trim(),
	          trigger_id: trigger_id.trim(),
	          post_id: current_post_id,
	          parent_comment_id: 0,
	          commented_unix_time: get_date_time(),
	             
	          submit_check_1: "submit_check_1"

                 
             


            },
            type: 'GET',
            async: false,
            success: function (data) {
              //console.log("Success");
              console.log(data);
             
              result = data;
              //alert("Inserted");
              //window.location.href = "/";
			 	trigger_id = $('#selected_trigger_parent_comment').val().toString();
				var e = document.getElementById("selected_trigger_parent_comment");
				//var trigger_name = e.options[e.selectedIndex].text;


			 	modal_comment = $('#comment').val().toString();

			 	//alert(trigger_id);

				previous_val = $( '#add_additional_comment_parent' ).html();

				current_post_id  = $('.current_post_id').text().toString();

				new_comment_id = "#new_child_additional_comment_" + current_post_id + "_" + result.toString();

				$('#add_additional_comment_parent' ).html(previous_val + "<li class='comment'><div class='comment-body comment-body-answered clearfix'><div class='avatar'><img alt='' src='"+current_user_image_url+"'></div><div class='comment-text'><div class='author clearfix'><div class='comment-author'><a>"+current_user_name+"</a></div><div class='comment-vote'><ul class='question-vote'><li><a style='cursor: default;' class='question-vote-up' title='Like'></a></li><li><a style='cursor: default;' class='question-vote-down' title='Dislike'></a></li></ul></div><span class='question-vote-result'>0</span><div class='comment-meta'><div class='date'><i class='icon-time'></i>"+get_date_time()+"</div> </div>  <a  data-toggle='modal' onclick='myFunction("+ result.toString()  +")' data-post-id='"+current_post_id.toString()+"' data-parent-id='"+new_comment_no.toString()+"' data-target='#myModalChildren'  style='cursor: pointer;' class='comment-reply myModalChildren' ><i class='icon-reply'></i>Reply</a> </div><p style='font-weight: bold;color:black;'>"+trigger_id+"</p><div class='text'><p>"+modal_comment+"</p></div><div style='color: red!important;' class='question-answered question-answered-done'><i class='icon-question-sign'></i>Not Verified</div> </div></div><div id='"+new_comment_id+"'>  </div></li>");
				new_comment_no = new_comment_no -1;


				 total_responses = parseInt(document.getElementById("total_responses").innerText);

				 total_responses = total_responses+1;
				 document.getElementById("total_responses").textContent=total_responses.toString();
				 document.getElementById("question-comment_a_tag").textContent=total_responses.toString() +" Response(s)";

				 total_answers_for_all_ques =  parseInt(document.getElementById("total_answers_for_all_ques").innerText) ;
				 total_answers_for_all_ques = total_answers_for_all_ques+1;
				 document.getElementById("total_answers_for_all_ques").textContent=total_responses.toString();

				 $('#selected_trigger_parent_comment').typeahead('destroy');
				 $('#selected_trigger_modal').typeahead('destroy');
				 //https://github.com/bassjobsen/Bootstrap-3-Typeahead
				// alert("f");

  					

				 
     				//document.getElementById('comment').innerHTML = "";
          			document.getElementById('selected_trigger_parent_comment').value = "";
          			document.getElementById('comment').value = '';


             

              },

               error: function (jqXHR, status, err) {
                  
                  //location.reload(true);
                 	alert("Data Missing");
	              
	              //window.location.href = "/ask_query";                  

                }
            })



}
var productNames ;
function getAnsTriggersParentComment(){


		
		//= ["Afghanistan","Albania","Algeria","Andorra","Angola","Anguilla","Antigua & Barbuda"];
    			
		productNames = getAnswerTriggers();

		// console.log("ddd");
		// console.log (productNames);

			    $('#selected_trigger_parent_comment').typeahead({


			      source: productNames,
			      items : 5,
			      minLength : 3,


			    });
			
}

function getAnsTriggersChildComment(){

		
		//= ["Afghanistan","Albania","Algeria","Andorra","Angola","Anguilla","Antigua & Barbuda"];
    			
		productNames = getAnswerTriggers();

			    $('#selected_trigger_modal').typeahead({


			      source: productNames,
			      items : 5,
			      minLength : 3,			      
			    });

}

function getAnswerTriggers(){

			    result ="";
			    var productNames ;
			    $.ajax({


			      url: "/get_triggers_ans",
			      data: {

			        search_type: "tags",
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
			        productNames.push( product.trigger );

			      } );
			    



			      console.log(productNames);

			      return productNames;

}

function myModalSubmit(){

 // $child_id_additional = "#child_additional_comment_" + $(this).data('post-id') + "_" + $(this).data('parent-id');

 	trigger_id = $('#selected_trigger_modal').val().toString();
 	modal_comment = $('#modal_comment').val().toString();
	var e = document.getElementById("selected_trigger_modal");
	//var trigger_name = e.options[e.selectedIndex].text; 	



 	current_user_name  = $('.current_user_name').text().toString();
 	current_user_image_url = $('.current_user_image_url').text().toString();

 	


 	//document.getElementById(id_name).innerHTML;


 	modal_post_id  = $('#modal_post_id').text().toString();

 	modal_parent_id  = $('#modal_parent_comment_id').text().toString();
	if((trigger_id !="")&&(modal_comment !="")){
	     $.ajax({
	        url: "/add_comment",
	        cache: false,

	        data: {
	          comment: modal_comment.trim(),
	          trigger_id: trigger_id.trim(),
	          post_id: modal_post_id,
	          parent_comment_id: modal_parent_id,
	          commented_unix_time: get_date_time(),
	          submit_check_1: "submit_check_1"


	        },
	        type: 'GET',
	        async: false,
	        success: function (data) {
	          //console.log("Success");
	          	console.log(data);
	         
	          	result = data;
				if(new_comment_new_post == 0){
					 $child_id_additional = "#child_additional_comment_" + modal_post_id + "_" + modal_parent_id;
					 previous_val = $( $child_id_additional ).html();

					 // $( $child_id_additional ).html(previous_val + "<ul class='children'><li class='comment'><div class='comment-body clearfix'><div class='avatar'><img alt='' src='http://placehold.it/60x60/FFF/444'></div><div class='comment-text'><div class='author clearfix'><div class='comment-author'><a href='#'>vbegy</a></div><div class='comment-vote'><ul class='question-vote'><li><a href='#' class='question-vote-up' title='Like'></a></li><li><a href='#' class='question-vote-down' title='Dislike'></a></li></ul></div><span class='question-vote-result'>+1</span><div class='comment-meta'><div class='date'><i class='icon-time'></i>January 15 , 2014 at 10:00 pm</div></div> <a style='display: none;'class='comment-reply' href='#'><i class='icon-reply'></i>Reply</a></div><div class='text'><p>yyyyyyy</p> </div>  </div></div>  </li> </ul>");

					 $( $child_id_additional ).html(previous_val + "<ul class='children'><li class='comment'><div class='comment-body clearfix'><div class='avatar'><img alt='' src='"+current_user_image_url+"'></div><div class='comment-text'><div class='author clearfix'><div class='comment-author'><a >"+current_user_name+"</a></div><div class='comment-vote'><ul class='question-vote'><li><a style='cursor: default;' class='question-vote-up' title='Like'></a></li><li><a style='cursor: default;' class='question-vote-down' title='Dislike'></a></li></ul></div><span class='question-vote-result'>0</span><div class='comment-meta'><div class='date'><i class='icon-time'></i>"+get_date_time()+"</div></div> <a style='display: none;'class='comment-reply' href='#'><i class='icon-reply'></i>Reply</a></div><p style='font-weight: bold;color:black;'>"+trigger_id+"</p><div class='text'><p>"+modal_comment+"</p> </div> <div style='color: red!important;' class='question-answered question-answered-done'><i class='icon-question-sign'></i>Not Verified</div> </div></div>  </li> </ul>");


				}else{
					jQuery.noConflict();
				//#new_child_additional_comment_4_10
				//#new_child_additional_comment_4_10
					 $child_id_additional = "#new_child_additional_comment_" + modal_post_id + "_" + modal_parent_id;
					 
					 previous_val =  document.getElementById($child_id_additional).innerHTML;
					//$( $child_id_additional ).html();
					



					 // document.getElementById($child_id_additional).innerHTML = previous_val + "<ul class='children'><li class='comment'><div class='comment-body clearfix'><div class='avatar'><img alt='' src='http://placehold.it/60x60/FFF/444'></div><div class='comment-text'><div class='author clearfix'><div class='comment-author'><a href='#'>vbegy</a></div><div class='comment-vote'><ul class='question-vote'><li><a href='#' class='question-vote-up' title='Like'></a></li><li><a href='#' class='question-vote-down' title='Dislike'></a></li></ul></div><span class='question-vote-result'>+1</span><div class='comment-meta'><div class='date'><i class='icon-time'></i>January 15 , 2014 at 10:00 pm</div></div> <a style='display: none;'class='comment-reply' href='#'><i class='icon-reply'></i>Reply</a></div><div class='text'><p>yyyyyyy</p> </div>  </div></div>  </li> </ul>";

					 document.getElementById($child_id_additional).innerHTML = previous_val + "<ul class='children'><li class='comment'><div class='comment-body clearfix'><div class='avatar'><img alt='' src='"+current_user_image_url+"'></div><div class='comment-text'><div class='author clearfix'><div class='comment-author'><a >"+current_user_name+"</a></div><div class='comment-vote'><ul class='question-vote'><li><a style='cursor: default;' class='question-vote-up' title='Like'></a></li><li><a style='cursor: default;' class='question-vote-down' title='Dislike'></a></li></ul></div><span class='question-vote-result'>0</span><div class='comment-meta'><div class='date'><i class='icon-time'></i>"+get_date_time()+"</div></div> <a style='display: none;'class='comment-reply' href='#'><i class='icon-reply'></i>Reply</a></div><p style='font-weight: bold;color:black;'>"+trigger_id+"</p><div class='text'><p>"+modal_comment+"</p> </div>  <div style='color: red!important;' class='question-answered question-answered-done'><i class='icon-question-sign'></i>Not Verified</div></div></div>  </li> </ul>";

					
				}
				total_responses = parseInt(document.getElementById("total_responses").innerText);

				 total_responses = total_responses+1;

				 document.getElementById("total_responses").textContent=total_responses.toString();
				 document.getElementById("question-comment_a_tag").textContent=total_responses.toString()+" Response(s)";

				 total_answers_for_all_ques = parseInt(document.getElementById("total_answers_for_all_ques").innerText) ;
				 total_answers_for_all_ques = total_answers_for_all_ques+1;
				 document.getElementById("total_answers_for_all_ques").textContent=total_responses.toString();



				 $('#selected_trigger_modal').typeahead('destroy');
				 $('#selected_trigger_parent_comment').typeahead('destroy');

				    //event.preventDefault();

				    //https://stackoverflow.com/questions/27064176/typeerror-modal-is-not-a-function-with-bootstrap-modal
				    //question 38 votes

          			document.getElementById('selected_trigger_modal').value = "";
          			document.getElementById('modal_comment').value = '';
				    
				    jQuery.noConflict();
				    
				 	$('#myModalChildren').modal('toggle');

	         

	          },

	           error: function (jqXHR, status, err) {
	              
	              //location.reload(true);
	              alert("Try Again");
	              //window.location.href = "/ask_query";                  

	            }
	        })

	}else{


		alert("Data Missing");
	}










  
}


</script>

<style type="text/css">
	


	
</style>
@endsection	

