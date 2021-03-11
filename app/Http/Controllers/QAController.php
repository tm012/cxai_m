<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FileUpload;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Cookie;
use DateTime;
use Session;
use Redirect;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use DB;
use Excel;
use File;

use Zipper;

use App\triggers;
use App\posts;
use App\tags;
use App\post_tags;
use App\User;
use App\comments;
use App\post_triggers;
use Illuminate\Filesystem\Filesystem;
use App\vote_user_id_comment;
use App\referenceurls;
use App\post_referenceurls;

use App\edit_history;
use App\post_plagiarism;






class QAController extends Controller
{
  public function check_similar_post(){
    $unix_timestamp_diff = 0;
    $date = new DateTime();
    $unix_timestamp_start = $date->getTimestamp();
    $unix_timestamp_end = $date->getTimestamp();
    $unix_timestamp_diff = ($unix_timestamp_end - $unix_timestamp_start)/60/1000;

    $break = 0;
    $myCart = DB::table('posts')->where('is_approval', '=', 0)->orderBy('post_id', 'DESC')->get();

    //dd($myCart);
    if (!$myCart->isEmpty()) {
      foreach($myCart as $key => $value){
        if($unix_timestamp_diff < 6){
        // dd($value->post);


          $need_status_update = 0;
          $current_post_id = $value->post_id;
          $current_post = $value->post;

          $myCart1 = DB::table('posts')->where('is_approval', '>=', 0)->where('post_id', '!=', $current_post_id)->orderBy('post_id', 'DESC')->get();
          foreach($myCart1 as $key => $value1){
            $matching_post_id = $value1->post_id;
            $matching_post = $value1->post;

            $sim = similar_text($current_post, $matching_post, $perc);
            // echo '<br>';
            // echo $current_post_id;
            // echo (float) $perc;
            // echo '<br>';
            // echo $matching_post_id ;
            // echo '<br>';
            if((float) $perc > 50){
              if (post_plagiarism::where('post_id', '=', $current_post_id)->where('compare_post_id', '=', $matching_post_id)->exists()) {
              }
              else{
                $bike_save = New post_plagiarism;
                $bike_save ->post_id = $current_post_id;
                $bike_save ->compare_post_id = $matching_post_id;
                $bike_save ->plagiarism = $perc;
                $bike_save -> save();
                $need_status_update = 1;
              }

            }

          }
          ##need update here

          if($need_status_update> 0){
            $updateDetailsUsers=array(
                      'is_approval' => -1
                    );

                    DB::table('posts')
                    ->where('post_id', '=', $current_post_id)
                    ->update($updateDetailsUsers); 

          }else{
            $updateDetailsUsers=array(
                      'is_approval' => 1
                    );

                    DB::table('posts')
                    ->where('post_id', '=', $current_post_id)
                    ->update($updateDetailsUsers); 


          }
          $date = new DateTime();
          $unix_timestamp_end = $date->getTimestamp();
          $unix_timestamp_diff = ($unix_timestamp_end - $unix_timestamp_start)/60/1000;
        }
      }

    }




      // do {

      //   $date = new DateTime();
      //   $unix_timestamp_end = $date->getTimestamp();
      //   $unix_timestamp_diff = ($unix_timestamp_end - $unix_timestamp_start)/60/1000;

      // } while (($unix_timestamp_diff < 9) && ($break == 0)); 
 // $updateDetailsUsers=array(
 //            'is_approval' => $unix_timestamp_start
 //          );

 //          DB::table('posts')
 //          ->where('post_id', '>', 0)
 //          ->update($updateDetailsUsers); 
  }

  public function tag_list(Request $request){

    return view('tag_list');

  }
  public function create_docs_excel (Request $request){

    dd("stop");

     //create dominion xls  START
      $paymentsArray = [];

      // Define the Excel spreadsheet headers
      $paymentsArray[] = ['post title', 'post', 'topics','tags'];

      $dominions_records = posts::where('post_id', '>', 0)->get();

      for ($x = 0; $x < count($dominions_records); $x++) {

        #topics

        $myCart = DB::table('post_triggers')
              ->join('posts', 'posts.post_id', '=', 'post_triggers.post_id')
              ->join('triggers', 'post_triggers.trigger_id', '=', 'triggers.trigger_id')
              ->where('posts.post_id', '=', (string) $dominions_records[$x]["post_id"])
               ->select('posts.post_id','posts.post','posts.user_id','posts.trigger_id','posts.posted_unix_time','posts.created_at','posts.updated_at','posts.post_title','posts.is_top_query','posts.total_responses','posts.is_answered','posts.user_id','triggers.trigger')->orderBy('posts.post_id', 'DESC')
              ->distinct()->get();

       
        $topic_string="";
 
        $z =0;
        foreach ($myCart as $p) {

          $topic_string=$topic_string.(string) $p->trigger;
          if(($z+1) == count($myCart)){


          }else{

            $topic_string=$topic_string.',';
          }


      
            $z=$z+1;
        }
       // dd($topic_string);
        #tags
        $myCart = DB::table('post_tags')
              ->join('posts', 'posts.post_id', '=', 'post_tags.post_id')
              ->join('tags', 'post_tags.tag_id', '=', 'tags.tag_id')
              ->where('posts.post_id', '=', (string) $dominions_records[$x]["post_id"])
               ->select('posts.post_id','posts.post','posts.user_id','posts.trigger_id','posts.posted_unix_time','posts.created_at','posts.updated_at','posts.post_title','posts.is_top_query','posts.total_responses','posts.is_answered','posts.user_id','tags.tag')->orderBy('posts.post_id', 'DESC')
              ->distinct()->get();

        $tag_string="";

        $z =0;
        foreach ($myCart as $p) {

          $tag_string=$tag_string.(string) $p->tag;
          if(($z+1) == count($myCart)){


          }else{

            $tag_string=$tag_string.',';
          }


      
            $z=$z+1;
        }




          $paymentsArray[] = [(string) $dominions_records[$x]["post_title"],(string) $dominions_records[$x]["post"],(string) $topic_string,(string) $tag_string];
      }

      // Generate and return the spreadsheet
    \Excel::create('Posts', function($excel) use ($paymentsArray) {

          // Set the spreadsheet title, creator, and description
          $excel->setTitle('CSV');
          $excel->setCreator('Laravel')->setCompany('MTU');
          $excel->setDescription('Keystamps');

          // Build the spreadsheet, passing in the payments array
          $excel->sheet('sheet1', function($sheet) use ($paymentsArray) {
              $sheet->fromArray($paymentsArray, null, 'A1', false, false);
          });

      })->store('csv', public_path().'/files/Posts' );


    //
  }
  public function index(Request $request){
    



    $myCart = DB::table('posts')->where('is_approval', '>=', 0)->limit(5)->orderBy('post_id', 'DESC')->get();

    
    if (!$myCart->isEmpty()) {
      foreach($myCart as $key => $value){

        // dd($value->post);

        $osi[$key]["post"] = $value->post;
        $osi[$key]["post_id"] = $value->post_id;
        $osi[$key]["post"] = $value->post;
        $osi[$key]["user_id"] = $value->user_id;   
        $osi[$key]["trigger_id"] = $value->trigger_id;  
        $osi[$key]["post_title"] = $value->post_title; 
        $osi[$key]["posted_unix_time"] = $value->posted_unix_time; 
        $osi[$key]["total_responses"] = $value->total_responses; 
        
        $trigger_name = DB::table('triggers')->where('trigger_id', $value->trigger_id)->value('trigger');    

        $user_name = DB::table('users')->where('id', $value->user_id)->value('name'); 
        $user_image_url = DB::table('users')->where('id', $value->user_id)->value('image_url'); 
        $osi[$key]["trigger_name"] = $trigger_name;  
        $osi[$key]["user_name"] = $user_name;  
        $osi[$key]["user_image_url"] = $user_image_url;  

        $last_id = $value->post_id;

        
      }
      $myJSON_recent = $osi;

      return view('index', ['myJSON_recent' => $myJSON_recent,'recent_exists'=>  '1','last_id'=>$last_id,'search_type' => "", 'search_cat'=> '','look_for_comment' => '']);

     # return view('index');

      
    }
    else{

      return view('index', ['recent_exists'=>  '0','last_id'=>0,'search_type' => "", 'search_cat'=> '','look_for_comment' => '']);
    }
    



    
  }

