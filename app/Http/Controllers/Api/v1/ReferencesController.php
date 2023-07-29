<?php
//Обращения пользователей
namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\reference;
use App\Imports\ReferencesImport;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use App\Models\references;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Validator;
use App\Http\Resources\reference as referenceResource;
use App\Http\Resources\referenceCollection;

use App\Exports\ReferencesExport;
use Maatwebsite\Excel\Facades\Excel;

class ReferencesController extends Controller
{
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }
    /**
     * Display a listing of the resource.
     *
     * @return Collection|JsonResponse|object|references[]
     */

    public function index()
    {

        $post = references::all();
        if (!$post) {
            return response()->json([
                "status"=>false,
                "message"=> "References not found"
            ])->setStatusCode(404);
         }
        // Gate::authorize('add-user',[$post]);
        return $post;


    }

    public function count(): array
    {

        $counts = [
            'countProcessed' => DB::table('references')->where('status','=','Обработано')->count(),
            'countNoProcessed' => DB::table('references')->where('status','=','Не обработан')->count(),
            'countRejected' => DB::table('references')->where('status','=','Отклонено')->count(),
            'countInProcessing' => DB::table('references')->where('status','=','В обработке')->count(),
        ];
        return $counts;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return BinaryFileResponse
     */


    public function referencesExport(): BinaryFileResponse
    {
        $export  = Excel::download(new ReferencesExport, 'references.xlsx');

        return $export;
//        if ($user->hasRole('admin')) {
//            $export  = Excel::download(new ReferencesExport, 'references.xlsx');
//
//            return $export;
//        }
//       return back()->with('success','Успешно импортировано!');
    }

    public function referencesImport(Request $request)
    {

        Excel::import(new ReferencesImport, $request->file('file_import'));

        return back()->with('success','Успешно импортировано!');


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return array
     */
    public function store(Request $request)
    {
        $validatior = Validator::make(
            $request->all(),
            [
                "FIO"=>["required"],
                "email"=>["required"],
                "telephone"=>["required"],
                "prichinaObr"=>["required"],
                "textObr"=>["required"],
                "idPodr"=>["required"]
            ]);

            if ($validatior->fails()) {
                return [
                    "status"=>false,
                    "errors"=>$validatior->messages()
                ];
            }
            $post= references::create([
                "FIO" => $request->FIO,
                "idUser" => '1',
                "email" => $request->email,
                "telephone" => $request->telephone,
                "prichinaObr" => $request->prichinaObr,
                "textObr" => $request->textObr,
                "idPodr" => $request->idPodr,
                "status" => 'Не обработан'
            ]);
            return[
                "status" => true,
                "post"=> $post
            ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $post = references::find($id);
        if (!$post) {
           return response()->json([
               "status"=>false,
               "message"=> "Post not found"
           ])->setStatusCode(404);
        }

        return response()->json([

             "id"=>$post->id,
             "FIO"=>$post->FIO,
             "email"=>$post->email,
             "telephone"=>$post->telephone,
             "prichinaObr"=>$post->prichinaObr,
             "textObr"=>$post->textObr,
             "idPodr"=>$post->idPodr,
             "status"=>$post->status,
             "created_at"=>$post->created_at->format('d.m.Y'),
             "updated_at"=>$post->created_at->format('d.m.Y'),
             ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return JsonResponse|object
     */
    public function update(Request $request, $id)
    {
        $request_data = $request->only(['status']);

        if (count($request_data) === 0) {
            return response()->json([
                "status" => false,
                "message" => "All fields is empty"
            ])->setStatusCode(422, "All fields is empty");
        }

        $rules_const = [
            "status" => ['required', 'string'],
        ];

        $rules = [];

        foreach ($request_data as $key => $data) {
            $rules[$key] = $rules_const[$key];
        }

        $validator = Validator::make($request_data, $rules);

        if ($validator->fails()) {
            return response()->json([
                "status" => false,
                "errors" => $validator->messages()
            ])->setStatusCode(422);
        }

        $reference = references::find($id);

        if (!$reference) {
            return response()->json([
                "status" => false,
                "message" => "Article not found"
            ])->setStatusCode(404, "Article not found");
        }

        foreach ($request_data as $key => $data) {
            $reference->$key = $data;
        }

        $reference->save();

        return response()->json([
            "status" => true,
            "message" => "Reference is updated",
            "id"=>$reference->id,
            "Full name"=>$reference->FIO,
            "Status"=>$reference->status,
        ])->setStatusCode(200, "Reference is updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
