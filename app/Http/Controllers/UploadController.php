<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Проверка на изображение и его размер
        ]);

        $imageName = time().'.'.$request->file->extension(); // Генерация уникального имени файла

        $request->file->move(public_path('dist/img'), $imageName); // Сохранение файла в нужной папке

        return back()
            ->with('success', 'Вы успешно загрузили файл.')
            ->with('image', $imageName); // Возвращение обратно с сообщением об успехе и именем загруженного файла
    }
}