  public function get_more_records(Request $request){
    $query_type = $request->query_type;

    if($query_type =="recent"){
      $myCart = DB::table('posts')->where('is_approval', '>=', 0)->limit(5)->orderBy('post_id', 'DESC')->where('post_id', '<', $request->last_record_recent)->get();
     
      
      if (!$myCart->isEmpty()) {
        foreach($myCart as $key => $value){

          // dd($value->post);

          $osi[$key]["post"] = $value->post;
          $osi[$key]["post_id"] = $value->post_id;
          $osi[$key]["post"] = $value->post;
          $osi[$key]["user_id"] = $value->user_id;   
          $osi[$key]["trigger_id"] = $value->trigger_id;  
          $osi[$key]["post_title"] = $value->post_title; 
          $osi[$key]["posted_unix_time"] = $value->posted_unix_time; 
          $osi[$key]["total_responses"] = $value->total_responses; 


          
          $trigger_name = DB::table('triggers')->where('trigger_id', $value->trigger_id)->value('trigger');    

          $user_name = DB::table('users')->where('id', $value->user_id)->value('name'); 
          $user_image_url = DB::table('users')->where('id', $value->user_id)->value('image_url'); 
          $osi[$key]["trigger_name"] = $trigger_name;  
          $osi[$key]["user_name"] = $user_name;  
          $osi[$key]["user_image_url"] = $user_image_url;  

          
        }
        $myJSON_recent = $osi;



        return $myJSON_recent;


     }
     else{
      return "no record";

     }
   }



   


  }

  public function query(Request $request, $id){

    //dd($id);

    $specific_query = DB::table('posts')->where('is_approval', '>=', 0)->where('post_id', '=', $id)->get();

    $parent_comments =  DB::table('comments')->where('is_approval', '>=', 0)->where('post_id', '=', $id)->where('parent_comment_id', '=', 0)->get();
    //dd($parent_comments);
    if (!$parent_comments->isEmpty()) {

      return view('query', ['specific_query' => $specific_query,'parent_comments'=>  $parent_comments,'current_post_id'=>$id,'answer_exists'=>'1']);
    }
    else{

      return view('query', ['specific_query' => $specific_query,'current_post_id'=>$id,'answer_exists'=>'0']);

    }

    #return view('query');
  }
  public function ask_query(Request $request){

    try {
      #  echo (string) $request->refernce_url . "\n";
      $reference_url = "https://pages.mtu.edu/~shanem/AI-web/google.html?transform=".(string) $request->transform."&image=".(string) $request->image;

      if(((string) $request->transform == "")|| ((string) $request->image=="")){
        $reference_url = "";
      }

      /*(string) $request->reference_url;*/
      
    } catch (Exception $e) {
       # echo 'Caught exception: ',  $e->getMessage(), "\n";
      $reference_url = "";
    }

    return view('ask_query', ['reference_url' => $reference_url]);
  }


  public function need_to_login(Request $request){

    Session::put('login_specific_redirect', (string) $request->redirect_to);


   // return view('ask_query');
  }

  public function add_comment(Request $request){

    ##$request->trigger_id is now contains trigger name

    if (DB::table('triggers')->where('trigger', '=', $request->trigger_id)->where('trigger_belong_to', '=', 'qus')->count() > 0) {
       // user found



      $updateDetailsUsers=array(
            'trigger_belong_to' => 'all'
          );

          DB::table('triggers')
          ->where('trigger', '=', $request->trigger_id)->where('trigger_belong_to', '=', 'qus')
          ->update($updateDetailsUsers); 

          $trigger_id = DB::table('triggers')->where('trigger', '=', $request->trigger_id)->where('trigger_belong_to', '=', 'all')->value('trigger_id');          



     // $trigger_id = DB::table('tags')->where('trigger', '=', $request->trigger_id)->where('trigger_belong_to', '=', 'qus')->value('tag_id'); 


    }elseif (DB::table('triggers')->where('trigger', '=', $request->trigger_id)->where('trigger_belong_to', '=', 'ans')->count() > 0) {
      # code...
      $trigger_id = DB::table('triggers')->where('trigger', '=', $request->trigger_id)->where('trigger_belong_to', '=', 'ans')->value('trigger_id'); 

    }elseif (DB::table('triggers')->where('trigger', '=', $request->trigger_id)->where('trigger_belong_to', '=', 'all')->count() > 0) {
      # code...
      $trigger_id = DB::table('triggers')->where('trigger', '=', $request->trigger_id)->where('trigger_belong_to', '=', 'all')->value('trigger_id'); 

    }

    else{


      $bike_save = New triggers;
      $bike_save ->trigger = $request->trigger_id;
      $bike_save ->trigger_header = "NONE";
      $bike_save ->trigger_belong_to = "ans";
      $bike_save -> save();
      $trigger_id = $bike_save->id;

    }



    $bike_save = New comments;

    $bike_save ->comment = str_replace('<br>', "\n", $request->comment);
             
    $bike_save ->trigger_id = $trigger_id;
    $bike_save ->post_id = $request->post_id;
    $bike_save ->parent_comment_id = $request->parent_comment_id;
    $bike_save ->commented_unix_time = $request->commented_unix_time;
    $bike_save ->user_id = Auth::user()->id;
    $bike_save -> save();
    $comment_id =  $bike_save ->id;
    if((int) $comment_id > 0){
       $number_comments = DB::table('posts')->where('is_approval', '>=', 0)->where('post_id', $request->post_id)->value('total_responses'); 
       $number_comments = (int) $number_comments + 1;

       $updateDetailsUsers=array(
          'total_responses' => $number_comments,
          'is_answered' => 1
        );

        DB::table('posts')
        ->where('post_id', $request->post_id)->where('is_approval', '>=', 0)
        ->update($updateDetailsUsers);       

    }

    return $comment_id ;

   





   // return view('ask_query');
  }

  public function search_home(Request $request){
      $myCart = DB::table('tags')->get();

      $i = 0;
      if (!$myCart->isEmpty()) {
        foreach($myCart as $key => $value){

          // dd($value->post);

          $osi[$i]["search"] = $value->tag . " - Tag"  ;
         
          $i=$i +1;
          

          
        }
      }

      $myCart = DB::table('triggers')->where('trigger_id', '>', 0)->where('trigger_belong_to', '=', 'qus')->orWhere('trigger_belong_to', '=', 'all')->get();
      if (!$myCart->isEmpty()) {
        foreach($myCart as $key => $value){

          // dd($value->post);

          $osi[$i]["search"] = $value->trigger . " - Topic"  ;
          $i=$i +1;

          

          
        }
      }

      $myCart = DB::table('posts')->where('post_id', '>', 0)->where('is_approval', '>=', 0)->get();

      if (!$myCart->isEmpty()) {
        foreach($myCart as $key => $value){

          // dd($value->post);



          $osi[$i]["search"] = $value->post_title . " - Title"  ;
          $i=$i +1;

          

          
        }
      }

 
      $myCart = DB::table('users')
              # ->join('users', 'posts.user_id', '=', 'users.id')
              #->join('triggers', 'post_triggers.trigger_id', '=', 'triggers.trigger_id')
              ->where('users.id', '>', 0)
              // ->select('posts.post_id','posts.post','posts.user_id','posts.trigger_id','posts.posted_unix_time','posts.created_at','posts.updated_at','posts.post_title','posts.is_top_query','posts.total_responses','posts.is_answered','posts.user_id')
              ->distinct()->get();

      if (!$myCart->isEmpty()) {
        foreach($myCart as $key => $value){

          // dd($value->post);



          $osi[$i]["search"] = $value->name . " - Author"  ;
          $i=$i +1;

          

          
        }
      }


      $myJSON_recent = $osi;

       


     

      return  $myJSON_recent;


  }


