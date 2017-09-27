<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Qa;
use App\Faq;
use App\Helpers\AppHelper;

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
        $fake_qas = [
            [
                "question" => "How will my questions look like ?",
                "answer" => "Certainly like this cards.",
                "time" => "Some days ago",
            ], [
                "question" => "Do I need an account ?",
                "answer" => "No there is no need. But dont loose the admin code!",
                "time" => "Some days ago + a bit",
            ], [
                "question" => "Is it free ?",
                "answer" => "Of course.",
                "time" => "Some days ago + a lot",
            ],
        ];

        return view('faqs.create', compact("fake_qas"));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
	    'g-recaptcha-response' => 'required|recaptcha', // https://github.com/greggilbert/recaptcha
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

        return redirect($faq->path())->with("status",
            "FAQ created. Be sure to <strong>save</strong> ".
            "somewhere the <strong>link</strong> with te <strong>admin code</strong>!"
        );
    }

    public function qas(Request $request)
    {
        $faq = Faq::find($request->faq_id);
        $qas = $faq->qas()->orderBy('order', 'desc')->get();
	return $qas;
    }


    public function show(Request $request)
    {
        $faq = Faq::find($request->faq_id);
        $isAdminCodeOkay = AppHelper::isAdmin($request, $faq);
        $qas = $faq->qas()->orderBy('order', 'desc')->get();
	return view('faqs.edit', compact('faq', 'qas', 'isAdminCodeOkay'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'question' => 'required',
            'answer' => 'required',
            'admin_code' => 'required',
        ]);

        $faq = Faq::find($request->faq_id);
        AppHelper::checkAdminCode($request, $faq);

        $qa = Qa::find($request->qa_id);
        $qa->question = $request->question;
        $qa->answer = $request->answer;
        $qa->order = 0;
        $qa->update();

        return redirect($faq->path());
    }
}
