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
        $qa->order = $faq->qas()->count();
        $qa->save();

        return redirect($faq->path());
    }

    public function up(Request $request)
    {
        $faq = Faq::find($request->id);
        $isOkay = $request->admin_code == $faq->admin_code; // TODO is safe ?
        if(!$isOkay) {
            // TODO redirect error html
            return "nope";
        }

        $faq = Faq::find($request->id);
        $qa = Qa::find($request->qa_id);

        // If there is not enough question/answer, don't bother
        if($faq->qas()->count() <= 1) {
            $request->session()->flash("error", "There is not enough questions/answers!");
            return redirect($faq->path());
        }
        // If first element
        if($qa->order == $faq->qas()->count() - 1) {
            $request->session()->flash("error", "This is already the first element");
            return redirect($faq->path());
        }

        $qa_next = Qa::where("order", $qa->order + 1)->first();

        $qa->faq_id = $faq->id; // TODO do it in a better way
        $qa->order = $qa->order + 1;
        $qa_next->order = $qa_next->order - 1;
        $qa_next->update();
        $qa->update();

        return redirect($faq->path());
    }

    public function down(Request $request)
    {
        $faq = Faq::find($request->id);
        $isOkay = $request->admin_code == $faq->admin_code; // TODO is safe ?
        if(!$isOkay) {
            // TODO redirect error html
            return "nope";
        }

        $faq = Faq::find($request->id);
        $qa = Qa::find($request->qa_id);

        // If there is not enough question/answer, don't bother
        if($faq->qas()->count() <= 1) {
            $request->session()->flash("error", "There is not enough questions/answers!");
            return redirect($faq->path());
        }
        // If last element
        if($qa->order == 0) {
            $request->session()->flash("error", "This is already the last element");
            return redirect($faq->path());
        }

        $qa_next = Qa::where("order", $qa->order - 1)->first();

        $qa->faq_id = $faq->id; // TODO do it in a better way
        $qa->order = $qa->order - 1;
        $qa_next->order = $qa_next->order + 1;
        $qa_next->update();
        $qa->update();

        return redirect($faq->path());
    }
}
