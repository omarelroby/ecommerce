<?php


 function apiResponse($status,$message,$data=null)
{
    $response=[
        'status'=> $status,
        'message'=>$message,
        'data'=>$data
    ];
    //The response: function creates a response instance or obtains an instance of the response factory:
    //The json :method will automatically set the Content-Type header to application/json:
    return response()->json($response);

}
function get_languages(){

    return \App\Models\Language::active() -> select() -> get();
}

 function get_default_language()
 {
     return \Illuminate\Support\Facades\Config::get('app.locale');
}
function uploadImage($folder, $image)
{
    $image->store('/', $folder);
    $filename = $image->hashName();
    $path = 'images/' . $folder . '/' . $filename;
    return $path;
}
function uploadVideo($folder, $video)
{
    $video->store('/', $folder);
    $filename = $video->hashName();
    $path = 'video/' . $folder . '/' . $filename;
    return $path;
}
?>
