<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        return view('blog.index');
    }

    public function getdata()
    {
        $data = Blog::all();
        return response()->json(['data' => $data, 'status' => 200]);
    }
    public function store(Request $request)
    {
       Blog::create($request->all());
        return response()->json(['message' => 'data successfully inserted', 'status' => 200]);
    }
    public function edit($id)
    {
        $blog =Blog::find($id);
        return response()->json(['data'=>$blog,'status'=>200]);
    }
    public function update(Request $request)
    {
        $data=Blog::find($request->id);
        $data->name =$request->name;
        $data->details =$request->details;
        $data->save();
        return response()->json(['success'=>'data updated suceessfully','status'=>200]);
    }
    public function destory($id)

    {

        $data =Blog::find($id);
        if($data)
        {
            $data->delete();
            return response()->json(['status'=>200]);

        }
        return response()->json(['error'=>'data not found']);

        
    }
}
