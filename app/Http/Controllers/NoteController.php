<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Student;
use Illuminate\Http\Request;

class NoteController extends Controller
{
   public function index()
   {
       $notes = Note::all();

       return response()->json([
           'message' => 'Llistat de notes',
           'data' => $notes
       ], 200);
   }

   public function store(Request $request)
   {
       $request->validate([
           'title' => 'required|string|max:255',
           'mark' => 'required|numeric|min:0|max:10',
           'student_id' => 'required|exists:students,id'
       ]);

       $note = Note::create([
           'title' => $request->title,
           'mark' => $request->mark,
           'student_id' => $request->student_id
       ]);

       return response()->json([
           'message' => 'Nota creada correctament',
           'data' => $note
       ], 201);
   }

   public function show(string $id)
   {
       $note = Note::find($id);

       if (!$note) {
           return response()->json([
               'message' => 'Nota no trobada'
           ], 404);
       }

       return response()->json([
           'message' => 'Detall de la nota',
           'data' => $note
       ], 200);
   }

   public function update(Request $request, string $id)
   {
       $note = Note::find($id);

       if (!$note) {
           return response()->json([
               'message' => 'Nota no trobada'
           ], 404);
       }

       $request->validate([
           'title' => 'required|string|max:255',
           'mark' => 'required|numeric|min:0|max:10',
           'student_id' => 'required|exists:students,id'
       ]);

       $note->update([
           'title' => $request->title,
           'mark' => $request->mark,
           'student_id' => $request->student_id
       ]);

       return response()->json([
           'message' => 'Nota actualitzada correctament',
           'data' => $note
       ], 200);
   }

   public function destroy(string $id)
   {
       $note = Note::find($id);

       if (!$note) {
           return response()->json([
               'message' => 'Nota no trobada'
           ], 404);
       }

       $note->delete();

       return response()->json([
           'message' => 'Nota eliminada correctament'
       ], 200);
   }


    public function notesWithStudents(){
        $notes = Note::with('student')->get();

        return response()->json([
            'message' => 'Notes amb dades de l’estudiant',
            'data' => $notes
        ], 200);
    }

    public function showNotas($id){
        $student = Student::with('notes')->find($id);

        if (!$student) {
            return response()->json([
                'message' => 'NO LO ENCUENTRO'
            ], 404);
        }

        return response()->json([
            'message' => 'Detall de l’estudiant amb les seves notes',
            'data' => $student
        ], 201);

    }


}
