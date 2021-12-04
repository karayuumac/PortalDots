<?php

namespace App\Http\Controllers\Circles;

use App\Eloquents\Circle;
use App\Eloquents\CustomForm;
use App\Http\Controllers\Controller;
use App\Services\Forms\AnswerDetailsService;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;

class ShowAction extends Controller
{
    /**
     * @var AnswerDetailsService
     */
    private $answerDetailsService;

    public function __construct(AnswerDetailsService $answerDetailsService)
    {
        $this->answerDetailsService = $answerDetailsService;
    }

    public function __invoke(Circle $circle)
    {
        $this->authorize('circle.belongsTo', $circle);

        $reauthorized_at = new CarbonImmutable(session()->get('user_reauthorized_at'));

        if (
            !$circle->hasSubmitted()
            || (session()->has('user_reauthorized_at') && $reauthorized_at->addHours(2)->gte(now()))
        ) {
            $circle->load('users', 'places');

            $custom_form = CustomForm::getFormByType('circle');
            $custom_form_answer = $circle->getCustomFormAnswer();
            $custom_form_answer_details = $this->answerDetailsService->getAnswerDetailsByAnswer($custom_form_answer);

            return view('circles.show')
                ->with('circle', $circle)
                ->with('questions', $custom_form->questions()->get())
                ->with('answer_details', $custom_form_answer_details);
        }
        return redirect()
            ->route('circles.auth', ['circle' => $circle]);
    }
}
