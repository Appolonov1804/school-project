<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        $imageName = time().'.'.$request->file->extension(); 

        $request->file->move(public_path('dist/img'), $imageName);

        return back()
            ->with('success', 'Вы успешно загрузили файл.')
            ->with('image', $imageName); 
    }
}