  public function index_populate($myCart){


    if (!$myCart->isEmpty()) {
      foreach($myCart as $key => $value){

        // dd($value->post);

        $osi[$key]["post"] = $value->post;
        $osi[$key]["post_id"] = $value->post_id;
        $osi[$key]["post"] = $value->post;
        $osi[$key]["user_id"] = $value->user_id;   
        $osi[$key]["trigger_id"] = $value->trigger_id;  
        $osi[$key]["post_title"] = $value->post_title; 
        $osi[$key]["posted_unix_time"] = $value->posted_unix_time; 
        $osi[$key]["total_responses"] = $value->total_responses; 
        
        $trigger_name = DB::table('triggers')->where('trigger_id', $value->trigger_id)->value('trigger');    

        $user_name = DB::table('users')->where('id', $value->user_id)->value('name'); 
        $user_image_url = DB::table('users')->where('id', $value->user_id)->value('image_url'); 
        $osi[$key]["trigger_name"] = $trigger_name;  
        $osi[$key]["user_name"] = $user_name;  
        $osi[$key]["user_image_url"] = $user_image_url;  

        $last_id = $value->post_id;

        
      }
      $myJSON_recent = $osi;

      return view('index', ['myJSON_recent' => $myJSON_recent,'recent_exists'=>  '1','last_id'=>$last_id,'look_for_comment' => '']);

     # return view('index');

      
    }
    else{

      return view('index', ['recent_exists'=>  '0','last_id'=>0,'look_for_comment' => '']);
    }
          

  }

  public function get_tags(Request $request){

    $tags = DB::table('tags')->where('tag_id', '>', 0)->get();
    return $tags;
  }



