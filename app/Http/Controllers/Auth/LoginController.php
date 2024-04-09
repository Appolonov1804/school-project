<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Teacher;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
{
    // Получаем id пользователя
    $userId = $user->id;

    // Ищем учителя с данным id пользователя
    $teacher = Teacher::where('user_id', $userId)->first(); 

    // Если у пользователя есть учитель, перенаправляем на страницу учителя
    if ($teacher) {
        return redirect()->route('teachers.show', ['teacher' => $teacher->id]);
    }

    // В противном случае перенаправляем на домашнюю страницу
    return redirect()->route('home');
}
}
