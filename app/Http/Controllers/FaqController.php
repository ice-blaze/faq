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
            // https://github.com/greggilbert/recaptcha
            // https://www.google.com/recaptcha/admin#site/338583795?setup
            // 'g-recaptcha-response' => 'required|recaptcha',
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
        $qa->save();

        return redirect($faq->path());
    }

    public function show(Request $request)
    {
        $faq = Faq::find($request->id);
        $isOkay = $request->admin_code == $faq->admin_code; // TODO is safe ?
        $qas = $faq->qas()->get();
	return view('faqs.edit', compact('faq', 'qas', 'isOkay'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            // https://github.com/greggilbert/recaptcha
            // https://www.google.com/recaptcha/admin#site/338583795?setup
            // 'g-recaptcha-response' => 'required|recaptcha',
            'question' => 'required',
            'answer' => 'required',
        ]);

        $faq = Faq::find($request->id);
        $isOkay = $request->admin_code == $faq->admin_code; // TODO is safe ?
        if(!$isOkay) {
            return "nope";
        }

        $qa = new Qa;
        $qa->question = $request->question;
        $qa->answer = $request->answer;
        $qa->faq_id = $request->id; // TODO do it in a better way
        $qa->save();

        return redirect($faq->path());
    }
}