  public function search_index(Request $request){


// $query = User::query();

// if ($this == $that) {
//   $query = $query->where('this', 'that');
// }

// if ($this == $another_thing) {
//   $query = $query->where('this', 'another_thing');
// }

// if ($this == $yet_another_thing) {
//   $query = $query->orderBy('this');
// }

// $results = $query->get();

      //https://stackoverflow.com/questions/38204188/how-to-build-dynamic-queries-with-laravel
    //https://www.tutorialrepublic.com/faq/how-to-extract-substring-from-a-string-in-php.php
    //https://stackoverflow.com/questions/37142882/php-check-if-string-contains-space-between-words-not-at-beginning-or-end

    $search_type = "";

    //dd($request->search);

   // dd(substr($request->search, -8));
  if(substr($request->search, -8) == "- Author"){
    $search_type = "Author";
    #dd(substr($request->search, 0, -9));
    $myCart1 = DB::table('posts')
              ->join('users', 'posts.user_id', '=', 'users.id')
              #->join('triggers', 'post_triggers.trigger_id', '=', 'triggers.trigger_id')
              ->where('posts.is_approval', '>=', 0)
              ->where('users.name', '=', substr($request->search, 0, -9))
               ->select('posts.post_id','posts.post','posts.user_id','posts.trigger_id','posts.posted_unix_time','posts.created_at','posts.updated_at','posts.post_title','posts.is_top_query','posts.total_responses','posts.is_answered','posts.user_id')->orderBy('posts.post_id', 'DESC')
              ->distinct()->get();

  $myCart2 = DB::table('comments')
              ->join('users', 'comments.user_id', '=', 'users.id')
              ->join('posts', 'posts.post_id', '=', 'comments.post_id')
              ->where('users.name', '=', substr($request->search, 0, -9))
              ->where('posts.is_approval', '>=', 0)
              ->where('comments.is_approval', '>=', 0)
               ->select('posts.post_id','posts.post','posts.user_id','posts.trigger_id','posts.posted_unix_time','posts.created_at','posts.updated_at','posts.post_title','posts.is_top_query','posts.total_responses','posts.is_answered','posts.user_id')->orderBy('posts.post_id', 'DESC')
              ->distinct()->get();

$myCart = $myCart1->merge($myCart2);
$myCart =$myCart->unique();

        if (!$myCart->isEmpty()) {
          foreach($myCart as $key => $value){

            // dd($value->post);

            $osi[$key]["post"] = $value->post;
            $osi[$key]["post_id"] = $value->post_id;
            $osi[$key]["post"] = $value->post;
            $osi[$key]["user_id"] = $value->user_id;   
            $osi[$key]["trigger_id"] = $value->trigger_id;  
            $osi[$key]["post_title"] = $value->post_title; 
            $osi[$key]["posted_unix_time"] = $value->posted_unix_time; 
            $osi[$key]["total_responses"] = $value->total_responses; 
            
            $trigger_name = DB::table('triggers')->where('trigger_id', $value->trigger_id)->value('trigger');    

            $user_name = DB::table('users')->where('id', $value->user_id)->value('name'); 
            $user_image_url = DB::table('users')->where('id', $value->user_id)->value('image_url'); 
            $osi[$key]["trigger_name"] = $trigger_name;  
            $osi[$key]["user_name"] = $user_name;  
            $osi[$key]["user_image_url"] = $user_image_url;  

            $last_id = $value->post_id;

            
          }
          $myJSON_recent = $osi;

          return view('index', ['myJSON_recent' => $myJSON_recent,'recent_exists'=>  '1','last_id'=>$last_id,'search_type' => $request->search,'search_cat' => 'Author','look_for_comment' => '']);
        }

        else{

          return view('index', ['recent_exists'=>  '0','last_id'=>0,'search_type' =>"",'search_cat' => '','look_for_comment' => '']);
        }  

  }

  elseif ($request->search == 'answered_queries') {
    # code...

    $search_type = "Answered";
    #dd(substr($request->search, 0, -9));
    $myCart = DB::table('posts')
              ->join('comments', 'posts.post_id', '=', 'comments.post_id')
              #->join('triggers', 'post_triggers.trigger_id', '=', 'triggers.trigger_id')
              ->where('posts.post_id', '>', 0)
              ->where('posts.is_approval', '>=', 0)
              ->where('comments.is_approval', '>=', 0)
               ->select('posts.post_id','posts.post','posts.user_id','posts.trigger_id','posts.posted_unix_time','posts.created_at','posts.updated_at','posts.post_title','posts.is_top_query','posts.total_responses','posts.is_answered','posts.user_id')->orderBy('posts.post_id', 'DESC')
              ->distinct()->get();

        if (!$myCart->isEmpty()) {
          foreach($myCart as $key => $value){

            // dd($value->post);

            $osi[$key]["post"] = $value->post;
            $osi[$key]["post_id"] = $value->post_id;
            $osi[$key]["post"] = $value->post;
            $osi[$key]["user_id"] = $value->user_id;   
            $osi[$key]["trigger_id"] = $value->trigger_id;  
            $osi[$key]["post_title"] = $value->post_title; 
            $osi[$key]["posted_unix_time"] = $value->posted_unix_time; 
            $osi[$key]["total_responses"] = $value->total_responses; 
            
            $trigger_name = DB::table('triggers')->where('trigger_id', $value->trigger_id)->value('trigger');    

            $user_name = DB::table('users')->where('id', $value->user_id)->value('name'); 
            $user_image_url = DB::table('users')->where('id', $value->user_id)->value('image_url'); 
            $osi[$key]["trigger_name"] = $trigger_name;  
            $osi[$key]["user_name"] = $user_name;  
            $osi[$key]["user_image_url"] = $user_image_url;  

            $last_id = $value->post_id;

            
          }
          $myJSON_recent = $osi;

          return view('index', ['myJSON_recent' => $myJSON_recent,'recent_exists'=>  '1','last_id'=>$last_id,'search_type' => $request->search,'search_cat' => 'Answered','look_for_comment' => '']);
        }

        else{

          return view('index', ['recent_exists'=>  '0','last_id'=>0,'search_type' =>"",'search_cat' => '','look_for_comment' => '']);
        }


  }
    
  elseif(substr($request->search, -7) == "- Title"){

        $search_type = "Title";

        $myCart = DB::table('posts')->where('is_approval', '>=', 0)->where('post_title', substr($request->search, 0, -8))->orderBy('post_id', 'DESC')->distinct()->get();
       // QAController::index_populate($myCart);

        if (!$myCart->isEmpty()) {
          foreach($myCart as $key => $value){

            // dd($value->post);

            $osi[$key]["post"] = $value->post;
            $osi[$key]["post_id"] = $value->post_id;
            $osi[$key]["post"] = $value->post;
            $osi[$key]["user_id"] = $value->user_id;   
            $osi[$key]["trigger_id"] = $value->trigger_id;  
            $osi[$key]["post_title"] = $value->post_title; 
            $osi[$key]["posted_unix_time"] = $value->posted_unix_time; 
            $osi[$key]["total_responses"] = $value->total_responses; 
            
            $trigger_name = DB::table('triggers')->where('trigger_id', $value->trigger_id)->value('trigger');    

            $user_name = DB::table('users')->where('id', $value->user_id)->value('name'); 
            $user_image_url = DB::table('users')->where('id', $value->user_id)->value('image_url'); 
            $osi[$key]["trigger_name"] = $trigger_name;  
            $osi[$key]["user_name"] = $user_name;  
            $osi[$key]["user_image_url"] = $user_image_url;  

            $last_id = $value->post_id;

            
          }
          $myJSON_recent = $osi;

          return view('index', ['myJSON_recent' => $myJSON_recent,'recent_exists'=>  '1','last_id'=>$last_id,'search_type' => $request->search,'search_cat' => 'Title','look_for_comment' => '']);
        }

        else{

          return view('index', ['recent_exists'=>  '0','last_id'=>0,'search_type' =>"",'search_cat' => '','look_for_comment' => '']);
        }        



  }
  elseif(substr($request->search, -7) == "- Topic"){
      $search_type = "Trigger";
     // dd(substr($request->search, 0, -8));

      $trigger_id = DB::table('triggers')->where('trigger', substr($request->search, 0, -8))->value('trigger_id'); 




      if ($trigger_id != 0) {

        $myCart = DB::table('post_triggers')
              ->join('posts', 'posts.post_id', '=', 'post_triggers.post_id')
              ->join('triggers', 'post_triggers.trigger_id', '=', 'triggers.trigger_id')
              ->where('triggers.trigger_id', $trigger_id)
              ->where('posts.is_approval', '>=', 0)
              ->select('posts.post_id','posts.post','posts.user_id','posts.trigger_id','posts.posted_unix_time','posts.created_at','posts.updated_at','posts.post_title','posts.is_top_query','posts.total_responses','posts.is_answered','triggers.trigger')
              ->distinct()->get();

              // dd($myCart);





        #DB::table('posts')->orderBy('post_id', 'DESC')->where('trigger_id', $trigger_id )->get();


       // QAController::index_populate($myCart);
        if (!$myCart->isEmpty()) {
          foreach($myCart as $key => $value){

            // dd($value->post);

            $osi[$key]["post"] = $value->post;
            $osi[$key]["post_id"] = $value->post_id;
            $osi[$key]["post"] = $value->post;
            $osi[$key]["user_id"] = $value->user_id;   
            $osi[$key]["trigger_id"] = $value->trigger_id;  
            $osi[$key]["post_title"] = $value->post_title; 
            $osi[$key]["posted_unix_time"] = $value->posted_unix_time; 
            $osi[$key]["total_responses"] = $value->total_responses; 
            
            $trigger_name = DB::table('triggers')->where('trigger_id', $value->trigger_id)->value('trigger');    

            $user_name = DB::table('users')->where('id', $value->user_id)->value('name'); 
            $user_image_url = DB::table('users')->where('id', $value->user_id)->value('image_url'); 
            $osi[$key]["trigger_name"] = $trigger_name;  
            $osi[$key]["user_name"] = $user_name;  
            $osi[$key]["user_image_url"] = $user_image_url;  

            $last_id = $value->post_id;

            
          }
          $myJSON_recent = $osi;

          return view('index', ['myJSON_recent' => array_reverse($myJSON_recent),'recent_exists'=>  '1','last_id'=>$last_id,'search_type' => $request->search,'search_cat' => 'Topic','look_for_comment' => '']);

         # return view('index');

          
        }
        else{

          return view('index', ['recent_exists'=>  '0','last_id'=>0,'search_type' =>"",'search_cat' => '','look_for_comment' => '']);
        }

      }
      else{
        return view('index', ['recent_exists'=>  '0','last_id'=>0,'search_type' =>"",'search_cat' => '','look_for_comment' => '']);
      }
    }
elseif (substr($request->search, -5) == "- Tag") {
      # code...

      $search_type = "Tag";

      $tag_id = DB::table('tags')->where('tag', substr($request->search, 0, -6))->value('tag_id'); 

      if ($tag_id != 0) {

        //$myCart = DB::table('posts')->orderBy('post_id', 'DESC')->where('trigger_id', $trigger_id )->get();


        $myCart = DB::table('post_tags')
              ->join('posts', 'posts.post_id', '=', 'post_tags.post_id')
              ->join('tags', 'post_tags.tag_id', '=', 'tags.tag_id')
              ->where('tags.tag_id', $tag_id)
              ->where('posts.is_approval', '>=', 0)
              ->select('posts.post_id','posts.post','posts.user_id','posts.trigger_id','posts.posted_unix_time','posts.created_at','posts.updated_at','posts.post_title','posts.is_top_query','posts.total_responses','posts.is_answered')
              ->distinct()->get();
             // dd($myCart);





        //QAController::index_populate($myCart);

        if (!$myCart->isEmpty()) {
          foreach($myCart as $key => $value){

            // dd($value->post);

            $osi[$key]["post"] = $value->post;
            $osi[$key]["post_id"] = $value->post_id;
            $osi[$key]["post"] = $value->post;
            $osi[$key]["user_id"] = $value->user_id;   
            $osi[$key]["trigger_id"] = $value->trigger_id;  
            $osi[$key]["post_title"] = $value->post_title; 
            $osi[$key]["posted_unix_time"] = $value->posted_unix_time; 
            $osi[$key]["total_responses"] = $value->total_responses; 
            
            $trigger_name = DB::table('triggers')->where('trigger_id', $value->trigger_id)->value('trigger');    

            $user_name = DB::table('users')->where('id', $value->user_id)->value('name'); 
            $user_image_url = DB::table('users')->where('id', $value->user_id)->value('image_url'); 
            $osi[$key]["trigger_name"] = $trigger_name;  
            $osi[$key]["user_name"] = $user_name;  
            $osi[$key]["user_image_url"] = $user_image_url;  

            $last_id = $value->post_id;

            
          }
          $myJSON_recent = $osi;

          return view('index', ['myJSON_recent' => array_reverse($myJSON_recent),'recent_exists'=>  '1','last_id'=>$last_id,'search_type' => $request->search,'search_cat' => 'Tag' ,'look_for_comment' => '']);

         # return view('index');

          
        }
        else{

          return view('index', ['recent_exists'=>  '0','last_id'=>0,'search_type' => "",'search_cat' => '','look_for_comment' => '']);
        }
      }
      else{
        return view('index', ['recent_exists'=>  '0','last_id'=>0,'search_type' => "",'search_cat' => '','look_for_comment' => '']);
      }
    }

    elseif ($request->search == trim($request->search) && strpos($request->search, ' ') !== false) {
        # code...
        $search_item = $request->search;
        $search_type = "Words";
        $search_item = strtolower($search_item);

        $search_item_array = explode(" ",$search_item);


                      $remove_items_from_array = array( 'a', 'an', 'the', 'and', 'or', 'but', 'aboard', 'about', 'above', 'across', 'after', 'against', 'along', 'amid', 'among', 'anti', 'around', 'as', 'at', 'before', 'behind', 'below', 'beneath', 'beside', 'besides', 'between', 'beyond', 'but', 'by', 'concerning', 'considering', 'despite', 'down', 'during', 'except', 'excepting', 'excluding', 'following', 'for', 'from', 'in', 'inside', 'into', 'like', 'minus', 'near', 'of', 'off', 'on', 'onto', 'opposite', 'outside', 'over', 'past', 'per', 'plus', 'regarding', 'round', 'save', 'since', 'than', 'through', 'to', 'toward', 'towards', 'under', 'underneath', 'unlike', 'until', 'up', 'upon', 'versus', 'via', 'with', 'within', 'without', '&' );

                      $search_item_array = array_diff($search_item_array,$remove_items_from_array);
                      $search_item_array = array_values($search_item_array);


########first level of search

        $myCart1 = DB::table('posts')->where('is_approval', '>=', 0)->where('post_title', 'LIKE', '%'.$search_item.'%')->select('posts.post_id','posts.post','posts.user_id','posts.trigger_id','posts.posted_unix_time','posts.created_at','posts.updated_at','posts.post_title','posts.is_top_query','posts.total_responses','posts.is_answered')->orderBy('post_id', 'DESC')->distinct()->get();


        $myCart2 = DB::table('posts')->where('is_approval', '>=', 0)->where('post', 'LIKE', '%'.$search_item.'%')->where('post_title', 'not like', '%'.$search_item.'%')->select('posts.post_id','posts.post','posts.user_id','posts.trigger_id','posts.posted_unix_time','posts.created_at','posts.updated_at','posts.post_title','posts.is_top_query','posts.total_responses','posts.is_answered')->orderBy('post_id', 'DESC')->distinct()->get();


        $myCart_temp = $myCart1->merge($myCart2);
        $myCart_temp =$myCart_temp->unique();



        $myCart7 = DB::table('comments')
              ->join('posts', 'posts.post_id', '=', 'comments.post_id')
              ->where('comments.is_approval', '>=', 0)
              // ->where('tags.tag_id', $tag_id)
              ->where('posts.is_approval', '>=', 0)
              ->where('posts.post_id', '<', 0) ##because now it is showing in comment in separate query , stopping this query
              ->where('comments.comment', 'LIKE', '%'.$search_item.'%')
              ->select('posts.post_id','posts.post','posts.user_id','posts.trigger_id','posts.posted_unix_time','posts.created_at','posts.updated_at','posts.post_title','posts.is_top_query','posts.total_responses','posts.is_answered')->orderBy('posts.post_id', 'DESC')
              ->distinct()->get();

          $myCart_temp1 = $myCart_temp->merge($myCart7);
          $myCart_temp1 =$myCart_temp1->unique();    


######################  


#####################second level of search

        $query = DB::table('posts')->select('posts.post_id','posts.post','posts.user_id','posts.trigger_id','posts.posted_unix_time','posts.created_at','posts.updated_at','posts.post_title','posts.is_top_query','posts.total_responses','posts.is_answered','posts.user_id');

          for ($x = 0; $x < count($search_item_array); $x++) {

            if($x == 0){
                $query =$query->where('post_title', 'LIKE', '%'.$search_item_array[$x].'%');
            }
            else{
                $query = $query->where('post_title', 'LIKE', '%'.$search_item_array[$x].'%');
            }

            
          } 


          $myCart9 = $query->where('posts.is_approval', '>=', 0)->orderBy('posts.post_id', 'DESC')
                  ->distinct()->get();
         


          $myCart_temp = $myCart_temp1->merge($myCart9);
          $myCart_temp =$myCart_temp->unique();

         $query = DB::table('posts')->select('posts.post_id','posts.post','posts.user_id','posts.trigger_id','posts.posted_unix_time','posts.created_at','posts.updated_at','posts.post_title','posts.is_top_query','posts.total_responses','posts.is_answered','posts.user_id');

            for ($x = 0; $x < count($search_item_array); $x++) {

              if($x == 0){
                  $query =$query->where('post', 'LIKE', '%'.$search_item_array[$x].'%')->where('post_title', 'not like', '%'.$search_item_array[$x].'%');
              }
              else{
                  $query = $query->where('post', 'LIKE', '%'.$search_item_array[$x].'%')->where('post_title', 'not like', '%'.$search_item_array[$x].'%');
              }

              
            } 


            $myCart10 = $query->where('posts.is_approval', '>=', 0)->orderBy('posts.post_id', 'DESC')
                    ->distinct()->get();
           


            $myCart_temp1 = $myCart_temp->merge($myCart10);
            $myCart_temp1 =$myCart_temp1->unique();

          $query = DB::table('comments')
              ->join('posts', 'posts.post_id', '=', 'comments.post_id')
              ->where('posts.post_id', '<', 0)
              ->select('posts.post_id','posts.post','posts.user_id','posts.trigger_id','posts.posted_unix_time','posts.created_at','posts.updated_at','posts.post_title','posts.is_top_query','posts.total_responses','posts.is_answered','posts.user_id');

            for ($x = 0; $x < count($search_item_array); $x++) {

              if($x == 0){
                  $query =$query->where('comments.comment', 'LIKE', '%'.$search_item_array[$x].'%');
              }
              else{
                  $query = $query->where('comments.comment', 'LIKE', '%'.$search_item_array[$x].'%');
              }

              
            }
            $myCart11 = $query->where('posts.is_approval', '>=', 0)->where('comments.is_approval', '>=', 0)->orderBy('posts.post_id', 'DESC')
                    ->distinct()->get();
          $myCart_temp = $myCart_temp1->merge($myCart11);
          $myCart_temp =$myCart_temp->unique(); 





###############third level of search


        $query = DB::table('posts')->select('posts.post_id','posts.post','posts.user_id','posts.trigger_id','posts.posted_unix_time','posts.created_at','posts.updated_at','posts.post_title','posts.is_top_query','posts.total_responses','posts.is_answered','posts.user_id');

          for ($x = 0; $x < count($search_item_array); $x++) {

            if($x == 0){
                $query =$query->where('post_title', 'LIKE', '%'.$search_item_array[$x].'%');
            }
            else{
                $query = $query->orWhere('post_title', 'LIKE', '%'.$search_item_array[$x].'%');
            }

            
          } 


          $myCart3 = $query->where('posts.is_approval', '>=', 0)->orderBy('posts.post_id', 'DESC')
                  ->distinct()->get();
         


          $myCart_temp1 = $myCart_temp->merge($myCart3);
          $myCart_temp1 =$myCart_temp1->unique();

          $query = DB::table('posts')->select('posts.post_id','posts.post','posts.user_id','posts.trigger_id','posts.posted_unix_time','posts.created_at','posts.updated_at','posts.post_title','posts.is_top_query','posts.total_responses','posts.is_answered','posts.user_id');

            for ($x = 0; $x < count($search_item_array); $x++) {

              if($x == 0){
                  $query =$query->where('post', 'LIKE', '%'.$search_item_array[$x].'%')->where('post_title', 'not like', '%'.$search_item_array[$x].'%');
              }
              else{
                  $query = $query->orWhere('post', 'LIKE', '%'.$search_item_array[$x].'%')->where('post_title', 'not like', '%'.$search_item_array[$x].'%');
              }

              
            } 


            $myCart4 = $query->where('posts.is_approval', '>=', 0)->orderBy('posts.post_id', 'DESC')
                    ->distinct()->get();
           


            $myCart_temp = $myCart_temp1->merge($myCart4);
            $myCart_temp =$myCart_temp->unique();



########

        // $myCart7 = DB::table('comments')
        //       ->join('posts', 'posts.post_id', '=', 'comments.post_id')
        //       ->where('comments.is_approval', '>=', 0)
        //       // ->where('tags.tag_id', $tag_id)
        //       ->where('posts.is_approval', '>=', 0)
        //       ->where('comments.comment', 'LIKE', '%'.$search_item.'%')
        //       ->select('posts.post_id','posts.post','posts.user_id','posts.trigger_id','posts.posted_unix_time','posts.created_at','posts.updated_at','posts.post_title','posts.is_top_query','posts.total_responses','posts.is_answered')->orderBy('posts.post_id', 'DESC')
        //       ->distinct()->get();

        //   $myCart_temp1 = $myCart_temp->merge($myCart7);
        //   $myCart_temp1 =$myCart_temp1->unique();    

          $query = DB::table('comments')
              ->join('posts', 'posts.post_id', '=', 'comments.post_id')
              ->where('posts.post_id', '<', 0)
              ->select('posts.post_id','posts.post','posts.user_id','posts.trigger_id','posts.posted_unix_time','posts.created_at','posts.updated_at','posts.post_title','posts.is_top_query','posts.total_responses','posts.is_answered','posts.user_id');

            for ($x = 0; $x < count($search_item_array); $x++) {

              if($x == 0){
                  $query =$query->where('comments.comment', 'LIKE', '%'.$search_item_array[$x].'%');
              }
              else{
                  $query = $query->orWhere('comments.comment', 'LIKE', '%'.$search_item_array[$x].'%');
              }

              
            }
            $myCart8 = $query->where('posts.is_approval', '>=', 0)->where('comments.is_approval', '>=', 0)->orderBy('posts.post_id', 'DESC')
                    ->distinct()->get();
          $myCart_temp1 = $myCart_temp->merge($myCart8);
          $myCart_temp1 =$myCart_temp1->unique(); 
 
############ fourth lebel of search - tags
        $myCart5 = DB::table('post_tags')
              ->join('posts', 'posts.post_id', '=', 'post_tags.post_id')
              ->join('tags', 'post_tags.tag_id', '=', 'tags.tag_id')
              // ->where('tags.tag_id', $tag_id)
              ->where('posts.is_approval', '>=', 0)
              ->where('tags.tag', 'LIKE', '%'.$search_item.'%')
              ->select('posts.post_id','posts.post','posts.user_id','posts.trigger_id','posts.posted_unix_time','posts.created_at','posts.updated_at','posts.post_title','posts.is_top_query','posts.total_responses','posts.is_answered')->orderBy('posts.post_id', 'DESC')
              ->distinct()->get();
          $myCart_temp = $myCart_temp1->merge($myCart5);
          $myCart_temp =$myCart_temp->unique();

          $query = DB::table('post_tags')
              ->join('posts', 'posts.post_id', '=', 'post_tags.post_id')
              ->join('tags', 'post_tags.tag_id', '=', 'tags.tag_id')->select('posts.post_id','posts.post','posts.user_id','posts.trigger_id','posts.posted_unix_time','posts.created_at','posts.updated_at','posts.post_title','posts.is_top_query','posts.total_responses','posts.is_answered','posts.user_id');


            for ($x = 0; $x < count($search_item_array); $x++) {

              if($x == 0){
                  $query =$query->where('tags.tag', 'LIKE', '%'.$search_item_array[$x].'%');
              }
              else{
                  $query = $query->orWhere('tags.tag', 'LIKE', '%'.$search_item_array[$x].'%');
              }

              
            }
            $myCart6 = $query->where('posts.is_approval', '>=', 0)->orderBy('posts.post_id', 'DESC')
                    ->distinct()->get();

          $myCart_temp1 = $myCart_temp->merge($myCart6);
          $myCart_temp1 =$myCart_temp1->unique();                    
 
          $myCart = $myCart_temp;

        if (!$myCart->isEmpty()) {
          foreach($myCart as $key => $value){

            // dd($value->post);

            $osi[$key]["post"] = $value->post;
            $osi[$key]["post_id"] = $value->post_id;
            $osi[$key]["post"] = $value->post;
            $osi[$key]["user_id"] = $value->user_id;   
            $osi[$key]["trigger_id"] = $value->trigger_id;  
            $osi[$key]["post_title"] = $value->post_title; 
            $osi[$key]["posted_unix_time"] = $value->posted_unix_time; 
            $osi[$key]["total_responses"] = $value->total_responses; 
            
            $trigger_name = DB::table('triggers')->where('trigger_id', $value->trigger_id)->value('trigger');    

            $user_name = DB::table('users')->where('id', $value->user_id)->value('name'); 
            $user_image_url = DB::table('users')->where('id', $value->user_id)->value('image_url'); 
            $osi[$key]["trigger_name"] = $trigger_name;  
            $osi[$key]["user_name"] = $user_name;  
            $osi[$key]["user_image_url"] = $user_image_url;  

            $last_id = $value->post_id;

            
          }
          $myJSON_recent = $osi;

          return view('index', ['myJSON_recent' => $myJSON_recent,'recent_exists'=>  '1','last_id'=>$last_id,'search_type' => $request->search,'search_cat' => 'Words','look_for_comment' => 'Words']);

         # return view('index');

          
        }
        else{

          return view('index', ['recent_exists'=>  '0','last_id'=>0,'search_type' =>$request->search,'search_cat' => '','look_for_comment' => 'Words']);
        }


      }  

    else{


        if(substr($request->search, -6) == "- Word"){
            $search_item = str_replace(' ', '', substr($request->search, 0, -7));

            //dd($search_item);
        }
        else{
          $search_item = str_replace(' ', '', $request->search);
          

        }
  
        $search_type = "Word";

        $myCart1 = DB::table('posts')->where('is_approval', '>=', 0)->where('post_title', 'LIKE', '%'.$search_item.'%')->select('posts.post_id','posts.post','posts.user_id','posts.trigger_id','posts.posted_unix_time','posts.created_at','posts.updated_at','posts.post_title','posts.is_top_query','posts.total_responses','posts.is_answered')->orderBy('post_id', 'DESC')->distinct()->get();


        $myCart2 = DB::table('posts')->where('is_approval', '>=', 0)->where('post', 'LIKE', '%'.$search_item.'%')->where('post_title', 'not like', '%'.$search_item.'%')->select('posts.post_id','posts.post','posts.user_id','posts.trigger_id','posts.posted_unix_time','posts.created_at','posts.updated_at','posts.post_title','posts.is_top_query','posts.total_responses','posts.is_answered')->orderBy('post_id', 'DESC')->distinct()->get();
       // $mm = $myCart1 + $myCart;
        $myCart_prev = DB::table('posts')->where('is_approval', '>=', 0)->where('post', 'LIKE', '%'.$search_item.'%')->orderBy('post_id', 'DESC')->distinct()->get();

        //dd($myCart_prev);
        $myCart_temp = $myCart1->merge($myCart2);
        $myCart_temp =$myCart_temp->unique();

        $tag_id = DB::table('tags')->where('tag', 'LIKE', $search_item)->value('tag_id'); 

      #if ($tag_id != 0) {

        //$myCart = DB::table('posts')->orderBy('post_id', 'DESC')->where('trigger_id', $trigger_id )->get();


        $myCart3 = DB::table('comments')
              ->join('posts', 'posts.post_id', '=', 'comments.post_id')
              ->where('comments.is_approval', '>=', 0)
              ->where('posts.post_id', '<', 0)
              // ->where('tags.tag_id', $tag_id)
              ->where('posts.is_approval', '>=', 0)
              ->where('comments.comment', 'LIKE', '%'.$search_item.'%')
              ->select('posts.post_id','posts.post','posts.user_id','posts.trigger_id','posts.posted_unix_time','posts.created_at','posts.updated_at','posts.post_title','posts.is_top_query','posts.total_responses','posts.is_answered')->orderBy('posts.post_id', 'DESC')
              ->distinct()->get();

        $myCart_temp1 = $myCart_temp->merge($myCart3);
        $myCart_temp1 =$myCart_temp1->unique();

        $myCart7 = DB::table('post_tags')
              ->join('posts', 'posts.post_id', '=', 'post_tags.post_id')
              ->join('tags', 'post_tags.tag_id', '=', 'tags.tag_id')
              // ->where('tags.tag_id', $tag_id)
              ->where('posts.is_approval', '>=', 0)
              ->where('tags.tag', 'LIKE', '%'.$search_item.'%')
              ->select('posts.post_id','posts.post','posts.user_id','posts.trigger_id','posts.posted_unix_time','posts.created_at','posts.updated_at','posts.post_title','posts.is_top_query','posts.total_responses','posts.is_answered')->orderBy('posts.post_id', 'DESC')
              ->distinct()->get();


          $myCart = $myCart_temp1->merge($myCart7);
          $myCart =$myCart->unique(); 


      #}



        // dd($myCart);
      
        #DB::table('post_triggers')
             # ->join('posts', 'posts.post_id', '=', 'post_triggers.post_id')
             # ->join('triggers', 'post_triggers.trigger_id', '=', 'triggers.trigger_id')
             # ->where('post', 'LIKE', '%'.$request->search.'%')
             # ->select('posts.post_id','posts.post','posts.user_id','posts.trigger_id','posts.posted_unix_time','posts.created_at','posts.updated_at','posts.post_title','posts.is_top_query','posts.total_responses','posts.is_answered')
              #->distinct()->get();

              // dd($myCart);





        #DB::table('posts')->orderBy('post_id', 'DESC')->where('trigger_id', $trigger_id )->get();


       // QAController::index_populate($myCart);
        if (!$myCart->isEmpty()) {
          foreach($myCart as $key => $value){

            // dd($value->post);

            $osi[$key]["post"] = $value->post;
            $osi[$key]["post_id"] = $value->post_id;
            $osi[$key]["post"] = $value->post;
            $osi[$key]["user_id"] = $value->user_id;   
            $osi[$key]["trigger_id"] = $value->trigger_id;  
            $osi[$key]["post_title"] = $value->post_title; 
            $osi[$key]["posted_unix_time"] = $value->posted_unix_time; 
            $osi[$key]["total_responses"] = $value->total_responses; 
            
            $trigger_name = DB::table('triggers')->where('trigger_id', $value->trigger_id)->value('trigger');    

            $user_name = DB::table('users')->where('id', $value->user_id)->value('name'); 
            $user_image_url = DB::table('users')->where('id', $value->user_id)->value('image_url'); 
            $osi[$key]["trigger_name"] = $trigger_name;  
            $osi[$key]["user_name"] = $user_name;  
            $osi[$key]["user_image_url"] = $user_image_url;  

            $last_id = $value->post_id;

            
          }
          $myJSON_recent = $osi;

          return view('index', ['myJSON_recent' => $myJSON_recent,'recent_exists'=>  '1','last_id'=>$last_id,'search_type' => $request->search,'search_cat' => 'Word','look_for_comment' => 'Word']);

         # return view('index');

          
        }
        else{

          return view('index', ['recent_exists'=>  '0','last_id'=>0,'search_type' =>$request->search,'search_cat' => '','look_for_comment' => 'Word']);
        }

      
      

    }


    ############

    



   // dd(explode(" - ",$request->search));
  }

