<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Qa;
use App\Faq;

class FaqController extends Controller
{
    private function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function index(Request $request)
    {
	$qas = Qa::all();

	return view('faqs.create', compact('qas'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'g-recaptcha-response' => 'required', // https://github.com/greggilbert/recaptcha
            'question' => 'required',
            'answer' => 'required',
        ]);

        // project creation
        $faq = new Faq;
        $faq->admin_code = $this->generateRandomString(13);
        $faq->save();

        $qa = new Qa;
        $qa->question = $request->question;
        $qa->answer = $request->answer;
        $qa->faq_id = $faq->id; // TODO do it in a better way
        $qa->order = 0;
        $qa->save();

        return redirect($faq->path());
    }

    private function checkAdminCode($request, $faq){
        $isOkay = $request->admin_code == $faq->admin_code; // TODO is safe ?
        if(!$isOkay) {
            abort(403, 'Unauthorized action.');
        }
    }

    public function qas(Request $request)
    {
        $faq = Faq::find($request->id);
        $this->checkAdminCode($request, $faq);
        $qas = $faq->qas()->orderBy('order', 'desc')->get();
	return $qas;
    }

    public function show(Request $request)
    {
        $faq = Faq::find($request->id);
        $isOkay = $request->admin_code == $faq->admin_code; // TODO is safe ?
        $qas = $faq->qas()->orderBy('order', 'desc')->get();
	return view('faqs.edit', compact('faq', 'qas', 'isOkay'));
    }

    public function update(Request $request)
    {
        $faq = Faq::find($request->id);
        $this->checkAdminCode($request, $faq);
        $isOkay = $request->admin_code == $faq->admin_code; // TODO is safe ?

        $this->validate($request, [
            'question' => 'required',
            'answer' => 'required',
            'qa_id' => 'required',
        ]);

        $qa = Qa::find($request->qa_id);
        $qa->question = $request->question;
        $qa->answer = $request->answer;
        $qa->order = 0;
        $qa->update();

        return redirect($faq->path());
    }
}
