<?php
//меры по обращениям пользователей
namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\measurs;
use App\Models\references;
use Illuminate\Http\Request;
use Validator;
class MeasuresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        return measurs::all();
        $measures = measurs::query()
            ->join('references','measurs.id_obr','=','references.id')
            ->select('measurs.id','measurs.text','measurs.id_obr','measurs.created_at',
                'references.FIO','references.status','references.textObr','references.email','references.telephone')
            ->get();

        return $measures;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function store(Request $request)
    {
        $validatior = Validator::make(
            $request->all(),
            [
                "id_obr"=>["required"],
                "text"=>["required"],
            ]);

            if ($validatior->fails()) {
                return [
                    "status"=>false,
                    "errors"=>$validatior->messages()
                ];
            }
            $post= measurs::create([
                "id_obr" => $request->id_obr,
                "text" => $request->text,

            ]);
            $reference = references::find($request->id_obr);
            $reference->fill(["status"=>'В обработке'])->save();

            return[
                "status" => true,
                "post"=> $post,
                "reference" =>$reference
            ];
    }


    public function show($id)
    {

//dd($id);
        $post = measurs::find($id);

        if (!$post) {
           return response()->json([
               "status"=>false,
               "message"=> "Post not found"
           ])->setStatusCode(404);
        }
        return  view('mesures.show');
//        return $post;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    public function update(Request $request)
    {

        $measures = measurs::find($request['id']);
        $measures->text = $request['text'];

        $reference = references::find($measures->id_obr);
        $reference->status = $request['status'];

        $measures->save();
        $reference->save();

        return[
            "status" => true,
            "post"=> $measures
        ];


    }



//    public function update(Request $request, $id)
//    {
//        $request_data = $request->only(['text']);
//
//        if (count($request_data) === 0) {
//            return response()->json([
//                "status" => false,
//                "message" => "All fields is empty"
//            ])->setStatusCode(422, "All fields is empty");
//        }
//
//        $rules_const = [
//            "text" => ['required', 'string'],
//        ];
//
//        $rules = [];
//
//        foreach ($request_data as $key => $data) {
//            $rules[$key] = $rules_const[$key];
//        }
//
//        $validator = Validator::make($request_data, $rules);
//
//        if ($validator->fails()) {
//            return response()->json([
//                "status" => false,
//                "errors" => $validator->messages()
//            ])->setStatusCode(422);
//        }
//
//        $measures = measurs::find($id);
//
//        if (!$measures) {
//            return response()->json([
//                "status" => false,
//                "message" => "Article not found"
//            ])->setStatusCode(404, "Message not found");
//        }
//
//        foreach ($request_data as $key => $data) {
//            $measures->$key = $data;
//        }
//
//        $measures->save();
//
//        return response()->json([
//            "status" => true,
//            "message" => "Answer is updated",
//            "id"=>$measures->id,
//            "Answer"=>$measures->text,
//        ])->setStatusCode(200, "Answer is updated");
//    }


    public function destroy($id)
    {
        //
    }
}