  public function get_triggers_ans(Request $request){
    $triggers =  DB::table('triggers')->where('trigger_id', '>', 0)->where('trigger_belong_to', '=', 'ans')->orWhere('trigger_belong_to', '=', 'all')->orWhere('trigger_belong_to', '=', 'qus')->get();
    return $triggers;

  }
  public function check_last_vote(Request $request){

    if (vote_user_id_comment::where('user_id', '=', $request->user_id)->where('comment_id', '=', $request->comment_id)->exists()) {
       // user found
      if (vote_user_id_comment::where('user_id', '=', $request->user_id)->where('comment_id', '=', $request->comment_id)->where('last_vote', '=', $request->vote_type)->exists()) {

        return "not ok";

      }else{

       $updateDetailsUsers=array(
                'last_vote' => $request->vote_type
              );

              DB::table('vote_user_id_comments')
              ->where('user_id', '=', $request->user_id)->where('comment_id', '=', $request->comment_id)
              ->update($updateDetailsUsers); 

    $total_pos_vote =  vote_user_id_comment::where('comment_id', '=', $request->comment_id)->where('last_vote', '=', 1)->get()->count();
    $total_neg_vote =  vote_user_id_comment::where('comment_id', '=', $request->comment_id)->where('last_vote', '=', 0)->get()->count();
    $total_vote_for_this_comment =  $total_pos_vote - $total_neg_vote;


  
    $updateDetailsUsers=array(
            'vote' => $total_vote_for_this_comment
          );

          DB::table('comments')
          ->where('comment_id', '=', $request->comment_id)->where('is_approval', '>=', 0)
          ->update($updateDetailsUsers); 

    if(vote_user_id_comment::where('user_id', '=', $request->user_id)->where('comment_id', '=', $request->comment_id)->count() == 1){
      //if($request->vote_type == 1){

        if(($total_vote_for_this_comment == 1) || ($total_vote_for_this_comment == -1) ){
          $updateDetailsUsers=array(
                    'vote' => 0
                  );

                  DB::table('comments')
                  ->where('comment_id', '=', $request->comment_id)->where('is_approval', '>=', 0)
                  ->update($updateDetailsUsers); 

           DB::table('vote_user_id_comments')
              ->where('comment_id', '=', $request->comment_id)->delete();
          $total_vote_for_this_comment = 0;

        }



      //}

    }
          




        return $total_vote_for_this_comment;
      }



    }else{
      $bike_save = New vote_user_id_comment;

      $bike_save ->user_id = $request->user_id; 
      $bike_save ->comment_id = $request->comment_id; 
      $bike_save ->last_vote = $request->vote_type;           
      $bike_save -> save();

    $total_pos_vote =  vote_user_id_comment::where('comment_id', '=', $request->comment_id)->where('last_vote', '=', 1)->get()->count();
    $total_neg_vote =  vote_user_id_comment::where('comment_id', '=', $request->comment_id)->where('last_vote', '=', 0)->get()->count();
    $total_vote_for_this_comment =  $total_pos_vote - $total_neg_vote;
  
    $updateDetailsUsers=array(
            'vote' => $total_vote_for_this_comment
          );

          DB::table('comments')
          ->where('comment_id', '=', $request->comment_id)->where('is_approval', '>=', 0)
          ->update($updateDetailsUsers); 


      return $total_vote_for_this_comment;
    }



    

  }

