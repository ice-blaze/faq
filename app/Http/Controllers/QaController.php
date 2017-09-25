<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Faq;
use App\Qa;
use App\Helpers\AppHelper;

class QaController extends Controller
{
    public function getJson(Request $request) {
        $qa = Qa::find($request->qa_id);
        return $qa;
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'question' => 'required',
            'answer' => 'required',
            'admin_code' => 'required',
        ]);

        $qa = Qa::find($request->qa_id);
        $faq = $qa->faq;
        AppHelper::checkAdminCode($request, $faq);

        $qa->question = $request->question;
        $qa->answer = $request->answer;
        $qa->save();

        return redirect($faq->path());
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'question' => 'required',
            'answer' => 'required',
            'admin_code' => 'required',
        ]);

        $faq = Faq::find($request->faq_id);
        AppHelper::checkAdminCode($request, $faq);

        $qa = new Qa;
        $qa->question = $request->question;
        $qa->answer = $request->answer;
        $qa->faq_id = $faq->id; // TODO do it in a better way
        $qa->order = $faq->qas()->count();
        $qa->save();

        return redirect($faq->path());
    }


    public function reorder(Request $request) {
        $this->validate($request, [
            'ids' => 'required',
            'admin_code' => 'required',
        ]);

        $faq = Faq::find($request->faq_id);
        AppHelper::checkAdminCode($request, $faq);

        $ids = $request->ids;
        $qasIds = $faq->qas()->orderBy('order', 'desc')->get()->pluck("id")->toArray();
        // check if both ids array match
        sort($ids);
        sort($qasIds);
        $zip = array_map(null, $qasIds, $ids);
        foreach ($zip as $id12) {
            if( $id12[0] != $id12[1] ) {
                return "nope ids dont match with qas";
            }
        }

        // keep the real order
        $ids = $request->ids;

        $countIds = count($ids);
        for($i = 0; $i < $countIds; $i++) {
            $qa = Qa::find($ids[$i]);
            $newOrder = $countIds - $i - 1;
            if($qa->order != $newOrder){
                $qa->order = $newOrder;
                $qa->save();
            }
        }

        return redirect($faq->path());
    }

    public function delete(Request $request) {
        $this->validate($request, [
            'admin_code' => 'required',
        ]);

        $qa = Qa::find($request->qa_id);
        $faq = $qa->faq;
        AppHelper::checkAdminCode($request, $faq);

        $qa->delete();

        $request->session()->flash('status', "Delete okay");
        return redirect($faq->path());
    }

    // TODO WARNING apparently there is still a bug
    public function up(Request $request)
    {
        $this->validate($request, [
            'admin_code' => 'required',
        ]);

        $qa = Qa::find($request->qa_id);
        $faq = $qa->faq;
        AppHelper::checkAdminCode($request, $faq);

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

    // TODO WARNING apparently there is still a bug
    public function down(Request $request)
    {
        $this->validate($request, [
            'admin_code' => 'required',
        ]);

        $qa = Qa::find($request->qa_id);
        $faq = $qa->faq;
        AppHelper::checkAdminCode($request, $faq);

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
