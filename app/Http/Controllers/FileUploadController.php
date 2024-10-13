<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\File;  // Импортируем модель File
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log; // Импортируем фасад Log

class FileUploadController extends Controller
{
    public function upload(Request $request)
    {
        // Логируем начало загрузки формы
        Log::info('Форма загружена', ['email' => $request->email]);

        // Валидация формы
        $request->validate([
            'email' => 'required|email',
            'file1' => 'required|file|mimes:xlsx,xls|max:2048',
            'file2' => 'required|file|mimes:xlsx,xls|max:2048',
            'file3' => 'required|file|mimes:pdf|max:2048',
            'file4' => 'required|file|mimes:pdf|max:2048',
            'file5' => 'required|file|mimes:pdf|max:2048',
            'file6' => 'required|file|mimes:pdf|max:2048',
            'file7' => 'nullable|file|mimes:pdf|max:2048', // Прочее - необязательное
        ]);

        // Создание директории, если она не существует
        $uploadPath = storage_path('app/public/uploads');
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
            Log::info('Создана директория для загрузки', ['path' => $uploadPath]);
        }

        // Массив для хранения путей к загруженным файлам
        $filePaths = [];

        // Сохранение файлов на сервере
        foreach (['file1', 'file2', 'file3', 'file4', 'file5', 'file6', 'file7'] as $fileKey) {
            if ($request->hasFile($fileKey)) {
                $file = $request->file($fileKey);
                $filePath = $file->store('uploads', 'public');
                $filePaths[$fileKey] = $filePath;
                Log::info('Файл успешно сохранен', ['filePath' => $filePath]);
            }
        }

        // Сохранение записи в базе данных
        $file = new File();
        $file->email = $request->email;
        $file->file_path = json_encode($filePaths); // Сохранение всех путей в виде JSON
        $file->save();
        Log::info('Запись о файле сохранена в базе данных', ['email' => $file->email, 'file_paths' => $file->file_path]);

        // Отправка письма
        try {
            Mail::raw('Файлы были успешно загружены.', function ($message) use ($request, $filePaths) {
                $message->to($request->email)
                    ->subject('Загрузка файлов');
                foreach ($filePaths as $filePath) {
                    $message->attach(storage_path('app/public/' . $filePath));
                }
            });
            Log::info('Письмо успешно отправлено', ['email' => $request->email]);
        } catch (\Exception $e) {
            Log::error('Ошибка при отправке письма', ['error' => $e->getMessage()]);
        }

        return back()->with('success', 'Файлы успешно отправлены на ' . $request->email);
    }
}