  public function add_new_query(Request $request){
    // dd($request->triggers[0]);
     

    if(count($request->triggers) > 0){
      $tags_array = explode (",", $request->question_tags1); 
      
      $bike_save = New posts;
      $bike_save ->reference_url = $request->reference_url;  
      $bike_save ->post_title = str_replace('<br>', "\n", $request->post_title);
      #$request->post_title;          
      $bike_save ->trigger_id = 0;
      $bike_save ->post = str_replace('<br>', "\n", $request->post);
      #$request->post;
      $bike_save ->posted_unix_time = $request->posted_unix_time;
      $bike_save ->user_id = Auth::user()->id;
      $bike_save -> save();
      $post_id =  $bike_save ->id;



       


      if((int) $post_id > 0){

        if($request->custom_topics !=""){
          $custom_topics_array = explode (",", $request->custom_topics);
          for ($x = 0; $x < count($custom_topics_array); $x++) {
            if (triggers::where('trigger', '=', $custom_topics_array[$x])->where('trigger_belong_to', '=','ans')->exists()) {
               // user found

                $updateDetailsUsers=array(
                          'trigger_belong_to' => 'all'
                        );

                        DB::table('triggers')
                        ->where('trigger', '=', $custom_topics_array[$x])->where('trigger_belong_to', '=', 'ans')
                        ->update($updateDetailsUsers); 

                        $trigger_id = DB::table('triggers')->where('trigger', '=', $custom_topics_array[$x])->where('trigger_belong_to', '=', 'all')->value('trigger_id');


            }elseif (triggers::where('trigger', '=', $custom_topics_array[$x])->where('trigger_belong_to', '=','qus')->exists()) {


                        $trigger_id = DB::table('triggers')->where('trigger', '=', $custom_topics_array[$x])->where('trigger_belong_to', '=', 'qus')->value('trigger_id');


              # code...
            }elseif (triggers::where('trigger', '=', $custom_topics_array[$x])->where('trigger_belong_to', '=','all')->exists()) {

                $trigger_id = DB::table('triggers')->where('trigger', '=', $custom_topics_array[$x])->where('trigger_belong_to', '=', 'all')->value('trigger_id');
              # code...
            }else{

                    $bike_save = New triggers;
                    $bike_save ->trigger = $custom_topics_array[$x];
                    $bike_save ->trigger_header = "Custom Topics-Comments";
                    $bike_save ->trigger_belong_to = "qus";
                    $bike_save -> save();
                    $trigger_id = $bike_save->id;

            }
              $bike_save = New post_triggers;
              $bike_save ->trigger_id = $trigger_id;
              $bike_save ->post_id = $post_id;
              $bike_save -> save();



          }
          
        }

        if($request->reference_list!= ""){
          $custom_reference_list_array = explode (",", $request->reference_list);
        // use App\referenceurls;
        // use App\post_referenceurls;
          for ($x = 0; $x < count($custom_reference_list_array); $x++) {

              $bike_save = New referenceurls;
              $bike_save ->reference_url = $custom_reference_list_array[$x];
              $bike_save -> save();
              $referance_list_id = $bike_save->id;

              $bike_save = New post_referenceurls;
              $bike_save ->post_id = $post_id;
              $bike_save ->referance_list_id = $referance_list_id;
              $bike_save -> save();
              
          }


        }




        for ($x = 0; $x < count($tags_array); $x++) {

          if($tags_array[$x] !=""){
            if (DB::table('tags')->where('tag', '=', $tags_array[$x])->count() > 0) {
               // user found

              $tag_id = DB::table('tags')->where('tag', $tags_array[$x])->value('tag_id'); 


            }else{


              $bike_save = New tags;
              $bike_save ->tag = $tags_array[$x];
              $bike_save -> save();
              $tag_id = $bike_save->id;

            }
              $bike_save = New post_tags;
              $bike_save ->tag_id = $tag_id;
              $bike_save ->post_id = $post_id;
              $bike_save -> save();
          }


        }

        for ($x = 0; $x < count($request->triggers); $x++) {

          
            $bike_save = New post_triggers;
            $bike_save ->trigger_id = $request->triggers[$x];
            $bike_save ->post_id = $post_id;
            $bike_save -> save();


        }

        return Redirect::to('ask_query')->with('message', 'Recorded. Your post will be checked for plagiarism in this site. If found, it will be removed.');


      }
      else{

        return Redirect::to('ask_query')->with('message', 'Try Again');
      }
    }
    else{
      return Redirect::to('ask_query')->with('message', 'You need to select atleast one trigger');

    }

  }


