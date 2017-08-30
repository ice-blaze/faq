<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Faq;
use App\Qa;

class QaController extends Controller
{
    public function store(Request $request)
    {
        $faq = Faq::find($request->id);
        $isOkay = $request->admin_code == $faq->admin_code; // TODO is safe ?
        if(!$isOkay) {
            // TODO redirect error html
            return "nope";
        }

        $this->validate($request, [
            'question' => 'required',
            'answer' => 'required',
        ]);

        $faq = Faq::find($request->id);

        $qa = new Qa;
        $qa->question = $request->question;
        $qa->answer = $request->answer;
        $qa->faq_id = $faq->id; // TODO do it in a better way
        $qa->save();

        return redirect($faq->path());
    }
}
