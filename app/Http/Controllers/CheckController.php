<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Check;

class CheckController extends Controller
{
    // Роутинг на страницу проверок.
    public function index(){
        return view('check');
    }
    public function store(Request $request){
        $request->validate([
            'text' => 'required',
            'search_word' => 'required'
        ]);

        $text = mb_strtolower($request->text);
        $search_word = mb_strtolower($request->search_word);

        $words = array_filter(explode(" ", $text));

        $totalWords = (count($words));

        $foundWords = 0;
        foreach ($words as $wordToSearch) {
            if($wordToSearch === $search_word){
                $foundWords++;
            }
        }

        $check = Check::create([
            'text' => $text,
            'search_word' => $search_word,
            'total_words' => $totalWords,
            'found_words' => $foundWords
        ]);

        return response()->json($check);
    }
//    Возвращение данных из таблицы и сортировка их по времени создания
    public function history(){
        return Check::orderBy('created_at', 'desc')->get();
    }
}