  public function search_with_tag(Request $request){
  
      $tag_id = $request->tag_id;

      $search_type =  $tag_id .  " - Tag";


       $myCart = DB::table('post_tags')
              ->join('posts', 'posts.post_id', '=', 'post_tags.post_id')
              ->join('tags', 'post_tags.tag_id', '=', 'tags.tag_id')
              ->where('tags.tag_id', $tag_id)
              ->select('posts.post_id','posts.post','posts.user_id','posts.trigger_id','posts.posted_unix_time','posts.created_at','posts.updated_at','posts.post_title','posts.is_top_query','posts.total_responses','posts.is_answered')
              ->distinct()->get();
             // dd($myCart);





        //QAController::index_populate($myCart);

        if (!$myCart->isEmpty()) {
          foreach($myCart as $key => $value){

            // dd($value->post);

            $osi[$key]["post"] = $value->post;
            $osi[$key]["post_id"] = $value->post_id;
            $osi[$key]["post"] = $value->post;
            $osi[$key]["user_id"] = $value->user_id;   
            $osi[$key]["trigger_id"] = $value->trigger_id;  
            $osi[$key]["post_title"] = $value->post_title; 
            $osi[$key]["posted_unix_time"] = $value->posted_unix_time; 
            $osi[$key]["total_responses"] = $value->total_responses; 
            
            $trigger_name = DB::table('triggers')->where('trigger_id', $value->trigger_id)->value('trigger');    

            $user_name = DB::table('users')->where('id', $value->user_id)->value('name'); 
            $user_image_url = DB::table('users')->where('id', $value->user_id)->value('image_url'); 
            $osi[$key]["trigger_name"] = $trigger_name;  
            $osi[$key]["user_name"] = $user_name;  
            $osi[$key]["user_image_url"] = $user_image_url;  

            $last_id = $value->post_id;

            
          }
          $myJSON_recent = $osi;

          return view('index', ['myJSON_recent' => $myJSON_recent,'recent_exists'=>  '1','last_id'=>$last_id,'search_type' => $search_type, 'search_cat'=> 'Tag' ,'look_for_comment' => '']);

    }
      else{

          return view('index', ['recent_exists'=>  '0','last_id'=>0,'search_type' => "", 'search_cat'=> '','look_for_comment' => '']);
        }   
  }

