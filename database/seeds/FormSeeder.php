<?php

use CoenMooij\DevpoolApi\Form\Answer;
use CoenMooij\DevpoolApi\Form\Form;
use CoenMooij\DevpoolApi\Form\Question;
use Illuminate\Database\Seeder;

class FormSeeder extends Seeder
{
    const QUESTIONS_ANSWERS = [
        'When did you start programming' => 'When I was 12 in school',
        'What do you like about programming' => 'I like that you can build stuff',
        'Why are you a good programmer' => 'I have a lot of experience',
    ];
    const DEVELOPER_ID = 1;

    public function run(): void
    {
        if (Form::count() === 0) {
            $form = $this->addForm();
            $this->addQuestionsAndAnswers($form, self::QUESTIONS_ANSWERS);
        }
    }

    private function addForm(): Form
    {
        $form = new Form();
        $form->{Form::NAME} = 'Intake';
        $form->{Form::DESCRIPTION} = 'Intake form for developers v1';
        $form->save();

        return $form;
    }

    private function addQuestionsAndAnswers(Form $form, array $questionsAndAnswers): void
    {
        $order = 0;
        foreach ($questionsAndAnswers as $questionValue => $answerValue) {
            $question = new Question();
            $question->{Question::FORM_ID} = $form->{Form::ID};
            $question->{Question::ORDER} = $order;
            $question->{Question::VALUE} = $questionValue;
            $question->save();

            $answer = new Answer();
            $answer->{Answer::QUESTION_ID} = $question->{Question::ID};
            $answer->{Answer::DEVELOPER_ID} = self::DEVELOPER_ID;
            $answer->{Answer::VALUE} = $answerValue;
            $answer->save();
            $order++;
        }
    }
}
