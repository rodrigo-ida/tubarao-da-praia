<?php

namespace App\Http\Controllers\Admin;

use App\Loja;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Admin\UploadController;

class LojaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lojas = Loja::where('status', '!=', '0')->get();

        return view('admin.loja.index', compact('lojas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {

            return view('admin.loja.create');

        } catch (Exception $e) {
            return redirect()->route('admin.loja.index');
        }
    }

    private function validateData($_data)
    {

        if (empty($_data['whatsapp_loja'])) {
            $_data['whatsapp_loja'] = null;
        }
        if (empty($_data['email_loja'])) {
            $_data['email_loja'] = null;
        }
        if (empty($_data['telefone_loja'])) {
            $_data['telefone_loja'] = null;
        }

        return $_data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $data = UploadController::getInputFromRequest($request, Loja::class, 'loja');

            $image = UploadController::storeImageIfExists($request, Loja::class, 'loja');

            if ($image != false) {
                $data['loja_pic_src'] = $image;
            }

            $Loja = new Loja();

            $data['status'] = "1";

            $Loja->fill($data);

            if (!$Loja->validate(true)) {
                return Redirect::back()->withInput($request->all())->withErrors($Loja->getErrors());
            }

            $loja = $Loja->save($data);

            return redirect()->route('admin.lojas.index', ['id' => $Loja->id])
                ->with('alert-success', 'Loja criada com sucesso!');
        } catch (Exception $e) {
            return redirect()->route('admin.loja.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Loja  $loja
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $loja = Loja::find($id);

        return view('admin.loja.show', compact('loja'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Loja  $loja
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {

            $loja = Loja::find($id);

            return view('admin.loja.edit', compact('loja'));
        } catch (Exception $e) {
            return redirect()->route('admin.loja.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Loja  $loja
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {

            $data = UploadController::getInputFromRequest($request, Loja::class, 'loja');

            $image = UploadController::storeImageIfExists($request, Loja::class, 'loja');

            if ($image != false) {
                $data['loja_pic_src'] = $image;
            }

            $loja = Loja::findOrFail($id);

            $required_fields = [];
            if (!$loja->validate(false)) {
                $required_fields = [];
                foreach ($loja->getErrors()->getMessages() as $key => $value) {
                    $required_fields[] = $key;
                }
            }

            $data['status'] = "1";

            $loja->fill($data);

            if (!$loja->validate(false)) {

                return Redirect::back()->withInput($request->all())->withErrors($loja->getErrors());
            }

            $loja->save();

            return redirect()->route('admin.lojas.index');
        } catch (Exception $e) {
            return Redirect::back()->withInput($request->all())->withErrors($loja->getErrors());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Loja  $loja
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            $loja = Loja::select('loja.id')
                ->where('id', '=', $id)->get();

            if (!empty($loja)) {

                $order = Loja::where('id', $loja->First()->id)->update(array(
                    'status' => "0",
                ));

            }

            return redirect()->Route('admin.lojas.index');
        } catch (Exception $e) {
            return redirect()->route('admin.lojas.index');
        }
    }
}