  public function get_related_quries_for_ask_query_title(Request $request){

    $query_title = $request->query_title;
    //https://www.w3schools.com/sql/sql_wildcards.asp

    $products = posts::where('post_title', 'LIKE', '%'.$query_title.'%')->select('post_id','post_title')->limit(5)->get();
    
    return $products;
  }


  public function edit_replies(Request $request){
      $post_id = comments::where('comment_id', '=', $request->comment_id)->value('post_id');
      $last_comment = comments::where('comment_id', '=', $request->comment_id)->value('comment');
      $updateDetailsUsers=array(
            'comment' => str_replace('<br>', "\n", $request->comment)

          );

          DB::table('comments')
          ->where('comment_id', '=', $request->comment_id)->where('is_approval', '>=', 0)
          ->update($updateDetailsUsers); 


          $bike_save = New edit_history;
          $bike_save ->post_id = $post_id ; 
          $bike_save ->comment_id = $request->comment_id;
          $bike_save ->edit = $last_comment;          
          $bike_save ->type = 0;

          $bike_save -> save();
    return 1;
  }

  public function get_custom_topics_qus(Request $request){

   // $tags = DB::table('tags')->where('tag_id', '>', 0)->get();

    $tags =  DB::table('triggers')->where('trigger_header', '=', 'Custom Topics-Comments')->where('trigger_belong_to', '=', 'qus')->orWhere('trigger_belong_to', '=', 'all')->get();


    return $tags;    
  }


  public function modal_comment_post_edit_main(Request $request){


      #dd($request->all());
      $current_post = posts::where('post_id', '=', $request->post_id)->value('post'); 
      $current_post_title = posts::where('post_id', '=', $request->post_id)->value('post_title');

      if($current_post != $request->post_body){

          $bike_save = New edit_history;
          $bike_save ->post_id = $request->post_id; 

          $bike_save ->edit = $current_post;          
          $bike_save ->type = 2;

          $bike_save -> save();
          


      $updateDetailsUsers=array(
            'post' => str_replace('<br>', "\n", $request->post_body)
            #$request->post_body
          );

          DB::table('posts')
          ->where('post_id', '=', $request->post_id)->where('is_approval', '>=', 0)
          ->update($updateDetailsUsers); 


      }
      if($current_post_title != $request->post_title){

          $bike_save = New edit_history;
          $bike_save ->post_id = $request->post_id; 

          $bike_save ->edit = $current_post_title;          
          $bike_save ->type = 1;

          $bike_save -> save();
          


      $updateDetailsUsers=array(
            'post_title' => str_replace('<br>', "\n", $request->post_title)
            #$request->post_title
          );

          DB::table('posts')
          ->where('post_id', '=', $request->post_id)->where('is_approval', '>=', 0)
          ->update($updateDetailsUsers);



      }      
       



    return 1;
  }


  public function search_arena(Request $request){

    return view('search_arena');
  }


  public function insert_query_api(Request $request){
    //,$topics,$title,$tags;$details
    //https://stackoverflow.com/questions/22846897/how-to-create-a-laravel-hashed-password
    //https://stackoverflow.com/questions/32701107/how-to-decrypt-hash-password-in-laravel
      // $hashed = \Hash::make($password);

      // echo $hashed;
      // echo '<br>';
      // echo bcrypt($password);


    // POST parameters password, email, post_title, post, question_tags, triggers,reference_url
//http://localhost:8000/api/insert_query_api
     $dt = Carbon::now();



      if( strlen($request->password) == 60 && preg_match('/^\$2y\$/', $request->password )){
      
        $password = $request->password;
      }else{

        $password = bcrypt($request->password);
       

      }



      if (User::where('email', '=', $request->email)->where('password', '=', $password)->exists()) {
         // user found

        $user_id = User::where('email', '=', $request->email)->where('password', '=', $password)->value('id'); 

        if(count($request->triggers) > 0){
          $tags_array = explode (",", $request->question_tags); 
          
          $bike_save = New posts;
          $bike_save ->post_title = str_replace('<br>', "\n", $request->post_title);
          #$request->post_title; 

          $bike_save ->reference_url = $request->reference_url;          
          $bike_save ->trigger_id = 0;
          $bike_save ->post = str_replace('<br>', "\n", $request->post);
          #$request->post;
          $bike_save ->posted_unix_time = $dt->format('m/d/Y H:i:s');
          $bike_save ->user_id = $user_id;
          $bike_save -> save();
          $post_id =  $bike_save ->id;
           


          if((int) $post_id > 0){
            for ($x = 0; $x < count($tags_array); $x++) {

              if($tags_array[$x] !=""){
                if (DB::table('tags')->where('tag', '=', $tags_array[$x])->count() > 0) {
                   // user found

                  $tag_id = DB::table('tags')->where('tag', $tags_array[$x])->value('tag_id'); 


                }else{


                  $bike_save = New tags;
                  $bike_save ->tag = $tags_array[$x];
                  $bike_save -> save();
                  $tag_id = $bike_save->id;

                }
                  $bike_save = New post_tags;
                  $bike_save ->tag_id = $tag_id;
                  $bike_save ->post_id = $post_id;
                  $bike_save -> save();
              }


            }

            for ($x = 0; $x < count($request->triggers); $x++) {

              
                $bike_save = New post_triggers;
                $bike_save ->trigger_id = $request->triggers[$x];
                $bike_save ->post_id = $post_id;
                $bike_save -> save();


            }

            //return Redirect::to('ask_query')->with('message', 'Inserted');

            return "Inserted";


          }
          else{

           // return Redirect::to('ask_query')->with('message', 'Try Again');
            return "Try Again";
          }
        }
        else{
         // return Redirect::to('ask_query')->with('message', 'You need to select atleast one trigger');
         return "You need to select atleast one trigger";
        }





       
      }else{

        return "Record not found";
      }      

      // if(\Hash::check($password, $hashed)){

      //   dd("true");
      // }
      // else{
      //   $password=  bcrypt($password);
      //   dd("false");
      // }
      

  }


  

}